<?php

namespace App\Providers;

use App\Models\Catalogos\Category;
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
            $menus = Category::select('id','name')->with('brands:id,name,categories_id', 'sub_categorias:id,name,categories_id')->get();

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
