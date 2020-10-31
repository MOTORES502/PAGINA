<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Artesaos\SEOTools\Facades\SEOMeta;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function seo($title, $description, $keywords = [], $url_https)
    {
        $keywords_defaults = ['venta de carros', 'carros usados en venta', 'olx venta de carros', 'venta de carros usados', 'olx vehiculos', 'autos usados', 'toyota usados', 'usados de agencia', 'venta de autos', 'autos en venta', 'autos olx', 'venta de autos usados', 'carros de lujo', 'carros lujosos', 'autos de lujo', 'carros nuevos', 'sedan', 'hatchback',  'carros europeos', 'carros americanos', 'carros japoneses', 'carros de lujo'];

        foreach ($keywords_defaults as $key => $value) {
            array_push($keywords, mb_strtolower($value));
        }

        $categorias = DB::table('categories')
        ->select('name');

        $sub_categorias = DB::table('sub_categories')
        ->select('name');

        $marcas = DB::table('brands')
        ->select('name')
        ->union($categorias)
        ->union($sub_categorias)
        ->groupBy('name')
        ->get();

        foreach ($marcas as $key => $value) {
            array_push($keywords, mb_strtolower($value->name));
        }

        SEOMeta::setTitleDefault('Motores 502');
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        foreach ($keywords as $value) {
            SEOMeta::addKeyword($value);
        }
        SEOMeta::setTitleSeparator(', ');
        SEOMeta::setCanonical($url_https);
    }

    protected function ofertas()
    {
        return
            DB::table('transports_offers')
            ->join('coins', 'transports_offers.coins_id', 'coins.id')
            ->join('transports', 'transports_offers.transports_id', 'transports.id')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('generations', 'generations.id', 'transports.generations_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->select(
                'transports.code AS codigo',
                'transports.status AS estado',
                DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
                DB::RAW('CONCAT("Marcar: ",brands.name) AS marca'),
                DB::RAW('CONCAT("Linea: ",lines.name," ",versions.name) AS linea'),
                DB::RAW('CONCAT("Modelo: ",models.anio) AS modelo'),
                DB::RAW('CONCAT("Kilometraje: ",transports.mileage) AS kilometro'),
                DB::RAW('CONCAT("Valor: ",coins.symbol," ",FORMAT(transports_offers.price_offer,2)) AS precio'),
                DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
                DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
            )
            ->where('transports.status', 'DISPONIBLE')
            ->where('transports_offers.active', true)
            ->whereNull('transports_offers.deleted_at')
            ->whereNull('transports.deleted_at')
            ->orderByDesc('transports_offers.updated_at')
            ->limit(4)
            ->get();
    }

    public function categorias_carros()
    {
        $cantidad_categorias = 3;
        $array_uno = array();
        $sub_categorias = DB::table('sub_categories')
        ->join('categories', 'sub_categories.categories_id', 'categories.id')
        ->select('sub_categories.id AS id', DB::RAW('CONCAT(categories.name," / ",sub_categories.name) AS name'))
        ->whereNull('sub_categories.deleted_at')
        ->whereNull('categories.deleted_at')
        ->inRandomOrder()
            ->limit($cantidad_categorias)
            ->get();

        foreach ($sub_categorias as $key => $value) {

            $sub['nombre'] = $value->name;
            $sub['carrusel'] = array();
            array_push($array_uno, $sub);

            $carros = DB::table('sub_categories_transports')
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
                ->where('sub_categories_transports.sub_categories_id', $value->id)
                ->where('transports.status', 'DISPONIBLE')
                ->whereNull('transports.deleted_at')
                ->orderByDesc('transports.updated_at')
                ->limit(12)
                ->get();

            $items_carrusel = 4;
            for ($i = 0; $i < (count($carros) / $items_carrusel); $i++) {
                $carrusel['numero'] = $i;
                $carrusel['vehiculos'] = array();
                $contador = $items_carrusel;

                foreach ($carros as $llave => $value_dos) {
                    if ($contador == 0) {
                        break;
                    } else {
                        array_push($carrusel['vehiculos'], $value_dos);
                        $contador--;
                        unset($carros[$llave]);
                    }
                }

                array_push($array_uno[$key]['carrusel'], $carrusel);
            }
        }

        return $array_uno;
    }

    public function nuevo_ingreso($sub_categoria_id)
    {
        $array_uno = array();

        $carros = DB::table('sub_categories_transports')
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
        ->where('sub_categories_transports.sub_categories_id', $sub_categoria_id)
        ->whereNull('transports.deleted_at')
        ->orderByDesc('transports.created_at')
        ->limit(12)
        ->get();

        $items_carrusel = 4;

        for ($i = 0; $i < (count($carros) / $items_carrusel); $i++) {
            $carrusel['numero'] = $i;
            $carrusel['vehiculos'] = array();
            $contador = $items_carrusel;

            foreach ($carros as $llave => $value_dos) {
                if ($contador == 0) {
                    break;
                } else {
                    array_push($carrusel['vehiculos'], $value_dos);
                    $contador--;
                    unset($carros[$llave]);
                }
            }

            array_push($array_uno, $carrusel);
        }

        return $array_uno;
    }

    public function parserCarrusel($carros)
    {
        $array_uno = array();
        $items_carrusel = 4;

        for ($i = 0; $i < (count($carros) / $items_carrusel); $i++) {
            $carrusel['numero'] = $i;
            $carrusel['vehiculos'] = array();
            $contador = $items_carrusel;

            foreach ($carros as $llave => $value_dos) {
                if ($contador == 0) {
                    break;
                } else {
                    array_push($carrusel['vehiculos'], $value_dos);
                    $contador--;
                    unset($carros[$llave]);
                }
            }

            array_push($array_uno, $carrusel);
        }

        return $array_uno;
    }
}
