@extends('layouts.master')

@section('top')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .card {
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border: none;
    }

    .table th {
        background-color: #f8f9fc;
        font-weight: 600;
    }

    .btn-add {
        border-radius: 8px;
    }
</style>
@endsection

@section('content')

{{-- ALERT --}}
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container-fluid mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><b>Transaksi Inventory AXI</b></h4>

        <a href="{{ route('admin.transaction.axi.AxiCreate') }}" class="btn btn-primary btn-add">
            <i class="fa fa-plus"></i> Tambah Transaksi
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table id="axiTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Part Number</th>
                            <th>Deskripsi</th>
                            <th>Warehouse</th>
                            <th>Bin</th>
                            <th>Tipe</th>
                            <th>Qty</th>
                            <th>Remarks</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $trx)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $trx->transaction_date }}</td>
                            <td>{{ $trx->part_num }}</td>
                            <td>{{ $trx->part_desc }}</td>
                            <td>{{ $trx->warehouse_code }}</td>
                            <td>{{ $trx->bin_code }}</td>
                            <td>
                                <span class="badge {{ $trx->transaction_type == 'IN' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $trx->transaction_type }}
                                </span>
                            </td>
                            <td>{{ $trx->quantity }}</td>
                            <td>{{ $trx->remarks }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.transaction.axi.edit', $trx->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form action="{{ route('admin.transaction.axi.delete', $trx->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Belum ada transaksi AXI
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection

@section('bot')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(function() {
        $('#axiTable').DataTable({
            pageLength: 10,
            ordering: true,
            responsive: true,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Prev",
                    next: "Next"
                }
            }
        });
    });
</script>
@endsection