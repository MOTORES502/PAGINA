<?php

namespace App\Http\Controllers\Empresa;

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

            $people = People::find($request->email);

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

            foreach ($request->channel as $value) {
                QuoteChannel::firstOrCreate(['channels_id' => $value, 'quotes_id' => $quote->id]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'La cotización fue creado con existo, en breve momento un asesor se comunicara con usted para propocionar le más información');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', 'Lo sentimos hubo un inconveniente en el momento de guardar la información');
        }
    }

    public function rules()
    {
        return [
            'channel' => 'array',
            'channel.*' => 'required|integer|exists:channels,id',
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
            'channel.array' => 'Los canales no tienen formato correcto',

            'channel.*.required' => 'El canal es obligatorio',
            'channel.*.integer' => 'El canal no tiene formato válido',
            'channel.*.exists' => 'El canal no existe en la base de datos',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El dato ingresado no es un correo electrónico.',
            'email.max'  => 'El correo electrónico debe tener menos de :max caracteres.',
            'email.unique'  => 'El correo electrónico ingresado ya existe en el sistema.',

            'names.required' => 'El nombre del proveedor es obligatorio.',
            'names.max'  => 'El nombre del proveedor debe tener menos de :max caracteres.',

            'number.required' => 'El número de teléfono es obligatorio.',

            'surnames.required' => 'El apellido del proveedor es obligatorio.',
            'surnames.max'  => 'El apellido del proveedor debe tener menos de :max caracteres.',

            'transports_id.required' => 'El vehículo es obligatoria',
            'transports_id.integer' => 'El vehículo no tiene formato válido',
            'transports_id.exists' => 'El vehículo no existe en la base de datos',

            'type_phone_id.required' => 'El tipo de teléfono es obligatorio',
            'type_phone_id.integer' => 'El tipo de teléfono no tiene formato válido',
            'type_phone_id.exists' => 'El tipo de teléfono no existe en la base de datos'
        ];
    }
}
