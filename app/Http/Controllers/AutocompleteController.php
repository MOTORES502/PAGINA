<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function ocurrencia(Request $request)
    {
        if ($request->get('query') && !empty($request->get('query'))) {
            $query = $request->get('query');
            $quitar_espacios = str_replace(' ','',$query);

            $sub = DB::table('sub_categories')
            ->select('name')
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name');

            $brand = DB::table('brands')
            ->select('name')
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name');

            $lines = DB::table('lines')
            ->select('name')
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name');
        
            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',lines.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name');

            $generaciones = DB::table('generations')
            ->select('name')
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name');

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name');

            $modelos = DB::table('models')
            ->select('models.anio AS name')
            ->where('anio', 'LIKE', "%{$query}%")
            ->groupBy('anio');

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name,' ',models.anio) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name');

            $verciones = DB::table('versions')
            ->select('name')
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name');

            $ultimo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name,' ',models.anio,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name');

            $marca_modelo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',models.anio) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,models.anio))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name');

            $marca_linea_modelo_version = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',models.anio,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,models.anio,versions.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name');

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("CONCAT(brands.name,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,versions.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name')
            ->unionAll($sub)
            ->unionAll($brand)
            ->unionAll($lines)
            ->unionAll($generaciones)
            ->unionAll($modelos)
            ->unionAll($verciones)
            ->unionAll($ultimo)
            ->unionAll($marca_modelo)
            ->unionAll($marca_linea_modelo_version)
            ->orderBy('name')
            ->get();


            $output = '<div class="dropdown-menu" style="display:block; position:absolute; width: 100%;">';
            $existe = false;
            foreach ($data as $row) {
                $output .= '<a class="dropdown-item" href="#">' . $row->name . '</a>';
                $existe = true;
            }
            $output .= '</div>';
            return response()->json(['data' => $output, 'existe' => $existe]);
        }
    }
}
