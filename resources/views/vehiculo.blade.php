@extends('layouts.master')

@section('style')
    <link rel="stylesheet" href="{{ asset('template_new/css/jquery.datetimepicker.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.min.css') }}" type="text/css">
@endsection

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Si tiene motor, te ayudamos a venderlo</h1>
        </div>
    </section>
    <!--End Page Title-->

    <!--Inventory Section-->
    <section class="inventory-section inventory-single">
    	<div class="auto-container">
        	<div class="row clearfix">    
                <!--Column-->
            	<div class="column col-lg-8 col-md-8 col-sm-12 col-xs-12">
                	<!--Inventory Details-->
                    <div class="inventory-details">
                        <div class="vehicle-details">
                            <div class="text-description">
                                <h2>{{ $vehiculo->nombre_completo }} <span class="h3"><b>(id: {{ $vehiculo->codigo }})</b></span> </h2>
                                <p class="h4">Ubicación:
                                @if (count($ubicacion) > 0)
                                    @foreach ($ubicacion as $item)
                                        {{ $item->location }} <br>
                                    @endforeach
                                @else
                                    Haga su cita
                                @endif
                                </p>
                                <hr> 
                            </div>  
                        </div>
                        <!--Product Carousel-->
                        <div class="product-carousel-outer">
                            <div class="big-image-outer">

                                <!--Product image Carousel-->
                                <ul class="prod-image-carousel owl-theme owl-carousel">
                                    @foreach ($images as $key => $item)
                                        <li>
                                            <figure class="image">
                                                <img class="lazyload" data-src="{{ Storage::disk('images')->url($item->image) }}" alt="{{ $item->concat }}" />
                                                
                                                @if ($vehiculo->estado != 'DISPONIBLE')
                                                    <div class="ribbon ribbon-top-left"><span>{{ $vehiculo->estado }}</span></div>
                                                @endif
                                                <a class="lightbox-image fancy-btn" data-fancybox-group="example-gallery" href="{{ Storage::disk('images')->url($item->image) }}" title="{{ $item->concat }}">
                                                    <span class="fa fa-search-plus"></span>
                                                </a>
                                            </figure>
                                        </li>
                                    @endforeach   
                                    @foreach ($videos as $item)
                                        <li>
                                            <figure class="image">
                                                @foreach ($images->take(1) as $item_dos)
                                                    <img class="lazyload" data-src="{{ Storage::disk('images')->url($item_dos->image) }}" alt="{{ $item_dos->concat }}" />
                                                    
                                                    @if ($vehiculo->estado != 'DISPONIBLE')
                                                        <div class="ribbon ribbon-top-left"><span>{{ $vehiculo->estado }}</span></div>
                                                    @endif
                                                    <a class="lightbox-image fancy-btn" data-fancybox-group="example-gallery" href="{{ $item->link }}" title="Motores 502">
                                                        <span class="fa fa-play"></span>
                                                    </a>
                                                @endforeach
                                            </figure>
                                        </li>
                                    @endforeach 
                                </ul>
                            </div>

                            <!--Product Thumbs Carousel-->
                            <div class="prod-thumbs-carousel owl-theme owl-carousel">
                                @foreach ($images as $key => $item)
                                    <div class="thumb-item">
                                        <figure class="thumb-box image">
                                            <img alt="{{ $item->concat }}" class="lazyload" data-src="{{ Storage::disk('images')->url($item->image) }}" />
                                        </figure>
                                    </div>
                                @endforeach   
                                @foreach ($videos as $item)
                                    <div class="thumb-item">
                                        <figure class="thumb-box">
                                            @foreach ($images->take(1) as $item_dos)
                                            <img class="lazyload" data-src="{{ Storage::disk('images')->url($item_dos->image) }}" alt="{{ $item_dos->concat }}" />
                                            <div class="video-icon">
                                                <span class="fa fa-play"></span>
                                            </div>
                                            @endforeach
                                        </figure>
                                    </div>
                                @endforeach                              
                            </div>
                            
                        </div><!--End Product Carousel-->

                        <!--Details Panel Box-->
                        <div class="details-panel-box">
                        	<div class="panel-header"><div class="panel-btn clearfix"><h4><strong>Características del vehículo</strong> {{ $vehiculo->nombre_completo }} </h4><div class="arrow"><span class="fa fa-angle-down"></span></div></div></div>
                            <div class="panel-content">
                            	<div class="content-box">
                                	<div class="listing-outer clearfix">
                                    	<div class="list-column">
                                        	<ul class="list-style-seven">
                                            	<li class="clearfix"><span class="ttl">Fabricación</span><span class="dtl">{{ $general->fabrications }}</span></li>
                                                <li class="clearfix"><span class="ttl">Total Kilometros</span><span class="dtl">{{ $vehiculo->mileage }}Kms</span></li>
                                                <li class="clearfix"><span class="ttl">Combustible</span><span class="dtl">{{ $vehiculo->fuels }}</span></li>
                                                <li class="clearfix"><span class="ttl">Estado</span><span class="dtl">{{ $vehiculo->estado }}</span></li>
                                            </ul>
                                        </div>
                                        <div class="list-column">
                                        	<ul class="list-style-seven">
                                            	<li class="clearfix"><span class="ttl">Transmisión</span><span class="dtl">{{ $general->transmisions }}</span></li>
                                                <li class="clearfix"><span class="ttl">Tracción</span><span class="dtl">{{ $general->tractions }}</span></li>
                                                <li class="clearfix"><span class="ttl">Rendimiento</span><span class="dtl">{{ $general->yields }} kmpl</span></li>
                                                <li class="clearfix"><span class="ttl">Color</span><span class="dtl">{{ $vehiculo->colors }}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--Details Panel Box-->
                        <div class="details-panel-box tech-details">
                        	<div class="panel-header">
                                <div class="panel-btn clearfix">
                                    <h4>
                                        <strong>Detalles técnicos</strong> {{ $vehiculo->nombre_completo }} 
                                    </h4>
                                    <div class="arrow"><span class="fa fa-angle-down"></span></div>
                                </div>
                            </div>
                            <div class="panel-content">
                            	<div class="content-box tabs-box inventory-tabs clearfix">
                                	<div class="tab-buttons-outer">
                                    	<ul class="tab-buttons clearfix">
                                        	<li class="tab-btn active-btn" data-tab="#tab-one">Ingeniería</li>
                                            <li class="tab-btn" data-tab="#tab-two">Comfort</li>
                                            <li class="tab-btn" data-tab="#tab-three">Protección</li>
                                            <li class="tab-btn" data-tab="#tab-four">Extras</li>
                                        </ul>
                                    </div>
                                    
                                    <!--Tabs Content-->
                                    <div class="tabs-content">
                                    	<!--Tab / Active Tab-->
                                    	<div class="tab active-tab" id="tab-one">
                                            <div class="listing-outer clearfix">
                                                <div class="list-column">
                                                    <ul class="list-style-eight">
                                                        <li class="clearfix">
                                                            <span class="ttl">Descripción</span>
                                                            <span class="dtl">{!! $general->description !!}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!--End Tab-->
                                        <!--Tab-->
                                    	<div class="tab" id="tab-two">
                                            <div class="listing-outer clearfix">
                                                <div class="list-column">
                                                    <ul class="list-style-eight">
                                                        <li class="clearfix">
                                                            <span class="ttl">Descripción</span>
                                                            <span class="dtl">{!! $comfort->description !!}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!--End Tab-->
                                        <!--Tab-->
                                    	<div class="tab" id="tab-three">
                                            <div class="listing-outer clearfix">
                                                <div class="list-column">
                                                    <ul class="list-style-eight">
                                                        <li class="clearfix">
                                                            <span class="ttl">Descripción</span>
                                                            <span class="dtl">{!! $seguridad->description !!}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!--End Tab-->
                                        <!--Tab-->
                                    	<div class="tab" id="tab-four">
                                            <div class="listing-outer clearfix">
                                                <div class="list-column">
                                                    <ul class="list-style-eight">
                                                        <li class="clearfix">
                                                            <span class="ttl">Descripción</span>
                                                            <span class="dtl">{!! $extra->description !!}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!--End Tab-->
                                        
                                    </div><!--End Tabs Content-->
                                    
                                </div>
                            </div>
                        </div>
                        
                        <!--Details Panel Box-->
                        <div class="details-panel-box extra-features">
                        	<div class="panel-header"><div class="panel-btn clearfix"><h4><strong>Detalles únicos </strong> {{ $vehiculo->nombre_completo }} </h4><div class="arrow"><span class="fa fa-angle-down"></span></div></div></div>
                            <div class="panel-content">
                            	<div class="content-box">
                                    <div class="listing-outer clearfix">
                                        @foreach ($diferencia->chunk(3) as $bloque)
                                            <div class="list-column">
                                                <ul class="list-style-nine">                                       
                                            @foreach ($bloque as $item)
                                                <li>{{ $item->name }}</li>
                                            @endforeach
                                                </ul>
                                            </div>                                           
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--Offer Box-->
                        <div class="offer-box">
                        	<div class="row clearfix">
                            	<!--Offer Column-->
                                <div class="offer-column col-md-7 col-sm-12 col-xs-12">
                                	<div class="inner-box">
                                    	<h3>{{ $vehiculo->nombre_completo }} </h3>
                                        <div class="subtitle">Descuentos aplicados</div>
                                        <ul class="offer-info">
                                            @foreach ($ofertas as $key => $item)
                                                <li><h4>Descuento No. {{ $key+1 }}:</h4><div class="clearfix"><span class="pull-left">{{ $item->precio_formato }}</span><span class="pull-right"><div class="price">-{{ $item->porcentaje }} <span class="percent">%</span></div></span></div></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!--Offer Banner-->
                                <div class="offer-banner col-md-5 col-sm-6 col-xs-12">
                                	<div class="inner-box">
                                        @foreach ($images->take(1) as $item_dos)
                                    	    <figure class="image">
                                                <img class="lazyload" data-src="{{ Storage::disk('images')->url($item_dos->image) }}" alt="{{ $item_dos->concat }}">
                                            </figure>
                                        @endforeach
                                        <div class="upper-info">
                                        	<h4>Km 13 Antigua Carretera a El Salvador Muxbal Plaza Muxbal Local M08</h4>
                                            <div class="link"><a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#masInformacion" class="theme-btn btn-style-one">Más Información</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!--Form Column-->
                <div class="form-column col-lg-4 col-md-4 col-sm-12 col-xs-12">

                    <div class="inventory-single-price sec-title">
                        <h2>
                            @if ($vehiculo->oferta )
                                <del>{{ $vehiculo->precio }}</del>
                                <br>
                                {{ $vehiculo->oferta }}
                            @else
                                {{ $vehiculo->precio }}
                            @endif
                                                                        
                            <span class="pull-right">
                                <img width="50px" src="{{ Storage::disk('images')->url($vehiculo->imagen_marca) }}" alt="{{ $vehiculo->marca }}">
                            </span>
                        </h2>
                    </div> 

                    <div class="schedule-drive-outer">
                        <div class="form-outer">
                            <div class="form-header">
                                <h2>Compartir Información</h2>
                                <ul class="social-icon-four">
                                    <li><a class="copia" href="javascript:getlink();"><span class="icon fa fa-copy"></span></a></li>
                                    <li><a href="{{ "mailto:?$correo" }}" target="_blank" rel="noopener noreferrer"><span class="icon fa fa-envelope"></span></a></li>
                                    <li><a href="{{ "https://www.facebook.com/sharer/sharer.php?u=$url" }}" target="_blank" rel="noopener noreferrer"><span class="fa fa-facebook"></span></a></li>
                                    <li><a href="{{ "https://twitter.com/intent/tweet?original_referer=$url" }}" target="_blank" rel="noopener noreferrer"><span class="fa fa-twitter"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!--Schedule Test Drive Form-->
                    <div class="schedule-drive-outer">
                        <div class="form-outer">
                            <div class="form-header">
                                <h2>Formulario para prueba de manejo</h2>
                                <div class="vehicle-model">{{ $vehiculo->nombre_completo }}</div>
                            </div>
                            <div class="form-box">
                                <!--Cars Form-->
                                <div class="cars-form">
                                    <form action="{{ route('test.store') }}" role="form" method="post" autocomplete="off">
                                        @csrf
                                        <input type="hidden" name="transports_id" value="{{ $id }}">
                                        <div class="row clearfix">
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label for="names">Nombre</label>
                                                <div class="field-inner">
                                                    <input type="text" name="names" placeholder="escribir los nombres" onkeyup="mayus(this);" value="{{ old('names') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label for="surnames">Apellido</label>
                                                <div class="field-inner">
                                                    <input type="text" name="surnames" placeholder="escribir los apellidos" onkeyup="mayus(this);" value="{{ old('surnames') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label for="email">Correo electrónico</label>
                                                <div class="field-inner">
                                                    <input type="email" name="email" placeholder="escribir un correo electrónico para comunicarnos" onkeyup="min(this);" value="{{ old('email') }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label for="type_phone_id">Tipo de teléfono</label>
                                                <div class="field-inner">
                                                    <select class="form-control js-example-basic-single" style="width: 100%" name="type_phone_id">
                                                        <option value="">Seleccionar uno por favor</option>
                                                        @foreach ($tipos_telefono as $item)
                                                            <option value="{{ $item->id }}" {{ ($item->id == 1) ? 'selected' : '' }}>{{ $item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label for="number_test">Número de Teléfono</label>
                                                <div class="field-inner">
                                                    <input type="tel" name="number_test" placeholder="escribir número de teléfono" value="{{ old('number_test') }}" class="form-control" id="number_test">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <label for="date_time">Fecha &amp; Hora</label>
                                                <div class="field-inner">
                                                    <span class="fa fa-clock-o"></span>
                                                    <input class="date-time-picker" type="text" placeholder="seleccionar la fecha y hora" name="date_time" value="{{ old('date_time') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <button type="submit" id="guardar_test" class="theme-btn btn-style-one">Registrar información</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- oan calculator widget-->
                    <div class="loan-cal-widget">
                        <div class="inner">
                            <h3>Cotizador</h3>
                            <div class="form-box">
                                <!--Cars Form-->
                                <div class="cars-form">
                                    
                                        <div class="form-group">
                                            <label>Enganche</label>
                                            <input type="text" name="inputEnganche_d" id="inputEnganche_d" value="{{ $enganche }}" placeholder="50000">
                                        </div>

                                        <div class="form-group">
                                            <label>Cuotas</label>
                                            <select class="custom-select-box" name="mes_c_d" id="mes_c_d">
                                                <option id="mes0" value="24">24</option>
                                                <option id="mes1" value="36">36</option>
                                                <option id="mes2" value="48">48</option>
                                                <option id="mes3" value="60" selected>60</option>
                                            </select>
                                        </div>

                                        <h2>
                                            <div class="text-center" id="cuotasDesdeResult_d"></div>
                                        </h2>

                                        <div class="form-group">
                                            <button class="theme-btn btn-style-one" id="calcular"  onclick="{{ "javascript:calcularCuotas_d('$vehiculo->symbol',$precio);" }}">Calcular</button>
                                        </div>
                              
                                    <div id="o_trace_d"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single inventory Recommendation-->
                    <div class="recent-tickets-section inventory-single-recommendation">

                        <div class="inventory-single-price sec-title">
                            <h2>Recomendaciones</h2>
                        </div>

                        <div class="row clearfix">
                            <!--Car Block-->
                            @foreach ($precios_carros->take(3) as $item)
                 
                            <div class="car-block col-sm-12">
                                <div class="inner-box">
                                    <div class="image">
                                        @if ($item->estado != 'DISPONIBLE')
                                            <div class="ribbon ribbon-top-left"><span>{{ $item->estado }}</span></div>
                                        @endif
                                        <a href="{{ route('vehiculo_recomendacion', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}" title="{{ $item->alt }}">
                                            <img class="lazyload" data-src="{{ Storage::disk('images')->url($item->image) }}" alt="{{ $item->alt }}" />
                                        </a>
                                        <div class="price">{{ $item->precio }}</div>
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
                            <!--Car Block-->
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <!--End Inventory Section-->

    <div class="modal fade" id="masInformacion" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #595758; color: #eaeded;">
                    Formulario para cotización
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #eaeded; color: #595758;">
                    <div class="cars-form">
                        <form action="{{ route('cotizar.store') }}" role="form" method="post" autocomplete="off" id="mas-informacion-form">
                            @csrf
                            <input type="hidden" name="transports_id" value="{{ $id }}">
                            <div class="row clearfix">
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label for="names">Nombres</label>
                                    <div class="field-inner">
                                        <input type="text" name="names" placeholder="escribir los nombres" onkeyup="mayus(this);" value="{{ old('names') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label for="surnames">Apellidos</label>
                                    <div class="field-inner">
                                        <input type="text" name="surnames" placeholder="escribir los apellidos" onkeyup="mayus(this);" value="{{ old('surnames') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label for="email">Correo electrónico</label>
                                    <div class="field-inner">
                                        <input type="email" name="email" placeholder="escribir el correo eletrónico" onkeyup="min(this);" value="{{ old('email') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label for="type_phone_id">Tipo de teléfono</label>
                                    <div class="field-inner">
                                        <select class="form-control js-example-basic-single" style="width: 100%" name="type_phone_id">
                                            <option value="">Seleccionar uno por favor</option>
                                            @foreach ($tipos_telefono as $item)
                                                <option value="{{ $item->id }}" {{ ($item->id == 1) ? 'selected' : '' }}>{{ $item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label for="number">Número de Teléfono</label>
                                    <div class="field-inner">
                                        <input type="tel" name="number" placeholder="escribir el número de teléfono" style="width: 100%" value="{{ old('number') }}" class="form-control" id="phone">
                                        <span id="error-msg" class="hide"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <label for="channel_id">¿Medio por donde se entero de nosotros?</label>
                                    <div class="field-inner">
                                        <select class="form-control js-example-basic-multiple" style="width: 100%" multiple="multiple" name="channel_id[]">
                                            <option value="">Seleccionar uno o más por favor</option>
                                            @foreach ($canales as $item)
                                                <option value="{{ $item->id }}"><small>{{ $item->name }}</small></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                    <button type="submit" id="guardar" class="theme-btn btn-style-one">Enviar información</button>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')    
    <script type="text/javascript" src="{{ asset('template_new/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/jquery.datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/validate.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/intlTelInput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quotes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vehiculo_utileria.js') }}"></script>
@endsection