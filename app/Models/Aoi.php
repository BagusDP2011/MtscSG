<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aoi extends Model
{
    protected $fillable = [
        'PartNum',
        'PartDesc',
        'WareHouseCode',
        'BinNum',
        'MainTranQty',
        'PhysicalQty',
        'mtscbat_remarks',
        'MTSCBAT',
        'Remarks',
    ];

    
}
