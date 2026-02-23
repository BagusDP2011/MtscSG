@extends('layouts.master')

@section('top')
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
@endsection

@php
$isStaff = auth()->user()->role === 'staff';
@endphp

@section('content')
Halo ini konten
<div class="row">
    @if(!$isStaff)
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>

                <p>System Users</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-secret"></i>
            </div>
            <a href="/admin/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endif

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-olive">
            <div class="inner">
                <h3>{{ \App\Models\Axi::count() }}</h3>

                <p>AXI Spareparts</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-x-ray"></i>
            </div>
            <a href="/admin/vitrox/axi" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-lime">
            <div class="inner">
                <h3>{{ \App\Models\Aoi::count() }}</h3>

                <p>AOI Spareparts</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-camera"></i>
            </div>
            <a href="/admin/vitrox/aoi" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @if(!$isStaff)
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ \App\Models\InventoryTransaction::count() }}</h3>

                <p>Transaction Recorded</p>
            </div>
            <div class="icon">
                <i class="fa fa-exchange"></i>
            </div>
            <a href="/admin/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('bot')
@endsection