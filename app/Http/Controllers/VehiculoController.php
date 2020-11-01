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
        ->select(
            'transports.id AS id',
            'transports.code AS codigo',
            'transports.status AS estado',
            DB::RAW('LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio)) AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio) AS nombre_completo'),
            DB::RAW('CONCAT(generations.name," Generación (",generations.start," - ",generations.end,")") AS generacion'),
            'brands.image AS imagen_marca',
            'transports.price_publisher AS precio_sf',
            'coins.id AS moneda',
            'coins.symbol AS symbol',
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

        //SEO
        $nombre = mb_strtolower($vehiculo->nombre_completo);
        $title = $nombre;
        $description = "el vehículo seleccionado para ver la información es $nombre";
        $keywords = array();
        $image = count($images) > 0 ? $images[0]->image : asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

        return view('vehiculo', compact('vehiculo', 'images', 'precios_carros', 'precio', 'enganche'));
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
