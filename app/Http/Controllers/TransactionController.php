<?php

namespace App\Http\Controllers;

use App\Models\Aoi;
use App\Models\Axi;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function history()
    {
        $transaction = InventoryTransaction::all();
        return view('admin.history', compact('transaction'));
    }
    public function Transaction()
    {
        $transaction = InventoryTransaction::all();
        // $axiData = Transaction::with('images')->get();

        // if ($axiData->count() > 0) {
        //     return redirect()->back()->with('error', 'AXI data already exists.');
        // }

        return view('admin.transaksi.transaction', compact('transaction'));
    }

    public function TransactionAxiPage()
    {
        $transaction = InventoryTransaction::all();
        return view('admin.transaksi.transactionAxi', compact('transaction'));
    }
    public function AddTransactionAxi()
    {
        $transaction = InventoryTransaction::all();
        return view('admin.transaksi.transactionAxi', compact('transaction'));
    }
    public function TransactionAoiPage()
    {
        $transaction = InventoryTransaction::all();
        return view('admin.transaksi.transactionAoi', compact('transaction'));
    }
    public function AddTransactionAoi()
    {
        $transaction = InventoryTransaction::all();
        return view('admin.transaksi.transactionAoi', compact('transaction'));
    }


    public function AxiIndex()
    {
        $transactions = InventoryTransaction::where('machine_type', 'AXI')
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('admin.transaksi.axi.AxiCreate', compact('transactions'));
    }
    public function AxiCreate()
    {
        return view('admin.transaction.axi.create');
    }
    public function AxiStore(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'part_number'      => 'required|string',
            'part_desc'        => 'nullable|string',
            'warehouse_code'   => 'required|string',
            'bin_code'         => 'nullable|string',
            'transaction_type' => 'required|in:IN,OUT',
            'quantity'         => 'required|integer|min:1',
            'remarks'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // Cari data AXI berdasarkan part number + warehouse + bin
            $axi = Axi::where('PartNum', $request->part_number)
                ->where('WareHouseCode', $request->warehouse_code)
                ->where('BinNum', $request->bin_code)
                ->first();

            // Kalau IN dan belum ada → buat baru
            if ($request->transaction_type == 'IN') {

                if ($axi) {
                    $axi->MainTranQty += $request->quantity;
                    $axi->PhysicalQty += $request->quantity;
                    $axi->save();
                } else {
                    $axi = Axi::create([
                        'PartNum'        => $request->part_number,
                        'PartDesc'       => $request->part_desc,
                        'WareHouseCode'  => $request->warehouse_code,
                        'BinNum'         => $request->bin_code,
                        'MainTranQty'    => $request->quantity,
                        'PhysicalQty'    => $request->quantity,
                        'mtscbat_remarks' => $request->remarks,
                        'pictures'       => '',
                    ]);
                }
            }

            // Kalau OUT → harus cek stok cukup
            if ($request->transaction_type == 'OUT') {

                if (!$axi) {
                    return back()->with('error', 'Data part tidak ditemukan.');
                }

                if ($axi->PhysicalQty < $request->quantity) {
                    return back()->with('error', 'Stok tidak mencukupi.');
                }

                $axi->MainTranQty -= $request->quantity;
                $axi->PhysicalQty -= $request->quantity;
                $axi->save();
            }

            // Simpan ke inventory transaction (ledger)
            InventoryTransaction::create([
                'machine_type'     => 'AXI',
                'reference_type'   => 'AXI',
                'reference_id'     => $request->part_number,

                'transaction_date' => Carbon::parse($request->transaction_date),
                'transaction_type' => $request->transaction_type,
                'quantity'         => $request->quantity,

                'part_number'      => $request->part_number,
                'part_description' => $request->part_desc,

                'warehouse_code'   => $request->warehouse_code,
                'bin_code'         => $request->bin_code,

                'remarks'          => $request->remarks,
                'created_by'       => auth()->user()->name ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.transaction.axi.AxiPage')
                ->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    ////////// AOI ////////////
    public function aoiIndex()
    {
        $transactions = InventoryTransaction::where('machine_type', 'AOI')
            ->orderBy('transaction_date', 'desc')
            ->get();

        return view('admin.transaksi.aoi.AoiCreate', compact('transactions'));
    }
    public function aoiCreate()
    {
        return view('admin.transaction.aoi.create');
    }
    public function aoiStore(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'part_number'      => 'required|string',
            'part_desc'        => 'nullable|string',
            'warehouse_code'   => 'required|string',
            'bin_code'         => 'nullable|string',
            'transaction_type' => 'required|in:IN,OUT',
            'quantity'         => 'required|integer|min:1',
            'remarks'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // Cari data AXI berdasarkan part number + warehouse + bin
            $aoi = Aoi::where('PartNum', $request->part_number)
                ->where('WareHouseCode', $request->warehouse_code)
                ->where('BinNum', $request->bin_code)
                ->first();

            // Kalau IN dan belum ada → buat baru
            if ($request->transaction_type == 'IN') {

                if ($aoi) {
                    $aoi->MainTranQty += $request->quantity;
                    $aoi->PhysicalQty += $request->quantity;
                    $aoi->save();
                } else {
                    $aoi = Aoi::create([
                        'PartNum'        => $request->part_number,
                        'PartDesc'       => $request->part_desc,
                        'WareHouseCode'  => $request->warehouse_code,
                        'BinNum'         => $request->bin_code,
                        'MainTranQty'    => $request->quantity,
                        'PhysicalQty'    => $request->quantity,
                        'mtscbat_remarks' => $request->remarks,
                        'pictures'       => '',
                    ]);
                }
            }

            // Kalau OUT → harus cek stok cukup
            if ($request->transaction_type == 'OUT') {

                if (!$aoi) {
                    return back()->with('error', 'Data part tidak ditemukan.');
                }

                if ($aoi->PhysicalQty < $request->quantity) {
                    return back()->with('error', 'Stok tidak mencukupi.');
                }

                $aoi->MainTranQty -= $request->quantity;
                $aoi->PhysicalQty -= $request->quantity;
                $aoi->save();
            }

            // Simpan ke inventory transaction (ledger)
            InventoryTransaction::create([
                'machine_type'     => 'AOI',
                'reference_type'   => 'AOI',
                'reference_id'     => $request->part_number,

                'transaction_date' => Carbon::parse($request->transaction_date),
                'transaction_type' => $request->transaction_type,
                'quantity'         => $request->quantity,

                'part_number'      => $request->part_number,
                'part_description' => $request->part_desc,

                'warehouse_code'   => $request->warehouse_code,
                'bin_code'         => $request->bin_code,

                'remarks'          => $request->remarks,
                'created_by'       => auth()->user()->name ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.transaction.aoi.aoiPage')
                ->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
