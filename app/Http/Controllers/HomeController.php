<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Sistema\ViewPage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Venta de carros usados, motos y más en consignación. Guatemala';
        $description = 'Si tiene motor, te ayudamos a venderlo en consignación. Carros usados y seminuevos en venta.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        
        $this->seo($title, $description, $keywords, null, $image, 'website');

        $subs = DB::connection('mysql')->table('sub_categories')
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

        $marcas = $this->marcas();

        $carros = $this->categorias_carros();
        if ($request->ajax()) {
            return response()->json(['sub' => view('paginado.categoria', compact('subs', 'carros'))->render(), 'carro' => view('paginado.carro', compact('subs', 'carros'))->render()]);
        }

        $ofertas = $this->ofertas();

        $total_carros = DB::connection('mysql')->table('transports')
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->count();
        
        $visitas = DB::connection('mysql')->table('views')
        ->count();

        $comparaciones = DB::connection('mysql')->table('comparations')
        ->count();

        $arra_precio_bajo = $this->precios_minimos();
        $arra_precio_alto = $this->precios_maximos();

        $blogs = DB::connection('mysql')->table('blog')
        ->join('users', 'blog.users_id', 'users.id')
        ->join('people', 'users.people_id', 'people.id')
        ->select(
            'blog.id AS id',
            'blog.image AS image',
            'blog.name AS name',
            'blog.description AS description',
            'blog.created_at AS created_at',
            DB::RAW('REPLACE(LOWER(blog.name)," ","_") AS slug'),
            DB::RAW('CONCAT(people.names," ",people.surnames) AS usuario')
        )
        ->whereNull('blog.deleted_at')->orderByRaw('RAND()')->limit(3)->get();
        
        return view('home', compact('ofertas', 'carros', 'subs', 'marcas', 'total_carros', 'visitas', 'arra_precio_bajo', 'arra_precio_alto', 'blogs', 'comparaciones'));
    }
}
