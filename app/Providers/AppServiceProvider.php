<?php

namespace App\Providers;

use App\Traits\informacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use informacion;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        view()->composer('layouts.master', function ($view) {
            $categorias = DB::connection('mysql')->table('categories')->select('id', 'name')->whereNull('deleted_at')->get();
            $menus = array();

            foreach ($categorias as $key => $value) {
                $subs = DB::connection('mysql')->table('sub_categories')->select('id', 'name')->where('categories_id', $value->id)->whereNull('deleted_at')->get();
                $brands = DB::connection('mysql')->table('brands')->select('id', 'name')->where('categories_id', $value->id)->whereNull('deleted_at')->get();

                if(count($subs) > 0 && count($brands) > 0) {
                    $data['nombre'] = $value->name;
                    $data['subs'] = $subs;
                    $data['brands'] = $brands;

                    array_push($menus, $data);
                }
            }

            $view->with(
                [
                    'menus' => $menus,
                    'horario' => $this->horario_atencion(),
                    'canales' => $this->canales()
                ]
            );
        });
    }
}
