@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <br><br>
        </div>
        <div class="col-sm-12 col-md-10 col-lg-10" style="color: #808080;">
            <p><strong style="font-size: 4vw;">{{ $vehiculo->nombre_completo }} |</strong><span style="font-size: 2vw;">|  {{ $vehiculo->generacion }}</span></p>
        </div>
        <div class="col-sm-12 col-md-2 col-lg-2">
            <img class="img-fluid" width="100%" style="margin:auto; display:block;" alt="{{ $vehiculo->nombre_completo }}" src="{{ $vehiculo->imagen_marca }}" />
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <hr style="height: 10px; width: 80%; background-color:#343a40;">
        </div>
    </div>
    <div class="row" style="background-color: #d0d0d0;"> 
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <p style="color: #808080;"><strong style="font-size: 2vw;">id: </strong><span style="font-size: 3vw;">{{ $vehiculo->codigo }}</span></p>
                </div>      
                <div class="col-sm-12 col-md-11 col-lg-11">
                    <div id="gallery-lightbox" class="row" data-toggle="modal" data-target="#exampleModal">
                        @foreach ($images as $key => $item)
                        <div class="col-sm-12 col-md-3 col-lg-3 p-0">
                            <img class="w-100" src="{{ asset('img/encima_motores502.png') }}" width="100px" height="100px" alt="{{ $item->concat }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" data-target="#vehiculo_especifico" data-slide-to="{{ $key }}">
                        </div>
                        @endforeach
                    </div>
                </div>   
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 fondo-motores">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12"><br><br></div>
                <div class="col-ms-12 col-md-4 col-lg-4" style="font-size: 4em;">Valor</div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    @if ($vehiculo->oferta )
                        <h3><del>{{ $vehiculo->precio }}</del></h3>
                        <h1>{{ $vehiculo->oferta }}</h1>
                    @else
                        <h1>{{ $vehiculo->precio }}</h1>
                    @endif
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                    <hr>
                    <h2>COTIZADOR</h2>
                </div>
                <div class="col-ms-12 col-md-4 col-lg-4 text-right">
                    <h3>ENGANCHE</h3>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-left">
                    <input type="text" name="inputEnganche_d" id="inputEnganche_d" value="{{ $enganche }}" disabled>
                </div>
                <div class="col-ms-12 col-md-4 col-lg-4 text-right">
                    <h3>CUOTAS</h3>
                </div>
                <div class="col-ms-12 col-md-4 col-lg-4 text-left">
                    <select name="mes_c_d" id="mes_c_d" style="width: 100%">
                        <option id="mes0" value="24">24</option>
						<option id="mes1" value="36">36</option>
						<option id="mes2" value="48">48</option>
						<option id="mes3" value="60" selected>60</option>
                    </select>
                </div>
                <div class="col-ms-12 col-md-4 col-lg-4 text-right">
                    <div id="cuotasDesdeResult_d" style="font-family:'Montserrat-Medium'; color:black; background:transparent; font-size:2.4em;"></div>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-center">
                    <button class="btn btn-info" id="calcular" onclick="{{ "javascript:calcularCuotas_d('$vehiculo->symbol',$precio);" }}">CALCULAR</button>
                    <br>
                    <br>
                </div>
                <div class="col-ms-12 col-md-4 col-lg-4 text-right" style="color: black;"></div>
                <div class="col-sm-12 col-md-8 col-lg-8 text-right">
                    <h3>CUOTA:</h3>
                </div>
                <div class="col-ms-12 col-md-4 col-lg-4 text-right">
                    <button class="btn btn-sm btn-info">MÁS INFORMACIÓN</button>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 text-right" id="o_trace_d"></div>
                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                    <br><br>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="background-color: #d0d0d0; color: #808080;">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <br><br>
            <span style="font-size:2vw;"><strong> Ubicación: </strong>
                @if (count($ubicacion) > 0)
                    @foreach ($ubicacion as $item)
                        {{ $item->location }} <br>
                    @endforeach
                @else
                    Haga su cita
                @endif
            </span>
            <br><br>
        </div>
    </div>
    <div class="row" style="background-color: #d0d0d0;">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <h3 class="text-center"><strong>Generales</strong></h3>
            <p>
                {!! $general->description !!}<br>
                Combustible: {{ $vehiculo->fuels }}<br>
                Tracción: {{ $general->tractions }}<br>
                Transmisión: {{ $general->transmisions }}<br>
                Rendimiento: {{ $general->yields }}<br>
                Fabiración: {{ $general->fabrications }}<br>
                Color: {{ $vehiculo->colors }}
            </p>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3">
            <h3 class="text-center"><strong>Comfort</strong></h3>
            <p>
                {!! $comfort->description !!}
            </p>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3">
            <h3 class="text-center"><strong>Protección</strong></h3>
            <p>
                {!! $seguridad->description !!}
            </p>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3">
            <h3 class="text-center"><strong>Extras</strong></h3>
            <p>
                @foreach ($diferencia as $item)
                    {{ $item->name }} <br>
                @endforeach
                {!! $extra->description !!}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <hr style="height: 10px; width: 80%; background-color:#343a40;">
        </div>
    </div>
    <div class="row">
      <div class="col-6"><h3 class="mb-3" style="color: #808080;"><strong>Recomendaciones</strong></h3></div>
      @if (count($precios_carros) > 1)
      <div class="col-6 text-right">
        <a class="btn btn-primary mb-3 mr-1" href="#carrusel_categoria" role="button" data-slide="prev">Atrás</a>
        <a class="btn btn-primary mb-3" href="#carrusel_categoria" role="button" data-slide="next">Siguiente</a>
      </div>          
      @endif
      <div class="col-sm-12 col-md-12 col-lg-12">
        <div id="carrusel_categoria" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            @foreach ($precios_carros as $carrusel)
              <div class="{{ $carrusel['numero'] == 0 ? "carousel-item active" : "carousel-item" }}">
                <div class="row">
                  @foreach ($carrusel['vehiculos'] as $vehiculo)
                  <div class="col-md-3 mb-3">
                    <div class="card box">
                        @if ($vehiculo->estado != 'DISPONIBLE')
                            <div class="ribbon ribbon-top-left"><span>{{ $vehiculo->estado }}</span></div>
                        @endif
                        <a href="{{ route('vehiculo', ['slug' => $vehiculo->slug, 'value' => base64_encode($vehiculo->codigo)]) }}">
                        <img class="img-fluid" alt="{{ $vehiculo->alt }}" src="{{ asset('img/encima_motores502.png') }}" style="background-blend-mode: normal; background-image: url({{ $vehiculo->image }}); background-size: 100% 100%; background-repeat: no-repeat;" />
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">{{ $vehiculo->codigo }}</h4>
                            <p class="card-text">
                                <ul>
                                    <li>{{ $vehiculo->marca }}</li>
                                    <li>{{ $vehiculo->linea }}</li>
                                    <li>{{ $vehiculo->modelo }}</li>
                                    <li>{{ $vehiculo->kilometro }}</li>
                                    <li>{{ $vehiculo->oferta ? $vehiculo->oferta : $vehiculo->precio }}</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                  </div>                      
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>


    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close m-0 p-3 text-white position-absolute right-0" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-transparent">
                <div class="modal-body p-0">
                    <div id="vehiculo_especifico" class="carousel slide carousel-fade" data-ride="false">
                        @foreach ($images as $key => $item)
                        <div class="{{ $key == 0 ? 'carousel-item active' : 'carousel-item' }}">
                            <img class="d-block w-100" src="{{ asset('img/encima_motores502.png') }}" alt="{{ $item->concat }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;">
                        </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#vehiculo_especifico" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#vehiculo_especifico" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
<script>
    $(document).ready(function(){
   $("#calcular").click();
});
</script>
@stop

<script src="{{ asset('js/quotes.js') }}"></script>