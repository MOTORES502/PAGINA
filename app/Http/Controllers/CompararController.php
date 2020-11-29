<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompararController extends Controller
{
    public function index()
    {
        $title = 'Comparador';
        $description = 'Comparar vehículos motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'wbesite');

        return view('comparar');
    }
}
