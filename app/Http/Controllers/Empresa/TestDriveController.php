<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Models\Persona\People;
use App\Models\Sistema\Prospect;
use App\Models\Sistema\TestDrive;
use Illuminate\Support\Facades\DB;
use App\Models\Persona\PeoplePhone;
use App\Http\Controllers\Controller;
use App\Models\Sistema\Transport;
use App\Notifications\PruebaManejo;
use App\User;

class TestDriveController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules(), $this->message());
        try {
            DB::beginTransaction();

            $people = People::where('email', $request->email)->first();

            if (!is_null($people)) {
                $people->names = $request->names;
                $people->surnames = $request->surnames;
                $people->email = $request->email;
                $people->save();
            } else {
                $people = new People();
                $people->names = $request->names;
                $people->surnames = $request->surnames;
                $people->email = $request->email;
                $people->save();
            }

            PeoplePhone::firstOrCreate(
                [
                    'people_id' => $people->id,
                    'number' => $request->number_test,
                    'type_phone_id' => 1
                ]
            );

            $prospect = Prospect::where('people_id', $people->id)->first();

            if (is_null($prospect)) {
                $prospect = new Prospect();
                $prospect->code_prospect = $this->generadorCodigo(0, "PM");
                $prospect->code_client = null;
                $prospect->people_id = $people->id;
                $prospect->save();
            }

            $prospect->code_prospect = $this->generadorCodigo($prospect->id, "PM");
            $prospect->save();

            $insert = new TestDrive();
            $insert->name = "{$request->names} {$request->surnames}";
            $insert->email = $request->email;
            $insert->number = $request->number_test;
            $insert->date_time = date('Y-m-d h:i:s', strtotime($request->date_time));
            $insert->observation = null;
            $insert->users_id = 0;
            $insert->transports_id = $request->transports_id;
            $insert->prospects_id = $prospect->id;
            $insert->save();

            $usuarios = DB::connection()->table('users')
            ->select('id')
            ->get();

            foreach ($usuarios as $value) {
                $usuario = User::find($value->id);
                $usuario->notify(new PruebaManejo($usuario, $insert, Transport::find($insert->transports_id)));
            }

            DB::commit();

            return redirect()->back()->with('success', 'La prueba de manejo fue creada, en breve un asesor se comunicara con usted para propocionar le más información');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', 'Lo sentimos hubo un inconveniente al momento de guardar la información');
        }
    }

    public function rules()
    {
        $date = date('Y/m/d H:i');
        return [
            'email' => 'required|email|max:75',
            'names' => 'required|max:50',
            'surnames' => 'required|max:50',
            'number_test' => 'required',
            'date_time' => "required|date_format:Y/m/d H:i|after_or_equal:$date",
            'transports_id' => 'required|integer|exists:transports,id'
        ];
    }

    public function message()
    {
        $date = date('Y/m/d H:i');
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El dato ingresado no es un correo electrónico.',
            'email.max'  => 'El correo electrónico debe tener menos de :max caracteres.',
            'email.unique'  => 'El correo electrónico ingresado ya existe en el sistema.',

            'names.required' => 'El nombre es obligatorio.',
            'names.max'  => 'El nombre debe tener menos de :max caracteres.',

            'surnames.required' => 'El apellido es obligatorio.',
            'surnames.max'  => 'El apellido debe tener menos de :max caracteres.',

            'number_test.required' => 'El número de teléfono es obligatorio.',

            'date_time.required' => 'La fecha y hora es obligatorio.',
            'date_time.date_format' => 'El formato de la fecha no es correcto.',
            'date_time.after_or_equal' => "El formato de la fecha debe ser igual o mayor a $date",

            'transports_id.required' => 'El vehículo es obligatoria',
            'transports_id.integer' => 'El vehículo no tiene formato válido',
            'transports_id.exists' => 'El vehículo no existe en la base de datos'
        ];
    }
}
