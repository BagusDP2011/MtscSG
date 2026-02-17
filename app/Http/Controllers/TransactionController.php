<?php

namespace App\Http\Controllers;

use App\Models\Axi;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function TransactionMasuk()
    {
        InventoryTransaction::create([
            'part_number'       => 'IC-NE555',
            'part_description'  => 'Timer IC',
            'transaction_type'  => 'IN',
            'quantity'          => 1000,
            'uom'               => 'pcs',
            'warehouse_code'    => 'WH-A',
            'bin_code'          => 'BIN-01',
            'reference_type'    => 'PO',
            'reference_id'      => 'PO-2026-001',
            'transaction_date'  => now(),
            'remarks'           => 'Incoming shipment',
            'created_by'        => auth()->id(),
        ]);
    }
    public function TransactionKeluar()
    {
        InventoryTransaction::create([
            'part_number'       => 'IC-NE555',
            'transaction_type'  => 'OUT',
            'quantity'          => -200,
            'reference_type'    => 'AOI',
            'reference_id'      => 'AOI-00023',
            'transaction_date'  => now(),
            'created_by'        => auth()->id(),
        ]);
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
            'part_desc'        => 'string|nullable',
            'warehouse_code'   => 'required|string',
            'bin_code'          => 'string|nullable',
            'transaction_type' => 'required|in:IN,OUT',
            'quantity'         => 'required|integer|min:1',
            'remarks'          => 'string|nullable',
        ]);
        InventoryTransaction::create([
            // Machine & reference
            'machine_type'     => 'AXI',
            'reference_type'   => 'AXI',
            'reference_id'     => $request->part_number,

            // Transaction info
            'transaction_date' => $request->transaction_date,
            'transaction_type' => $request->transaction_type,
            'quantity'         => $request->quantity,

            // Item snapshot
            'part_number'      => $request->part_number,
            'part_description' => $request->part_desc,

            // Location
            'warehouse_code'   => $request->warehouse_code,
            'bin_code'         => $request->bin_code,

            // Remarks
            'remarks'          => $request->remarks,

            // Audit
            'created_by'       => Auth::user()->name ?? Auth::user()->fullname ?? null,
        ]);

        Axi::create([
                'PartNum' => $request->part_number,
                'PartDesc' => $request->part_desc,
                'WareHouseCode' => $request->warehouse_code,
                'BinNum' => $request->bin_code,
                'MainTranQty' => $request->quantity,
                'PhysicalQty' => $request->quantity,
                'mtscbat_remarks' => $request->remarks,
                'pictures' => '',
            ]);
        return redirect()
            ->route('admin.transaction.axi.AxiPage')
            ->with('success', 'Transaksi AXI berhasil ditambahkan');
    }
}
