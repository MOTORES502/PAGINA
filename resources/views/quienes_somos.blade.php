@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Quienes somos</h1>
        </div>
    </section>
    <!--End Page Title-->  
    
    <!--About Section-->
    <section class="about-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title">
                <h2>Quienes somos</h2>
            </div>
            <div class="row clearfix">
                <!--Content Column-->
                <div class="content-column col-md-4 col-sm-12 col-xs-12">
                    <div class="inner-column">
                        <div class="bold-text">Somos una agencia de mercadeo enfocada en negocios motrices.</div>
                        <div class="text">Motores 502 es una empresa integrada por un equipo de profesionales dedicados a la asesoría de compra y venta de carros, motos etc. Utilizamos las mejores herramientas digitales para promover nuestros productos.</div>
                        <div class="clearfix">
                            <div class="pull-left">
                                <div class="signature">
                                    <img class="lazyload" data-src="{{ asset('template_new/images/resource/signature.png') }}" alt="FIRMA" />
                                </div>
                            </div>
                            <div class="pull-right">
                                <h3>William Shocks,</h3>
                                <span class="designation">CEO & Founder</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Blocks Column-->
                <div class="blocks-column col-md-8 col-sm-12 col-xs-12">
                    <div class="row clearfix">
                        <!--About Block-->
                        <div class="about-block col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <div class="image">
                                    <img class="lazyload" data-src="{{ asset('template_new/images/resource/about-1.jpg') }}" alt="Motores 502" />
                                </div>
                                <div class="lower-box">
                                    <h3>Nuestra misión</h3>
                                    <div class="text">
                                        Hacer que cada negocio sea una transacción justa, en el cual todas las partes involucradas estén satisfechas.
                                        <br>
                                        Buscamos que nuestros clientes terminen siendo lazos duraderos de relaciones amistosas.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--About Block-->
                        <div class="about-block col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <div class="image">
                                    <img class="lazyload" data-src="{{ asset('template_new/images/resource/about-2.jpg') }}" alt="Motores 502" />
                                </div>
                                <div class="lower-box">
                                    <h3>Nuestra visión</h3>
                                    <div class="text">Ser el portal más importante, confiable y seguro de venta de autos, motos y aviones en América Latina.</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End About Section-->
    
    <!--Advantage Section-->
    <section class="advantage-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Blocks Column-->
            	<div class="blocks-column col-lg-8 col-md-12 col-sm-12 col-xs-12">
                	<div class="sec-title light">
                    	<h2>Ventajas</h2>
                    </div>
                    <div class="row clearfix">
                    	<!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-car-search"></span>
                                </div>
                                <h3>20 años de experiencia</h3>
                                <div class="sub-title">Calidad en el servicio</div>
                                <div class="text">Amplia cartera de clientes en todas las ramas.</div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-steering-wheel"></span>
                                </div>
                                <h3>Calidad de producto</h3>
                                <div class="sub-title">Al precio justo</div>
                                <div class="text">El negocio en donde todos hacen un trato justo.</div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-networking"></span>
                                </div>
                                <h3>Ambiente agradable</h3>
                                <div class="sub-title">En confianza</div>
                                <div class="text">El equipo de Motores 502 está integrado por amigos apasionados por el tema.</div>
                            </div>
                        </div>
                        
                        <!--Services Block-->
                        <div class="services-block-three col-md-6 col-sm-6 col-xs-12">
                        	<div class="inner-box">
                            	<div class="icon-box">
                                	<span class="icon flaticon-support"></span>
                                </div>
                                <h3>Servicio al cliente</h3>
                                <div class="sub-title">Te atenderemos a la brevedad posible</div>
                                <div class="text">No dudes en contactar a tu asesor a cualquier hora, el estará responsiendo tus inquietudes a la brevedad posible.</div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!--Customer Column-->
                <div class="customer-column col-lg-4 col-md-12 col-sm-12 col-xs-12">
                	<div class="inner-box">
                    	<div class="upper-box">
                        	<div class="icon flaticon-24-hours"></div>
                            <h3>Atención al cliente</h3>
                            <div class="title">Para servicio al cliente</div>
                        </div>
                        <div class="lower-box">
                        	<div class="number">+(502) 6646-7000</div>
                            <div class="text">¿Quiere vender o comprar con nosotros? ¿Tiene alguna sugerencia? ¡Póngase en contacto cuándo lo necesite!.</div>
                            <h4>Para consultas:</h4>
                            <ul>
                            	<li><span class="theme_color">Tel:</span> +(502) 6646-7000</li>
                                <li><span class="theme_color">Email:</span> info@motores502.com</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Advantage Section-->
    
    <!--Team Section-->
    <section class="team-section">
    	<div class="auto-container">
        	<!--Sec Title-->
            <div class="sec-title centered">
            	<h2>Nuestro equipo</h2>
            </div>
            <div class="two-item-carousel owl-carousel owl-theme">
            	
                <!--Team Block-->
                @foreach ($asesores as $item)
                    <div class="team-block">
                        <div class="inner-box">
                            <div class="clearfix">
                                <div class="image-column col-md-6 col-sm-6 col-xs-12">
                                    <div class="image">
                                        <img class="lazyload" data-src="{{ $item->foto ? $item->foto : asset('template_new/images/resource/author-11.jpg') }}" alt="{{ $item->asesor }}" />
                                    </div>
                                </div>
                                <div class="content-column col-md-6 col-sm-6 col-xs-12">
                                    <div class="content-inner">
                                        <h3>{{ $item->asesor }}</h3>
                                        <ul class="list-style-three">
                                            <li><span class="icon fa fa-phone"></span>{{ $item->numero }}</li>
                                            <li><span class="icon fa fa-envelope"></span>{{ $item->email }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                @endforeach
            </div>
        </div>
    </section>
    <!--End Team Section-->
    
    <!--Client Section-->
    <section class="client-section style-two">
    	<div class="auto-container">
        	<div class="row clearfix">
                <!--Title Column-->
                <div class="title-column col-md-4 col-sm-12 col-xs-12">
                    <div class="sec-title no-border">
                        <h2>¿Quienes confian en nosotros?</h2>
                    </div>
                    <div class="style-text">Contamos con socios estratégicos a nivel financiero, legal y técnico automotriz que confían en nosotros para prestar un servicio de excelencia..</div>
                </div>
                <!--Client Column-->
                <div class="client-column col-md-8 col-sm-12 col-xs-12">
                	<div class="clients-box">
                    	<div class="clearfix">
                        
                        	<!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/credomatic.png') }}" width="175" height="125" alt="Credomatic" />
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/gyt.png') }}" width="175" height="125" alt="G&T" />
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/bi.png') }}" width="175" height="125" alt="BI" />
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/visa.png') }}" width="175" height="125" alt="VISA" />
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/brembo.png') }}" width="175" height="125" alt="BREMBO" />
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/cropped.jpg') }}" width="175" height="125" alt="CROPPED" />
                                </div>
                            </div>
                            
                            <!--Client Box-->
                        	<div class="client-box col-md-3 col-sm-6 col-xs-12">
                            	<div class="image">
                                    <img class="lazyload" data-src="{{ asset('img/proveedores/sonax.png') }}" width="175" height="125" alt="SONAX" />
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Client Section-->
@stop