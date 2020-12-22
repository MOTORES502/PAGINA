<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function marca($slug, $value, Request $request) //existe
    {
        $buscar = str_replace('_', ' ', $slug);

        //SEO
        $title = "vehículos por marca $buscar";
        $description = "todos los vehículos de la marca $buscar";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca');

        $titulo = "vehículos de la marca $buscar";
        $buscar = mb_strtoupper($buscar);

        $sub_categoria = (isset($request->sub_categoria) && !is_null($request->sub_categoria) && !empty($request->sub_categoria)) ? $request->sub_categoria : null;
        $ordenar_precio = (isset($request->ordenar_precio) && !is_null($request->ordenar_precio) && !empty($request->ordenar_precio)) ? $request->ordenar_precio : null;
        $ordenar_modelo = (isset($request->ordenar_modelo) && !is_null($request->ordenar_modelo) && !empty($request->ordenar_modelo)) ? $request->ordenar_modelo : null;

        $data = DB::connection('mysql')->table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->join('sub_categories', 'sub_categories.id', 'transports.sub_categories_id')
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
            'transports_images.concat AS alt',
            'transports.created_at',
            'transports.sub_categories_id AS sub_categories',
            DB::raw('(CASE WHEN coins.id = 1
            THEN 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) END
                )
            ELSE 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher*8
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)*8 END
                )            
            END) AS order_by')
        )
        ->where('brands.name', $buscar)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->when($sub_categoria, function ($query) use ($sub_categoria) {
            return $query->where('sub_categories.name', $sub_categoria);
        })
        ->when($ordenar_precio, function ($query) use ($ordenar_precio) {
            return $query->orderBy('order_by', $ordenar_precio);
        })
        ->when($ordenar_modelo, function ($query) use ($ordenar_modelo) {
            return $query->orderBy('models.anio', $ordenar_modelo);
        })
        ->when(is_null($ordenar_modelo) && is_null($ordenar_precio), function ($query) {
            return $query->orderByDesc('transports.created_at');
        })  
        ->paginate(16);

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $existe = count($data) == 0 ? false : true;

        $categorias = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('sub_categories', 'transports.sub_categories_id', 'sub_categories.id')
        ->select(
            'sub_categories.name AS sub_categories',
            'sub_categories.id AS id'
        )
            ->where('brands.name', $buscar)
        ->whereNull('transports.deleted_at')
        ->distinct('sub_categories.id')
        ->orderBy('sub_categories.name')
        ->get();

        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search', 'categorias'));        
    }

    public function marca_linea($slug, $value, Request $request) //existe
    {
        $buscar = str_replace('_', ' ', $slug);

        //SEO
        $title = "vehículos de la marca y línea $buscar";
        $description = "todos los vehículos de la marca y línea $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca y línea');

        $titulo = "vehículos de la marca y línea $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $sub_categoria = (isset($request->sub_categoria) && !is_null($request->sub_categoria) && !empty($request->sub_categoria)) ? $request->sub_categoria : null;
        $ordenar_precio = (isset($request->ordenar_precio) && !is_null($request->ordenar_precio) && !empty($request->ordenar_precio)) ? $request->ordenar_precio : null;
        $ordenar_modelo = (isset($request->ordenar_modelo) && !is_null($request->ordenar_modelo) && !empty($request->ordenar_modelo)) ? $request->ordenar_modelo : null;

        $data = DB::connection('mysql')->table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->join('sub_categories', 'sub_categories.id', 'transports.sub_categories_id')
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
            'transports_images.concat AS alt',
            'transports.created_at',
            'transports.sub_categories_id AS sub_categories',
            DB::raw('(CASE WHEN coins.id = 1
            THEN 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) END
                )
            ELSE 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher*8
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)*8 END
                )            
            END) AS order_by')
        )
        ->where(DB::RAW("REPLACE(CONCAT(brands.name,lines.name),' ','')"), $quitar_espacios)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->when($sub_categoria, function ($query) use ($sub_categoria) {
            return $query->where('sub_categories.name', $sub_categoria);
        })
        ->when($ordenar_precio, function ($query) use ($ordenar_precio) {
            return $query->orderBy('order_by', $ordenar_precio);
        })
        ->when($ordenar_modelo, function ($query) use ($ordenar_modelo) {
            return $query->orderBy('models.anio', $ordenar_modelo);
        })
        ->when(is_null($ordenar_modelo) && is_null($ordenar_precio), function ($query) {
            return $query->orderByDesc('transports.created_at');
        })  
        ->paginate(16);

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $existe = count($data) == 0 ? false : true;

        $categorias = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('sub_categories', 'transports.sub_categories_id', 'sub_categories.id')
        ->select(
            'sub_categories.name AS sub_categories',
            'sub_categories.id AS id'
        )
        ->where(DB::RAW("REPLACE(CONCAT(brands.name,lines.name),' ','')"), $quitar_espacios)
        ->whereNull('transports.deleted_at')
        ->distinct('sub_categories.id')
        ->orderBy('sub_categories.name')
        ->get();

        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search', 'categorias'));    
    }

    public function marca_modelo($slug, $value, Request $request) //existe
    {
        $buscar = str_replace('_', ' ', $slug);

        //SEO
        $title = "vehículos de la marca y modelo $buscar";
        $description = "todos los vehículos de la marca y modelo $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca y modelo');

        $titulo = "vehículos de la marca y modelo $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $sub_categoria = (isset($request->sub_categoria) && !is_null($request->sub_categoria) && !empty($request->sub_categoria)) ? $request->sub_categoria : null;
        $ordenar_precio = (isset($request->ordenar_precio) && !is_null($request->ordenar_precio) && !empty($request->ordenar_precio)) ? $request->ordenar_precio : null;
        $ordenar_modelo = (isset($request->ordenar_modelo) && !is_null($request->ordenar_modelo) && !empty($request->ordenar_modelo)) ? $request->ordenar_modelo : null;

        $data = DB::connection('mysql')->table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->join('sub_categories', 'sub_categories.id', 'transports.sub_categories_id')
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
            'transports_images.concat AS alt',
            'transports.created_at',
            'transports.sub_categories_id AS sub_categories',
            DB::raw('(CASE WHEN coins.id = 1
            THEN 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) END
                )
            ELSE 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher*8
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)*8 END
                )            
            END) AS order_by')
        )
        ->where(DB::RAW("REPLACE(CONCAT(brands.name,models.anio),' ','')"), $quitar_espacios)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->when($sub_categoria, function ($query) use ($sub_categoria) {
            return $query->where('sub_categories.name', $sub_categoria);
        })
        ->when($ordenar_precio, function ($query) use ($ordenar_precio) {
            return $query->orderBy('order_by', $ordenar_precio);
        })
        ->when($ordenar_modelo, function ($query) use ($ordenar_modelo) {
            return $query->orderBy('models.anio', $ordenar_modelo);
        })
        ->when(is_null($ordenar_modelo) && is_null($ordenar_precio), function ($query) {
            return $query->orderByDesc('transports.created_at');
        })  
        ->paginate(16);

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $existe = count($data) == 0 ? false : true;

        $categorias = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('sub_categories', 'transports.sub_categories_id', 'sub_categories.id')
        ->select(
            'sub_categories.name AS sub_categories',
            'sub_categories.id AS id'
        )
        ->where(DB::RAW("REPLACE(CONCAT(brands.name,models.anio),' ','')"), $quitar_espacios)
        ->whereNull('transports.deleted_at')
        ->distinct('sub_categories.id')
        ->orderBy('sub_categories.name')
        ->get();

        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search', 'categorias')); 
    }

    public function marca_linea_version($slug, $value, Request $request) //existe
    {
        $buscar = str_replace('_', ' ', $slug);

        //SEO
        $title = "vehículos de la versión y modelo $buscar";
        $description = "todos los vehículos de la versión y modelo $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/version-modelo/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'versión y modelo');

        $titulo = "vehículos de la versión y modelo $buscar";
        $quitar_espacios = mb_strtoupper(str_replace('_', ' ', $buscar));

        $sub_categoria = (isset($request->sub_categoria) && !is_null($request->sub_categoria) && !empty($request->sub_categoria)) ? $request->sub_categoria : null;
        $ordenar_precio = (isset($request->ordenar_precio) && !is_null($request->ordenar_precio) && !empty($request->ordenar_precio)) ? $request->ordenar_precio : null;
        $ordenar_modelo = (isset($request->ordenar_modelo) && !is_null($request->ordenar_modelo) && !empty($request->ordenar_modelo)) ? $request->ordenar_modelo : null;

        $data = DB::connection('mysql')->table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->join('sub_categories', 'sub_categories.id', 'transports.sub_categories_id')
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
            'transports_images.concat AS alt',
            'transports.created_at',
            'transports.sub_categories_id AS sub_categories',
            DB::raw('(CASE WHEN coins.id = 1
            THEN 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) END
                )
            ELSE 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher*8
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)*8 END
                )            
            END) AS order_by')
        )
        ->where(DB::RAW("CONCAT(brands.name,' ',lines.name,' ',versions.name)"), $quitar_espacios)
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->when($sub_categoria, function ($query) use ($sub_categoria) {
            return $query->where('sub_categories.name', $sub_categoria);
        })
        ->when($ordenar_precio, function ($query) use ($ordenar_precio) {
            return $query->orderBy('order_by', $ordenar_precio);
        })
        ->when($ordenar_modelo, function ($query) use ($ordenar_modelo) {
            return $query->orderBy('models.anio', $ordenar_modelo);
        })
        ->when(is_null($ordenar_modelo) && is_null($ordenar_precio), function ($query) {
            return $query->orderByDesc('transports.created_at');
        })       
        ->paginate(16);

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $existe = count($data) == 0 ? false : true;

        $categorias = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('sub_categories', 'transports.sub_categories_id', 'sub_categories.id')
        ->select(
            'sub_categories.name AS sub_categories',
            'sub_categories.id AS id'
        )
        ->where(DB::RAW("CONCAT(brands.name,' ',lines.name,' ',versions.name)"), $quitar_espacios)
        ->whereNull('transports.deleted_at')
        ->distinct('sub_categories.id')
        ->orderBy('sub_categories.name')
        ->get();

        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search', 'categorias'));
    }

    public function personalizada(Request $request)
    {
        $buscar = str_replace(['_', '+'], ' ', $request->get('search'));

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

        $sub_categoria = (isset($request->sub_categoria) && !is_null($request->sub_categoria) && !empty($request->sub_categoria)) ? $request->sub_categoria : null;
        $ordenar_precio = (isset($request->ordenar_precio) && !is_null($request->ordenar_precio) && !empty($request->ordenar_precio)) ? $request->ordenar_precio : null;
        $ordenar_modelo = (isset($request->ordenar_modelo)&& !is_null($request->ordenar_modelo) && !empty($request->ordenar_modelo)) ? $request->ordenar_modelo : null;

        $data = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('sub_categories', 'transports.sub_categories_id', 'sub_categories.id')
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
            'transports_images.concat AS alt',
            'transports.created_at',
            'transports.sub_categories_id AS sub_categories',
            DB::raw('(CASE WHEN coins.id = 1
            THEN 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) END
                )
            ELSE 
                (
                    CASE WHEN (SELECT COUNT(offe.price_offer) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0
                    THEN transports.price_publisher*8
                    ELSE (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)*8 END
                )            
            END) AS order_by')
        )
        ->orWhere(function ($query) use ($quitar_espacios) {
            $query->orWhere('transports.code', $quitar_espacios)
            ->orWhere('sub_categories.name', $quitar_espacios)
            ->orWhere('brands.name', $quitar_espacios)
            ->orWhere('lines.name', $quitar_espacios)
            ->orWhere('models.anio', $quitar_espacios)
            ->orWhere('versions.name', $quitar_espacios)
            ->orWhere(DB::RAW('CONCAT(models.anio,brands.name)'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(models.anio,brands.name,lines.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,generations.name,models.anio)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,models.anio,versions.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,versions.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,versions.name,models.anio)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(versions.name,models.anio)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,versions.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(lines.name,versions.name)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,models.anio)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(lines.name,models.anio)," ","")'), $quitar_espacios)
            ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,models.anio)," ","")'), $quitar_espacios);
        })        
        ->where('transports_images.order', 1)
        ->whereNull('transports.deleted_at')
        ->when($sub_categoria, function ($query) use ($sub_categoria) {
            return $query->where('sub_categories.name', $sub_categoria);
        })
        ->when($ordenar_precio, function ($query) use ($ordenar_precio) {
            return $query->orderBy('order_by', $ordenar_precio);
        })  
        ->when($ordenar_modelo, function ($query) use ($ordenar_modelo) {
            return $query->orderBy('models.anio', $ordenar_modelo);
        }) 
        ->when(is_null($ordenar_modelo) && is_null($ordenar_precio), function ($query) {
            return $query->orderByDesc('transports.created_at');
        })       
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $categorias = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('sub_categories', 'transports.sub_categories_id', 'sub_categories.id')
        ->select(
            'sub_categories.name AS sub_categories',
            'sub_categories.id AS id'
        )
        ->orWhere('transports.code', $quitar_espacios)
        ->orWhere('sub_categories.name', $quitar_espacios)
        ->orWhere('brands.name', $quitar_espacios)
        ->orWhere('lines.name', $quitar_espacios)
        ->orWhere('models.anio', $quitar_espacios)
        ->orWhere('versions.name', $quitar_espacios)
        ->orWhere(DB::RAW('CONCAT(models.anio,brands.name)'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(models.anio,brands.name,lines.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,generations.name,models.anio)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,models.anio,versions.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,versions.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,versions.name,models.anio)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(versions.name,models.anio)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,versions.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(lines.name,versions.name)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,models.anio)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(lines.name,models.anio)," ","")'), $quitar_espacios)
        ->orWhere(DB::RAW('REPLACE(CONCAT(brands.name,lines.name,models.anio)," ","")'), $quitar_espacios)
        ->whereNull('transports.deleted_at')
        ->distinct('sub_categories.id')
        ->orderBy('sub_categories.name')
        ->get();

        $search = $request->get('search');

        return view('buscar', compact('data', 'existe', 'titulo', 'search', 'categorias'));
    }

    public function buscador_combo(Request $request)
    {
        try {
            //SEO
            $title = "busqueda personalizada";
            $description = "buscar en la base de datos";
            $keywords = array();
            $image = asset('img/logo_s_fondo_mrm.png');
            $url = "/busqueda/personalizada";

            $this->seo($title, $description, $keywords, $url, $image, 'vehículo');
            $titulo = "Sin registro";

            /*$marca = (isset($request->marca_id) && !is_null($request->marca_id) && !empty($request->marca_id)) ? explode("lineas/", $request->marca_id) : array();
            $marca = count($marca) > 1 ? $marca[1] : null;*/
            $marca = (isset($request->marca_id) && !is_null($request->marca_id) && !empty($request->marca_id)) ? $request->marca_id : null;
            $linea = (isset($request->linea_id) && !is_null($request->linea_id) && !empty($request->linea_id)) ? $request->linea_id : 0;
            $precio_minimo = (isset($request->precio_minimo) && !is_null($request->precio_minimo) && !empty($request->precio_minimo)) ? $request->precio_minimo : 0;
            $precio_maximo = (isset($request->precio_maximo) && !is_null($request->precio_maximo) && !empty($request->precio_maximo)) ? $request->precio_maximo : 0;

            $precio_minimo_s = 0;
            if($precio_minimo > 0) {
                $precio_minimo_s = (int)($precio_minimo / 8);
            }
            $precio_maximo_s = 0;
            if ($precio_maximo > 0) {
                $precio_maximo_s = (int)($precio_maximo / 8);
            }

            $data = array();
            if(!is_null($marca) && $linea > 0 && $precio_minimo == 0 && $precio_maximo == 0) {
                $data = $this->buscar_c_marca_linea($marca, $linea);
                $titulo = "marca y línea";
            } elseif (!is_null($marca) && $precio_minimo == 0 && $precio_maximo == 0) {
                $data = $this->buscar_c_marca($marca);
                $titulo = "marca";
            } elseif (!is_null($marca) && $precio_minimo > 0 && $precio_maximo == 0) {
                $data = $this->buscar_c_marca_pm_pm($marca, $precio_minimo, 400000, $precio_minimo_s, 400000/8, 'asc');
                $titulo = "marca y precio mínimo";
            } elseif ($linea > 0 && $precio_minimo > 0 && $precio_maximo == 0) {
                $data = $this->buscar_c_linea_pm_pm($linea, $precio_minimo, 400000, $precio_minimo_s, 400000/8, 'asc');
                $titulo = "línea y precio mínimo";
            } elseif (is_null($marca) && $linea == 0 && $precio_minimo > 0 && $precio_maximo > 0) {
                $data = $this->buscar_c_pm_pm($precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, 'asc');
                $titulo = "precio mínimo y máximo";
            } elseif (!is_null($marca) && $precio_minimo == 0 && $precio_maximo > 0) {
                $data = $this->buscar_c_marca_pm_pm($marca, $precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, 'desc');
                $titulo = "marca y precio máximo";
            } elseif ($linea > 0 && $precio_minimo == 0 && $precio_maximo > 0) {
                $data = $this->buscar_c_linea_pm_pm($linea, $precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, 'desc');
                $titulo = "marca, línea y precio máximo";
            } elseif (is_null($marca) && $linea == 0 && $precio_minimo == 0 && $precio_maximo > 0) {
                $data = $this->buscar_c_pm_pm($precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, 'desc');
                $titulo = "precio máximo";
            } elseif (is_null($marca) && $linea == 0 && $precio_minimo > 0 && $precio_maximo == 0) {
                $data = $this->buscar_c_pm_pm($precio_minimo, 400000, $precio_minimo_s, 400000/8, 'asc');
                $titulo = "precio mínimo";
            }
            
            $existe = count($data) == 0 ? false : true;

            if ($request->ajax()) {
                return response()->json(['carro' => view('paginado.paginador_combo', compact('data'))->render()]);
            }

            $marca_id = $request->marca_id;
            $linea_id = $linea;
            $precio_minimo = $precio_minimo;
            $precio_maximo = $precio_maximo;
            $marcas = $this->marcas();
            $arra_precio_bajo = $this->precios_minimos();
            $arra_precio_alto = $this->precios_maximos();

            return view('buscar_combo', compact('data', 'existe', 'titulo', 'marca_id', 'linea_id', 'precio_minimo', 'precio_maximo', 'marcas', 'arra_precio_bajo', 'arra_precio_alto'));

        } catch (\Throwable $th) {
            return response()->json(['carro' => $th->getMessage()]);
        }
    }

    public function buscar_c_marca_linea($marca, $linea)
    {
        $todos = DB::connection('mysql')->table('transports')
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
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports_images.image AS image',
            'transports_images.concat AS alt'
        )
        ->whereNull('transports.deleted_at')
        ->where('lines.id', $linea)
        ->where('transports_images.order', 1)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_marca($marca)
    {
        $todos = DB::connection('mysql')->table('transports')
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
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports_images.image AS image',
            'transports_images.concat AS alt'
        )
        ->whereNull('transports.deleted_at')
        ->where('brands.id', $marca)
        ->where('transports_images.order', 1)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_marca_pm_pm($marca, $precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, $sort)
    {
        $consulta = DB::RAW('IF((SELECT COUNT(offe.price_offer) 
        FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
        transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
        AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))');
        $dolares = DB::connection('mysql')->table('transports')
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
            DB::RAW('IF((SELECT COUNT(offe.price_offer) 
            FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
            transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
            AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))*8 AS order_by'),
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
        ->where('coins.id', 2)
        ->whereBetween($consulta, [$precio_minimo_s, $precio_maximo_s])
        ->whereNull('transports.deleted_at')
        ->where('brands.id', $marca)
        ->where('transports_images.order', 1);

        $todos = DB::connection('mysql')->table('transports')
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
            DB::RAW('IF((SELECT COUNT(offe.price_offer) 
            FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
            transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
            AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)) AS order_by'),
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
        ->where('coins.id', 1)
        ->whereBetween($consulta, [$precio_minimo, $precio_maximo])
        ->whereNull('transports.deleted_at')
        ->where('brands.id', $marca)
        ->where('transports_images.order', 1)
        ->union($dolares, true)
        ->orderBy('order_by', $sort)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_linea_pm_pm($linea, $precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, $sort)
    {
        $consulta = DB::RAW('IF((SELECT COUNT(offe.price_offer) 
        FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
        transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
        AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))');
        $dolares = DB::connection('mysql')->table('transports')
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
            DB::RAW('IF((SELECT COUNT(offe.price_offer) 
            FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
            transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
            AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))*8 AS order_by'),
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
        ->where('coins.id', 2)
        ->whereBetween($consulta, [$precio_minimo_s, $precio_maximo_s])
        ->whereNull('transports.deleted_at')
        ->where('lines.id', $linea)
        ->where('transports_images.order', 1);

        $todos = DB::connection('mysql')->table('transports')
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
            DB::RAW('IF((SELECT COUNT(offe.price_offer) 
        FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
        transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
        AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)) AS order_by'),
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
        ->where('coins.id', 1)
        ->whereBetween($consulta, [$precio_minimo, $precio_maximo])
        ->whereNull('transports.deleted_at')
        ->where('lines.id', $linea)
        ->where('transports_images.order', 1)
        ->union($dolares, true)
        ->orderBy('order_by', $sort)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_pm_pm($precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, $sort)
    {
        $consulta = DB::RAW('IF((SELECT COUNT(offe.price_offer) 
        FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
        transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
        AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))');
        $dolares = DB::connection('mysql')->table('transports')
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
            DB::RAW('IF((SELECT COUNT(offe.price_offer) 
        FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
        transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
        AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))*8 AS order_by'),
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
        ->where('coins.id', 2)
        ->whereBetween($consulta, [$precio_minimo_s, $precio_maximo_s])
        ->whereNull('transports.deleted_at')
        ->where('transports_images.order', 1);

        $todos = DB::connection('mysql')->table('transports')
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
            DB::RAW('IF((SELECT COUNT(offe.price_offer) 
        FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = 0, 
        transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id 
        AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)) AS order_by'),
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
        ->where('coins.id', 1)
        ->whereBetween($consulta, [$precio_minimo, $precio_maximo])
        ->whereNull('transports.deleted_at')
        ->where('transports_images.order', 1)
        ->union($dolares, true)
        ->orderBy('order_by', $sort)
        ->paginate(12);

        return $todos;
    }
}
