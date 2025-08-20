@extends('layouts.master')

@section('top')
@endsection

@section('content')
<div class="container my-5">
    {{-- Paragraf Pengantar --}}
    <div class="mb-5">
        <h3 class="text-center font-weight-bold mb-4">Electronics Assembly</h3>
        <p class="text-center" style="line-height: 1.8;">
            Design and manufacture automated, intelligent and advanced machine vision inspection solutions for the electronics manufacturing industry, ranging from Advanced Solder Paste Inspection (SPI), Advanced 3D Optical Inspection (AOI), Advanced 3D X-ray inspection (AXI) and Advanced Robotic Vision (ARV) for Conformal Coating and Final Inspection. The innovative solutions are designed to enhance production yield capacity and provide quality assurance.
        </p>
    </div>

    {{-- Card Grid --}}
    <div class="row">
        @php
        $products = [
        [
        'title' => 'Advanced 3D Solder Paste Inspection (SPI)',
        'description_main' => 'Designed to enhance the production process with maximum throughput and provide high accuracy true 3D inspection image.',
        'ai_feature' => 'Artificial Intelligence (AI) feature is available',
        'image' => 'vitrox-spi.png',
        ],
        [
        'title' => 'Advanced 3D Optical Inspection (AOI)',
        'description_main' => 'Designed for various sizes of board inspection to enhance production efficiency, provide high accuracy 3D inspection images and provide cost-effective solutions for electronic manufacturing services, communication industry, etc.',
        'ai_feature' => 'Artificial Intelligence (AI) feature is available',
        'image' => 'vitrox-aoi.png',
        ],
        [
        'title' => 'Advanced 3D X-Ray Inspection (AXI)',
        'description_main' => 'Designed for various sizes of board inspection and provides comprehensive, reliable, and high speed X-ray inspection for hidden defects.',
        'ai_feature' => 'Artificial Intelligence (AI) feature is available',
        'image' => 'vitrox-axi.png',
        ],
        [
        'title' => 'Advanced Robotic Vision (ARV)',
        'description_main' => 'Revolutionary Robotic Vision Solution designed to cater for conformal coating and final inspection and for challenging and complex production process.',
        'ai_feature' => 'Artificial Intelligence (AI) feature is available',
        'image' => 'vitrox-v9.png',
        ],
        ];
        @endphp


        @foreach ($products as $product)
        <div class="col-md-6 col-lg-3 mb-4 d-flex align-items-stretch">
            <div class="card shadow-sm d-flex flex-column w-100">
                <!-- {{-- Gambar --}} -->
                <div style="height: 200px; overflow: hidden;" class="d-flex align-items-center justify-content-center bg-light">
                    <img src="{{ asset('assets/img/' . $product['image']) }}" alt="Image" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                </div>

                <!-- {{-- Konten --}} -->
                <div class="card-body d-flex flex-column h-100">
                    <h5 class="card-title">{{ $product['title'] }}</h5>

                    <p class="card-text flex-grow-1">
                        {!! $product['description_main'] !!}
                    </p>

                    <div class="mt-auto">
                        @if (!empty($product['ai_feature']))
                        <p class="text-muted small mb-2">
                            <em>* {{ $product['ai_feature'] }}</em>
                        </p>
                        @endif
                        <a href="#" class="btn btn-primary btn-sm w-100">Learn more</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@endsection

@section('bot')
@endsection