<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Venta de carros usados, motos y más en consignación. Guatemala';
        $description = 'Si tiene motor, te ayudamos a venderlo en consignación. Carros usados y seminuevos en venta.';
        $keywords = array();
        $url_https = 'https://www.motores502.com/';
        
        $this->seo($title, $description, $keywords, $url_https);

        $ofertas = $this->ofertas();
        $carros = $this->categorias_carros();

        return view('home', compact('ofertas', 'carros'));
    }
}
