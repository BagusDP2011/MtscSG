@extends('layouts.master')

@section('top')
@endsection

@section('content')
<div class="container-fluid p-0">

    <!-- Hero Section -->
    <div class="position-relative">
        <img src="{{ asset('assets/img/vitrox.jpg') }}"
            class="w-100"
            style="height:450px; object-fit:cover;">

        <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
            <h1 class="display-4 fw-bold">ViTrox Corporation Berhad</h1>
            <p class="lead">
                World Leading Automated Vision Inspection Solution Provider
            </p>
        </div>
    </div>

    <div class="container py-5">

        <!-- Quick Facts -->
        <div class="row g-4 mb-5 ">

            <div class="col-md-3">
                <div class="card shadow-xl h-100 border-0 bg-gray rounded-4" style="padding: 10px; border-radius: 20px;">
                    <div class="card-body text-center">
                        <h2 class="text-primary">2000</h2>
                        <p class="mb-0">Founded</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow h-100 border-0 rounded-4 bg-gray" style="padding: 10px; border-radius: 20px;">
                    <div class="card-body text-center">
                        <h2 class="text-success">0097</h2>
                        <p class="mb-0">Bursa Malaysia Stock Code</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow h-100 border-0 rounded-4 bg-gray" style="padding: 10px; border-radius: 20px;">
                    <div class="card-body text-center">
                        <h2 class="text-danger">20+</h2>
                        <p class="mb-0">Countries Served</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow h-100 border-0 rounded-5 bg-gray" style="padding: 10px; border-radius: 20px;">
                    <div class="card-body text-center">
                        <h2 class="text-warning">Global</h2>
                        <p class="mb-0">Customer Network</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- About -->
        <div class="card border-0 shadow rounded-4 mb-5">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4">About ViTrox</h2>

                <p style="line-height:1.9;">
                    Since its inception in 2000, ViTrox has been designing and manufacturing
                    innovative, leading-edge, and cost-effective automated vision inspection
                    equipment and embedded electronic solutions for the semiconductor and
                    electronics industries.
                </p>

                <p style="line-height:1.9;">
                    The company provides advanced technologies that help manufacturers improve
                    quality, productivity, and operational efficiency through automation and
                    machine vision solutions.
                </p>
            </div>
        </div>

        <br>
        <!-- Main Products -->
        <h2 class="fw-bold text-center mb-4">Core Business Solutions</h2>

        <div class="row g-5 mb-5">

            <div class="col-md-4 mt-3">
                <div class="card border-0 shadow bg-gray rounded-4" style="border-radius: 20px;">
                    <div class="card-body text-center">
                        <h4 class="fw-bold text-primary">MVS</h4>
                        <p>Machine Vision System for semiconductor inspection.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3">
                <div class="card border-0 shadow bg-gray rounded-4" style="border-radius: 20px;">
                    <div class="card-body text-center">
                        <h4 class="fw-bold text-success">ABI</h4>
                        <p>Automated Board Inspection for PCB manufacturing.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3">
                <div class="card border-0 shadow bg-gray rounded-4" style="border-radius: 20px;">
                    <div class="card-body text-center">
                        <h4 class="fw-bold text-danger">IIES</h4>
                        <p>Integrated Industrial Embedded Solutions.</p>
                    </div>
                </div>
            </div>

            <br>
            <div class="row g-4 m-5" style="margin: 50px;">

                <div class="col-md-6 mt-5">
                    <div class="card border-0 shadow bg-gray rounded-4" style="border-radius: 20px;">
                        <div class="card-body text-center">
                            <h4 class="fw-bold text-warning">SPI</h4>
                            <p>
                                Automated Solder Paste Inspection systems that ensure solder paste quality
                                and improve SMT process control before component placement.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-5">
                    <div class="card border-0 shadow bg-gray rounded-4" style="border-radius: 20px;">
                        <div class="card-body text-center">
                            <h4 class="fw-bold text-info">AXI / X-Ray</h4>
                            <p>
                                Advanced Automated X-Ray Inspection solutions for detecting hidden solder
                                defects, BGA issues, voids, and internal assembly faults.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Timeline -->
        <div class="card border-0 shadow rounded-4 mb-5">
            <div class="card-body p-5">
                <h2 class="fw-bold text-center mb-4">Company Milestones</h2>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>2000</strong> – ViTrox was established.
                    </li>
                    <li class="list-group-item">
                        <strong>2004</strong> – Converted into a public limited company.
                    </li>
                    <li class="list-group-item">
                        <strong>2004</strong> – Listed on Bursa Malaysia.
                    </li>
                    <li class="list-group-item">
                        <strong>Today</strong> – Serving customers worldwide across Asia,
                        Europe, Australia, and the Americas.
                    </li>
                </ul>
            </div>
        </div>

        <br>
        <!-- Global Presence -->
        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-5 text-center">

                <h2 class="fw-bold mb-4">Global Presence</h2>

                <p style="line-height:1.9;">
                    ViTrox serves customers from Malaysia, Singapore, Indonesia,
                    Thailand, Vietnam, Philippines, Taiwan, China, Japan, Korea,
                    India, Australia, Europe, Brazil, Mexico, the USA, and many
                    other countries around the world.
                </p>

                <a href="https://www.vitrox.com"
                    target="_blank"
                    class="btn btn-primary btn-lg rounded-pill">
                    Visit Official Website
                </a>

            </div>
        </div>

    </div>
</div>
@endsection

@section('bot')
@endsection