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
                $data = DB::connection('mysql')->table('lines')
                    ->select(
                        'lines.id AS id',
                        'lines.name AS name'
                    )
                    ->where('lines.brands_id', $marca->id)
                    ->whereNull('lines.deleted_at')
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
