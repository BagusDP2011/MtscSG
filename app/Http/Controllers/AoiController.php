<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aoi;
use App\Imports\AoiImport;
use Maatwebsite\Excel\Facades\Excel;


class AoiController extends Controller
{
    public function aoi()
    {
        $aoiData = Aoi::all();
        // $aoiData = Aoi::with('images')->get();
        return view('admin.vitrox.aoi', compact('aoiData'));
    }

    public function importAoi(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new AoiImport, $request->file('file'));

        return back()->with('success', 'Data AOI berhasil diimpor dari Excel!');
    }
    public function addDataAoi(Request $request)
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

        // cek duplicate
        if (Aoi::where('PartNum', $validated['PartNum'])->exists()) {
            return redirect()->back()->with('error', 'PartNum already exists. Data skipped.');
        }

        Aoi::create($validated);

        return redirect()->back()->with('success', 'Data AOI berhasil ditambahkan.');
    }

    public function updateAoi(Request $req)
    {
        // dd();
        $req->validate([
            'aoi_id' => 'required|integer|exists:aois,aoi_id',
            'PartNum' => 'required|string',
            'pictures' => 'nullable|image|max:2048',
            // ... other rules
        ]);

        $aoi = Aoi::findOrFail($req->aoi_id);

        if ($req->hasFile('pictures')) {
            $file = $req->file('pictures');
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/upload'), $name);
            $aoi->pictures = 'assets/upload/' . $name;
        }

        $aoi->PartNum = $req->PartNum;
        $aoi->PartDesc = $req->PartDesc;
        $aoi->WareHouseCode = $req->WareHouseCode;
        $aoi->BinNum = $req->BinNum;
        $aoi->MainTranQty = $req->MainTranQty;
        $aoi->PhysicalQty = $req->PhysicalQty;
        $aoi->mtscbat_remarks = $req->mtscbat_remarks;
        $aoi->save();

        return back()->with('success', 'Data aoi berhasil diperbarui.');
    }

    public function truncateAoi(Request $request)
    {
        Aoi::truncate();
        return back()->with('success', 'Semua data aoi telah dihapus.');
    }
    public function destroyAoi($aoi_id)
    {
        try {
            $aoi = Aoi::findOrFail($aoi_id);

            // hapus gambar kalau ada
            if ($aoi->pictures && file_exists(public_path($aoi->pictures))) {
                unlink(public_path($aoi->pictures));
            }

            $aoi->delete();

            return redirect()->back()->with('success', 'Data aoi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
