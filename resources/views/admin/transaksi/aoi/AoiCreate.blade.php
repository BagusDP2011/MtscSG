@extends('layouts.master')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0"><b>Tambah Transaksi AOI</b></h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.transaction.aoi.aoiStore') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Tanggal --}}
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Tanggal Transaksi</label>
                        <input type="datetime-local" name="transaction_date" class="form-control" required value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>

                    {{-- Tipe Transaksi --}}
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Tipe Transaksi</label>
                        <select name="transaction_type" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="IN">IN (Masuk)</option>
                            <option value="OUT">OUT (Keluar)</option>
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Quantity</label>
                        <input type="number" name="quantity"
                            class="form-control"
                            min="1" required>
                    </div>

                    <hr class="col-12">

                    {{-- Part Number --}}
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Part Number</label>
                        <input type="text" name="part_number"
                            class="form-control" required>
                    </div>

                    {{-- Warehouse --}}
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Warehouse</label>
                        <input type="text" name="warehouse_code"
                            class="form-control" required>
                    </div>

                    {{-- Bin --}}
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Bin</label>
                        <input type="text" name="bin_code"
                            class="form-control">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Deskripsi</label>
                        <input type="text" name="part_desc"
                            class="form-control">
                    </div>

                    {{-- Remarks --}}
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Remarks</label>
                        <textarea name="remarks"
                            class="form-control"
                            rows="3"
                            placeholder="Catatan tambahan (optional)"></textarea>
                    </div>

                </div>

                <div class="d-flex m-5" style="margin-top: 10px;">
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.transaction') }}"
                            class="btn btn-secondary">
                            Kembali
                        </a>

                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Transaksi
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection