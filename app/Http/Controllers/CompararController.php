<?php

namespace App\Http\Controllers;

use App\Models\Sistema\Comparation;
use App\Models\Sistema\Transport;
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

        $this->seo($title, $description, $keywords, '/comparador', $image, 'website');

        $carros = $this->getComparaciones();
        $marcas = $this->marcas();

        return view('comparar', compact('carros', 'marcas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->message());
        try {
            DB::beginTransaction();

            $insert = new Comparation();
            $insert->one_id = $request->codigo_id_one;
            $insert->two_id = $request->codigo_id_two;
            $insert->visitor = $request->ip();
            $insert->save();

            $vehiculo_one = DB::connection('mysql')->table('transports')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('generations', 'generations.id', 'transports.generations_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->join('coins', 'transports.coins_id', 'coins.id')
            ->join('fuels', 'transports.fuels_id', 'fuels.id')
            ->join('colors', 'transports.colors_id', 'colors.id')
            ->select(
                'transports.id AS id',
                'transports.code AS codigo',
                'transports.status AS estado',
                'fuels.name AS fuels',
                'colors.name AS colors',
                'brands.name AS marca',
                DB::RAW('LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio)) AS slug'),
                DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio) AS nombre_completo'),
                DB::RAW('CONCAT(generations.name," Generación (",generations.start," - ",generations.end,")") AS generacion'),
                'brands.image AS imagen_marca',
                'transports.price_publisher AS precio_sf',
                'coins.id AS moneda',
                'coins.symbol AS symbol',
                'transports.mileage',
                'transports.people_id AS people_id',
                DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
                DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
                DB::RAW('(SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta_sf')
            )
            ->where('transports.id', $insert->one_id)
            ->first();

            $image_one = DB::connection('mysql')->table('transports_images')
            ->select('image', 'concat')
            ->where('transports_images.transports_id', $vehiculo_one->id)
            ->where('order', 1)
            ->first();


            $general_one = DB::connection('mysql')->table('transports_engineers')
            ->join('tractions', 'transports_engineers.tractions_id', 'tractions.id')
            ->join('transmisions', 'transports_engineers.transmisions_id', 'transmisions.id')
            ->join('yields', 'transports_engineers.yields_id', 'yields.id')
            ->join('fabrications', 'transports_engineers.fabrications_id', 'fabrications.id')
            ->select(
                'tractions.name AS tractions',
                'transmisions.name AS transmisions',
                'yields.name AS yields',
                'fabrications.name AS fabrications',
                'transports_engineers.description AS description'
            )
            ->where('transports_engineers.transports_id', $vehiculo_one->id)
            ->first();

            $comfort_one = DB::connection('mysql')->table('transports_mod_cons')
            ->select('transports_mod_cons.description AS description')
            ->where('transports_mod_cons.transports_id', $vehiculo_one->id)
            ->first();

            $seguridad_one = DB::connection('mysql')->table('transports_securities')
            ->select('transports_securities.description AS description')
            ->where('transports_securities.transports_id', $vehiculo_one->id)
            ->first();

            $diferencia_one = DB::connection('mysql')->table('transports_differences')
            ->join('differences', 'transports_differences.differences_id', 'differences.id')
            ->select(
                'differences.name AS name'
            )
            ->where('transports_differences.transports_id', $vehiculo_one->id)
            ->get();

            $extra_one = DB::connection('mysql')->table('additional_features')
            ->select('additional_features.description AS description')
            ->where('additional_features.transports_id', $vehiculo_one->id)
            ->first();

            $vehiculo_two = DB::connection('mysql')->table('transports')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('generations', 'generations.id', 'transports.generations_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->join('coins', 'transports.coins_id', 'coins.id')
            ->join('fuels', 'transports.fuels_id', 'fuels.id')
            ->join('colors', 'transports.colors_id', 'colors.id')
            ->select(
                'transports.id AS id',
                'transports.code AS codigo',
                'transports.status AS estado',
                'fuels.name AS fuels',
                'colors.name AS colors',
                'brands.name AS marca',
                DB::RAW('LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio)) AS slug'),
                DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio) AS nombre_completo'),
                DB::RAW('CONCAT(generations.name," Generación (",generations.start," - ",generations.end,")") AS generacion'),
                'brands.image AS imagen_marca',
                'transports.price_publisher AS precio_sf',
                'coins.id AS moneda',
                'coins.symbol AS symbol',
                'transports.mileage',
                'transports.people_id AS people_id',
                DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
                DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
                DB::RAW('(SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta_sf')
            )
            ->where('transports.id', $insert->two_id)
            ->first();

            $image_two = DB::connection('mysql')->table('transports_images')
            ->select('image', 'concat')
            ->where('transports_images.transports_id', $vehiculo_two->id)
            ->where('order', 1)
            ->first();

            $general_two = DB::connection('mysql')->table('transports_engineers')
            ->join('tractions', 'transports_engineers.tractions_id', 'tractions.id')
            ->join('transmisions', 'transports_engineers.transmisions_id', 'transmisions.id')
            ->join('yields', 'transports_engineers.yields_id', 'yields.id')
            ->join('fabrications', 'transports_engineers.fabrications_id', 'fabrications.id')
            ->select(
                'tractions.name AS tractions',
                'transmisions.name AS transmisions',
                'yields.name AS yields',
                'fabrications.name AS fabrications',
                'transports_engineers.description AS description'
            )
            ->where('transports_engineers.transports_id', $vehiculo_two->id)
            ->first();

            $comfort_two = DB::connection('mysql')->table('transports_mod_cons')
            ->select('transports_mod_cons.description AS description')
            ->where('transports_mod_cons.transports_id', $vehiculo_two->id)
            ->first();

            $seguridad_two = DB::connection('mysql')->table('transports_securities')
            ->select('transports_securities.description AS description')
            ->where('transports_securities.transports_id', $vehiculo_two->id)
            ->first();

            $diferencia_two = DB::connection('mysql')->table('transports_differences')
            ->join('differences', 'transports_differences.differences_id', 'differences.id')
            ->select(
                'differences.name AS name'
            )
            ->where('transports_differences.transports_id', $vehiculo_two->id)
            ->get();

            $extra_two = DB::connection('mysql')->table('additional_features')
            ->select('additional_features.description AS description')
            ->where('additional_features.transports_id', $vehiculo_two->id)
            ->first();

            DB::commit();

            $title = 'Comparando vehículo';
            $description = "Comparando $vehiculo_one->nombre_completo con $vehiculo_two->nombre_completo";
            $keywords = array();
            $image = asset('img/logo_s_fondo_mrm.png');

            $this->seo($title, $description, $keywords, null, $image, 'website');

            $carros = $this->getComparaciones();

            return view('comparar_dos', 
            compact('vehiculo_one', 'vehiculo_two', 'image_one', 
            'image_two', 'general_one', 'general_two', 'comfort_one', 
            'comfort_two', 'seguridad_one', 'seguridad_two',
            'diferencia_one', 'diferencia_two', 'extra_one', 'extra_two', 'carros'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', "Ocurrio un problema, por favor intentelo más tarde.");
        }
    }

    public function compracion_historica($slug_uno, Comparation $comparacion, $slug_dos)
    {
        try {
            DB::beginTransaction();

            $vehiculo_one = DB::connection('mysql')->table('transports')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('generations', 'generations.id', 'transports.generations_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->join('coins', 'transports.coins_id', 'coins.id')
            ->join('fuels', 'transports.fuels_id', 'fuels.id')
            ->join('colors', 'transports.colors_id', 'colors.id')
            ->select(
                'transports.id AS id',
                'transports.code AS codigo',
                'transports.status AS estado',
                'fuels.name AS fuels',
                'colors.name AS colors',
                'brands.name AS marca',
                DB::RAW('LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio)) AS slug'),
                DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio) AS nombre_completo'),
                DB::RAW('CONCAT(generations.name," Generación (",generations.start," - ",generations.end,")") AS generacion'),
                'brands.image AS imagen_marca',
                'transports.price_publisher AS precio_sf',
                'coins.id AS moneda',
                'coins.symbol AS symbol',
                'transports.mileage',
                'transports.people_id AS people_id',
                DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
                DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
                DB::RAW('(SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta_sf')
            )
                ->where('transports.id', $comparacion->one_id)
                ->first();

            $image_one = DB::connection('mysql')->table('transports_images')
            ->select('image', 'concat')
            ->where('transports_images.transports_id', $vehiculo_one->id)
                ->where('order', 1)
                ->first();


            $general_one = DB::connection('mysql')->table('transports_engineers')
            ->join('tractions', 'transports_engineers.tractions_id', 'tractions.id')
            ->join('transmisions', 'transports_engineers.transmisions_id', 'transmisions.id')
            ->join('yields', 'transports_engineers.yields_id', 'yields.id')
            ->join('fabrications', 'transports_engineers.fabrications_id', 'fabrications.id')
            ->select(
                'tractions.name AS tractions',
                'transmisions.name AS transmisions',
                'yields.name AS yields',
                'fabrications.name AS fabrications',
                'transports_engineers.description AS description'
            )
                ->where('transports_engineers.transports_id', $vehiculo_one->id)
                ->first();

            $comfort_one = DB::connection('mysql')->table('transports_mod_cons')
            ->select('transports_mod_cons.description AS description')
            ->where('transports_mod_cons.transports_id', $vehiculo_one->id)
                ->first();

            $seguridad_one = DB::connection('mysql')->table('transports_securities')
            ->select('transports_securities.description AS description')
            ->where('transports_securities.transports_id', $vehiculo_one->id)
                ->first();

            $diferencia_one = DB::connection('mysql')->table('transports_differences')
            ->join('differences', 'transports_differences.differences_id', 'differences.id')
            ->select(
                'differences.name AS name'
            )
                ->where('transports_differences.transports_id', $vehiculo_one->id)
                ->get();

            $extra_one = DB::connection('mysql')->table('additional_features')
            ->select('additional_features.description AS description')
            ->where('additional_features.transports_id', $vehiculo_one->id)
                ->first();

            $vehiculo_two = DB::connection('mysql')->table('transports')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('generations', 'generations.id', 'transports.generations_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->join('coins', 'transports.coins_id', 'coins.id')
            ->join('fuels', 'transports.fuels_id', 'fuels.id')
            ->join('colors', 'transports.colors_id', 'colors.id')
            ->select(
                'transports.id AS id',
                'transports.code AS codigo',
                'transports.status AS estado',
                'fuels.name AS fuels',
                'colors.name AS colors',
                'brands.name AS marca',
                DB::RAW('LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio)) AS slug'),
                DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio) AS nombre_completo'),
                DB::RAW('CONCAT(generations.name," Generación (",generations.start," - ",generations.end,")") AS generacion'),
                'brands.image AS imagen_marca',
                'transports.price_publisher AS precio_sf',
                'coins.id AS moneda',
                'coins.symbol AS symbol',
                'transports.mileage',
                'transports.people_id AS people_id',
                DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
                DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
                DB::RAW('(SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta_sf')
            )
                ->where('transports.id', $comparacion->two_id)
                ->first();

            $image_two = DB::connection('mysql')->table('transports_images')
            ->select('image', 'concat')
            ->where('transports_images.transports_id', $vehiculo_two->id)
                ->where('order', 1)
                ->first();

            $general_two = DB::connection('mysql')->table('transports_engineers')
            ->join('tractions', 'transports_engineers.tractions_id', 'tractions.id')
            ->join('transmisions', 'transports_engineers.transmisions_id', 'transmisions.id')
            ->join('yields', 'transports_engineers.yields_id', 'yields.id')
            ->join('fabrications', 'transports_engineers.fabrications_id', 'fabrications.id')
            ->select(
                'tractions.name AS tractions',
                'transmisions.name AS transmisions',
                'yields.name AS yields',
                'fabrications.name AS fabrications',
                'transports_engineers.description AS description'
            )
                ->where('transports_engineers.transports_id', $vehiculo_two->id)
                ->first();

            $comfort_two = DB::connection('mysql')->table('transports_mod_cons')
            ->select('transports_mod_cons.description AS description')
            ->where('transports_mod_cons.transports_id', $vehiculo_two->id)
                ->first();

            $seguridad_two = DB::connection('mysql')->table('transports_securities')
            ->select('transports_securities.description AS description')
            ->where('transports_securities.transports_id', $vehiculo_two->id)
                ->first();

            $diferencia_two = DB::connection('mysql')->table('transports_differences')
            ->join('differences', 'transports_differences.differences_id', 'differences.id')
            ->select(
                'differences.name AS name'
            )
                ->where('transports_differences.transports_id', $vehiculo_two->id)
                ->get();

            $extra_two = DB::connection('mysql')->table('additional_features')
            ->select('additional_features.description AS description')
            ->where('additional_features.transports_id', $vehiculo_two->id)
                ->first();

            DB::commit();

            $title = 'Comparando vehículo';
            $description = "Comparando $vehiculo_one->nombre_completo con $vehiculo_two->nombre_completo";
            $keywords = array();
            $image = asset('img/logo_s_fondo_mrm.png');

            $this->seo($title, $description, $keywords, null, $image, 'website');

            $carros = $this->getComparaciones();

            return view(
                'comparar_dos',
                compact(
                    'vehiculo_one',
                    'vehiculo_two',
                    'image_one',
                    'image_two',
                    'general_one',
                    'general_two',
                    'comfort_one',
                    'comfort_two',
                    'seguridad_one',
                    'seguridad_two',
                    'diferencia_one',
                    'diferencia_two',
                    'extra_one',
                    'extra_two',
                    'carros'
                )
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', "Ocurrio un problema, por favor intentelo más tarde.");
        }        
    }

    public function getComparaciones()
    {
        return DB::connection('mysql')->table('comparations')
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
        ->join('transports_images AS image_consulta_one', 'one.id', 'image_consulta_one.transports_id')
        ->join('transports_images AS image_consulta_two', 'two.id', 'image_consulta_two.transports_id')
        ->select(
            'comparations.id AS id',
            'one.code AS code_one',
            'two.code AS code_two',
            'one.status AS estado_one',
            'two.status AS estado_two',
            DB::RAW('REPLACE(LOWER(CONCAT(brand_one.name,"-",lines_one.name,"-",versions_one.name,"-",models_one.anio))," ","") AS slug_one'),
            DB::RAW('REPLACE(LOWER(CONCAT(brand_two.name,"-",lines_two.name,"-",versions_two.name,"-",models_two.anio))," ","") AS slug_two'),
            DB::RAW('CONCAT(brand_one.name," ",lines_one.name," ",versions_one.name) AS completo_one'),
            DB::RAW('CONCAT(brand_two.name," ",lines_two.name," ",versions_two.name) AS completo_two'),
            DB::RAW('CONCAT(coins_one.symbol," ",FORMAT(one.price_publisher,2)) AS precio_one'),
            DB::RAW('CONCAT(coins_two.symbol," ",FORMAT(two.price_publisher,2)) AS precio_two'),
            DB::RAW('IF(one.offer IS NULL, one.offer, CONCAT(coins_one.symbol," ",FORMAT(one.offer,2))) AS oferta_one'),
            DB::RAW('IF(two.offer IS NULL, two.offer, CONCAT(coins_two.symbol," ",FORMAT(two.offer,2))) AS oferta_two'),
            'image_consulta_one.image AS image_one',
            'image_consulta_one.concat AS alt_one',
            'image_consulta_two.image AS image_two',
            'image_consulta_two.concat AS alt_two'
        )
        ->where('image_consulta_one.order', 1)
        ->where('image_consulta_two.order', 1)
        ->orderByRaw('RAND()')
        ->limit(4)
        ->get();
    }

    public function rules()
    {
        return [
            'codigo_id_one' => 'required|integer|exists:transports,id',
            'codigo_id_two' => 'required|integer|exists:transports,id'
        ];
    }

    public function message()
    {
        return [
            'codigo_id_one.required' => 'El primer vehículo es obligatorio',
            'codigo_id_one.integer' => 'El primer vehículo no tiene formato válido',
            'codigo_id_one.exists' => 'El primer vehículo no existe en la base de datos',

            'codigo_id_two.required' => 'El primer vehículo es obligatorio',
            'codigo_id_two.integer' => 'El primer vehículo no tiene formato válido',
            'codigo_id_two.exists' => 'El primer vehículo no existe en la base de datos',
        ];
    }
}
