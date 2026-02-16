<?php

namespace App\Http\Controllers;

use App\Models\AoiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AoiImageController extends Controller
{
    public function bulkUploadImages(Request $request)
    {
        $request->validate([
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            'aoi_id'   => 'nullable|integer',
            'filename' => 'string'
        ]);

        $uploadFolder = public_path('assets/upload/aoi');

        if (!File::exists($uploadFolder)) {
            File::makeDirectory($uploadFolder, 0755, true);
        }

        $images = (array) $request->file('images');

        foreach ($images as $image) {

            $filename = $image->getClientOriginalName();
            $relativePath = 'assets/upload/aoi/' . $filename;
            $fullPath = $uploadFolder . '/' . $filename;

            // Skip jika file sudah ada di folder
            if (File::exists($fullPath)) {
                Log::info("AOI image skipped (file exists): {$filename}");
                continue;
            }

            // Skip jika sudah ada di DB
            $existsInDb = AoiImage::where('image_path', $relativePath)->exists();
            if ($existsInDb) {
                Log::info("AOI image skipped (db exists): {$filename}");
                continue;
            }

            // Simpan file
            $image->move($uploadFolder, $filename);

            // Simpan DB
            AoiImage::create([
                'aoi_id'     => $request->aoi_id,
                'image_path' => $relativePath,
                'filename'   => $filename,
            ]);
        }

        return redirect()->back()
            ->with('success', 'AOI images uploaded successfully (duplicate files skipped).');
    }
}
