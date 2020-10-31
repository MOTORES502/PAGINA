@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <br><br>
        </div>
        <div class="col-10" style="color: #808080;">
            <p><strong style="font-size: 4vw;">{{ $vehiculo->nombre_completo }} |</strong><span style="font-size: 2vw;">|  {{ $vehiculo->generacion }}</span></p>
        </div>
        <div class="col-2">
            <img class="img-fluid" width="100%" style="margin:auto; display:block;" alt="{{ $vehiculo->nombre_completo }}" src="{{ $vehiculo->imagen_marca }}" />
        </div>
        <div class="col-12">
            <hr style="height: 10px; width: 80%; background-color:#343a40;">
        </div>
    </div>
    <div class="row"> 
        <div class="col-12" style="color: #808080;">
            <p><strong style="font-size: 2vw;">id: </strong><span style="font-size: 3vw;">{{ $vehiculo->codigo }}</span><span style="font-size:2vw;"><strong> Ubicación: </strong>Haga su cita</span></p>
        </div>      
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div id="gallery-lightbox" class="row" data-toggle="modal" data-target="#exampleModal">
                        @foreach ($images as $key => $item)
                        <div class="col-3 p-0">
                            <img class="w-100" src="{{ asset('img/encima_motores502.png') }}" width="100px" height="100px" alt="{{ $item->concat }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" data-target="#vehiculo_especifico" data-slide-to="{{ $key }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>   
        <div class="col-6" style="height: 100%">
            <div class="row">
                <div class="col-4" style="background: #595758; color: white; font-size: 4em;">Valor</div>
                <div class="col-8 text-right" style="background: #595758; color: white;">
                    @if ($vehiculo->oferta )
                        <h3><del>{{ $vehiculo->precio }}</del></h3>
                        <h1>{{ $vehiculo->oferta }}</h1>
                    @else
                        <h1>{{ $vehiculo->precio }}</h1>
                    @endif
                </div>
                <div class="col-12 text-center" style="background: #595758; color: white;">
                    <hr>
                    <h2>COTIZADOR</h2>
                </div>
                <div class="col-4 text-right" style="background: #595758; color: white;">
                    <h3>ENGANCHE</h3>
                </div>
                <div class="col-8 text-left" style="background: #595758; color: white;">
                    <input type="text" name="inputEnganche_d" id="inputEnganche_d" value="{{ $enganche }}" disabled>
                </div>
                <div class="col-4 text-right" style="background: #595758; color: white;">
                    <h3>CUOTAS</h3>
                </div>
                <div class="col-4 text-left" style="background: #595758; color: white;">
                    <select name="mes_c_d" id="mes_c_d" style="width: 100%">
                        <option id="mes0" value="24">24</option>
						<option id="mes1" value="36">36</option>
						<option id="mes2" value="48">48</option>
						<option id="mes3" value="60" selected>60</option>
                    </select>
                </div>
                <div class="col-4 text-right" style="background: #595758; color: white;">
                    <div id="cuotasDesdeResult_d" style="font-family:'Montserrat-Medium'; color:black; background:transparent; font-size:2.4em;"></div>
                </div>
                <div class="col-8 text-center" style="background: #595758; color: white;">
                    <button class="btn btn-primary" style="background: #1a1a1a;" id="calcular" onclick="{{ "javascript:calcularCuotas_d('$vehiculo->symbol',$precio);" }}">CALCULAR</button>
                </div>
                <div class="col-4 text-right" style="background: #595758; color: black;"></div>
                <div class="col-8 text-right" style="background: #595758; color: white;">
                    <h3>CUOTA:</h3>
                </div>
                <div class="col-4 text-right" style="background: #595758; color: white;">
                    <button class="btn btn-sm btn-primary" style="background: #1a1a1a;">MÁS INFORMACIÓN</button>
                </div>
                <div class="col-12 text-right" id="o_trace_d"></div>
                <div class="col-12 text-right">
                    <br><br>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <hr style="height: 10px; width: 80%; background-color:#343a40;">
        </div>
    </div>
    <div class="row">
      <div class="col-6"><h3 class="mb-3" style="color: #808080;"><strong>Recomendaciones</strong></h3></div>
      @if (count($precios_carros) > 1)
      <div class="col-6 text-right">
        <a style="color: #808080;" class="btn btn-primary mb-3 mr-1" style="color: white;" href="#carrusel_categoria" role="button" data-slide="prev">Atrás</a>
        <a style="color: #808080;" class="btn btn-primary mb-3" href="#carrusel_categoria" role="button" data-slide="next">Siguiente</a>
      </div>          
      @endif
      <div class="col-12">
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