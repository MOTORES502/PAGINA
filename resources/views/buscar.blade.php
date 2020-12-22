@extends('layouts.master')

@section('content')
<input type="hidden" id="search" value="{{ $search }}">
@if ($existe)
<!--Popular Cars Section-->
<section class="recent-tickets-section">
    <div class="auto-container">
        <!--Sec Title-->
        <div class="sec-title">
            <h2>{{ $titulo }}</h2>
        </div>

        <!--Popular Used Tabs-->
        <div class="single-brand-inventory">

            <!--Tabs Box-->
            <div class="prod-tabs tabs-box">
                <div class="text-center">
                    <!--Tab Btns-->
                    <ul class="tab-btns tab-buttons clearfix">
                        <li data-tab="#latest-entries" class="tab-btn active-btn"><span class="text">Últimos ingresos</span></li>
                    </ul>
                </div>

                <!--Tabs Container-->
                <div class="tabs-content">
                    <div class="tab active-tab" id="latest-entries">
                        <div class="layout-box clearfix">
                            <div class="pull-left">
                                <div class="sort-form">
                                    <div class="form-group">
                                        <label>Ordenar por categoría:</label>
                                        <select id="categoria" class="custom-select-box">
                                            <option value="0" selected>Seleccionar categoría</option>
                                            @foreach ($categorias as $item)
                                                <option value="{{ $item->sub_categories }}">{{ $item->sub_categories }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-left">
                                <div class="sort-form">
                                    <div class="form-group">
                                        <label>Ordenar por precio:</label>
                                        <select id="precio" class="custom-select-box">
                                            <option value="0" selected>Seleccionar por precio</option>
                                            <option value="DESC">Precio más alto</option>
                                            <option value="ASC">Precio más bajo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-left">
                                <div class="sort-form">
                                    <div class="form-group">
                                        <label>Ordenar por modelo:</label>
                                        <select id="modelo" class="custom-select-box">
                                            <option value="0" selected>Seleccionar por modelo</option>
                                            <option value="DESC">Modelo más reciente</option>
                                            <option value="ASC">Modelo menos reciente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-left">
                                <div class="sort-form">
                                    <button id="consultar" class="theme-btn btn-sm btn-style-one" style="padding: 9px 25px;">Consultar</button>
                                </div>
                            </div>
                        </div>
                        <div class="content" id="carros_buscados">
                            <!--Styled Pagination-->
                            {{ $data->links() }}
                            <!--End Styled Pagination-->
                            <br>
                            <!--Car Block-->
                            @foreach($data->chunk(4) as $bloque)
                                <div class="row clearfix">
                                @foreach ($bloque as $item)
                                    <div class="car-block col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
                </div>
            </div>
        </div>
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
    <script type="text/javascript" src="{{ asset('template_new/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/paginador_buscar.js') }}"></script>
@endsection