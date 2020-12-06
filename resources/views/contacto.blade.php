@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Contacta con nosotros</h1>
        </div>
    </section>
    <!--End Page Title-->
    
    <!--Contact Form Section-->
    <section class="contact-form-section">
    	<div class="auto-container">
        	<div class="sec-title">
            	<h2>Envíanos un mensaje</h2>
                <div class="text">¿Quieres vender con nosotros? ¿Quieres comprar con nosotros? ¿Tiene alguna sugerencia? ¡Estamos para servirle! No dude en llenar el formulario que nuestro equipo de atención al cliente siempre está listo para ayudarlo a la brevedad posible.</div>
            </div>
        	
            <!--Contact Form-->
            <div class="contact-form">
                <form method="post" action="#" id="contact-form">
                    <div class="row clearfix">
                        <div class="column col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input type="text" name="username" value="{{ old('username') }}" placeholder="Ingresa tu nombre completo *" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Ingresa tu correo electrónico *" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Ingresa tu número de teléfono" required>
                            </div>
                        </div>
                        
                        <div class="column col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <textarea name="message" placeholder="Ingresa tu mensaje...">{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="column btn-column col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="theme-btn btn-style-one" type="submit" name="submit-form">Enviar consulta</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </section>
    <!--End Contact Form Section-->
    
    <!--Contact Detailed Section-->
    <section class="contact-detailed-section">
    	<div class="auto-container">
        	<!--Sec Title-->
            <div class="sec-title light centered">
            	<h2>Detalle de contactos</h2>
            </div>
            <div class="row clearfix">
            	<!--Headquater-->
                <div class="column col-md-4 col-sm-6 col-xs-12">
                	<div class="headquater-box">
                    	<div class="inner-box">
                        	<h2>Motores 502</h2>
                            <ul class="list-style-six">
                            	<li><span class="icon flaticon-maps-and-flags"></span><span class="bold">Dirección:</span>Km 13 Carretera a El Salvador Muxbal The Shops at Muxbal Guatemala, 01000 .</li>
                                <li><span class="icon flaticon-telephone"></span><span class="bold">Teléfono:</span><br>+(502) 6646-7000</li>
                                <li><span class="icon flaticon-e-mail-envelope"></span><span class="bold">Correo:</span><br>info@motores502.com</li>
                            </ul>
                            <ul class="social-icon-four">
                                @foreach ($canales as $item)
                            	    <li><a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"><span class="{{ $item['icon'] }}"></span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--Sales-->
                <div class="column col-md-4 col-sm-6 col-xs-12">
                	<!--Sales Department-->
                	<div class="sales-department">
                    	<div class="inner-box">
                        	<h2>Asesores</h2>
                            <div class="single-item-carousel owl-carousel owl-theme">
                            
                                @foreach ($asesores->chunk(2) as $bloque)
                                    <div class="slide">
                                        @foreach ($bloque as $item)
                                            <div class="department-author">
                                                <div class="inner-box">
                                                    <div class="content">
                                                        <div class="image">
                                                            <img src="{{ $item->foto ? $item->foto : asset('template_new/images/resource/author-11.jpg') }}" alt="{{ $item->asesor }}" />
                                                        </div>
                                                        <h3>{{ $item->asesor }}</h3>
                                                        <ul>
                                                            <li><span class="icon fa fa-phone"></span>{{ $item->numero }}</li>
                                                            <li><span class="icon fa fa-envelope"></span>{{ $item->email }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        @endforeach
                                    </div>
                                @endforeach
                            	<div class="slide">
                                    <div class="department-author">
                                        <div class="inner-box">
                                            <div class="content">
                                                <div class="image">
                                                    <img src="{{ asset('template_new/images/resource/author-7.jpg') }}" alt="" />
                                                </div>
                                                <h3>Charles Mecky</h3>
                                                <ul>
                                                    <li><span class="icon fa fa-phone"></span>84578-25-658</li>
                                                    <li><span class="icon fa fa-envelope"></span>Charlesmeck@gmail.com</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!--Hours-->
                <div class="column col-md-4 col-sm-12 col-xs-12">
                	<div class="hours-block">
                    	<div class="inner-box">
                        	<h2>Horario de atención en instalaciones</h2>
                            <ul>
                                @foreach ($horario as $item)
                                    <li class="clearfix">{{ $item['dia'] }}<span class="{{ $item['abierto'] ? '' : 'closed' }}">{{ $item['hora'] }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Detailed Section-->  
    
    <!--Map Section-->
    <section class="map-section">
    	<!--Map Outer-->
        <div class="map-outer">
            <iframe src="{{ $ubicacion }}" width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </section>
	<!--End Map Section-->  
@stop

@section('script')
    <!--Google Map APi Key-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHzPSV2jshbjI8fqnC_C4L08ffnj5EN3A"></script>
    <script src="{{ asset('template_new/js/gmaps.js') }}"></script>
    <script src="{{ asset('template_nnew/js/map-script.js') }}"></script>
    <!--End Google Map APi-->
@endsection