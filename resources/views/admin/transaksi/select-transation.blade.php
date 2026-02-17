@extends('layouts.master')

@section('top')
<style>
    .transaction-card {
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transition: all 0.25s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .transaction-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 30px rgba(0,0,0,0.25);
        text-decoration: none;
        color: inherit;
    }

    .card-axi {
        background: linear-gradient(135deg, #43cea2, #185a9d);
        color: #fff;
    }

    .card-aoi {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
    }

    .transaction-icon {
        font-size: 64px;
        margin-bottom: 15px;
    }

    .transaction-title {
        font-size: 26px;
        font-weight: bold;
    }

    .transaction-sub {
        font-size: 14px;
        opacity: 0.9;
    }
</style>
@endsection

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4"><b>Pilih Jenis Transaksi</b></h2>

    <div class="row justify-content-center">
        
        {{-- TRANSAKSI AXI --}}
        <div class="col-md-5 mb-4">
            <a href="{{ route('inventory.transaction.axi') }}" class="transaction-card card-axi">
                <div>
                    <div class="transaction-icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <div class="transaction-title">Transaksi AXI</div>
                    <div class="transaction-sub">
                        Barang masuk / keluar untuk AXI
                    </div>
                </div>
            </a>
        </div>

        {{-- TRANSAKSI AOI --}}
        <div class="col-md-5 mb-4">
            <a href="{{ route('inventory.transaction.aoi') }}" class="transaction-card card-aoi">
                <div>
                    <div class="transaction-icon">
                        <i class="fa fa-industry"></i>
                    </div>
                    <div class="transaction-title">Transaksi AOI</div>
                    <div class="transaction-sub">
                        Barang masuk / keluar untuk AOI
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

@endsection
