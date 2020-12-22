<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function categoria($slug, $value, Request $request)
    {
        $slug = str_replace('_', ' ', $slug);
        $title = "categoría de vehículos $slug";
        $description = "todos los vehículos de la categoria $slug";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/categoria/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'website');

        $sub_categoria = DB::connection('mysql')->table('sub_categories')
                        ->select('name', 'icon', 'id')
                        ->where('id', base64_decode($value))
                        ->first();

        $carros = DB::connection('mysql')->table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->join('transports_engineers', 'transports.id', 'transports_engineers.transports_id')
        ->join('transmisions', 'transports_engineers.transmisions_id', 'transmisions.id')
        ->join('transports_images', 'transports.id', 'transports_images.transports_id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            'transmisions.name AS transmision',
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports_images.image AS image',
            'transports_images.concat AS alt',
            'brands.name AS brands_name',
            'brands.image AS brands_image',
            'brands.id AS brands_id'
        )
        ->where('sub_categories_transports.sub_categories_id', $sub_categoria->id)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->orderByDesc('transports.created_at')
        ->paginate(10);

        if ($request->ajax()) {
            return response()->json(view('paginado.categoria_carros', compact('carros'))->render());
        }

        $nuevo_ingreso = $this->nuevo_ingreso(base64_decode($value));
        
        return view('categoria', compact('sub_categoria', 'carros', 'nuevo_ingreso'));
    }
}
