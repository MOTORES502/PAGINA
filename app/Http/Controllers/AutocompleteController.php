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

            $subcategoria = DB::table('sub_categories')
            ->select(
                DB::RAW("1 AS condicion"),                
                'name'
            )
            ->where('name', $query)
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM sub_categories_transports 
                INNER JOIN transports ON transports.id = sub_categories_transports.transports_id
                WHERE sub_categories_transports.sub_categories_id = sub_categories.id 
                AND sub_categories_transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE"
            )'), '>', 0)           
            ->groupBy('name')
            ->groupBy('condicion');

            $brand = DB::table('brands')
            ->select(
                DB::RAW("2 AS condicion"),                 
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

            $lines = DB::table('lines')
            ->select(
                DB::RAW("3 AS condicion"),
                'name'
            )
            ->where('name', $query)
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.lines_id = lines.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('name')
            ->groupBy('name')
            ->groupBy('condicion');
        
            $marca_linea = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->select(
                DB::RAW("4 AS condicion"),   
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

            $generaciones = DB::table('generations')
            ->select(
                DB::RAW("5 AS condicion"),
                'name'
            )
            ->where('name', $query)
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.generations_id = generations.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('name')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_linea_generacion = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->select(
                DB::RAW("6 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.lines_id = lines.id 
                AND transports.generations_id = generations.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->groupBy('name')
            ->groupBy('condicion');

            $modelos = DB::table('models')
            ->select(
                DB::RAW("7 AS condicion"),
                'models.anio AS name'
            )
            ->where('anio', $query)
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.models_id = models.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('models.anio')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_linea_generacion_modelo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->select(
                DB::RAW("8 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name,' ',models.anio) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.lines_id = lines.id 
                AND transports.generations_id = generations.id 
                AND transports.models_id = models.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->whereNotNull('models.anio')
            ->groupBy('name')
            ->groupBy('condicion');

            $verciones = DB::table('versions')
            ->select(
                DB::RAW("9 AS condicion"),
                'name'
            )
            ->where('name', $query)
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.versions_id = versions.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('name')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_linea_generacion_modelo_version = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("10 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name,' ',models.anio,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.lines_id = lines.id 
                AND transports.generations_id = generations.id 
                AND transports.models_id = models.id 
                AND transports.versions_id = versions.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->whereNotNull('models.anio')
            ->whereNotNull('versions.name')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_modelo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("11 AS condicion"),
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

            $marca_linea_modelo_version = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("12 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',models.anio,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,models.anio,versions.name))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.lines_id = lines.id 
                AND transports.models_id = models.id 
                AND transports.versions_id = versions.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->whereNotNull('models.anio')
            ->whereNotNull('versions.name')
            ->groupBy('name')
            ->groupBy('condicion');

            $marca_version = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("13 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,versions.name))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.brands_id = brands.id 
                AND transports.versions_id = versions.id 
                AND transports.deleted_at IS NULL
                AND transports.status = "DISPONIBLE")'), '>', 0)
            ->whereNotNull('brands.name')
            ->whereNotNull('lines.name')
            ->whereNotNull('generations.name')
            ->whereNotNull('models.anio')
            ->whereNotNull('versions.name')
            ->groupBy('name')
            ->groupBy('condicion');

            $version_modelo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("14 AS condicion"),
                DB::RAW("CONCAT(versions.name,' ',models.anio) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(versions.name,models.anio))"), 'LIKE', "{$quitar_espacios}%")
            ->where(DB::RAW('(
                SELECT COUNT(*) 
                FROM transports 
                WHERE transports.versions_id = versions.id 
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

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("15 AS condicion"),
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
            ->unionAll($subcategoria)
            ->unionAll($brand)
            ->unionAll($lines)
            ->unionAll($marca_linea)
            ->unionAll($generaciones)
            ->unionAll($marca_linea_generacion)
            ->unionAll($modelos)
            ->unionAll($marca_linea_generacion_modelo)
            ->unionAll($verciones)
            ->unionAll($marca_linea_generacion_modelo_version)
            ->unionAll($marca_modelo)
            ->unionAll($marca_linea_modelo_version)
            ->unionAll($marca_version)
            ->unionAll($version_modelo)
            ->groupBy('name')
            ->groupBy('condicion')
            ->get();

            $output = '<div class="dropdown-menu" style="display:block; position:absolute; width: 100%;">';
            $existe = false;
            foreach ($data as $row) {
                $guiones = str_replace(' ', '-', $row->name);
                $minusculas = mb_strtolower($guiones);
                switch ($row->condicion) {
                    case 1:
                        $url = route('buscar.sub_categoria', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 2:
                        $url = route('buscar.marca', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 3:
                        $url = route('buscar.linea', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 4:
                        $url = route('buscar.marca_linea', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 5:
                        $url = route('buscar.generacion', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 6:
                        $url = route('buscar.marca_linea_generacion', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 7:
                        $url = route('buscar.modelo', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 8:
                        $url = route('buscar.marca_linea_generacion_modelo', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 9:
                        $url = route('buscar.version', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 10:
                        $url = route('buscar.marca_linea_generacion_modelo_version', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 11:
                        $url = route('buscar.marca_modelo', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 12:
                        $url = route('buscar.marca_linea_modelo_version', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 13:
                        $url = route('buscar.marca_version', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 14:
                        $url = route('buscar.version_modelo', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;

                    case 15:
                        $url = route('buscar.marca_linea_version', ['slug' => $minusculas, 'value' => Crypt::encrypt($row->condicion)]);
                        $output .= '<a class="dropdown-item" href="' . $url . '">' . $row->name . '</a>';
                        break;
                }
                
                $existe = true;
            }
            $output .= '</div>';
            return response()->json(['data' => $output, 'existe' => $existe]);
        }
    }
}
