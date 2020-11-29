<?php

namespace App\Http\Controllers;

use App\Traits\informacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    use informacion;

    public function index()
    {
        $title = 'Contacto';
        $description = 'Contacto con motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'wbesite');

        $horario = $this->horario_atencion();
        $ubicacion = $this->ubicacion();
        $canales = $this->canales();

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
        ->distinct('users.id')
        ->get();
        
        return view('contacto', compact('horario', 'ubicacion', 'canales', 'asesores'));
    }
}
