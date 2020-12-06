<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    public function index($slug, $value)
    {
        $slug = str_replace('_', ' ', $slug);
        $title = "marca de vehículos $slug";
        $description = "todos los vehículos de la marca $slug";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/marca/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'website');

        $marca = DB::connection('mysql')->table('brands')
        ->select('name', 'image', 'description', 'code')
        ->where('name', base64_decode($value))
        ->first();

        $subs = DB::connection('mysql')->table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->select(
            'brands.id AS id',
            'brands.name AS nombre',
            'sub_categories_transports.sub_categories_id AS sub_id'
        )
        ->where('brands.name', base64_decode($value))
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->distinct('brands.id')
        ->orderBy('brands.name')
        ->get();

        $carros = array();

        foreach ($subs as $item) {
            $data['subs'] = DB::connection('mysql')->table('sub_categories')
            ->select('id', 'name')
            ->where('id', $item->sub_id)
            ->first();

            $data['carros'] = DB::connection('mysql')->table('sub_categories_transports')
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
                DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
                DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
                DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
            )
            ->where('sub_categories_transports.sub_categories_id', $item->sub_id)
            ->whereNull('transports.deleted_at')
            ->where('transports.status', 'DISPONIBLE')
            ->whereNull('brands.deleted_at')
            ->get();

            array_push($carros, $data);
        }

        $nuevo_ingreso = $this->nuevo_ingreso_marca(base64_decode($value));

        return view('marca', compact('marca', 'carros', 'nuevo_ingreso'));
    }
}
