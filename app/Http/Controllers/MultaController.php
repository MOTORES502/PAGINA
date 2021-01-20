<?php

namespace App\Http\Controllers;

use App\Traits\informacion;
use Illuminate\Http\Request;

class MultaController extends Controller
{
    use informacion;

    public function index()
    {
        $title = 'Linsk multas de tránsíto';
        $description = 'Página para ver las multas de tránsito en motores502.';
        $keywords = ['multa', 'multa guatemala', 'multa de tránsito', 'tránsito', 'consultar multas', 'multa de vehículo'];
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, '/multas', $image, 'website');

        $multas = $this->multas();

        return view('multas', compact('multas'));
    }
}
