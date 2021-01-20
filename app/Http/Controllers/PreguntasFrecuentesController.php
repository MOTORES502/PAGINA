<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreguntasFrecuentesController extends Controller
{
    public function index()
    {
        $title = 'Preguntas frecuentes';
        $description = 'Preguntas que ayudarán a responder las inquietudes de los visitantes de motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, '/preguntas_frecuentes', $image, 'website');

        $marcas = $this->marcas();
        $arra_precio_bajo = $this->precios_minimos();
        $arra_precio_alto = $this->precios_maximos();

        $categorias = DB::connection('mysql')->table('categoria_faqs')
        ->select(
            'id', 
            'name'
        )
        ->get();

        $preguntas = DB::connection('mysql')->table('faqs')
        ->select(
            'question',
            'reply',
            'categoria_faqs_id'
        )
        ->orderByDesc('updated_at')
        ->get();
        

        return view('preguntas_frecuentes', compact('marcas', 'arra_precio_bajo', 'arra_precio_alto', 'categorias', 'preguntas'));
    }
}
