@extends('layouts.master')

@section('top')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<form action="{{ route('admin.vitrox.import.aoi') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="file">Upload Excel AOI</label>
        <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
    </div>
    <button type="submit" class="btn btn-success">Import AOI</button>
</form>

<table id="aoiTable" class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>PartNum</th>
            <th>PartDesc</th>
            <th>WareHouseCode</th>
            <th>BinNum</th>
            <th>MainTranQty</th>
            <th>PhysicalQty</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @isset($aoiData)
        @foreach ($aoiData as $item)
        <tr>
            <td>{{ $item->PartNum }}</td>
            <td>{{ $item->PartDesc }}</td>
            <td>{{ $item->WareHouseCode }}</td>
            <td>{{ $item->BinNum }}</td>

            <td @if($item->MainTranQty != $item->PhysicalQty) style="background-color: yellow;" @endif>
                {{ $item->MainTranQty }}
            </td>
            <td @if($item->MainTranQty != $item->PhysicalQty) style="background-color: yellow;" @endif>
                {{ $item->PhysicalQty }}
            </td>

            <td>{{ $item->mtscbat_remarks }}</td>
        </tr>
        @endforeach
        @endisset
    </tbody>

</table>




@endsection

@section('bot')
<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#aoiTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthChange: true,
            ordering: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
        });
    });
</script>
@endsection