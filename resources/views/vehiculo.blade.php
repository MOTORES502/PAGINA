@extends('layouts.master')

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
                    
                        <!--Product Carousel-->
                        <div class="product-carousel-outer">
                            <div class="big-image-outer">

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

                                <!--Product image Carousel-->
                                <ul class="prod-image-carousel owl-theme owl-carousel">
                                    @foreach ($images as $key => $item)
                                        <li>
                                            <figure class="image">
                                                <img src="{{ asset('img/encima_motores502.png') }}" alt="{{ $item->concat }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;">
                                                <a class="lightbox-image fancy-btn" data-fancybox-group="example-gallery" href="{{ asset('img/encima_motores502.png') }}" title="{{ $item->concat }}" 
                                                    style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;">
                                                    <span class="fa fa-search-plus"></span>
                                                </a>
                                            </figure>
                                        </li>
                                    @endforeach                                   
                                    <li><figure class="image"><img src="{{ asset('template_new/images/resource/inventory-image-7.jpg') }}" alt=""><a class="lightbox-image fancy-btn" data-fancybox-group="example-gallery" href="https://www.youtube.com/watch?v=icbp9z1pw40" title="Image Title Here"><span class="fa fa-play"></span></a></figure></li>
                                </ul>
                            </div>
                            
                            <!--Product Thumbs Carousel-->
                            <div class="prod-thumbs-carousel owl-theme owl-carousel">
                                @foreach ($images as $key => $item)
                                    <div class="thumb-item">
                                        <figure class="thumb-box">
                                            <img src="{{ asset('img/encima_motores502.png') }}" alt="{{ $item->concat }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;">
                                        </figure>
                                    </div>
                                @endforeach                                   
                                <div class="thumb-item"><figure class="thumb-box"><img src="images/resource/inv-thumb-3.jpg" alt=""><div class="video-icon"><span class="fa fa-play"></span></div></figure></div>
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
                                                <li class="clearfix"><span class="ttl">Total Kilometres</span><span class="dtl">{{ $vehiculo->mileage }}Km’s</span></li>
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
                        	<div class="panel-header"><div class="panel-btn clearfix"><h4><strong>Detalles técnicos</strong> {{ $vehiculo->nombre_completo }} </h4><div class="arrow"><span class="fa fa-angle-down"></span></div></div></div>
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
                                                <ul class="list-style-eight">
                                                <li class="clearfix">
                                                    <span class="ttl">Descripción</span>
                                                    <span class="dtl">{!! $general->description !!}</span>
                                                </li>
                                                </ul>
                                            </div>
                                        </div><!--End Tab-->
                                        <!--Tab-->
                                    	<div class="tab" id="tab-two">
                                            <div class="listing-outer clearfix">
                                                <ul class="list-style-eight">
                                                <li class="clearfix">
                                                    <span class="ttl">Descripción</span>
                                                    <span class="dtl">{!! $comfort->description !!}</span>
                                                </li>
                                                </ul>
                                            </div>
                                        </div><!--End Tab-->
                                        <!--Tab-->
                                    	<div class="tab" id="tab-three">
                                            <div class="listing-outer clearfix">
                                                <ul class="list-style-eight">
                                                <li class="clearfix">
                                                    <span class="ttl">Descripción</span>
                                                    <span class="dtl">{!! $seguridad->description !!}</span>
                                                </li>
                                                </ul>
                                            </div>
                                        </div><!--End Tab-->
                                        <!--Tab-->
                                    	<div class="tab" id="tab-four">
                                            <div class="listing-outer clearfix">
                                                <ul class="list-style-eight">
                                                <li class="clearfix">
                                                    <span class="ttl">Descripción</span>
                                                    <span class="dtl">{!! $extra->description !!}</span>
                                                </li>
                                                </ul>
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
                                    	<h3>Audi A8 3.0 TDI S12 Quattro Tiptronic </h3>
                                        <div class="subtitle">Special Offer</div>
                                        <ul class="offer-info">
                                        	<li><h4>Sales Offer:</h4><div class="clearfix"><span class="pull-left">1.5APR ,Deal Available untill Aug 21</span><span class="pull-right">*2 Years  Free Service</span></div></li>
                                            <li><h4>Service Offer:</h4><div class="clearfix"><span class="pull-left">Get 50% Discount on Every Service<br>3 Years Warrant for all Products</span><span class="pull-right">* 1 Year Free Service</span></div></li>
                                            <li><div class="conditions-apply"><a href="javascript:">* Conditions Apply.</a></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--Offer Banner-->
                                <div class="offer-banner col-md-5 col-sm-6 col-xs-12">
                                	<div class="inner-box">
                                    	<figure class="image"><img src="images/resource/inventory-image-10.jpg" alt=""></figure>
                                        <div class="upper-info">
                                        	<h3>Audi A4 3.0</h3>
                                            <div class="text">100% Safety and 0% Emissions</div>
                                            <div class="link"><a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#masInformacion" class="theme-btn btn-style-one">Más Información</a></div>
                                        </div>
                                        <div class="limit">* Get some special offers now</div>
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
                                <img width="50px" src="{{ $vehiculo->imagen_marca }}" alt="{{ $vehiculo->marca }}">
                            </span>
                        </h2>
                    </div>

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
                                    <form method="post" action="">
                                        <div class="row clearfix">
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>Name</label>
                                                <div class="field-inner">
                                                    <input type="text" name="field-name" value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>Email</label>
                                                <div class="field-inner">
                                                    <input type="email" name="field-name" value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>Phone</label>
                                                <div class="field-inner">
                                                    <input type="text" name="field-name" value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                <label>Date &amp; Time</label>
                                                <div class="field-inner">
                                                    <span class="fa fa-clock-o"></span>
                                                    <input class="date-time-picker" type="text" name="field-name" value="" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                <button class="theme-btn btn-style-one">Request Now</button>
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
                                    <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                                        <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                                    </a>
                                    <div class="price">{{ $item->precio }}</div>
                                    </div>
                                    <h3>
                                    <a  href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                                        {{ $item->completo }} <br> {{ $item->codigo }}
                                    </a>
                                    </h3>
                                    <div class="lower-box">
                                    <ul class="car-info">
                                        <li><span class="icon fa fa-road"></span>{{ number_format($item->kilometro, 0, '.', ',') }}</li>
                                        <li><span class="icon fa fa-car"></span>{{ $item->combustible }}</li>
                                        <br>
                                        <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
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


    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <br><br>
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="fa fa-ban"></i> ¡Error!</h5>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div> 
            @elseif(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="fa fa-check"></i> ¡Éxito!</h5>
                    {{Session::get('success')}}
                </div>
            @elseif(Session::has('warning'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="fa fa-exclamation-triangle"></i> ¡Advertencia!</h5>
                    {{Session::get('warning')}}
                </div>
            @elseif(Session::has('danger'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="fa fa-exclamation-triangle"></i> ¡Error!</h5>
                    {{Session::get('danger')}}
                </div>
            @elseif(Session::has('info'))
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="fa fa-info"></i> ¡Información!</h5>
                    {{Session::get('info')}}
                </div>
            @endif 
        </div>
    </div>
    <div class="row" style="background-color: #d0d0d0;"> 
        <div class="col-sm-12 col-md-6 col-lg-6 fondo-motores">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                    <br><br>
                    <a 
                        href="{{ 'https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fmotores502.com%2Fvehiculo%3Fid%3D' .  $vehiculo->facebook}}"
                        class="btn-info btn-lg btn-fb" 
                        style="margin-right: 15px;"
                        type="button" 
                        role="button"
                    >
                        <i class="fa fa-facebook-f"></i>
                    </a>
                    <a 
                        href="mailto:info@motores502.com"
                        class="btn-info btn-lg btn-fb" 
                        style="margin-right: 15px;"
                        type="button" 
                        role="button"
                    >
                        <i class="fa fa-envelope"></i>
                    </a>
                    <a 
                        href="tel:+50255792225"
                        class="btn-info btn-lg btn-fb" 
                        type="button" 
                        role="button"
                    >
                        <i class="fa fa-phone"></i>
                    </a>
                    <br><br>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="masInformacion" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #595758; color: #eaeded;">
                    Formulario para cotización
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background: #eaeded; color: #595758;">
                    <form action="{{ route('cotizar.store') }}" role="form" method="post" autocomplete="off">
                        @csrf
                        <input type="text" name="transports_id" value="{{ $id }}" hidden>
                        <div class="form-group">
                            <label for="names">Nombres</label>
                            <input type="text" name="names" onkeyup="mayus(this);" value="{{ old('names') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="surnames">Apellidos</label>
                            <input type="text" name="surnames" onkeyup="mayus(this);" value="{{ old('surnames') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email" name="email" onkeyup="min(this);" value="{{ old('email') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type_phone_id">Tipo de teléfono</label>
                            <select class="form-control js-example-basic-single" style="width: 100%" name="type_phone_id">
                                <option value="">Seleccionar uno por favor</option>
                                @foreach ($tipos_telefono as $item)
                                    <option value="{{ $item->id }}" {{ ($item->id == old('type_phone_id')) ? 'selected' : '' }}>{{ $item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number">Número de Teléfono</label>
                            <br>
                            <input type="tel" name="number" style="width: 100%" value="{{ old('number') }}" class="form-control" id="phone">
                            <span id="error-msg" class="hide"></span>
                        </div>
                        <div class="form-group">
                            <label for="channel_id">¿Medio por donde se entero de nosotros?</label>
                            <select class="form-control js-example-basic-multiple" style="width: 100%" multiple="multiple" name="channel_id[]">
                                <option value="">Seleccionar uno o más por favor</option>
                                @foreach ($canales as $item)
                                    <option value="{{ $item->id }}"><small>{{ $item->name }}</small></option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="guardar" class="btn btn-info btn-large pull-right">Cotizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<script>
$(document).ready(function(){
    $("#calcular").click();
});

function mayus(e) {
    e.value = e.value.toUpperCase();
}

function min(e) {
    e.value = e.value.toLowerCase();
}

var input = document.querySelector("#phone"),
    errorMsg = document.querySelector("#error-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Número inválido", "Código de país no válido", "Cantidad de dígitos inválido", "Cantidad de dígitos inválido", "Número inválido", "Número inválido"];

// initialise plugin
var iti = window.intlTelInput(input, {
  initialCountry: "auto",
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "gt";
      callback(countryCode);
    });
  },   
  utilsScript: "{{ asset('assets/js/utils.js') }}"
});

var reset = function() {
  input.classList.remove("text-danger");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('keyup', function() {
  reset();
  if (input.value.trim()) {
    if (iti.isValidNumber()) {
      input.classList.remove("text-danger");
      input.classList.add("text-success");
      $('#guardar').show();
    } else {
      input.classList.remove("text-success");
      input.classList.add("text-danger");
      var errorCode = iti.getValidationError();
      errorMsg.innerHTML = errorMap[errorCode];
      errorMsg.classList.remove("hide");
      errorMsg.classList.add("text-danger");
      $('#guardar').hide();
    }
  }
});

// on keyup / change flag: reset
input.addEventListener('keyup', reset);
input.addEventListener('change', reset);

</script>
@stop

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/intlTelInput.js') }}"></script>
<script src="{{ asset('js/quotes.js') }}"></script>