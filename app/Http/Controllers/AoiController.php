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
}
