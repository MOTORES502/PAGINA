<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\Url;
use App\Traits\SiteMap;
use Illuminate\Http\Request;
use App\Models\Catalogos\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SiteMAPController extends Controller
{
    private $siteMap;
    
    public function index()
    {
        $siteMapXml = Cache::remember('sitemap', 3, function () {
            $this->siteMap = new SiteMap();

            $this->addUniqueRoutes();
            $this->addCategorias();
            $this->addVehiculos();

            return $this->siteMap->build();
        });

        return response($siteMapXml, 200)
        ->header('Content-Type', 'text/xml');
    }

    private function addUniqueRoutes()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('c');

        $this->siteMap->add(
            Url::create('/')
                ->lastUpdate($startOfMonth)
                ->frequency('monthly')
                ->priority('1.00')
        );

        $this->siteMap->add(
            Url::create('/home')
            ->lastUpdate($startOfMonth)
                ->frequency('monthly')
                ->priority('0.8')
        );

        $this->siteMap->add(
            Url::create('/contacto')
            ->lastUpdate($startOfMonth)
                ->frequency('yearly')
                ->priority('0.8')
        );

        $this->siteMap->add(
            Url::create('/comparar')
            ->lastUpdate($startOfMonth)
                ->frequency('monthly')
                ->priority('0.7')
        );

        $this->siteMap->add(
            Url::create('/blog')
            ->lastUpdate($startOfMonth)
                ->frequency('monthly')
                ->priority('0.8')
        );

        $this->siteMap->add(
            Url::create('/quienes_somos')
            ->lastUpdate($startOfMonth)
                ->frequency('yearly')
                ->priority('0.7')
        );

        $this->siteMap->add(
            Url::create('/preguntas_frecuentes')
            ->lastUpdate($startOfMonth)
                ->frequency('yearly')
                ->priority('0.7')
        );
    }

    private function addCategorias()
    {
        $subs = Category::select('id', 'name')->with('brands:id,name,categories_id,updated_at', 'sub_categorias:id,name,icon,categories_id,updated_at')->get();

        foreach ($subs as $sub) {

            foreach ($sub->sub_categorias as $key => $item) {
                $slug = str_replace(' ', '_', mb_strtolower($item->name));
                $value = base64_encode($item->id);
                $startOfMonth = Carbon::parse($item->updated_at)->startOfMonth()->format('c');

                $this->siteMap->add(
                    Url::create("categoria/{$slug}/{$value}")
                        ->lastUpdate($startOfMonth)
                        ->frequency('monthly')
                        ->priority('0.9')
                );
            }

            foreach ($sub->brands as $key => $item) {
                $slug = str_replace(' ', '_', mb_strtolower($item->name));
                $value = base64_encode($item->id);
                $startOfMonth = Carbon::parse($item->updated_at)->startOfMonth()->format('c');

                $this->siteMap->add(
                    Url::create("marca/{$slug}/{$value}")
                    ->lastUpdate($startOfMonth)
                        ->frequency('monthly')
                        ->priority('0.9')
                );
            }
        }
    }

    private function addVehiculos()
    {
        $carros = DB::connection('mysql')->table('transports')
        ->join('brands', 'brands.id', 'transports.brands_id')
        ->join('lines', 'lines.id', 'transports.lines_id')
        ->join('models', 'models.id', 'transports.models_id')
        ->join('versions', 'versions.id', 'transports.versions_id')
        ->select(
            'transports.code AS codigo',
            DB::RAW('REPLACE(LOWER(CONCAT(brands.name,"-",lines.name,"-",versions.name,"-",models.anio))," ","") AS slug'),
            'transports.updated_at',
            'transports.deleted_at'
        )
        ->whereNull('transports.deleted_at')
        ->orderByDesc('transports.updated_at')
        ->get();

        foreach ($carros as $key => $item) {
            $slug = $item->slug;
            $value = base64_encode($item->codigo);
            $startOfMonth = Carbon::parse($item->updated_at)->startOfMonth()->format('c');

            $this->siteMap->add(
                Url::create("vehiculo/{$slug}/{$value}")
                ->lastUpdate($startOfMonth)
                    ->frequency('monthly')
                    ->priority('1.00')
            );
        }
    }
}
