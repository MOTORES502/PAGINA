<?php

namespace App\Http\Controllers;

use App\Models\Sistema\Comparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompararController extends Controller
{
    public function index()
    {
        $title = 'Comparador';
        $description = 'Comparar vehículos motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        $carros = DB::connection('mysql')->table('comparations')
        ->join('transports AS one', 'comparations.one_id', 'one.id')
        ->join('brands AS brand_one', 'brand_one.id', 'one.brands_id')
        ->join('lines AS lines_one', 'lines_one.id', 'one.lines_id')
        ->join('generations AS generations_one', 'generations_one.id', 'one.generations_id')
        ->join('models AS models_one', 'models_one.id', 'one.models_id')
        ->join('versions AS versions_one', 'versions_one.id', 'one.versions_id')
        ->join('coins AS coins_one', 'one.coins_id', 'coins_one.id')
        ->join('transports AS two', 'comparations.two_id', 'two.id')
        ->join('brands AS brand_two', 'brand_two.id', 'two.brands_id')
        ->join('lines AS lines_two', 'lines_two.id', 'two.lines_id')
        ->join('generations AS generations_two', 'generations_two.id', 'two.generations_id')
        ->join('models AS models_two', 'models_two.id', 'two.models_id')
        ->join('versions AS versions_two', 'versions_two.id', 'two.versions_id')
        ->join('coins AS coins_two', 'two.coins_id', 'coins_two.id')
        ->select(
            'comparations.id AS id',
            'one.code AS code_one',
            'two.code AS code_two',
            DB::RAW('REPLACE(LOWER(CONCAT(brand_one.name,"-",lines_one.name,"-",versions_one.name,"-",models_one.anio))," ","") AS slug_one'),
            DB::RAW('REPLACE(LOWER(CONCAT(brand_two.name,"-",lines_two.name,"-",versions_two.name,"-",models_two.anio))," ","") AS slug_two'),
            DB::RAW('CONCAT(brand_one.name," ",lines_one.name," ",versions_one.name) AS completo_one'),
            DB::RAW('CONCAT(brand_two.name," ",lines_two.name," ",versions_two.name) AS completo_two'),
            DB::RAW('CONCAT(coins_one.symbol," ",FORMAT(one.price_publisher,2)) AS precio_one'),
            DB::RAW('CONCAT(coins_two.symbol," ",FORMAT(two.price_publisher,2)) AS precio_two'),
            DB::RAW('(SELECT CONCAT(coins_one.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = one.id AND offe.people_id = one.people_id AND offe.active = true LIMIT 1) AS oferta_one'),
            DB::RAW('(SELECT CONCAT(coins_two.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = two.id AND offe.people_id = two.people_id AND offe.active = true LIMIT 1) AS oferta_two'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = one.id AND i.order = 1 LIMIT 1) AS image_one'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = two.id AND i.order = 1 LIMIT 1) AS image_two'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = one.id AND i.order = 1 LIMIT 1) AS alt_one'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = two.id AND i.order = 1 LIMIT 1) AS alt_two')
        )
        ->orderByDesc('comparations.id')
        ->limit(4)
        ->get();

        $marcas = $this->marcas();

        return view('comparar', compact('carros', 'marcas'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $insert = new Comparation();
            $insert->one_id = $request->codigo_id_one;
            $insert->two_id = $request->codigo_id_two;
            $insert->visitor = $request->ip();
            $insert->save();

            DB::commit();

            return redirect()->back()->with('success', 'La cotización fue creado con existo, en breve momento un asesor se comunicara con usted para propocionar le más información');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', 'Lo sentimos hubo un inconveniente en el momento de guardar la información');
        }
    }
}
