<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Venta de carros usados, motos y más en consignación. Guatemala';
        $description = 'Si tiene motor, te ayudamos a venderlo en consignación. Carros usados y seminuevos en venta.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        
        $this->seo($title, $description, $keywords, null, $image, 'wbesite');

        $subs = DB::table('sub_categories')
        ->select(
            'id', 
            'name', 
            'icon',
            DB::RAW('(SELECT COUNT(*) 
                FROM sub_categories_transports 
                WHERE sub_categories_transports.sub_categories_id = sub_categories.id 
                AND sub_categories_transports.deleted_at IS NULL) AS cantidad')
        )
        ->whereNull('deleted_at')->paginate(8, ['*'], 'categorias');

        $marcas = DB::table('transports')
        ->join('brands', 'transports.brands_id', 'brands.id')
        ->select('brands.id', 'brands.name')
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->groupByRaw('brands.id')
        ->groupByRaw('brands.name')
        ->orderByDesc('brands.name')
        ->get();

        $ofertas = $this->ofertas();
        $carros = $this->categorias_carros();

        return view('home', compact('ofertas', 'carros', 'subs', 'marcas'));
    }
}
