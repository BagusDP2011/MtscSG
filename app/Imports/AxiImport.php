<?php

namespace App\Imports;

use App\Models\Axi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AxiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $partNum = $row['part id'] ?? $row['partnum'] ?? null;
        $partDesc = $row['part description'] ?? $row['partdesc'] ?? null;
        $binNum = $row['binnum'] ?? $row['bin num'] ?? null;
        $mainTranQty = $row['maintranqty'] ?? $row['systemqty'] ?? null;
        $physicalQty = $row['physicalqty'] ?? null;
        $remarks = $row['mtscbat_remarks'] ?? $row['mtscbat remarks'] ?? null;

        // Skip jika semua kosong
        if (
            is_null($partNum) &&
            is_null($partDesc) &&
            is_null($binNum) &&
            is_null($mainTranQty) &&
            is_null($physicalQty) &&
            is_null($remarks)
        ) {
            return null;
        }

        return new Axi([
            'PartNum' => $partNum,
            'PartDesc' => $partDesc,
            'WareHouseCode' => 'Batam',
            'BinNum' => $binNum,
            'MainTranQty' => $mainTranQty,
            'PhysicalQty' => $physicalQty,
            'mtscbat_remarks' => $remarks,
        ]);
    }
}
