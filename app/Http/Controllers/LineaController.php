<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogos\Brand;
use App\Models\Catalogos\Line;
use App\Models\Sistema\Transport;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LineaController extends Controller
{
    public function lineas(Brand $marca, Request $request)
    {
        if($request->ajax()) {
            try {
                $data = DB::connection('mysql')->table('transports')
                    ->join('lines', 'transports.lines_id', 'lines.id')
                    ->select(
                        'lines.id AS id',
                        'lines.name AS name'
                    )
                    ->where('lines.brands_id', $marca->id)
                    ->where('transports.status', 'DISPONIBLE')
                    ->whereNull('lines.deleted_at')
                    ->whereNull('transports.deleted_at')
                    ->distinct('lines.name')
                    ->orderBy('lines.name')
                    ->get();

                return response()->json($data);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage());
            }
        } else {
            return redirect()->back()->with('warning', 'La consulta no es válida');
        }
    }

    public function codigos(Line $linea, Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = DB::connection('mysql')->table('transports')
                ->join('brands', 'brands.id', 'transports.brands_id')
                ->join('lines', 'lines.id', 'transports.lines_id')
                ->join('generations', 'generations.id', 'transports.generations_id')
                ->join('models', 'models.id', 'transports.models_id')
                ->join('versions', 'versions.id', 'transports.versions_id')
                ->select(
                    'transports.id AS id',
                    DB::RAW('CONCAT(models.anio,", ",versions.name," ",transports.code) AS name'),
                    'transports.code'
                )
                ->where('lines.id', $linea->id)
                ->where('transports.status', 'DISPONIBLE')
                ->whereNull('lines.deleted_at')
                ->whereNull('transports.deleted_at')
                ->distinct('transports.code')
                ->orderBy('transports.code')
                ->get();

                return response()->json($data);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage());
            }
        } else {
            return redirect()->back()->with('warning', 'La consulta no es válida');
        }
    }

    public function imagenes(Transport $codigo, Request $request)
    {
        if ($request->ajax()) {
            try {
                $base = Config::get('filesystems.disks.images.url');
                $marca = asset('img/encima_motores502.png');
                $data = DB::connection('mysql')->table('transports_images')
                ->select(
                    'transports_images.image AS image',
                    'transports_images.concat AS concat'
                )
                ->selectRaw("'$base' AS base")
                ->selectRaw("'$marca' AS marca")
                ->where('transports_id', $codigo->id)
                ->where('order', 1)
                ->first();

                return response()->json($data);
            } catch (\Throwable $th) {
                return response()->json('La consulta no es válida');
            }
        } else {
            return redirect()->back()->with('warning', 'La consulta no es válida');
        }
    }
}
