<?php

namespace App\Imports;

use App\Models\Aoi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AoiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Aoi([
            'PartNum'          => $row['partnum'] ?? null,
            'PartDesc'         => $row['partdesc'] ?? null,
            'WareHouseCode'    => $row['warehousecode'] ?? null,
            'BinNum'           => $row['binnum'] ?? null,
            'MainTranQty'      => $row['maintranqty'] ?? null,
            'PhysicalQty'      => $row['physicalqty'] ?? null,
            'mtscbat_remarks'  => $row['mtscbat_remarks'] ?? $row['mtscbat remarks'] ?? null,
        ]);
    }
}
