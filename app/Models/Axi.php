<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Axi extends Model
{
    use HasFactory;

    protected $table = 'axis';

    protected $fillable = [
        'PartNum',
        'PartDesc',
        'WareHouseCode',
        'BinNum',
        'MainTranQty',
        'PhysicalQty',
        'mtscbat_remarks',
        'pictures',
    ];
}
