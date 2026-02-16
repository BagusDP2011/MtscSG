<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function vitDashboard()
    {
        return view('admin.vitrox.vitDashboard');
    }

    public function machines()
    {
        return view('admin.vitrox.machines');
    }

    public function spi()
    {
        return view('admin.vitrox.spi');
    }


}
