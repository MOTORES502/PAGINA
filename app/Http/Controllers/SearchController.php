<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $data = DB::connection('mysql')->table('brands')
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
        $title = "vehículos de la marca y línea $buscar";
        $description = "todos los vehículos de la marca y línea $buscar";
        $keywords = [$buscar];
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/buscar/marca-linea/$slug/$value";

        $this->seo($title, $description, $keywords, $url, $image, 'marca y línea');

        $titulo = "vehículos de la marca y línea $buscar";
        $quitar_espacios = mb_strtoupper(str_replace(' ', '', $buscar));

        $data = DB::connection('mysql')->table('brands')
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

        $data = DB::connection('mysql')->table('brands')
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

        $data = DB::connection('mysql')->table('brands')
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

        $data = DB::connection('mysql')->table('sub_categories_transports')
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
            ->orWhere(DB::RAW('TRIM(CONCAT(models.anio,brands.name))'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(CONCAT(models.anio,brands.name,lines.name))'), $quitar_espacios)
            ->orWhere(DB::RAW('TRIM(CONCAT(brands.name,lines.name))'), $quitar_espacios)
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
            ->distinct('transports.code')
            ->orderByRaw('RAND()')
            ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        $search = $request->get('search');

        return view('buscar', compact('data', 'existe', 'titulo', 'search'));
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

            $marca = (isset($request->marca_id) && !is_null($request->marca_id) && !empty($request->marca_id)) ? explode("lineas/", $request->marca_id) : array();
            $marca = count($marca) > 1 ? $marca[1] : null;
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
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('lines.id', $linea)
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
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('brands.id', $marca)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_marca_pm_pm($marca, $precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, $sort)
    {
        $consulta = DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))');
        $dolares = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))*8 AS order_by'),
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
        ->where('coins.id', 2)
        ->whereBetween($consulta, [$precio_minimo_s, $precio_maximo_s])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('brands.id', $marca);

        $todos = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)) AS order_by'),
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
        ->where('coins.id', 1)
        ->whereBetween($consulta, [$precio_minimo, $precio_maximo])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('brands.id', $marca)
        ->union($dolares, true)
        ->orderBy('order_by', $sort)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_linea_pm_pm($linea, $precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, $sort)
    {
        $consulta = DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))');
        $dolares = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))*8 AS order_by'),
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
        ->where('coins.id', 2)
        ->whereBetween($consulta, [$precio_minimo_s, $precio_maximo_s])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('lines.id', $linea);

        $todos = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)) AS order_by'),
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
        ->where('coins.id', 1)
        ->whereBetween($consulta, [$precio_minimo, $precio_maximo])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('lines.id', $linea)
        ->union($dolares, true)
        ->orderBy('order_by', $sort)
        ->paginate(12);

        return $todos;
    }

    public function buscar_c_pm_pm($precio_minimo, $precio_maximo, $precio_minimo_s, $precio_maximo_s, $sort)
    {
        $consulta = DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))');
        $dolares = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1))*8 AS order_by'),
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
        ->where('coins.id', 2)
        ->whereBetween($consulta, [$precio_minimo_s, $precio_maximo_s])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE');

        $todos = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('generations', 'generations.id', 'transports.generations_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->join('coins', 'transports.coins_id', 'coins.id')
        ->join('fuels', 'fuels.id', 'transports.fuels_id')
        ->select(
            DB::RAW('IF((SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1) = null, transports.price_publisher, (SELECT offe.price_offer FROM transports_offers offe WHERE offe.transports_id = transports.id AND offe.people_id = transports.people_id AND offe.active = true LIMIT 1)) AS order_by'),
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
        ->where('coins.id', 1)
        ->whereBetween($consulta, [$precio_minimo, $precio_maximo])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->union($dolares, true)
        ->orderBy('order_by', $sort)
        ->paginate(12);

        return $todos;
    }
}
