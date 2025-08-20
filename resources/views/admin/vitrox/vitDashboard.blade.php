@extends('layouts.master')

@section('top')
@endsection

@section('content')
<div class="container my-5">
    <div>
        <h1 class="text-center text-bold font">ViTrox Corporation Berhad</h1>
    </div>
    <div class="text-center mb-4">
        <img src="{{ asset('assets/img/vitrox.jpg') }}" class="shadow-lg" alt="User Image" style="height: 300px;">
    </div>

    <div class="container bg-white p-4 rounded shadow-xxl" style="max-width: 800px;">
        <br>
        <p class="text-center" style="line-height: 1.8;">
            Since its inception in 2000, ViTrox designs and manufactures innovative, leading-edge, and cost-effective automated vision inspection equipment and system-on-chip embedded electronics devices for the semiconductor and electronics packaging industries.
        </p>
        <p class="text-center" style="line-height: 1.8;">
            ViTrox's core products are its Machine Vision System (MVS), Automated Board Inspection (ABI), and Integrated Industrial Embedded Solutions (IIES). ViTrox serves customers from semiconductor Outsourced Assembly and Test (OSAT) companies, printed circuit board manufacturers, electronics assemblies companies, Original Equipment Manufacturers (OEM), Original Design Manufacturers (ODM), Electronics Manufacturing Services (EMS) providers, and Contract Manufacturers (CM) around the world.
        </p>
        <p class="text-center" style="line-height: 1.8;">
            On 24th June 2004, ViTrox was converted into a public limited company and adopted the name of ViTrox Corporation Berhad. Currently, ViTrox is listed under the Main Board of Bursa Malaysia with stock code of 0097.
            ViTrox received numerous national and international recognitions and awards for its outstanding performance in product development and corporate performance, as well as human resource development.
        </p>
        <p class="text-center" style="line-height: 1.8;">
            At present, ViTrox is well recognized as one of the world-leading automated machine vision inspection solution providers with an extensive customer base in Malaysia, Singapore, Indonesia, Thailand, Vietnam, Philippines, Taiwan, China, Japan, Korea, India, Australia, Europe, Brazil, Mexico, the USA, and more.
        </p>
    </div>
</div>
@endsection

@section('bot')
@endsection
