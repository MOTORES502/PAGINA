<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller
{
    public function vehiculo($slug, $value)
    {
        $vehiculo = DB::table('transports')
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
            DB::RAW('LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio)) AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio) AS nombre_completo'),
            DB::RAW('CONCAT(generations.name," Generación (",generations.start," - ",generations.end,")") AS generacion'),
            'brands.image AS imagen_marca',
            'transports.price_publisher AS precio_sf',
            'coins.id AS moneda',
            'coins.symbol AS symbol',
            DB::RAW('substring(transports.code, INSTR(transports.code, "|")+1) AS facebook'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta_sf')
        )
        ->where('transports.code', base64_decode($value))
        ->first();  

        if(is_null($vehiculo))
            return redirect()->route('home');

        $images = DB::table('transports_images')
        ->select('image', 'concat')
        ->where('transports_images.transports_id', $vehiculo->id)
        ->orderByDesc('order')
        ->get();

        $sub_categoria = DB::table('sub_categories_transports')->where('transports_id', $vehiculo->id)->whereIn('option', [1,2])->first();
        $precio = is_null($vehiculo->oferta_sf) ? intval($vehiculo->precio) : intval($vehiculo->oferta_sf);
        $precios_carros = $this->recomendacion($precio, $vehiculo->moneda, $sub_categoria->sub_categories_id, $vehiculo->id);
        $enganche = $this->calcular_enganche($precio, $vehiculo->symbol);

        $general = DB::table('transports_engineers')
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
        ->where('transports_engineers.transports_id', $vehiculo->id)
        ->first();

        $comfort = DB::table('transports_mod_cons')
        ->select('transports_mod_cons.description AS description')
        ->where('transports_mod_cons.transports_id', $vehiculo->id)
        ->first();

        $seguridad = DB::table('transports_securities')
        ->select('transports_securities.description AS description')
        ->where('transports_securities.transports_id', $vehiculo->id)
        ->first();

        $diferencia = DB::table('transports_differences')
        ->join('differences', 'transports_differences.differences_id', 'differences.id')
        ->select(
            'differences.name AS name'
        )
        ->where('transports_differences.transports_id', $vehiculo->id)
        ->get();

        $extra = DB::table('additional_features')
        ->select('additional_features.description AS description')
        ->where('additional_features.transports_id', $vehiculo->id)
        ->first();

        $ubicacion = DB::table('transports_business')
        ->join('bussines', 'transports_business.bussines_id', 'bussines.id')
        ->join('bussines_locations', 'bussines.id', 'bussines_locations.bussines_id')
        ->join('municipalities', 'bussines_locations.municipalities_id', 'municipalities.id')
        ->join('departaments', 'municipalities.departaments_id', 'departaments.id')
        ->join('countries', 'departaments.countries_id', 'countries.id')
        ->select(
            DB::RAW('CONCAT(countries.name,", ",departaments.name,", ",municipalities.name,", ",bussines_locations.location) AS location')
        )
        ->where('transports_business.transports_id', $vehiculo->id)
        ->get();

        $tipos_telefono = DB::table('type_phone')
        ->select('id', 'name')
        ->get();

        $canales = DB::table('channels')
        ->select('id', 'name')
        ->whereNull('deleted_at')
        ->get();

        //SEO
        $nombre = mb_strtolower($vehiculo->nombre_completo);
        $title = $nombre;
        $description = "el vehículo seleccionado para ver la información es $nombre";
        $keywords = array();
        $image = count($images) > 0 ? $images[0]->image : asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

        return view('vehiculo', compact('vehiculo', 'images', 'precios_carros', 'precio', 'enganche', 'general', 'comfort', 'seguridad', 'diferencia', 'extra', 'ubicacion', 'tipos_telefono', 'canales'));
    }

    public function calcular_enganche($precio, $moneda)
    {
        $enganche = ($precio / 100) * 20;
        return $moneda." ".$enganche;
    }

    public function recomendacion($precio, $moneda, $sub_categories_transports, $id)
    {
        switch ($moneda) {
            case 1:
                $pmax = $precio + 40000;
                $pmin = $precio - 20000;

                $moneda_s = 2;
                $pmin_s = (int)($pmin / 8);
                $pmax_s = (int)($pmax / 8);
                break;

            case 2:
                $pmax = $precio + 20000;
                $pmin = $precio - 10000;

                $moneda_s = 1;
                $pmin_s = $pmin * 8;
                $pmax_s = $pmax * 8;
                break;

            default:
                $pmax = $precio + 100000;
                $pmin = $precio - 10000;

                $moneda_s = 1;
                $pmin_s = $pmin * 8;
                $pmax_s = $pmax * 8;
                break;
        }
        
        $dolares = DB::table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT("Marcar: ",brands.name) AS marca'),
            DB::RAW('CONCAT("Linea: ",lines.name," ",versions.name) AS linea'),
            DB::RAW('CONCAT("Modelo: ",models.anio) AS modelo'),
            DB::RAW('CONCAT("Kilometraje: ",transports.mileage) AS kilometro'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
        ->where('sub_categories_transports.sub_categories_id', $sub_categories_transports)
        ->where('coins.id', $moneda_s)
        ->whereBetween(DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))'), [$pmin_s, $pmax_s])
        ->whereNull('transports.deleted_at')
        ->where('transports.id', '!=', $id)
        ->where('transports.status', 'DISPONIBLE');

        $todos = DB::table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT("Marcar: ",brands.name) AS marca'),
            DB::RAW('CONCAT("Linea: ",lines.name," ",versions.name) AS linea'),
            DB::RAW('CONCAT("Modelo: ",models.anio) AS modelo'),
            DB::RAW('CONCAT("Kilometraje: ",transports.mileage) AS kilometro'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
        ->where('sub_categories_transports.sub_categories_id', $sub_categories_transports)
        ->where('coins.id', $moneda)
        ->whereBetween(DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))'), [$pmin, $pmax])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('transports.id', '!=', $id)
        ->union($dolares)
        ->orderByRaw('RAND()')
        ->limit(12)
        ->get();  
        
        
        return $this->parserCarrusel($todos);
    }
}
