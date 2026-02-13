<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AxiImage;

class AxiController extends Controller
{
    public function bulkUploadImages(Request $request)
    {
        $request->validate([
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:5120',
            'axi_id'   => 'nullable|integer'
        ]);
    
        foreach ($request->file('images') as $image) {
    
            $path = $image->store('axi_images', 'public');
    
            AxiImage::create([
                'axi_id'     => $request->axi_id,
                'image_path' => $path
            ]);
        }
    
        return back()->with('success', 'Bulk images uploaded successfully.');
    }
}



