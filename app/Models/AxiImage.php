<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AxiImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'axi_id',
        'image_path',
    ];

    public function axi()
    {
        return $this->belongsTo(Axi::class, 'axi_id');
    }
}
