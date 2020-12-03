@extends('layouts.master')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <h1>Preguntas Frecuentes</h1>
        </div>
    </section>
    <!--End Page Title-->

    
    <!--Faq Section-->
    <section class="faq-section">
    	<div class="auto-container">
        	<div class="row clearfix">
            	<!--Faq Column-->
            	<div class="faq-column col-lg-9 col-md-8 col-sm-12 col-xs-12">
                	<div class="inner-column">
                        <!--Sec Title-->
                        <div class="sec-title">
                            <h2>Preguntas & Respuestas</h2>
                        </div>
                        <div class="title-text">motores502 Auto Dealer over 20 years of experience we’ll ensured you always get the best guidance. We serves clients at every level of their organization, in whatever capacity we can be most usefull, whether seds as a trusted advisor to top consulting management or as a hands-on coach for seds front line employees.</div>
                        
                        <!--Faq Info Tabs-->
                        <div class="faq-info-tabs">
                            <!--Tabs Box-->
                            <div class="prod-tabs tabs-box">
                            
                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    @foreach ($categorias as $key => $item)
                                        <li data-tab="{{ '#'.str_replace(' ','-',$item->name) }}" class="{{ $key == 0 ? 'tab-btn active-btn' : 'tab-btn' }}">{{ $item->name }}</li>
                                    @endforeach
                                </ul>
                                
                                <!--Tabs Container-->
                                <div class="tabs-content">
                                    
                                    @foreach ($categorias as $key => $cat)
                                    <!--Tab / Active Tab-->
                                    <div class="{{ $key == 0 ? 'tab active-tab' : 'tab' }}" id="{{ str_replace(' ','-',$cat->name) }}">
                                        <div class="content">
                                            
                                            <ul class="accordion-box">
                                                <!--Block-->
                                                @foreach ($preguntas as $item) 
                                                    @if ($item->categoria_faqs_id == $cat->id)
                                                    <li class="accordion block">
                                                        <div class="acc-btn">
                                                            <div class="icon-outer">
                                                                <span class="icon icon-plus flaticon-plus"></span> 
                                                                <span class="icon icon-minus flaticon-minus"></span>
                                                            </div>
                                                            {{ $item->question }}
                                                        </div>
                                                        <div class="acc-content">
                                                            <div class="content">
                                                                <div class="text">
                                                                    <p>{!! $item->reply !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                        </div>
                        <!--End Product Info Tabs-->
                        
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
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
    <!--End Faq Section-->
@stop