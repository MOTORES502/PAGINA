@extends('layouts.master')

@section('content')
<input type="hidden" name="marca_idc" value="{{ $marca_id }}">
<input type="hidden" name="linea_idc" value="{{ $linea_id }}">
<input type="hidden" name="precio_minimoc" value="{{ $precio_minimo }}">
<input type="hidden" name="precio_maximoc" value="{{ $precio_maximo }}">
@if ($existe)
    <!--Inventory Section-->
    <section class="inventory-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Column-->
            	<div class="column col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <!--Sec Title-->
                    <div class="sec-title">
                        <h2>{{ $titulo }}</h2>
                    </div>

                    <!--End Sec Title-->
                    <div id="carros_buscados">
                        <!--Styled Pagination-->
                        {{ $data->links() }}
                        <!--End Styled Pagination-->

                        <br>
                        <!--Car Block-->
                        @foreach($data->chunk(3) as $bloque)
                            <div class="row clearfix">
                            @foreach ($bloque as $item)
                                <div class="car-block col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <div class="inner-box">
                                    <div class="image">
                                        @if ($item->estado != 'DISPONIBLE')
                                            <div class="ribbon ribbon-top-left"><span>{{ $item->estado }}</span></div>
                                        @endif
                                        <a href="{{ route('vehiculo_buscar', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}" title="{{ $item->alt }}">
                                            <img alt="{{ $item->alt }}" class="lazyload" data-src="{{ Storage::disk('images')->url($item->image) }}" />
                                        </a>
                                        <div class="price">{{ $item->oferta ? $item->oferta : $item->precio }}</div>
                                    </div>
                                    <h3>
                                        {{ $item->completo }} <br> {{ $item->codigo }}
                                    </h3>
                                    <div class="lower-box">
                                        <ul class="car-info">
                                            <li><span class="icon fa fa-road"></span>{{ number_format($item->kilometro, 0, '.', ',') }}</li>
                                            <li><span class="icon fa fa-car"></span>{{ $item->combustible }}</li>
                                            <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
                                            <li><span class="icon fa fa-gears"></span>{{ $item->transmision }}</li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>            
                            @endforeach
                            </div>
                        @endforeach
                        
                        <!--Styled Pagination-->
                        {{ $data->links() }}
                        <!--End Styled Pagination-->
                    </div>
                    
                </div>
                
                <!--Form Column-->
                <div class="form-column col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <!-- Search Box -->
                    <div class="faq-search-box">
                    	<div class="outer-box">
                            <form action="{{ route('buscar.personalizada') }}" method="get">
                                <div class="form-group">
                                    <input type="search" name="search" value="{{ old('search') }}" placeholder="Buscar por marca, línea o palabra" required>
                                    <button type="submit"><span class="icon fa fa-search"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!--Select Car Tabs-->
                    <div class="select-cars-tabs">
                        <!--Tabs Box-->
                        <div class="cars-form">
                            <form action="{{ route('buscar.buscador_combo') }}" method="post">
                                @csrf
                                <!--Form Group-->
                                <div class="form-group">
                                    <select id="marca_id" name="marca_id" class="form-control js-example-basic-single">
                                        <option value="">Seleccione marca</option>
                                        @foreach ($marcas as $item)
                                            <option value="0" disabled><strong>{{ $item->name }} DE MARCA</strong></option>
                                            @foreach ($item->brands as $marca)
                                                <option value="{{ $marca->id }}"><b>{{ $marca->name }}</b></option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>

                                <!--Form Group-->
                                <div class="form-group">
                                    <select id="linea_id" name="linea_id" class="form-control js-example-basic-single">
                                        <option value="">Seleccione línea</option>
                                    </select>
                                </div> 
                                
                                <!--Form Group-->
                                <div class="form-group">
                                    <select name="precio_minimo" class="form-control js-example-basic-single">
                                        <option value="">Seleccione el precio mínimo</option>
                                        @foreach ($arra_precio_bajo as $item)
                                            <option value="{{ $item['numero'] }}">{{ $item['numero_formato'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!--Form Group-->
                                <div class="form-group">
                                    <select name="precio_maximo" class="form-control js-example-basic-single">
                                        <option value="">Seleccione el precio máximo</option>
                                        @foreach ($arra_precio_alto as $item)
                                            <option value="{{ $item['numero'] }}">{{ $item['numero_formato'] }}</option>
                                        @endforeach
                                    </select>
                                </div>   

                                <div class="form-group">
                                    <button type="submit" class="theme-btn btn-style-one">Buscar vehículo</button>
                                </div>
                            </form>   
                        </div>
                    </div>
                    <!--End Select Car Tabs-->
                </div>
            </div>
        </div>
    </section>
    <!--End Inventory Section-->

<!--Popular Cars Section-->
<section class="recent-tickets-section">
    <div class="auto-container">

    </div>
</section>
<!--End Popular Cars Section-->
@else
    <section class="error-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
    	<div class="auto-container">
        	<div class="inner-section">
                <h2>{{ "No pudimos encontrar vehículos con las siguientes especficaciones $titulo" }}</h2>
                <div class="text">Te invitamos a que sigas navegando en nuestra página</div>
            </div>
        </div>
    </section>
    <!--End Error Section-->
@endif
@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/paginador_buscar_combo.js') }}"></script>
@endsection