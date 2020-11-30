<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreguntasFrecuentesController extends Controller
{
    public function index()
    {
        $title = 'Preguntas frecuentes';
        $description = 'Preguntas que ayudarán a responder las inquietudes de los visitantes de motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        $marcas = $this->marcas();
        $arra_precio_bajo = $this->precios_minimos();
        $arra_precio_alto = $this->precios_maximos();

        return view('preguntas_frecuentes', compact('marcas', 'arra_precio_bajo', 'arra_precio_alto'));
    }
}
