<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogos\Brand;
use Illuminate\Support\Facades\DB;

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
                //throw $th;
            }
        } else {
            return redirect()->back()->with('warning', 'La consulta no es válida');
        }
    }
}
