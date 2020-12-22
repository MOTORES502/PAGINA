<?php

namespace App\Http\Controllers\Empresa;

use App\User;
use Illuminate\Http\Request;
use App\Models\Empresa\Quote;
use App\Models\Catalogos\Coin;
use App\Models\Persona\People;
use App\Models\Sistema\Prospect;
use App\Models\Sistema\Transport;
use Illuminate\Support\Facades\DB;
use App\Models\Persona\PeoplePhone;
use App\Http\Controllers\Controller;
use App\Models\Empresa\QuoteChannel;
use App\Models\Sistema\TransportOffer;
use App\Notifications\Cotizacion;

class QuoteController extends Controller
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
                    'number' => $request->number,
                    'type_phone_id' => $request->type_phone_id
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

            $transport = Transport::find($request->transports_id);
            $offer = TransportOffer::where('transports_id', $transport->id)->where('active', true)->first();
            $price = is_null($offer) ? $transport->price_publisher : $offer->price_offer;

            $quote = new Quote();
            $quote->email = $people->email;
            $quote->sent = false;
            $quote->transports_id = $request->transports_id;
            $quote->prospects_id = $prospect->id;
            $quote->body = "Le recuerdo que tenemos planes de financiamiento con la mayoría de bancos del sistema. Es oportuno mencionar que las especificaciones arriba descritas son obtenidas de internet para su uso de referencia y por el mismo, MOTORES 502 no se compromete si difiere en la realidad. Espero sea de su utilidad esta información.";
            $quote->note = "Nota: Más gastos de traspaso y calcomanía.";
            $quote->price = $price;
            $quote->moneda = Coin::find($transport->coins_id)->symbol;
            $quote->save();

            if(isset($request->channel_id)) {
                foreach ($request->channel_id as $value) {
                    QuoteChannel::firstOrCreate(['channels_id' => $value, 'quotes_id' => $quote->id]);
                }
            }


            $usuarios = DB::connection()->table('users')
                ->select('id')
                ->get();

            foreach ($usuarios as $value) {
                $usuario = User::find($value->id);
                $usuario->notify(new Cotizacion($usuario, $quote, Transport::find($quote->transports_id)));
            }
            
            DB::commit();

            return redirect()->back()->with('success', 'La cotización fue creada, en breve un asesor se comunicara con usted para propocionar le más información');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', $e->getMessage());
        }
    }

    public function rules()
    {
        return [
            //'channel_id' => 'required|array',
            'channel_id.*' => 'required|integer|exists:channels,id',
            'email' => 'required|email|max:75',
            'names' => 'required|max:50',
            'number' => 'required',
            //'notify' => 'required|boolean',
            'surnames' => 'required|max:50',
            'transports_id' => 'required|integer|exists:transports,id',
            'type_phone_id' => 'required|integer|exists:type_phone,id'
        ];
    }

    public function message()
    {
        return [

            'channel_id.required' => 'El canal es obligatorio',
            'channel_id.array' => 'Los canales no tienen formato correcto',

            'channel_id.*.required' => 'El canal es obligatorio',
            'channel_id.*.integer' => 'El canal no tiene formato válido',
            'channel_id.*.exists' => 'El canal no existe en la base de datos',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El dato ingresado no es un correo electrónico.',
            'email.max'  => 'El correo electrónico debe tener menos de :max caracteres.',
            'email.unique'  => 'El correo electrónico ingresado ya existe en el sistema.',

            'names.required' => 'El nombre es obligatorio.',
            'names.max'  => 'El nombre debe tener menos de :max caracteres.',

            'number.required' => 'El número de teléfono es obligatorio.',

            'surnames.required' => 'El apellido es obligatorio.',
            'surnames.max'  => 'El apellido debe tener menos de :max caracteres.',

            'transports_id.required' => 'El vehículo es obligatoria',
            'transports_id.integer' => 'El vehículo no tiene formato válido',
            'transports_id.exists' => 'El vehículo no existe en la base de datos',

            'type_phone_id.required' => 'El tipo de teléfono es obligatorio',
            'type_phone_id.integer' => 'El tipo de teléfono no tiene formato válido',
            'type_phone_id.exists' => 'El tipo de teléfono no existe en la base de datos'
        ];
    }
}
