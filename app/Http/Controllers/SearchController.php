<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function marca($slug, $value) //existe
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

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
        ->where('brands.name', $buscar)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;
        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search'));        
    }

    public function marca_linea($slug, $value) //existe
    {
        $buscar = str_replace('_', ' ', $slug);

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
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;
        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search'));    
    }

    public function marca_modelo($slug, $value) //existe
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

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,models.anio))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->whereNull('brands.deleted_at')
        ->whereNull('models.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;
        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search')); 
    }

    public function marca_linea_version($slug, $value) //existe
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
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::table('brands')
        ->join('transports', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
        ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,versions.name))"), $quitar_espacios)
        ->where('transports.status', 'DISPONIBLE')
        ->whereNull('transports.deleted_at')
        ->orderByRaw('RAND()')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;
        $search = '';

        return view('buscar', compact('data', 'existe', 'titulo', 'search'));
    }

    public function personalizada(Request $request)
    {
        $buscar = str_replace('_', ' ', $request->get('search'));

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
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            'transports.code AS codigo',
            'transports.status AS estado',
            'models.anio AS modelo',
            'transports.mileage AS kilometro',
            'fuels.name AS combustible',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name) AS completo'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('(SELECT CONCAT(coins.symbol," ",FORMAT(offe.price_offer,2)) FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) AS oferta'),
            DB::RAW('(SELECT i.image FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS image'),
            DB::RAW('(SELECT i.concat FROM transports_images i WHERE i.transports_id = transports.id AND i.order = 1 LIMIT 1) AS alt')
        )
            ->orWhere(DB::RAW('substring(transports.code, INSTR(transports.code, "|")+1)'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(sub_categories.name)'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(brands.name)'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(lines.name)'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(generations.name)'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(models.anio)'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(versions.name)'), $quitar_espacios)
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
            ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name,models.anio))'), $quitar_espacios)
            ->where('transports.status', 'DISPONIBLE')
            ->whereNull('transports.deleted_at')
            ->whereNull('sub_categories.deleted_at')
            ->whereNull('brands.deleted_at')
            ->whereNull('lines.deleted_at')
            ->whereNull('generations.deleted_at')
            ->whereNull('models.deleted_at')
            ->whereNull('versions.deleted_at')
            ->groupBy('transports.code')
            ->groupBy('transports.status')
            ->groupBy('models.anio')
            ->groupBy('fuels.name')
            ->groupBy('brands.name')
            ->groupBy('lines.name')
            ->groupBy('versions.name')
            ->groupBy('transports.mileage')
            ->orderByRaw('RAND()')
            ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $search = $request->get('search');

        return view('buscar', compact('data', 'existe', 'titulo', 'search'));
    }
}
