<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function ocurrencia(Request $request)
    {
        if ($request->get('query') && !empty($request->get('query'))) {
            $query = mb_strtoupper($request->get('query'));
            $quitar_espacios = str_replace(' ','',$query);

            $marca = DB::table('brands')
            ->select(
                DB::RAW("1 AS condicion"),                 
                'name'
            )
            ->where('name', $query)
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.deleted_at IS NULL 
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('name')
            ->groupBy('name')
            ->groupBy('condicion');
        
            $marca_linea = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->select(
                DB::RAW("2 AS condicion"),   
                DB::RAW("CONCAT(brands.name,' ',lines.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports WHERE 
                transports.brands_id = brands.id 
                AND transports.lines_id = lines.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_modelo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("3 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',models.anio) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,models.anio))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.models_id = models.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->whereNotNull('models.anio')
            ->whereNotNull('versions.name')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_linea_version = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("4 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,versions.name))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.lines_id = lines.id 
                AND transports.versions_id = versions.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->whereNotNull('models.anio')
            ->whereNotNull('versions.name')
            ->unionAll($marca)
            ->unionAll($marca_linea)
            ->unionAll($marca_modelo)
            ->groupBy('name')
            ->groupBy('condicion')
            ->get();

            $output = '<div class="dropdown-menu" style="display:block; position:absolute; width: 100%;">';
            $existe = false;
            foreach ($marca_linea_version as $row) {
                $guiones = str_replace(' ', '-', $row->name);
                $minusculas = mb_strtolower($guiones);
                switch ($row->condicion) {
                    case 1:
                        $url = route('buscar.marca', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '"><span class="badge badge-secondary">' . $row->name . '</span></a>';
                        break;

                    case 2:
                        $url = route('buscar.marca_linea', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '"><span class="badge badge-secondary">' . $row->name . '</span></a>';
                        break;

                    case 3:
                        $url = route('buscar.marca_modelo', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '"><span class="badge badge-secondary">' . $row->name . '</span></a>';
                        break;

                    case 4:
                        $url = route('buscar.marca_linea_version', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '"><span class="badge badge-secondary">' . $row->name . '</span></a>';
                        break;
                }
                
                $existe = true;
            }
            $output .= '</div>';
            return response()->json(['data' => $output, 'existe' => $existe]);
        }
    }
}
