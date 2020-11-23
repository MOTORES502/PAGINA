<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
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
        ->orderBy('brands.name')
        ->get();

        $carros = $this->categorias_carros();
        if ($request->ajax()) {
            return response()->json(['sub' => view('paginado.categoria', compact('subs', 'carros'))->render(), 'carro' => view('paginado.carro', compact('subs', 'carros'))->render()]);
        }

        $ofertas = $this->ofertas();
        $total_carros = DB::table('transports')
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->count();
        
        return view('home', compact('ofertas', 'carros', 'subs', 'marcas', 'total_carros'));
    }
}
