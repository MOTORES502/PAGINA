<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="es">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}    <!--Favicon-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    
    <!-- Stylesheets -->  
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/plugins/revolution/css/layers.min.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/plugins/revolution/css/navigation.min.css') }}">

    <link rel="stylesheet" type="text/css" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/flaticon.css') }}">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/jquery.bootstrap-touchspin.css') }}">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('template_new/css/responsive.min.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('whatsapp/floating-wpp.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('select2/css/select2.min.css') }}">

    @yield('style')

    <script type="text/javascript">
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NKP4G5Q');
    </script>
</head>
<body class="msb-x">
    <div class="page-wrapper">

        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKP4G5Q"
        height="0" width="0" hidden></iframe></noscript>

        <!-- Main Header-->
        <header class="main-header">
            
            <!--Header-Upper-->
            <div class="header-upper">
                <div class="container-fluid p-0">
                    <div class="upper-inner clearfix">

                        <div class="navbar-header">
                            <div class="mnb">
                                <a href="javascript:" id="msbo">
                                    <div id="burger">
                                        <div class="gliphicon allBar topBar"></div>
                                        <div class="gliphicon allBar middleBar"></div>
                                        <div class="gliphicon allBar bottomBar"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="logo"><a href="{{ route('home') }}"><img src="{{ asset('template_new/images/logo.png') }}" alt="Motores 502" title="Motores 502"></a></div>
                        </div>

                        <div class="msb" id="msb">
                            <div class="side-menu-container">
                                <ul>
                                    <li class="panel panel-default">
                                        <a data-toggle="collapse" href="javascript:">
                                            <i class="fa fa-list"></i>Menú Motores 502<i class="fa fa-close"></i>
                                        </a>
                                    </li>

                                    @foreach ($menus as $key => $item)
                                    <li class="panel panel-default">
                                        <a data-toggle="collapse" href="{{ '#'.str_replace(" ","-",$item->name) }}">
                                            <!--<i class="fa fa-car"></i>-->{{ $item->name }} <i class="fa fa-chevron-down"></i>
                                        </a>
                                        <div id="{{ str_replace(" ","-",$item->name) }}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    <!-- Dropdown level 2 -->
                                                    <li class="panel panel-default">
                                                        <a data-toggle="collapse" href="{{ "#sub$key" }}">
                                                            <!--<i class="glyphicon glyphicon-off"></i>--> Categorías <i class="fa fa-chevron-down"></i>
                                                        </a>
                                                        <div id="{{ "sub$key" }}" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <ul class="nav navbar-nav">
                                                                    @foreach ($item->sub_categorias as $sub)
                                                                        <li>
                                                                            <a href="javascript:link_categoria('{{ str_replace(' ', '_', mb_strtolower($sub->name)) }}', '{{ base64_encode($sub->id) }}')">{{ $sub->name }}</a>
                                                                        </li>             
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!-- Dropdown level 2 -->
                                                    <li class="panel panel-default">
                                                        <a data-toggle="collapse" href="{{ "#marca$key" }}">
                                                            <!--<i class="glyphicon glyphicon-off"></i>--> Marcas <i class="fa fa-chevron-down"></i>
                                                        </a>
                                                        <div id="{{ "marca$key" }}" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <ul class="nav navbar-nav">
                                                                    @foreach ($item->brands as $sub)
                                                                        <li>
                                                                            <a href="javascript:link_marca('{{ str_replace(' ', '_', mb_strtolower($sub->name)) }}', '{{ base64_encode($sub->id) }}')">{{ $sub->name }}</a>
                                                                        </li>             
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <li class="panel panel-default">
                                        <a href="{{ route('multa.index') }}">MULTAS DE TRÁNSITO</a>
                                    </li>
                                    <li class="panel panel-default">
                                        <a href="{{ route('contacto.index') }}">CONTACTO</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="contact-on-call">
                            <ul>
                                <li><a href="tel:50266467000"><i class="fa fa-phone"></i>+502 6646-7000</a></li>
                                <li><a href="https://api.whatsapp.com/send?phone=50256914466" target="_blank"><i class="fa fa-whatsapp"></i>+502 5691-4466</a></li>
                            </ul>
                        </div>

                        <div class="search-box">
                            <form action="{{ route('buscar.personalizada') }}" method="get">
                                <form class="form-inline form-group flex-nowrap mx-0 mx-lg-auto rounded p-1" action="{{ route('buscar.personalizada') }}" method="get" role="search" autocomplete="off">
                                    <div class="form-group">
                                        <input type="search" id="search" name="search" value="{{ old('search') }}" placeholder="Buscar por marca, línea o palabra" required>
                                        <div id="registros"></div>
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </form>
                        </div>

                        <div id="google_translate_element" class="google pull-right"></div>
                    </div>
                </div>
            </div>
            <!--End Header Upper-->

            <div class="header-lower">
                <div class="container-fluid p-0">
                    <div class="lower-inner">
                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <div class="navbar-header">
                                <h4><b>Motores 502</b></h4>
                                <!-- Toggle Button -->
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix">
                                <ul class="navigation clearfix">
                                    <li class="current"><a href="{{ route('home') }}">Inicio</a></li>
                                    <li><a href="{{ route('quienes_somos.index') }}">Quienes Somos</a></li>
                                    <li><a href="{{ route('vehiculos') }}">Inventario Completo</a></li>
                                    <li><a href="{{ route('comparar.index') }}">Comparar Vehículo</a></li>
                                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                    <li><a href="{{ route('preguntas_frecuentes.index') }}">Preguntas Frecuentes</a></li>
                                    <li><a href="{{ route('multa.index') }}">Multas de Tránsito</a></li>
                                    <li><a href="{{ route('contacto.index') }}">Contacto</a></li>
                                </ul>
                            </div>
                        </nav>
                        <!-- Main Menu End-->
                    </div>
                </div>
            </div>
        
        </header>
        <!--End Main Header -->

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

        @yield('content') 


        <!--Main Footer-->
        <footer class="main-footer">
            <div class="auto-container">
                <!--Widgets Section-->
                <div class="widgets-section">
                    <div class="row clearfix">

                        <!--big column-->
                        <div class="big-column col-md-6 col-sm-12 col-xs-12">
                            <div class="row clearfix">

                                <!--Footer Column-->
                                <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                                    <div class="footer-widget about-widget">
                                        <h2>Sobre nosotros</h2>
                                        <div class="text">
                                            <p>Somos una empresa que está integrada por profesionales en mercadeo, compra y venta, con más de 15 años de experiencia.</p>
                                            <p>Buscaremos y encontraremos la mejor forma de comercializar tu motor, en base a una amplia cartera de clientes satisfechos sumado a una gran experiencia de ventas y mercadeo en todas las plataformas aplicables. </p>
                                        </div>
                                        <a href="{{ route('quienes_somos.index') }}" class="theme-btn btn-style-three">Leer sobre nosotros</a>
                                    </div>
                                </div>

                                <!--Footer Column-->
                                <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                                    <div class="footer-widget links-widget">
                                        <h2>Enlaces útiles</h2>
                                        <div class="widget-content">
                                            <ul class="footer-links">
                                                <li><a href="{{ route('quienes_somos.index') }}">Quienes Somos</a></li>
                                                <li><a href="{{ route('vehiculos') }}">Vehículos Publicados</a></li>
                                                <li><a href="{{ route('comparar.index') }}">Comparar Vehículo</a></li>
                                                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                                <li><a href="{{ route('preguntas_frecuentes.index') }}">Preguntas Frecuentes</a></li>
                                                <li><a href="{{ route('multa.index') }}">Multas de Tránsito</a></li>
                                                <li><a href="{{ route('contacto.index') }}">Contacto</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--big column-->
                        <div class="big-column col-md-6 col-sm-12 col-xs-12">
                            <div class="row clearfix">
                                <!--Footer Column-->
                                <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                                    <div class="footer-widget links-widget">
                                        <h2>Detalle de Contácto</h2>
                                        <div class="widget-content">
                                            <ul class="list-style-one">
                                                <li><span class="icon flaticon-maps-and-flags"></span>Km 13 Antigua Carretera a El Salvador Muxbal Plaza Muxbal Local M08</li>
                                                <li><span class="icon flaticon-telephone"></span>Teléfono: +(502) 6646-7000</li>
                                                <li><span class="icon flaticon-web"></span>info@motores502.com</li>
                                            </ul>
                                        </div>
                                        <h2>Siguenos</h2>
                                        <ul class="social-icon-four">
                                            @foreach ($canales as $item)
                                                <li><a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"><span class="{{ $item['icon'] }}"></span></a></li>
                                            @endforeach                                        
                                        </ul>
                                    </div>
                                </div>

                                <!--Footer Column-->
                                <div class="footer-column col-md-6 col-sm-6 col-xs-12">
                                    <div class="footer-widget offer-widget">
                                        <div class="column">
                                            <div class="hours-block">
                                                <div class="inner-box p-0">
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

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--Footer Bottom-->
            <div class="footer-bottom">
                <div class="auto-container">
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="copyright">Copyrights © 2019 Todos los derechos reservados de Motores 502.</div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--End Main Footer-->

        <div id="whatsapp"></div>
        <div id="fb-root"></div>
        
        <div 
            class="fb-customerchat"
            attribution=setup_tool
            page_id="360279197871178"
            theme_color="#0084ff"
            logged_in_greeting="¡Bienvenido al mundo de Motores 502! ¡Estamos para servirle!"
            logged_out_greeting="¡Bienvenido al mundo de Motores 502! ¡Estamos para servirle!">
        </div> 

               
    </div>
    
    <!--Scroll to top-->
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon fa fa-angle-up"></span></div> 
   
    <script type="text/javascript" src="{{ asset('template_new/js/jquery.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('template_new/js/bootstrap.min.js') }}"></script>
    
    <!--Revolution Slider-->
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/main-slider-script.js') }}"></script>
    <!--End Revolution Slider-->

    @yield('script')
    
    <script type="text/javascript" src="{{ asset('template_new/js/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/owl.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/appear.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/wow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('template_new/js/script.js') }}"></script> 
     
    <script type="text/javascript" src="{{ asset('whatsapp/floating-wpp.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/buscar_lineas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('select2/js/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
    <script type="text/javascript" src="{{ asset('js/utileria_principal.js') }}"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        lazyload();
        window.oncontextmenu = function() {
            return false;
        } 
        function googleTranslateElementInit() {
	        new google.translate.TranslateElement(
                {
                    pageLanguage: 'es', 
                    includedLanguages: 'bg,bs,ca,co,zh-CN,cs,cy,da,de,el,en,es,et,fa,fi,fr,es,fy,ga,gd,gl,he,hu,iw,is,it,ka,la,lb,lt,lv,mk,nl,no,pl,pt,ro,ru,sk,sl,sq,sr,sv,tr,uk,zh', 
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE, 
                    gaTrack: true
                }, 'google_translate_element');
        }
    </script> 
    
</body> 
</html> 