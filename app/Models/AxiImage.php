<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AxiImage extends Model
{
    use HasFactory;
    protected $primaryKey = 'images_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'axi_id',
        'image_path',
        'filename',
    ];

    public function axi()
    {
        return $this->belongsTo(Axi::class, 'axi_id');
    }
}
