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

            $sub = DB::table('sub_categories')
            ->select(
                DB::RAW("1 AS condicion"),                
                'name'
            )
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $brand = DB::table('brands')
            ->select(
                DB::RAW("2 AS condicion"),                 
                'name'
            )
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $lines = DB::table('lines')
            ->select(
                DB::RAW("3 AS condicion"),                
                'name'
            )
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name')
            ->groupBy('condicion');
        
            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->select(
                DB::RAW("4 AS condicion"),   
                DB::RAW("CONCAT(brands.name,' ',lines.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $generaciones = DB::table('generations')
            ->select(
                DB::RAW("5 AS condicion"),              
                'name'
            )
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->select(
                DB::RAW("6 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $modelos = DB::table('models')
            ->select(
                DB::RAW("7 AS condicion"),
                'models.anio AS name'
            )
            ->where('anio', 'LIKE', "%{$query}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->select(
                DB::RAW("8 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name,' ',models.anio) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $verciones = DB::table('versions')
            ->select(
                DB::RAW("9 AS condicion"),
                'name'
            )
            ->where('name', 'LIKE', "%{$query}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $ultimo = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("10 AS condicion"),
                DB::RAW("CONCAT(brands.name,' ',lines.name,' ',generations.name,' ',models.anio,' ',versions.name) AS name")
            )
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,generations.name,models.anio,versions.name))"), 'LIKE', "%{$quitar_espacios}%")
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
            ->where(DB::RAW("TRIM(CONCAT(brands.name,models.anio))"), 'LIKE', "%{$quitar_espacios}%")
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
            ->where(DB::RAW("TRIM(CONCAT(brands.name,lines.name,models.anio,versions.name))"), 'LIKE', "%{$quitar_espacios}%")
            ->groupBy('name')
            ->groupBy('condicion');

            $data = DB::table('brands')
            ->join('lines', 'brands.id', 'lines.brands_id')
            ->join('generations', 'lines.id', 'generations.lines_id')
            ->join('models', 'generations.id', 'models.generations_id')
            ->join('versions', 'models.id', 'versions.models_id')
            ->select(
                DB::RAW("13 AS condicion"),
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
                }
                
                $existe = true;
            }
            $output .= '</div>';
            return response()->json(['data' => $output, 'existe' => $existe]);
        }
    }
}
