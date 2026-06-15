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
        // $transaction = InventoryTransaction::all();
        $transaction = InventoryTransaction::orderBy('transaction_date', 'asc')->get();
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
    public function getAxiDescription(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string'
        ]);

        $part = Axi::where('PartNum', $request->part_number)->first();

        if (!$part) {
            return response()->json([
                'part_desc' => '',
                'warehouse_code' => '',
                'bin_code' => '',
            ], 404);
        }

        return response()->json([
            'part_desc' => $part->PartDesc,
            'warehouse_code' => $part->WareHouseCode,
            'bin_code' => $part->BinNum,
        ]);
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
            'transaction_type' => 'required|in:IN,OUT',
            'quantity'         => 'required|integer|min:1',
            'remarks'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // Ambil data master berdasarkan part number
            $masterPart = Axi::where('PartNum', $request->part_number)->first();

            if (!$masterPart) {
                return back()->with(
                    'error',
                    'Part Number tidak ditemukan pada master AXI.'
                );
            }

            $partDesc = $masterPart->PartDesc;
            $warehouseCode = $masterPart->WareHouseCode;
            $binCode = $masterPart->BinNum;

            // Cari stok berdasarkan part + warehouse + bin
            $axi = Axi::where('PartNum', $request->part_number)
                ->where('WareHouseCode', $warehouseCode)
                ->where('BinNum', $binCode)
                ->first();

            // Transaksi IN
            if ($request->transaction_type == 'IN') {

                $axi->MainTranQty += $request->quantity;
                $axi->PhysicalQty += $request->quantity;

                if (!empty($request->remarks)) {
                    $axi->mtscbat_remarks = $request->remarks;
                }

                $axi->save();
            }

            // Transaksi OUT
            if ($request->transaction_type == 'OUT') {

                if (!$axi) {
                    return back()->with(
                        'error',
                        'Data part tidak ditemukan.'
                    );
                }

                if ($axi->PhysicalQty < $request->quantity) {
                    return back()->with(
                        'error',
                        'Stok tidak mencukupi.'
                    );
                }

                $axi->MainTranQty -= $request->quantity;
                $axi->PhysicalQty -= $request->quantity;

                if (!empty($request->remarks)) {
                    $axi->mtscbat_remarks = $request->remarks;
                }

                $axi->save();
            }

            // Simpan ke inventory transaction
            InventoryTransaction::create([
                'machine_type'     => 'AXI',
                'reference_type'   => 'AXI',
                'reference_id'     => $request->part_number,

                'transaction_date' => Carbon::parse($request->transaction_date),
                'transaction_type' => $request->transaction_type,
                'quantity'         => $request->quantity,

                'part_number'      => $request->part_number,
                'part_description' => $partDesc,

                'warehouse_code'   => $warehouseCode,
                'bin_code'         => $binCode,

                'remarks'          => $request->remarks,
                'created_by'       => auth()->user()->name ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.transaction.axi.AxiPage')
                ->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Terjadi kesalahan: ' . $e->getMessage()
            );
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

    public function getDescription(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string'
        ]);

        $part = Aoi::where('PartNum', $request->part_number)->first();

        if (!$part) {
            return response()->json([
                'part_desc' => '',
                'warehouse_code' => '',
                'bin_code' => '',
            ], 404);
        }

        return response()->json([
            'part_desc' => $part->PartDesc,
            'warehouse_code' => $part->WareHouseCode,
            'bin_code' => $part->BinNum,
        ]);
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
            'transaction_type' => 'required|in:IN,OUT',
            'quantity'         => 'required|integer|min:1',
            'remarks'          => 'nullable|string',
        ]);

        $masterPart = Aoi::where('PartNum', $request->part_number)->first();

        if (!$masterPart && $request->transaction_type === 'OUT') {
            return back()->with('error', 'Data part tidak ditemukan.');
        }

        $partDesc = $masterPart ? $masterPart->PartDesc : null;
        $warehouseCode = $masterPart ? $masterPart->WareHouseCode : null;
        $binCode = $masterPart ? $masterPart->BinNum : null;

        DB::beginTransaction();

        try {

            // Cari data AXI berdasarkan part number + warehouse + bin
            $aoi = Aoi::where('PartNum', $request->part_number)
                ->where('WareHouseCode', $warehouseCode)
                ->where('BinNum', $binCode)
                ->first();

            // Kalau IN dan belum ada → buat baru
            if ($request->transaction_type == 'IN') {

                if ($aoi) {
                    $aoi->MainTranQty += $request->quantity;
                    $aoi->PhysicalQty += $request->quantity;
                    $aoi->save();
                } else {
                    $aoi = Aoi::create([
                        'PartNum'         => $request->part_number,
                        'PartDesc'        => $partDesc,
                        'WareHouseCode'   => $warehouseCode,
                        'BinNum'          => $binCode,
                        'MainTranQty'     => $request->quantity,
                        'PhysicalQty'     => $request->quantity,
                        'mtscbat_remarks' => $request->remarks,
                        'pictures'        => '',
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
                'part_description' => $partDesc,

                'warehouse_code'   => $warehouseCode,
                'bin_code'         => $binCode,

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
