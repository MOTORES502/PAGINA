<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function sub_categoria($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos por sub categoría $buscar";
        $description = "todos los vehículos de la sub categoría $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/sub-categoria/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'sub categoría');

        $titulo = "vehículos de la sub categoría $buscar";
        $buscar = mb_strtoupper($buscar);

        $data = DB::table('sub_categories_transports')
            ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
            ->join('brands', 'brands.id', 'transports.brands_id')
            ->join('lines', 'lines.id', 'transports.lines_id')
            ->join('generations', 'generations.id', 'transports.generations_id')
            ->join('models', 'models.id', 'transports.models_id')
            ->join('versions', 'versions.id', 'transports.versions_id')
            ->join('coins', 'transports.coins_id', 'coins.id')
            ->join('sub_categories', 'sub_categories_transports.sub_categories_id', 'sub_categories.id')
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
                DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
                'brands.image AS imagen_marca',
                'brands.name AS marca_alt'
            )
            ->where('sub_categories.name', $buscar)
            ->where('transports.status', 'DISPONIBLE')
            ->whereNull('transports.deleted_at')
            ->whereNull('sub_categories.deleted_at')
            ->orderByRaw('RAND()')
            ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));
    }

    public function marca($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos por marca $buscar";
        $description = "todos los vehículos de la marca $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca');

        $titulo = "vehículos de la marca $buscar";
        $buscar = mb_strtoupper($buscar);

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where('brands.name', $buscar)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));        
    }

    public function linea($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la linea $buscar";
        $description = "todos los vehículos de la linea $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/linea/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'linea');

        $titulo = "vehículos de la linea $buscar";
        $buscar = mb_strtoupper($buscar);

        $data = DB::table('lines')
        ->join('transports', 'lines.id', 'transports.lines_id')
        ->join('brands', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where('lines.name', $buscar)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('lines.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));           
    }

    public function marca_linea($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca y linea $buscar";
        $description = "todos los vehículos de la marca y linea $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca y linea');

        $titulo = "vehículos de la marca y línea $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('lines.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));    
    }

    public function generacion($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la generación $buscar";
        $description = "todos los vehículos de la generación $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/generacion/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'generación');

        $titulo = "vehículos de la generación $buscar";
        $buscar = mb_strtoupper($buscar);

        $data = DB::table('generations')
        ->join('transports', 'generations.id', 'transports.generations_id')
        ->join('brands', 'transports.brands_id', 'brands.id')
        ->join('lines', 'lines.id', 'transports.lines_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where('generations.name', $buscar)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('generations.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));    
    }

    public function marca_linea_generacion($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca, linea y generación $buscar";
        $description = "todos los vehículos de la marca, linea y generación $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea-generacion/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca, linea y generación');

        $titulo = "vehículos de la marca, linea y generación $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('lines.deleted_at')
        ->whereNull('generations.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));  
    }

    public function modelo($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos del modelo $buscar";
        $description = "todos los vehículos del modelo $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'modelo');
        
        $titulo = "vehículos del modelo $buscar";
        $buscar = mb_strtoupper($buscar);

        $data = DB::table('models')
        ->join('transports', 'models.id', 'transports.models_id')
        ->join('brands', 'transports.brands_id', 'brands.id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where('models.anio', $buscar)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('models.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));  
    }

    public function marca_linea_generacion_modelo($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca, linea, generación y modelo $buscar";
        $description = "todos los vehículos de la marca, linea, generación y modelo $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea-generacion-modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca, linea, generación y modelo');

        $titulo = "vehículos de la marca, linea y generación $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio))"), $quitar_espacios)
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('lines.deleted_at')
        ->whereNull('generations.deleted_at')
        ->whereNull('models.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));  
    }

    public function version($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la versión $buscar";
        $description = "todos los vehículos de la versión $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/version/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'versión');

        $titulo = "vehículos de la versión $buscar";
        $buscar = mb_strtoupper($buscar);

        $data = DB::table('versions')
        ->join('transports', 'versions.id', 'transports.versions_id')
        ->join('brands', 'transports.brands_id', 'brands.id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where('versions.name', $buscar)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('versions.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo')); 
    }

    public function marca_linea_generacion_modelo_version($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca, linea, generación, modelo y versión $buscar";
        $description = "todos los vehículos de la marca, linea, generación, modelo y versión $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea-generacion-modelo-version/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca, linea, generación, modelo y versión');

        $titulo = "vehículos de la marca, linea, generación, modelo y versión $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('lines.deleted_at')
        ->whereNull('generations.deleted_at')
        ->whereNull('models.deleted_at')
        ->whereNull('versions.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo')); 
    }

    public function marca_modelo($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca y modelo $buscar";
        $description = "todos los vehículos de la marca y modelo $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca y modelo');

        $titulo = "vehículos de la marca y modelo $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,models.anio))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('models.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo')); 
    }

    public function marca_linea_modelo_version($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca, linea, modelo y versión $buscar";
        $description = "todos los vehículos de la marca, linea, modelo y versión $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea-modelo-version/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca, linea, modelo y versión');

        $titulo = "vehículos de la marca, línea, modelo y versión $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,models.anio,versions.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('lines.deleted_at')
        ->whereNull('models.deleted_at')
        ->whereNull('versions.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo')); 
    }

    public function marca_version($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la marca y versión $buscar";
        $description = "todos los vehículos de la marca y versión $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-version/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca y versión');

        $titulo = "vehículos de la marca y versión $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,versions.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('versions.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));
    }

    public function version_modelo($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la versión y modelo $buscar";
        $description = "todos los vehículos de la versión y modelo $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/version-modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'versión y modelo');

        $titulo = "vehículos de la versión y modelo $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(versions.name,models.anio))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('models.deleted_at')
        ->whereNull('versions.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));
    }

    public function marca_linea_version($slug, $value)
    {
        $buscar = str_replace('-', ' ', $slug);

        //SEO
        $title = "vehículos de la versión y modelo $buscar";
        $description = "todos los vehículos de la versión y modelo $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/version-modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'versión y modelo');

        $titulo = "vehículos de la versión y modelo $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
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
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
            'brands.image AS imagen_marca',
            'brands.name AS marca_alt'
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,versions.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('models.deleted_at')
        ->whereNull('versions.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        return view('buscar', compact('data', 'existe', 'titulo'));
    }

    public function personalizada(Request $request)
    {
        if($request->get('search') && !empty($request->get('search'))) {
            $buscar = str_replace('-', ' ', $request->get('search'));

            //SEO
            $title = "busqueda personalizada $buscar";
            $description = "buscar $buscar en la base de datos";
            $keywords = array();
            $image = asset('img/logo_s_fondo_mrm.png');
            $url = "/busqueda/personalizada";

            $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

            $titulo = "vehículos encontrados con la siguiente descripción $buscar";
            $buscar = mb_strtoupper($buscar);
            $quitar_espacios = str_replace(' ', '', $buscar);

            $data = DB::table('sub_categories_transports')
                ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
                ->join('brands', 'brands.id', 'transports.brands_id')
                ->join('lines', 'lines.id', 'transports.lines_id')
                ->join('generations', 'generations.id', 'transports.generations_id')
                ->join('models', 'models.id', 'transports.models_id')
                ->join('versions', 'versions.id', 'transports.versions_id')
                ->join('coins', 'transports.coins_id', 'coins.id')
                ->join('sub_categories', 'sub_categories_transports.sub_categories_id', 'sub_categories.id')
                ->select(
                    DB::RAW('DISTINCT transports.code'),
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
                    DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt'),
                    'brands.image AS imagen_marca',
                    'brands.name AS marca_alt'
                )
                ->orWhere(DB::RAW('TRIM(sub_categories.name)'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(brands.name)'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(lines.name)'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(generations.name)'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(models.anio)'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(versions.name)'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name,generations.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name,models.anio,versions.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name,versions.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,versions.name,models.anio))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(versions.name,models.anio))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,versions.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(lines.name,versions.name))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,models.anio))'), $quitar_espacios)
                ->orWhere(DB::RAW('TRIM(CONCAT(lines.name,models.anio))'), $quitar_espacios)
                ->where('transports.status', 'DISPONIBLE')
                ->whereNull('transports.deleted_at')
                ->whereNull('sub_categories.deleted_at')
                ->orderByRaw('RAND()')
                ->paginate(16);

            $existe = count($data) == 0 ? false : true;

            return view('buscar', compact('data', 'existe', 'titulo'));
        } else {
            $titulo = '';
            $data = array();
            $existe = count($data) == 0 ? false : true;

            return view('buscar', compact('data', 'existe', 'titulo'));
        }
    }
}
