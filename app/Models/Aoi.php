<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aoi extends Model
{
    use HasFactory;
    protected $primaryKey = 'aoi_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $table = 'aois';
    
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
