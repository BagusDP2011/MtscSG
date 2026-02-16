<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AxiImage;
use App\Imports\AxiImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Axi;


class AxiController extends Controller
{
    public function axi()
    {
        $axiData = Axi::with('images')->get();

        // if ($axiData->count() > 0) {
        //     return redirect()->back()->with('error', 'AXI data already exists.');
        // }

        return view('admin.vitrox.axi', compact('axiData'));
    }

    public function addDataAxi(Request $request)
    {
        $validated = $request->validate([
            'PartNum' => 'required|string|max:255',
            'PartDesc' => 'required|string|max:255',
            'WareHouseCode' => 'required|string|max:255',
            'BinNum' => 'nullable|string|max:255',
            'MainTranQty' => 'nullable|numeric',
            'PhysicalQty' => 'nullable|numeric',
            'mtscbat_remarks' => 'nullable|string',
            'pictures' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('pictures')) {
            $file = $request->file('pictures');
            $filename = time() . '_' . $file->getClientOriginalName(); // contoh: 1754916208_joveen.jpg
            $file->move(public_path('assets/upload'), $filename);
            $validated['pictures'] = 'assets/upload/' . $filename;
        }


        Axi::create($validated);

        return redirect()->back()->with('success', 'Data AXI berhasil ditambahkan.');
    }

    public function updateAxi(Request $req)
    {
        // dd();
        $req->validate([
            'axi_id' => 'required|integer|exists:axis,axi_id',
            'PartNum' => 'required|string',
            'pictures' => 'nullable|image|max:2048',
            // ... other rules
        ]);

        $axi = Axi::findOrFail($req->axi_id);

        if ($req->hasFile('pictures')) {
            $file = $req->file('pictures');
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/upload'), $name);
            $axi->pictures = 'assets/upload/' . $name;
        }

        $axi->PartNum = $req->PartNum;
        $axi->PartDesc = $req->PartDesc;
        $axi->WareHouseCode = $req->WareHouseCode;
        $axi->BinNum = $req->BinNum;
        $axi->MainTranQty = $req->MainTranQty;
        $axi->PhysicalQty = $req->PhysicalQty;
        $axi->mtscbat_remarks = $req->mtscbat_remarks;
        $axi->save();

        return back()->with('success', 'Data AXI berhasil diperbarui.');
    }

    public function importAxi(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new AxiImport, $request->file('file'));

        return back()->with('success', 'Data AXI X-ray berhasil diimpor dari Excel!');
    }

    public function truncateAxi(Request $request)
    {
        Axi::truncate();
        return back()->with('success', 'Semua data AXI telah dihapus.');
    }
    public function destroyAxi($axi_id)
    {
        try {
            $axi = Axi::findOrFail($axi_id);

            // hapus gambar kalau ada
            if ($axi->pictures && file_exists(public_path($axi->pictures))) {
                unlink(public_path($axi->pictures));
            }

            $axi->delete();

            return redirect()->back()->with('success', 'Data AXI berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
