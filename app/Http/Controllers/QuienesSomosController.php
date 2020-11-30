<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuienesSomosController extends Controller
{
    public function index()
    {
        $title = 'Quienes somos';
        $description = 'Información de motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        return view('quienes_somos');
    }
}
