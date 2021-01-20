<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sistema\TransportView;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class VehiculoController extends Controller
{
    public function all(Request $request)
    {
        //SEO
        $title = "listado de todos los vehículos publicados en la página";
        $description = "muestra todos los vehículos que han sido publicados a lo largo de la historia";
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculos/publicados";

        $this->seo($title, $description, $keywords, $url, $image, 'vehículos');

        $data = DB::connection('mysql')->table('transports')
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
        ->where('transports_images.order', 1)
        ->orderByDesc('transports.created_at')
        ->paginate(16);

        $existe = count($data) == 0 ? false : true;

        if ($request->ajax()) {
            return response()->json(['carro' => view('paginado.carros_buscados', compact('data'))->render()]);
        }

        return view('vehiculos', compact('data'));
    }

    public function vehiculo($slug, $value, Request $request)
    {
        $tipos_telefono = DB::connection('mysql')->table('type_phone')
        ->select('id', 'name')
        ->get();

        $canales = DB::connection('mysql')->table('channels')
        ->select('id', 'name')
        ->whereNull('deleted_at')
        ->get();

        $vehiculo = DB::connection('mysql')->table('transports')
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
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio,", ",generations.name," GENERACIÓN (",generations.start," - ",generations.end,")") AS nombre_completo'),
            'brands.image AS imagen_marca',
            'transports.price_publisher AS precio_sf',
            'coins.id AS moneda',
            'coins.symbol AS symbol',
            'transports.mileage',
            'transports.people_id AS people_id',
            DB::RAW('substring(transports.code, INSTR(transports.code, "|")+1) AS facebook'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports.offer AS oferta_sf'
        )
        ->where('transports.code', base64_decode($value))
        ->first();

        if(is_null($vehiculo))
            return redirect()->route('home');

        $ofertas = DB::connection('mysql')->table('transports_offers')
        ->join('coins', 'transports_offers.coins_id', 'coins.id')
        ->select(
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(price_offer,2)) AS precio_formato'),
            'price_offer',
            DB::RAW("FORMAT(100-((transports_offers.price_offer*100)/{$vehiculo->precio_sf}),2) AS porcentaje")
        )
        ->where('transports_offers.transports_id', $vehiculo->id)
        ->where('transports_offers.people_id', $vehiculo->people_id)
        ->whereNull('transports_offers.deleted_at')
        ->get();

        $images = DB::connection('mysql')->table('transports_images')
        ->select('image', 'concat')
        ->where('transports_images.active', 1)
        ->where('transports_images.transports_id', $vehiculo->id)
        ->orderBy('order')
        ->get();

        $sub_categoria = DB::connection('mysql')->table('sub_categories_transports')->where('transports_id', $vehiculo->id)->whereIn('option', [1,2])->pluck('sub_categories_id');
  
        $precio = !$vehiculo->oferta_sf ? intval($vehiculo->precio_sf) : intval($vehiculo->oferta_sf);
        $precios_carros = $this->recomendacion($precio, $vehiculo->moneda, $sub_categoria, $vehiculo->id);
        $enganche = $this->calcular_enganche($precio, $vehiculo->symbol);

        $general = DB::connection('mysql')->table('transports_engineers')
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

        $videos = DB::connection('mysql')->table('transports_youtube')
        ->select('transports_youtube.link')
        ->where('transports_youtube.transports_id', $vehiculo->id)
        ->orderByRaw('RAND()')
        ->limit(1)
        ->get();

        $comfort = DB::connection('mysql')->table('transports_mod_cons')
        ->select('transports_mod_cons.description AS description')
        ->where('transports_mod_cons.transports_id', $vehiculo->id)
        ->first();

        $seguridad = DB::connection('mysql')->table('transports_securities')
        ->select('transports_securities.description AS description')
        ->where('transports_securities.transports_id', $vehiculo->id)
        ->first();

        $diferencia = DB::connection('mysql')->table('transports_differences')
        ->join('differences', 'transports_differences.differences_id', 'differences.id')
        ->select(
            'differences.name AS name'
        )
        ->where('transports_differences.transports_id', $vehiculo->id)
        ->get();

        $extra = DB::connection('mysql')->table('additional_features')
        ->select('additional_features.description AS description')
        ->where('additional_features.transports_id', $vehiculo->id)
        ->first();

        $ubicacion = DB::connection('mysql')->table('transports_business')
        ->join('bussines', 'transports_business.bussines_id', 'bussines.id')
        ->join('bussines_locations', 'bussines.id', 'bussines_locations.bussines_id')
        ->join('municipalities', 'bussines_locations.municipalities_id', 'municipalities.id')
        ->join('departaments', 'municipalities.departaments_id', 'departaments.id')
        ->join('countries', 'departaments.countries_id', 'countries.id')
        ->select(
            DB::RAW('CONCAT(countries.name,", ",departaments.name,", ",municipalities.name,", ",bussines_locations.location) AS location')
        )
        ->whereNull('transports_business.deleted_at')
        ->where('transports_business.transports_id', $vehiculo->id)
        ->get();
        
        //SEO
        $nombre = mb_strtolower($vehiculo->nombre_completo);
        $title = $nombre;
        $description = "el vehículo seleccionado para ver la información es $nombre";
        $keywords = array();
        $image = count($images) > 0 ? Storage::disk('images')->url($images[0]->image) : asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculo/$slug/$value";

        $id = $vehiculo->id;

        $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

        TransportView::create(
            [
                'type_view' => TransportView::PAGINA_INICIO,
                'visitor' => $request->ip(),
                'transports_id' => $id,
                'anio' => date('Y')
            ]
        );

        $url = Config::get('app.url') . $url; 
        $subject = "Te comparto la información del vehículo $vehiculo->nombre_completo";
        $body = "Si quieres ver más información te comparto el link, copia y pega el link en tu navegador: $url";
        $correo = "Subject=" . str_replace(' ', '%20', $subject) . "&body=" . str_replace(' ', '%20', $body);

        return view('vehiculo', compact('vehiculo', 'images', 'precios_carros', 'precio', 'enganche', 'general', 'comfort', 'seguridad', 'diferencia', 'extra', 'ubicacion', 'tipos_telefono', 'canales', 'id', 'ofertas', 'videos', 'url', 'correo'));
    }

    public function vehiculo_recomendacion($slug, $value, Request $request)
    {
        $tipos_telefono = DB::connection('mysql')->table('type_phone')
        ->select('id', 'name')
        ->get();

        $canales = DB::connection('mysql')->table('channels')
        ->select('id', 'name')
        ->whereNull('deleted_at')
        ->get();

        $vehiculo = DB::connection('mysql')->table('transports')
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
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio,", ",generations.name," GENERACIÓN (",generations.start," - ",generations.end,")") AS nombre_completo'),
            'brands.image AS imagen_marca',
            'transports.price_publisher AS precio_sf',
            'coins.id AS moneda',
            'coins.symbol AS symbol',
            'transports.mileage',
            'transports.people_id AS people_id',
            DB::RAW('substring(transports.code, INSTR(transports.code, "|")+1) AS facebook'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports.offer AS oferta_sf'
        )
        ->where('transports.code', base64_decode($value))
        ->first();

        if (is_null($vehiculo))
            return redirect()->route('home');

        $ofertas = DB::connection('mysql')->table('transports_offers')
        ->join('coins', 'transports_offers.coins_id', 'coins.id')
        ->select(
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(price_offer,2)) AS precio_formato'),
            'price_offer',
            DB::RAW("FORMAT(100-((transports_offers.price_offer*100)/{$vehiculo->precio_sf}),2) AS porcentaje")
        )
        ->where('transports_offers.transports_id', $vehiculo->id)
        ->where('transports_offers.people_id', $vehiculo->people_id)
        ->whereNull('transports_offers.deleted_at')
        ->get();

        $images = DB::connection('mysql')->table('transports_images')
        ->select('image', 'concat')
        ->where('transports_images.active', 1)
        ->where('transports_images.transports_id', $vehiculo->id)
        ->orderBy('order')
        ->get();

        $sub_categoria = DB::connection('mysql')->table('sub_categories_transports')->where('transports_id', $vehiculo->id)->whereIn('option', [1, 2])->pluck('sub_categories_id');

        $precio = is_null($vehiculo->oferta_sf) ? intval($vehiculo->precio_sf) : intval($vehiculo->oferta_sf);
        $precios_carros = $this->recomendacion($precio, $vehiculo->moneda, $sub_categoria, $vehiculo->id);
        $enganche = $this->calcular_enganche($precio, $vehiculo->symbol);

        $general = DB::connection('mysql')->table('transports_engineers')
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

        $videos = DB::connection('mysql')->table('transports_youtube')
        ->select('transports_youtube.link')
        ->where('transports_youtube.transports_id', $vehiculo->id)
        ->orderByRaw('RAND()')
        ->limit(1)
        ->get();

        $comfort = DB::connection('mysql')->table('transports_mod_cons')
        ->select('transports_mod_cons.description AS description')
        ->where('transports_mod_cons.transports_id', $vehiculo->id)
            ->first();

        $seguridad = DB::connection('mysql')->table('transports_securities')
        ->select('transports_securities.description AS description')
        ->where('transports_securities.transports_id', $vehiculo->id)
            ->first();

        $diferencia = DB::connection('mysql')->table('transports_differences')
        ->join('differences', 'transports_differences.differences_id', 'differences.id')
        ->select(
            'differences.name AS name'
        )
            ->where('transports_differences.transports_id', $vehiculo->id)
            ->get();

        $extra = DB::connection('mysql')->table('additional_features')
        ->select('additional_features.description AS description')
        ->where('additional_features.transports_id', $vehiculo->id)
            ->first();

        $ubicacion = DB::connection('mysql')->table('transports_business')
        ->join('bussines', 'transports_business.bussines_id', 'bussines.id')
        ->join('bussines_locations', 'bussines.id', 'bussines_locations.bussines_id')
        ->join('municipalities', 'bussines_locations.municipalities_id', 'municipalities.id')
        ->join('departaments', 'municipalities.departaments_id', 'departaments.id')
        ->join('countries', 'departaments.countries_id', 'countries.id')
        ->select(
            DB::RAW('CONCAT(countries.name,", ",departaments.name,", ",municipalities.name,", ",bussines_locations.location) AS location')
        )
        ->whereNull('transports_business.deleted_at')
        ->where('transports_business.transports_id', $vehiculo->id)
        ->get();

        //SEO
        $nombre = mb_strtolower($vehiculo->nombre_completo);
        $title = $nombre;
        $description = "el vehículo seleccionado para ver la información es $nombre";
        $keywords = array();
        $image = count($images) > 0 ? Storage::disk('images')->url($images[0]->image) : asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculo/$slug/$value";

        $id = $vehiculo->id;

        $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

        TransportView::create(
            [
                'type_view' => TransportView::RECOMENDACION,
                'visitor' => $request->ip(),
                'transports_id' => $id,
                'anio' => date('Y')
            ]
        );


        $url = Config::get('app.url') . $url; 
        $subject = "Te comparto la información del vehículo $vehiculo->nombre_completo";
        $body = "Si quieres ver más información te comparto el link, copia y pega el link en tu navegador: $url";
        $correo = "Subject=" . str_replace(' ', '%20', $subject) . "&body=" . str_replace(' ', '%20', $body);

        return view('vehiculo', compact('vehiculo', 'images', 'precios_carros', 'precio', 'enganche', 'general', 'comfort', 'seguridad', 'diferencia', 'extra', 'ubicacion', 'tipos_telefono', 'canales', 'id', 'ofertas', 'videos', 'url', 'correo'));
    }

    public function vehiculo_buscar($slug, $value, Request $request)
    {
        $tipos_telefono = DB::connection('mysql')->table('type_phone')
        ->select('id', 'name')
        ->get();

        $canales = DB::connection('mysql')->table('channels')
        ->select('id', 'name')
        ->whereNull('deleted_at')
        ->get();

        $vehiculo = DB::connection('mysql')->table('transports')
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
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio,", ",generations.name," GENERACIÓN (",generations.start," - ",generations.end,")") AS nombre_completo'),
            'brands.image AS imagen_marca',
            'transports.price_publisher AS precio_sf',
            'coins.id AS moneda',
            'coins.symbol AS symbol',
            'transports.mileage',
            'transports.people_id AS people_id',
            DB::RAW('substring(transports.code, INSTR(transports.code, "|")+1) AS facebook'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports.offer AS oferta_sf'
        )
        ->where('transports.code', base64_decode($value))
        ->first();

        if (is_null($vehiculo))
            return redirect()->route('home');

        $ofertas = DB::connection('mysql')->table('transports_offers')
        ->join('coins', 'transports_offers.coins_id', 'coins.id')
        ->select(
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(price_offer,2)) AS precio_formato'),
            'price_offer',
            DB::RAW("FORMAT(100-((transports_offers.price_offer*100)/{$vehiculo->precio_sf}),2) AS porcentaje")
        )
        ->where('transports_offers.transports_id', $vehiculo->id)
        ->where('transports_offers.people_id', $vehiculo->people_id)
        ->whereNull('transports_offers.deleted_at')
        ->get();

        $images = DB::connection('mysql')->table('transports_images')
        ->select('image', 'concat')
        ->where('transports_images.active', 1)
        ->where('transports_images.transports_id', $vehiculo->id)
        ->orderBy('order')
        ->get();

        $sub_categoria = DB::connection('mysql')->table('sub_categories_transports')->where('transports_id', $vehiculo->id)->whereIn('option', [1, 2])->pluck('sub_categories_id');

        $precio = is_null($vehiculo->oferta_sf) ? intval($vehiculo->precio_sf) : intval($vehiculo->oferta_sf);
        $precios_carros = $this->recomendacion($precio, $vehiculo->moneda, $sub_categoria, $vehiculo->id);
        $enganche = $this->calcular_enganche($precio, $vehiculo->symbol);

        $general = DB::connection('mysql')->table('transports_engineers')
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

        $videos = DB::connection('mysql')->table('transports_youtube')
        ->select('transports_youtube.link')
        ->where('transports_youtube.transports_id', $vehiculo->id)
        ->orderByRaw('RAND()')
        ->limit(1)
        ->get();

        $comfort = DB::connection('mysql')->table('transports_mod_cons')
        ->select('transports_mod_cons.description AS description')
        ->where('transports_mod_cons.transports_id', $vehiculo->id)
            ->first();

        $seguridad = DB::connection('mysql')->table('transports_securities')
        ->select('transports_securities.description AS description')
        ->where('transports_securities.transports_id', $vehiculo->id)
            ->first();

        $diferencia = DB::connection('mysql')->table('transports_differences')
        ->join('differences', 'transports_differences.differences_id', 'differences.id')
        ->select(
            'differences.name AS name'
        )
            ->where('transports_differences.transports_id', $vehiculo->id)
            ->get();

        $extra = DB::connection('mysql')->table('additional_features')
        ->select('additional_features.description AS description')
        ->where('additional_features.transports_id', $vehiculo->id)
            ->first();

        $ubicacion = DB::connection('mysql')->table('transports_business')
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

        //SEO
        $nombre = mb_strtolower($vehiculo->nombre_completo);
        $title = $nombre;
        $description = "el vehículo seleccionado para ver la información es $nombre";
        $keywords = array();
        $image = count($images) > 0 ? Storage::disk('images')->url($images[0]->image) : asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculo/$slug/$value";

        $id = $vehiculo->id;

        $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

        TransportView::create(
            [
                'type_view' => TransportView::BUSCADOR,
                'visitor' => $request->ip(),
                'transports_id' => $id,
                'anio' => date('Y')
            ]
        );


        $url = Config::get('app.url') . $url; 
        $subject = "Te comparto la información del vehículo $vehiculo->nombre_completo";
        $body = "Si quieres ver más información te comparto el link, copia y pega el link en tu navegador: $url";
        $correo = "Subject=" . str_replace(' ', '%20', $subject) . "&body=" . str_replace(' ', '%20', $body);

        return view('vehiculo', compact('vehiculo', 'images', 'precios_carros', 'precio', 'enganche', 'general', 'comfort', 'seguridad', 'diferencia', 'extra', 'ubicacion', 'tipos_telefono', 'canales', 'id', 'ofertas', 'videos', 'url', 'correo'));
    }

    public function vehiculo_inventario($slug, $value, Request $request)
    {
        $tipos_telefono = DB::connection('mysql')->table('type_phone')
        ->select('id', 'name')
        ->get();

        $canales = DB::connection('mysql')->table('channels')
        ->select('id', 'name')
        ->whereNull('deleted_at')
        ->get();

        $vehiculo = DB::connection('mysql')->table('transports')
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
            DB::RAW('CONCAT(brands.name," ",lines.name," ",versions.name," ",models.anio,", ",generations.name," GENERACIÓN (",generations.start," - ",generations.end,")") AS nombre_completo'),
            'brands.image AS imagen_marca',
            'transports.price_publisher AS precio_sf',
            'coins.id AS moneda',
            'coins.symbol AS symbol',
            'transports.mileage',
            'transports.people_id AS people_id',
            DB::RAW('substring(transports.code, INSTR(transports.code, "|")+1) AS facebook'),
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(transports.price_publisher,2)) AS precio'),
            DB::RAW('IF(offer IS NULL, offer, CONCAT(coins.symbol," ",FORMAT(transports.offer,2))) AS oferta'),
            'transports.offer AS oferta_sf'
        )
        ->where('transports.code', base64_decode($value))
        ->first();

        if (is_null($vehiculo))
            return redirect()->route('home');

        $ofertas = DB::connection('mysql')->table('transports_offers')
        ->join('coins', 'transports_offers.coins_id', 'coins.id')
        ->select(
            DB::RAW('CONCAT(coins.symbol," ",FORMAT(price_offer,2)) AS precio_formato'),
            'price_offer',
            DB::RAW("FORMAT(100-((transports_offers.price_offer*100)/{$vehiculo->precio_sf}),2) AS porcentaje")
        )
        ->where('transports_offers.transports_id', $vehiculo->id)
        ->where('transports_offers.people_id', $vehiculo->people_id)
        ->whereNull('transports_offers.deleted_at')
        ->get();

        $images = DB::connection('mysql')->table('transports_images')
        ->select('image', 'concat')
        ->where('transports_images.active', 1)
        ->where('transports_images.transports_id', $vehiculo->id)
        ->orderBy('order')
        ->get();

        $sub_categoria = DB::connection('mysql')->table('sub_categories_transports')->where('transports_id', $vehiculo->id)->whereIn('option', [1, 2])->pluck('sub_categories_id');

        $precio = is_null($vehiculo->oferta_sf) ? intval($vehiculo->precio_sf) : intval($vehiculo->oferta_sf);
        $precios_carros = $this->recomendacion($precio, $vehiculo->moneda, $sub_categoria, $vehiculo->id);
        $enganche = $this->calcular_enganche($precio, $vehiculo->symbol);

        $general = DB::connection('mysql')->table('transports_engineers')
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

        $videos = DB::connection('mysql')->table('transports_youtube')
        ->select('transports_youtube.link')
        ->where('transports_youtube.transports_id', $vehiculo->id)
        ->orderByRaw('RAND()')
        ->limit(1)
        ->get();

        $comfort = DB::connection('mysql')->table('transports_mod_cons')
        ->select('transports_mod_cons.description AS description')
        ->where('transports_mod_cons.transports_id', $vehiculo->id)
            ->first();

        $seguridad = DB::connection('mysql')->table('transports_securities')
        ->select('transports_securities.description AS description')
        ->where('transports_securities.transports_id', $vehiculo->id)
            ->first();

        $diferencia = DB::connection('mysql')->table('transports_differences')
        ->join('differences', 'transports_differences.differences_id', 'differences.id')
        ->select(
            'differences.name AS name'
        )
            ->where('transports_differences.transports_id', $vehiculo->id)
            ->get();

        $extra = DB::connection('mysql')->table('additional_features')
        ->select('additional_features.description AS description')
        ->where('additional_features.transports_id', $vehiculo->id)
            ->first();

        $ubicacion = DB::connection('mysql')->table('transports_business')
        ->join('bussines', 'transports_business.bussines_id', 'bussines.id')
        ->join('bussines_locations', 'bussines.id', 'bussines_locations.bussines_id')
        ->join('municipalities', 'bussines_locations.municipalities_id', 'municipalities.id')
        ->join('departaments', 'municipalities.departaments_id', 'departaments.id')
        ->join('countries', 'departaments.countries_id', 'countries.id')
        ->select(
            DB::RAW('CONCAT(countries.name,", ",departaments.name,", ",municipalities.name,", ",bussines_locations.location) AS location')
        )
        ->whereNull('transports_business.deleted_at')
        ->where('transports_business.transports_id', $vehiculo->id)
        ->get();

        //SEO
        $nombre = mb_strtolower($vehiculo->nombre_completo);
        $title = $nombre;
        $description = "el vehículo seleccionado para ver la información es $nombre";
        $keywords = array();
        $image = count($images) > 0 ? Storage::disk('images')->url($images[0]->image) : asset('img/logo_s_fondo_mrm.png');
        $url = "/vehiculo/$slug/$value";

        $id = $vehiculo->id;

        $this->seo($title, $description, $keywords, $url, $image, 'vehículo');

        TransportView::create(
            [
                'type_view' => TransportView::INVENTARIO,
                'visitor' => $request->ip(),
                'transports_id' => $id,
                'anio' => date('Y')
            ]
        );


        $url = Config::get('app.url') . $url; 
        $subject = "Te comparto la información del vehículo $vehiculo->nombre_completo";
        $body = "Si quieres ver más información te comparto el link, copia y pega el link en tu navegador: $url";
        $correo = "Subject=" . str_replace(' ', '%20', $subject) . "&body=" . str_replace(' ', '%20', $body);

        return view('vehiculo', compact('vehiculo', 'images', 'precios_carros', 'precio', 'enganche', 'general', 'comfort', 'seguridad', 'diferencia', 'extra', 'ubicacion', 'tipos_telefono', 'canales', 'id', 'ofertas', 'videos', 'url', 'correo'));
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
        
        $dolares = DB::connection('mysql')->table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
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
        ->whereIn('sub_categories_transports.sub_categories_id', $sub_categories_transports)
        ->where('coins.id', $moneda_s)
        ->whereBetween(DB::RAW('IF(offer IS NULL, transports.price_publisher, transports.offer)'), [$pmin_s, $pmax_s])
        ->whereNull('transports.deleted_at')
        ->where('transports.id', '!=', $id)
        ->where('transports.status', 'DISPONIBLE')
        ->where('transports_images.order', 1)
        ->distinct('transports.code')
        ->orderByRaw('RAND()')
        ->limit(\rand(1,3));

        $todos = DB::connection('mysql')->table('sub_categories_transports')
        ->join('transports', 'sub_categories_transports.transports_id', 'transports.id')
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
        ->whereIn('sub_categories_transports.sub_categories_id', $sub_categories_transports)
        ->where('coins.id', $moneda)
        ->whereBetween(DB::RAW('IF(offer IS NULL, transports.price_publisher, transports.offer)'), [$pmin, $pmax])
        ->whereNull('transports.deleted_at')
        ->where('transports.status', 'DISPONIBLE')
        ->where('transports.id', '!=', $id)
        ->where('transports_images.order', 1)
        ->orderByRaw('RAND()')
        ->limit(\rand(1,3))
        ->union($dolares, true)
        ->distinct('transports.code')
        ->orderByRaw('RAND()')
        ->get();
        
        return $todos;
    }
}
