<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuienesSomosController extends Controller
{
    public function index()
    {
        $title = 'Quienes somos';
        $description = 'Información de motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        $asesores = DB::connection()->table('users')
        ->join('people', 'users.people_id', 'people.id')
        ->join('people_phones', 'people.id', 'people_phones.people_id')
        ->select(
            'users.photo AS foto',
            'users.email AS email',
            DB::RAW('CONCAT(people.names," ",people.surnames) AS asesor'),
            'people_phones.number AS numero'
        )
        ->whereNull('users.deleted_at')
        ->where('users.aparece', true)
        ->orderByRaw('RAND()')
        ->distinct('users.id')
        ->get();

        return view('quienes_somos', compact('asesores'));
    }
}
