@extends('layouts.master')

@section('content')

    <!--Main Slider-->
    <section class="main-slider">
        <div class="rev_slider_wrapper fullwidthbanner-container"  id="rev_slider_one_wrapper" data-source="gallery">
            <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
                <ul>
                    <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1687" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default" data-thumb="{{ asset('template_new/images/main-slider/image-1.jpg') }}" data-title="Slide Title" data-transition="parallaxvertical">
                        <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="{{ asset('template_new/images/main-slider/image-1.jpg') }}">
                    </li>
                    
                    <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1688" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default" data-thumb="{{ asset('template_new/images/main-slider/image-2.jpg') }}" data-title="Slide Title" data-transition="parallaxvertical">
                        <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="" src="{{ asset('template_new/images/main-slider/image-2.jpg') }}">
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Main Slider-->

    <!--Car Search Form-->
    <div class="car-search-form">
        <div class="container">
            <div class="inner-section">
    <form action="{{ route('buscar.buscador_combo') }}" method="post" id="buscador">
        @csrf
        <div class="row clearfix">
            <div class="column col-lg-5 col-md-12 col-sm-12 col-xs-12">
                <div class="row clearfix">
                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select id="marca_id" name="marca_id" class="form-control js-example-basic-single">
                            <option value="">Seleccione marca</option>
                            @foreach ($marcas as $item)
                                <option value="0" disabled><strong>{{ $item->name }}</strong></option>
                                @foreach ($item->brands as $marca)
                                    <option value="{{ $marca->id }}"><b>{{ $marca->name }}</b></option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select id="linea_id" name="linea_id" class="form-control js-example-basic-single">
                            <option value="">Seleccione línea</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="column col-lg-5 col-md-12 col-sm-12 col-xs-12">
                <div class="row clearfix">
                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select name="precio_minimo" class="form-control js-example-basic-single">
                            <option value="">Seleccione el precio mínimo</option>
                            @foreach ($arra_precio_bajo as $item)
                                <option value="{{ $item['numero'] }}">{{ $item['numero_formato'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!--Form Group-->
                    <div class="form-group col-md-6">
                        <select name="precio_maximo" class="form-control js-example-basic-single">
                            <option value="">Seleccione el precio máximo</option>
                            @foreach ($arra_precio_alto as $item)
                                <option value="{{ $item['numero'] }}">{{ $item['numero_formato'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-group col-md-2">
                <button id="buscador" class="theme-btn search-btn" type="submit" name="submit-form">Buscar</button>
            </div>
        </div>
    </form>         
            </div>
        </div>
    </div>
    <!--End Car Search Form-->

    <!--Popular Cars Section Two-->
    <section class="Category-display">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title centered">
                <h2>Categorias</h2>
            </div>
            <div class="allcategory">
                <div id="categorias_paginas" class="content">
                    <div class="row clearfix">
                        @foreach ($subs as $sub)
                            <div class="body-block col-md-3 col-sm-4 col-xs-12">
                                <div class="inner-box">
                                    <a href="{{ route('categoria', ['slug' => str_replace(' ', '_', mb_strtolower($sub->name)), 'value' => base64_encode($sub->id)]) }}" class="link-box">
                                    <div class="icon-box">
                                        <img src="{{ $sub->icon ? $sub->icon : asset('template_new/images/icons/car-icons/1.png') }}" alt="{{ $sub->name }}">
                                    </div>
                                    <div class="text">{{ $sub->name }} ({{ $sub->cantidad }})</div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--Styled Pagination-->
                    {{ $subs->appends(['carros' => $carros->currentPage()])->links() }}
                    <!--End Styled Pagination-->      
                </div>
            </div>
        </div>
    </section>
    <!--End Popular Cars Section Two-->

    <!--Offer Section-->
    <section class="offer-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title light centered">
                <h2>Ofertas Especiales</h2>
            </div>
            <div class="three-item-carousel owl-carousel owl-theme">
                <!--Offer Block-->
                @foreach ($ofertas as $item)
                <div class="offer-block">
                    <div class="inner-box">
                        <div class="image">
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                                <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                            </a>
                            <div class="price">-{{ $item->porcentaje }} <span class="percent">%</span></div>
                        </div>
                        <h3>
                            <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                            {{ $item->completo }} <br> {{ $item->codigo }}
                            </a>
                        </h3>
                        <div class="lower-box">
                            <div class="plus-box">
                                <span class="icon fa fa-plus"></span>
                                <ul class="tooltip-data">
                                    <li>{{ $item->marca }}</li>
                                    <li>{{ $item->linea }}</li>
                                    <li>{{ $item->version }}</li>
                                    <li>{{ $item->estado }}</li>
                                </ul>
                            </div>
                            <div class="lower-price">{{ $item->precio }}</div>
                            <ul>
                                <li><span class="icon fa fa-road"></span>{{ number_format($item->kilometro, 0, '.', ',') }}</li>
                                <li><span class="icon fa fa-car"></span>{{ $item->combustible }}</li>
                                <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
                                <li><span class="icon fa fa-gear"></span>{{ $item->transmision }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End Offer Section-->

    <!--Popular Cars Section-->
    <section class="recent-tickets-section">
        <div class="auto-container">
            <!--Sec Title-->
        <div class="sec-title">
            <h2>Entradas Recientes</h2>
        </div>
        <!--End Sec Title-->
        <div id="carros_paginas">
            <!--Car Block-->
            @foreach($carros->chunk(4) as $bloque)
            <div class="row clearfix">
                @foreach ($bloque as $item)
                <div class="car-block col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="image">
                        <a href="{{ route('vehiculo', ['slug' => $item->slug, 'value' => base64_encode($item->codigo)]) }}">
                            <img alt="{{ $item->alt }}" style="background-blend-mode: normal; background-image: url({{ $item->image }}); background-size: 100% 100%; background-repeat: no-repeat;" src="{{ asset('img/encima_motores502.png') }}" />
                        </a>
                        <div class="price">{{ $item->oferta ? $item->oferta : $item->precio }}</div>
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
                            <li><span class="icon fa fa-clock-o"></span>{{ $item->modelo }}</li>
                            <li><span class="icon fa fa-gear"></span>{{ $item->transmision }}</li>
                        </ul>
                        </div>
                    </div>
                </div>            
                @endforeach
            </div>
            @endforeach
            
            <!--Styled Pagination-->
            {{ $carros->appends(['categorias' => $subs->currentPage()])->links() }}
            <!--End Styled Pagination-->
        </div>
        </div>
    </section>
    <!--End Popular Cars Section-->

    <!--Counter Section-->
    <section class="counter-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">

            <div class="fact-counter">
                <div class="row clearfix">

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-transport-1"></span></div>
                                    <span class="count-text" data-speed="4000" data-stop="{{ $total_carros }}">0</span>
                                </div>
                                <h4 class="counter-title">Vehículos Disponibles</h4>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-good-mood-emoticon"></span></div>
                                    <span class="count-text" data-speed="4000" data-stop="{{ $visitas }}">0</span>
                                </div>
                                <h4 class="counter-title">Visitas</h4>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-black"></span></div>
                                    <span class="count-text" data-speed="4000" data-stop="295">0</span>+
                                </div>
                                <h4 class="counter-title">Experts Reviews</h4>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column counter-column col-md-3 col-sm-6 col-xs-12">
                        <div class="inner">
                            <div class="content">
                                <div class="count-outer count-box">
                                    <div class="icon-box"><span class="icon flaticon-interface-1"></span></div>
                                    <span class="count-text" data-speed="4000" data-stop="{{ $comparaciones }}">0</span>
                                </div>
                                <h4 class="counter-title">Vehículos comparados</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <!--End Counter Section-->  
        
    <!--Choose Section-->
    <section class="choose-section" style="background-image:url({{ asset('template_new/images/background/3.jpg') }});">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title style-two">
                <h2>¿Por qué elegirnos?</h2>
            </div>
            <div class="row clearfix">
            
                <!--Services Block-->
                <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-car-washing"></span></div>
                        <h3><a href="javascript:">Para vendedores:</a></h3>
                        <div class="sub-title">Lo que ofrecemos</div>
                        <div class="text">Ofrecemos ayudarte a vender en consignación, tu auto, moto, avión, etc. ¡Cualquier medio de transporte que tenga un motor!.</div>
                        <ul>
                            <li>Toma de fotografías y vídeo</li>
                            <li>Publicación en nuestras plataformas digitales</li>
                            <li>Promoción por medio de una estrategia digital</li>
                            <li>¡Pronto pago!</li>
                        </ul>
                    </div>
                </div>
                
                <!--Services Block-->
                <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-contract"></span></div>
                        <h3><a href="javascript:">Para compradores:</a></h3>
                        <div class="sub-title">Lo que obtendrás</div>
                        <div class="text">¡Cualquier medio de transporte que tenga un motor, podemos ayudarte a conseguirlo</div>
                        <ul>
                            <li>Atención personalizada</li>
                            <li>Transparencia en la negociación</li>
                            <li>Papelería en orden</li>
                            <li>¡Precio justo!</li>
                        </ul>
                    </div>
                </div>
                
                <!--Services Block-->
                <div class="services-block-two col-md-4 col-sm-6 col-xs-12">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-telemarketer"></span></div>
                        <h3><a href="javascript:">Servicios Motores 502</a></h3>
                        <div class="sub-title">Lo que necesitarás</div>
                        <div class="text">En Motores 502 no solo te ayudamos a comprar o vender. Te ofrecemos estos servicios adicionales</div>
                        <ul>
                            <li>Traspasos electrónicos</li>
                            <li>Corretaje de seguros</li>
                            <li>Car Wash & Detailing</li>
                            <li>Asesoría en Marketing Digital</li>
                            <li>¡Todo en un solo lugar!</li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!--End Choose Section--> 
    
    <!--Client Section-->
    <section class="client-section" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
        <div class="auto-container">
            <div class="row clearfix" style="display: flex; align-items: center;">
                <!--Title Column-->
                <div class="title-column col-md-4 col-sm-12 col-xs-12">
                    <div class="sec-title light no-border">
                        <h2>¿Quienes confian en nosotros?</h2>
                    </div>
                    <div class="style-text">Contamos con socios estratégicos a nivel financiero, legal y técnico automotriz que confían en nosotros para prestar un servicio de excelencia..</div>
                </div>
                <!--Client Column-->
                <div class="client-column col-md-8 col-sm-12 col-xs-12">
                    <div class="clients-box">
                        <div class="clearfix">
                            <!--Client Box-->
                            <div class="client-box col-md-4 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('img/bancos/credomatic.png') }}" alt="Credomatic" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                            <div class="client-box col-md-4 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('img/bancos/bam.png') }}" alt="BAM" /></a>
                                </div>
                            </div>
                            
                            <!--Client Box-->
                            <div class="client-box col-md-4 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('img/bancos/gyt.png') }}" alt="G&T" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                    <div class="clients-box">
                        <div class="clearfix">

                            <!--Client Box-->
                            <div class="client-box col-md-4 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('img/bancos/bi.png') }}" alt="BI" /></a>
                                </div>
                            </div>

                            <!--Client Box-->
                            <div class="client-box col-md-4 col-sm-6 col-xs-12">
                                <div class="image">
                                    <a href="javascript:"><img src="{{ asset('img/bancos/visa.png') }}" alt="VISA" /></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Client Section-->  
        
    <!--News Section-->
    <section class="news-section">
        <div class="auto-container">
            <!--Sec Title-->
            <div class="sec-title centered">
                <h2>Nuestros blogs</h2>
            </div>
            <div class="row clearfix">
                @foreach ($blogs as $item)
                    <!--News Block-->
                    <div class="news-block col-md-4 col-sm-6 col-xs-12">
                        <div class="inner-box">
                            <div class="image">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" />
                                <a class="overlay-link" href="{{ route('blog.seleccionado', ['slug' => $item->slug, 'value' => base64_encode($item->id)]) }}"><span class="icon fa fa-link"></span></a>
                            </div>
                            <div class="lower-box">
                                <div class="post-date">{{ date('d', strtotime($item->created_at)) }} <br> {{ date('M', strtotime($item->created_at)) }}</div>
                                <div class="content">
                                    <div class="author">{{ $item->usuario }}</div>
                                    <h3><a href="{{ route('blog.seleccionado', ['slug' => $item->slug, 'value' => base64_encode($item->id)]) }}">{{ $item->name }}</a></h3>
                                    <div class="text">{{ $item->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>   
                @endforeach                 
            </div>
        </div>
    </section>
    <!--End News Section-->

@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/paginador.js') }}"></script>
@endsection