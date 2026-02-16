<?php

namespace App\Http\Controllers;

use App\Models\AxiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AxiImageController extends Controller
{
    public function bulkUploadImages(Request $request)
    {
        $request->validate([
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            'axi_id'   => 'nullable|integer',
            'filename' => 'string'
        ]);

        $uploadFolder = public_path('assets/upload/axi');

        if (!File::exists($uploadFolder)) {
            File::makeDirectory($uploadFolder, 0755, true);
        }

        foreach ($request->file('images') as $image) {
            $filename = $image->getClientOriginalName();
            $fullPath = $uploadFolder . '/' . $filename;

            if (File::exists($fullPath)) {
                Log::info("File skipped (already exists): {$filename}");
                continue;
            }

            $existsInDb = AxiImage::where('image_path', 'assets/upload/axi/' . $filename)->exists();
            if ($existsInDb) {
                continue;
            }

            $image->move($uploadFolder, $filename);

            AxiImage::create([
                'axi_id'     => $request->axi_id,
                'image_path' => 'assets/upload/axi/' . $filename,
                'filename'   => $filename
            ]);
        }

        return redirect()->back()->with('success', 'Bulk images uploaded successfully (duplicate files skipped).');
    }
}
