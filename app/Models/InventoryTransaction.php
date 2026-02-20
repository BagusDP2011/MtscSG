<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    protected $table = 'inventory_transactions';

    protected $fillable = [
        'machine_type',
        'part_number',
        'part_description',
        'transaction_type',   // IN | OUT | ADJUST
        'quantity',
        'uom',
        'warehouse_code',
        'bin_code',
        'reference_type',     // AXI | AOI | MANUAL
        'reference_id',
        'transaction_date',
        'remarks',
        'created_by',
    ];
}
