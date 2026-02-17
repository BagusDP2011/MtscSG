@extends('layouts.master')

@section('top')
{{-- DataTables Bootstrap 3 --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css">
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-4">

    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-3"><b>History Transaksi Inventory</b></h4>
        </div>
    </div>

    <div class="panel panel-default shadow-sm">
        <div class="panel-body table-responsive">

            <table id="transactionTable" class="table table-bordered table-hover">
                <thead style="background:#f5f5f5">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Machine</th>
                        <th>Part Number</th>
                        <th>Deskripsi</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>UOM</th>
                        <th>Warehouse</th>
                        <th>Bin</th>
                        <th>Ref Type</th>
                        <th>Ref ID</th>
                        <th>Remarks</th>
                        <th>Created By</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaction as $index => $row)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($row->transaction_date)->format('d-m-Y H:i') }}
                        </td>

                        {{-- Machine --}}
                        <td class="text-center">
                            <span class="label label-default">
                                {{ $row->machine_type }}
                            </span>
                        </td>

                        {{-- Part --}}
                        <td><b>{{ $row->part_number }}</b></td>
                        <td>{{ $row->part_description }}</td>

                        {{-- Transaction Type --}}
                        <td class="text-center">
                            @if($row->transaction_type === 'IN')
                            <span class="label label-success">IN</span>
                            @elseif($row->transaction_type === 'OUT')
                            <span class="label label-danger">OUT</span>
                            @else
                            <span class="label label-warning">ADJUST</span>
                            @endif
                        </td>

                        {{-- Quantity --}}
                        <td class="text-right">
                            {{ number_format($row->quantity, 0) }}
                        </td>

                        <td class="text-center">
                            {{ $row->uom ?? 'pcs' }}
                        </td>

                        <td>{{ $row->warehouse_code }}</td>
                        <td>{{ $row->bin_code }}</td>

                        <td>{{ $row->reference_type }}</td>
                        <td>{{ $row->reference_id }}</td>

                        <td>{{ $row->remarks }}</td>

                        <td>{{ $row->created_by }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="14" class="text-center text-muted">
                            Belum ada data transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('bot')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- jQuery & DataTables --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#transactionTable').DataTable({
            order: [
                [1, 'desc']
            ],
            pageLength: 10,
            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                search: "Cari:",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });
</script>
@endsection