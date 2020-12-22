<?php

namespace App\Http\Controllers;

use App\Notifications\Contacto;
use App\Traits\informacion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    use informacion;

    public function index()
    {
        $title = 'Contacto';
        $description = 'Contacto con motores 502.';
        $keywords = array();
        $image = asset('img/logo_s_fondo_mrm.png');

        $this->seo($title, $description, $keywords, null, $image, 'website');

        $horario = $this->horario_atencion();
        $ubicacion = $this->ubicacion();
        $canales = $this->canales();

        $asesores = DB::connection()->table('users')
        ->join('people', 'users.people_id', 'people.id')
        ->join('people_phones', 'people.id', 'people_phones.people_id')
        ->select(
            'users.photo AS foto',
            'users.email AS email',
            DB::RAW('CONCAT(people.names," ",people.surnames) AS asesor'),
            'people_phones.number AS numero'
        )
        ->whereNull('users.deleted_at')
        ->where('users.aparece', true)
        ->orderByRaw('RAND()')
        ->distinct('users.id')
        ->get();
        
        return view('contacto', compact('horario', 'ubicacion', 'canales', 'asesores'));
    }
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
            $usuario = User::withTrashed()->where('email', 'info@motores502.com')->first();

            if(is_null($usuario)) {
                return redirect()->back()->with('warning', 'No se encuentra el correo electrónico de contacto.');
            }

            $usuario->notify(new Contacto($usuario, $request));
            return redirect()->back()->with('success', 'En breve nos comunicaremos con usted');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Lo sentimos hubo un inconveniente al enviar el correo electrónico');
        }
    }

    public function rules()
    {
        return [
            'email' => 'required|email|max:75',
            'username' => 'required|max:100',
            'phone' => 'required',
            'message' => "required|max:1000"
        ];
    }

    public function message()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El dato ingresado no es un correo electrónico.',
            'email.max'  => 'El correo electrónico debe tener menos de :max caracteres.',
            'email.unique'  => 'El correo electrónico ingresado ya existe en el sistema.',

            'username.required' => 'El nombre es obligatorio.',
            'username.max'  => 'El nombre debe tener menos de :max caracteres.',

            'phone.required' => 'El número de teléfono es obligatorio.',

            'message.required' => 'El mensaje es obligatorio.',
            'message.max'  => 'El mensaje debe tener menos de :max caracteres.',
        ];
    }
}
