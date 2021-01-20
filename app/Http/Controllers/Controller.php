<?php

namespace App\Http\Controllers;

use App\Models\Catalogos\Category;
use Illuminate\Support\Facades\DB;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Config;
use Artesaos\SEOTools\Facades\OpenGraph;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function seo($title, $description, $keywords = [], $url = null, $image = null, $type = null)
    {
        $keywords_defaults = ['venta de carros', 'carros usados en venta', 'olx venta de carros', 'venta de carros usados', 'olx vehiculos', 'autos usados', 'toyota usados', 'usados de agencia', 'venta de autos', 'autos en venta', 'autos olx', 'venta de autos usados', 'carros de lujo', 'carros lujosos', 'autos de lujo', 'carros nuevos', 'sedan', 'hatchback',  'carros europeos', 'carros americanos', 'carros japoneses', 'carros de lujo'];

        foreach ($keywords_defaults as $key => $value) {
            array_push($keywords, mb_strtolower($value));
        }

        SEOMeta::setTitleDefault('Motores 502');
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        foreach ($keywords as $value) {
            SEOMeta::addKeyword($value);
        }
        SEOMeta::setTitleSeparator(', ');
        SEOMeta::setCanonical(Config::get('app.url') . $url, 'https://www.motores502.com/');

        $this->opengraph($image, $description, $title, $url, $type);
    }

    public function opengraph($image = null, $descripcion = null, $title = null, $url = null, $type = null)
    {
        OpenGraph::addProperty('locale', 'es_ES');
        if(!is_null($image)) {
            OpenGraph::addImage($image, ['size' => 300]);
        } else {
            OpenGraph::addImage('', ['size' => 300]);
        }
        if(!is_null($title)) {
            OpenGraph::setTitle($title);
        }
        if(!is_null($descripcion)) {
            OpenGraph::setDescription($descripcion);
        }
        if(!is_null($type)) {
            OpenGraph::setType($type);
        }
        if(!is_null($url)) {
            OpenGraph::setUrl(Config::get('app.url') . $url, 'https://www.motores502.com/');
        }

        $this->jsonld($image, $descripcion, $title, $type);
    }

    public function jsonld($image = null, $descripcion = null, $title = null, $type = null)
    {
        if (!is_null($image)) {
            JsonLd::addImage($image, ['size' => 300]);
        } else {
            JsonLd::addImage('https://www.motores502.com/img/Logo-Motores502.png', ['size' => 300]);
        }
        if (!is_null($title)) {
            JsonLd::setTitle($title);
        }
        if (!is_null($descripcion)) {
            JsonLd::setDescription($descripcion);
        }
        if (!is_null($type)) {
            JsonLd::setType($type);
        }
    }

    protected function ofertas()
    {
        return
            DB::connection('mysql')->table('transports_offers')
            ->join('coins', 'transports_offers.coins_id', 'coins.id')
            ->join('transports', 'transports_offers.transports_id', 'transports.id')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->join('fuels', 'fuels.id', 'transports.fuels_id')
            ->join('transports_engineers', 'transports.id', 'transports_engineers.transports_id')
            ->join('transmisions', 'transports_engineers.transmisions_id', 'transmisions.id')
            ->join('transports_images', 'transports.id', 'transports_images.transports_id')
            ->select(
                'transports.code AS codigo',
                'transports.status AS estado',
                DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
                DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
                DB::RAW('CONCAT("Marca: ",brands.name) AS marca'),
                DB::RAW('CONCAT("Linea: ",lines.name) AS linea'),
                DB::RAW('CONCAT("Versión: ",versions.name) AS version'),
                'models.anio AS modelo',
                'transports.mileage AS kilometro',
                'fuels.name AS combustible',
                'transmisions.name AS transmision',
                DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports_offers.price_offer,2)) AS precio'),
                'transports_images.image AS image',
                'transports_images.concat AS alt',
                DB::RAW('FORMAT(100-((transports_offers.price_offer*100)/transports.price_publisher),2) AS porcentaje')
            )
            ->where('transports.status', 'DISPONIBLE')
            ->where('transports_offers.active', true)
            ->whereNull('transports_offers.deleted_at')
            ->where('transports_images.order', 1)
            ->whereNull('transports.deleted_at')
            ->orderByDesc('transports_offers.updated_at')
            ->limit(9)
            ->get();
    }

    public function categorias_carros()
    {
        $carros = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
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
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports_images.image AS image',
            'transports_images.concat AS alt'
        )
        ->where('transports.status', 'DISPONIBLE')
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->orderByDesc('transports.updated_at')
        ->paginate(9, ['*'], 'carros');

        return $carros;
    }

    public function nuevo_ingreso($sub_categoria_id)
    {
        $carros = DB::connection('mysql')->table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
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
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT("Marca: ",brands.name) AS marca'),
            DB::RAW('CONCAT("Linea: ",lines.name) AS linea'),
            DB::RAW('CONCAT("Versión: ",versions.name) AS version'),
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            'transmisions.name AS transmision',
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports_images.image AS image',
            'transports_images.concat AS alt'
        )
        ->where('sub_categories_transports.sub_categories_id', $sub_categoria_id)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->orderByDesc('transports.created_at')
        ->limit(18)
        ->get();

        return $carros;
    }

    public function nuevo_ingreso_marca($marca)
    {
        $carros = DB::connection('mysql')->table('transports')
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
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT("Marca: ",brands.name) AS marca'),
            DB::RAW('CONCAT("Linea: ",lines.name) AS linea'),
            DB::RAW('CONCAT("Versión: ",versions.name) AS version'),
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            'transmisions.name AS transmision',
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports_images.image AS image',
            'transports_images.concat AS alt'
        )
        ->where('brands.id', $marca)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->orderByDesc('transports.created_at')
        ->limit(18)
        ->get();

        return $carros;
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

    public function precios_minimos()
    {
        $arra_precio_bajo = array();

        for ($i = 0; $i < 350001; $i = $i + 50000) {
            $registro['numero'] = $i;
            $registro['numero_formato'] = "Q " . number_format($i, 0, '.', ',');
            array_push($arra_precio_bajo, $registro);
        }

        return $arra_precio_bajo;
    }

    public function precios_maximos()
    {
        $arra_precio_alto = array();

        for ($i = 50000; $i < 400001; $i = $i + 50000) {
            $registro['numero'] = $i;
            $registro['numero_formato'] = "Q " . number_format($i, 0, '.', ',');
            array_push($arra_precio_alto, $registro);
        }
        
        return $arra_precio_alto;
    }

    public function marcas()
    {
        return Category::select('id', 'name')->with('brands:id,name,categories_id', 'sub_categorias:id,name,icon,categories_id')->get();
    }

    public function generadorCodigo($id, $abreviatura)
    {
        $año = date('Y');
        $codigo = str_pad(strval($id), 3, "0", STR_PAD_LEFT);
        return "{$abreviatura}-{$codigo}-{$año}";
    }
}
