<?php

namespace Tests\Feature;

use App\Models\Aoi;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

class SystemFeatureTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | FR001 - Login Berhasil
    |--------------------------------------------------------------------------
    */
    public function test_fr001_admin_can_login_successfully()
    {
        // FR001 - Halaman login untuk Admin & MTSC Staff
        $user = User::factory()->create([
            'name' => 'Robot Testing',
            'email' => 'robottest@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        $response = $this->post('/', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    /*
    |--------------------------------------------------------------------------
    | FR001 - Login Gagal
    |--------------------------------------------------------------------------
    */
    public function test_fr001_login_fails_with_wrong_password()
    {
        // FR001 - Login gagal jika password salah
        $user = User::factory()->create([
            'name' => 'Robot Testing',
            'email' => 'robottest@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        $response = $this->post('/', [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | FR002 - Logout
    |--------------------------------------------------------------------------
    */
    public function test_fr002_user_can_logout()
    {
        // FR002 - Fitur logout
        /** @var \Illuminate\Contracts\Auth\Authenticatable $userData */
        $userData = User::factory()->create([
            'name' => 'Robot Testing',
            'email' => 'robottest@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);
        $response = $this->actingAs($userData)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /*
    |--------------------------------------------------------------------------
    | FR003 - Admin Tambah User
    |--------------------------------------------------------------------------
    */
    public function test_fr003_admin_can_create_user()
    {
        // FR003 - Kelola User & Role (Tambah User)
        /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->post('/admin/register', [
            'name' => 'Test User',
            'email' => 'testuser@mail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'staff'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@mail.com'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FR004 - Role Based Access Control
    |--------------------------------------------------------------------------
    */
    public function test_fr004_staff_cannot_access_admin_page()
    {
        // FR004 - Staff hanya bisa akses menu staff
        /** @var \Illuminate\Contracts\Auth\Authenticatable $staff */
        $staff = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($staff)
            ->get('/admin/user');

        $response->assertStatus(403);
    }

    /*
    |--------------------------------------------------------------------------
    | FR005 - CRUD Master Data Barang (Create)
    |--------------------------------------------------------------------------
    */
    public function test_fr006_stock_increases_when_item_in()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $aoi = Aoi::factory()->create([
            'PartNum'       => '0000-0001',
            'WareHouseCode' => 'BATAM',
            'BinNum'        => 'AOI',
            'MainTranQty'   => 10,
            'PhysicalQty'   => 10,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.transaction.aoi.aoiStore'), [
                'transaction_date' => now()->toDateString(),
                'part_number'      => '0000-0001',
                'part_desc'        => 'AOI Item',
                'warehouse_code'   => 'BATAM',
                'bin_code'         => 'AOI',
                'transaction_type' => 'IN',
                'quantity'         => 5,
                'remarks'          => 'Testing IN',
            ]);

        $response->assertRedirect(route('admin.transaction.aoi.aoiPage'));

        $this->assertDatabaseHas('aois', [
            'PartNum'     => '0000-0001',
            'PhysicalQty' => 15,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FR007 - Barang Keluar & Stok Berkurang
    |--------------------------------------------------------------------------
    */
    public function test_fr007_stock_reduces_when_item_out()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        // Buat data AOI awal
        $aoi = Aoi::factory()->create([
            'PartNum'       => '0000-0001',
            'WareHouseCode' => 'BATAM',
            'BinNum'        => 'AOI',
            'MainTranQty'   => 10,
            'PhysicalQty'   => 10,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.transaction.aoi.aoiStore'), [
                'transaction_date' => now()->toDateString(),
                'part_number'      => '0000-0001',
                'part_desc'        => 'AOI Item',
                'warehouse_code'   => 'BATAM',
                'bin_code'         => 'AOI',
                'transaction_type' => 'OUT',
                'quantity'         => 5,
                'remarks'          => 'Testing OUT',
            ]);

        $response->assertRedirect(route('admin.transaction.aoi.aoiPage'));

        // Pastikan stok berkurang
        $this->assertDatabaseHas('aois', [
            'PartNum'     => '0000-0001',
            'PhysicalQty' => 5,
        ]);
    }

    /*
            |--------------------------------------------------------------------------
            | FR008 - Barang Keluar Stock Tidak Cukup
            |--------------------------------------------------------------------------
            */
    public function test_fr008_out_fails_when_stock_not_enough()
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $aoi = Aoi::factory()->create([
            'PartNum'       => '0000-0001',
            'WareHouseCode' => 'BATAM',
            'BinNum'        => 'AOI',
            'PhysicalQty'   => 2,
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.transaction.aoi.aoiStore'), [
                'transaction_date' => now()->toDateString(),
                'part_number'      => '0000-0001',
                'warehouse_code'   => 'BATAM',
                'bin_code'         => 'AOI',
                'transaction_type' => 'OUT',
                'quantity'         => 5,
            ]);

        $response->assertSessionHas('error');

        // Stok tetap
        $this->assertDatabaseHas('aois', [
            'PartNum'     => '0000-0001',
            'PhysicalQty' => 2,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FR010 - Upload Excel Valid
    |--------------------------------------------------------------------------
    */
    public function test_fr010_admin_can_upload_valid_excel()
    {
        // FR010 - Upload data massal via Excel
        /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        Excel::fake();

        $response = $this->actingAs($admin)->post('/admin/vitrox/import-aoi', [
            'file' => UploadedFile::fake()->create('aoi.xlsx')
        ]);

        Excel::assertImported('aoi.xlsx');
        $response->assertStatus(302);
    }

    /*
    |--------------------------------------------------------------------------
    | FR011 - Validasi Excel Duplikat
    |--------------------------------------------------------------------------
    */
    // public function test_fr011_add_duplicate_validation()
    // {
    //     // FR011 - Validasi otomatis data Excel duplikat
    //     /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
    //     $admin = User::factory()->create(['role' => 'admin']);

    //     Aoi::factory()->create(['PartNum' => '2140-0011']);

    //     $response = $this->actingAs($admin)->post('/admin/vitrox/aoi/add', [
    //         'PartNum' => '2140-0011',
    //         'PartDesc' => 'Duplicate Item',
    //         'PhysicalQty' => 5,
    //         'MainTranQty' => 5
    //     ]);

    //     $response->assertSessionHasErrors('PartNum');
    // }

    public function test_fr011_add_duplicate_validation()
    {
        // FR011 - Validasi otomatis data Excel duplikat
        /** @var \Illuminate\Contracts\Auth\Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        Aoi::factory()->create([
            'PartNum' => '2140-0011'
        ]);

        $response = $this->actingAs($admin)->post('/admin/vitrox/aoi/add', [
            'PartNum' => '2140-0011',
            'PartDesc' => 'Duplicate Item',
            'WareHouseCode' => 'WH01',
            'PhysicalQty' => 5,
            'MainTranQty' => 5
        ]);

        $response->assertSessionHas('error');

        $this->assertDatabaseCount('aois', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | FR012 - Peringatan Duplikasi Manual
    |--------------------------------------------------------------------------
    */
    // public function test_fr012_duplicate_item_code_is_rejected()
    // {
    //     // FR012 - Peringatan duplikasi kode barang
    //     Item::factory()->create(['code' => 'AXI-001']);

    //     $response = $this->post('/items', [
    //         'code' => 'AXI-001',
    //         'name' => 'Test Item',
    //         'stock' => 5
    //     ]);

    //     $response->assertSessionHasErrors('code');
    // }

    /*
    |--------------------------------------------------------------------------
    | FR018 - Guest Akses Landing Page
    |--------------------------------------------------------------------------
    */
    public function test_fr018_guest_can_access_landing_page()
    {
        // FR018 - Guest dapat membuka landing page tanpa login
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
