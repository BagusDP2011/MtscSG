@extends('layouts.master')

@section('top')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .transaction-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: all 0.25s ease;
        cursor: pointer;
        text-decoration: none;
        color: #333;
        height: 320px;

        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .transaction-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.25);
        text-decoration: none;
        color: #333;
    }

    .machine-image-wrapper {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .machine-image-wrapper img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    .transaction-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .transaction-sub {
        font-size: 14px;
        color: #6c757d;
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

<div class="container mt-5">
    <h2 class="text-center mb-5"><b>Pilih Jenis Transaksi</b></h2>

    <div class="row justify-content-center">

        {{-- TRANSAKSI AXI --}}
        <div class="col-md-6 mb-4 d-flex justify-content-center">
            <a href="{{ route('admin.transaction.axi.AxiPage') }}" class="transaction-card">
                <div>
                    <div class="machine-image-wrapper">
                        <img src="{{ asset('assets/img/vitrox-axi.png') }}" alt="AXI Machine">
                    </div>
                    <div class="transaction-title">Transaksi AXI</div>
                    <div class="transaction-sub">
                        Barang masuk & keluar untuk AXI
                    </div>
                </div>
            </a>
        </div>

        {{-- TRANSAKSI AOI --}}
        <div class="col-md-6 mb-4 d-flex justify-content-center">
            <a href="{{ route('admin.transaction.aoi.page') }}" class="transaction-card">
                <div>
                    <div class="machine-image-wrapper">
                        <img src="{{ asset('assets/img/vitrox-aoi.png') }}" alt="AOI Machine">
                    </div>
                    <div class="transaction-title">Transaksi AOI</div>
                    <div class="transaction-sub">
                        Barang masuk & keluar untuk AOI
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

@endsection