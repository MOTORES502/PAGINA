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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('template_new/css/bootstrap.css') }}">

    <link href="{{ asset('template_new/plugins/revolution/css/settings.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
    <link href="{{ asset('template_new/plugins/revolution/css/layers.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
    <link href="{{ asset('template_new/plugins/revolution/css/navigation.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->

    <link rel="stylesheet" href="{{ asset('template_new/css/jquery.datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('template_new/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template_new/css/responsive.css') }}">
    
    <!-- Extras -->
    <link rel="stylesheet" href="{{ asset('whatsapp/floating-wpp.css') }}">
    <link rel="stylesheet" href="{{ asset('select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}"> 
</head>
<body class="msb-x">
    <div class="page-wrapper">
        <div class="preloader"></div>

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
                                            <i class="fa fa-list"></i>Categorias<i class="fa fa-close"></i>
                                        </a>
                                    </li>

                                    @foreach ($menus as $item)
                                    <li class="panel panel-default">
                                        <a data-toggle="collapse" href="{{ '#'.str_replace(" ","-",$item['nombre']) }}">
                                            <i class="fa fa-car"></i>{{ $item['nombre'] }} <i class="fa fa-chevron-down"></i>
                                        </a>
                                        <div id="{{ str_replace(" ","-",$item['nombre']) }}" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <ul class="nav navbar-nav">
                                                    @foreach ($item['subs'] as $sub)
                                                        <li><a href="{{ route('categoria', ['slug' => str_replace(' ', '_', mb_strtolower($sub->name)), 'value' => base64_encode($sub->id)]) }}">{{ $sub->name }}</a></li>             
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="contact-on-call">
                            <ul>
                                <li><a href="tel:50255792225"><i class="fa fa-phone"></i>+502 5579-2225</a></li>
                                <li><a href="https://api.whatsapp.com/send?phone=50255792225" target="_blank"><i class="fa fa-whatsapp"></i>+502 5579-2225</a></li>
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
                                    <li><a href="{{ route('vehiculos') }}">Vehículos Publicados</a></li>
                                    <li><a href="{{ route('comparar.index') }}">Comparar Vehículo</a></li>
                                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                    <li><a href="{{ route('preguntas_frecuentes.index') }}">Preguntas Frecuentes</a></li>
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
        <footer class="main-footer" style="background-image:url({{ asset('template_new/images/background/1.jpg') }});">
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
                                            <p>Somos una empresa que está integrada por profesionales en mercadeo, compra y ventas, con más de 15 años de experiencia.</p>
                                            <p>Buscaremos y encontraremos la mejor forma de comercializar tu motor, en base a una amplia cartera de clientes satisfechos y una gran experiencia de ventas y mercadeo en todas las plataformas aplicables. </p>
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
                                        <h2>Contact Details</h2>
                                        <div class="widget-content">
                                            <ul class="list-style-one">
                                                <li><span class="icon flaticon-maps-and-flags"></span>Km 13 Carretera a El Salvador Muxbal The Shops at Muxbal Guatemala, 01000</li>
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
                            <div class="copyright">Copyrights © 2020 Todos los derechos reservados de Motores502.</div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--End Main Footer-->

        <div id="whatsapp"></div>
               
    </div>
    
    <!--Scroll to top-->
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="icon fa fa-angle-up"></span></div> 
   
    <script src="{{ asset('template_new/js/jquery.js') }}"></script> 
    <script src="{{ asset('template_new/js/bootstrap.min.js') }}"></script>
    
    <!--Revolution Slider-->
    <script src="{{ asset('template_new/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('template_new/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <script src="{{ asset('template_new/js/main-slider-script.js') }}"></script>
    <!--End Revolution Slider-->
    <script src="{{ asset('template_new/js/jquery.datetimepicker.js') }}"></script>
    <script src="{{ asset('template_new/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('template_new/js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('template_new/js/jquery.fancybox-media.js') }}"></script>
    <script src="{{ asset('template_new/js/owl.js') }}"></script>
    <script src="{{ asset('template_new/js/appear.js') }}"></script>
    <script src="{{ asset('template_new/js/wow.js') }}"></script>
    <script src="{{ asset('template_new/js/main-slider-script.js') }}"></script>
    <script src="{{ asset('template_new/js/validate.js') }}"></script>
    <script src="{{ asset('template_new/js/script.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('whatsapp/floating-wpp.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/buscar_lineas.js') }}"></script>
    <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
</body>
    @yield('script')    
    <script type="text/javascript">
        $(function () {		
            $('.js-example-basic-single').select2({
                theme: "classic",
                width: 'resolve'
            });
            $('.js-example-basic-multiple').select2({
                theme: "classic",
                width: 'resolve'
            });
            $('#whatsapp').floatingWhatsApp({
                phone: '50255792225',
                popupMessage: '¿Hola, en que podemos ayudarle?',
                showPopup: true,
                showOnIE: true,
                headerTitle: 'Whatsapp - Motores 502',
                position: 'right',
                headerColor: '#545454',
                size: '50px',
                backgroundColor: '#eaeded'
            });
        });
    </script>   
    <script>        
        $(document).ready(function(){	
            $('.js-example-basic-single').select2({
                theme: "classic",
                width: 'resolve'
            });
            $('.js-example-basic-multiple').select2({
                theme: "classic",
                width: 'resolve'
            });
            $('#icono_carro_one').show()
            $('#imagen_carro_one').hide()
            $('#icono_carro_two').show()
            $('#imagen_carro_two').hide()
            $('#search').keyup(function(){ 
                var query = $(this).val();
                $('#registros').fadeOut(); 
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('autocomplete.ocurrencia') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if(data.existe) {
                                $('#registros').fadeIn();  
                                $('#registros').html(data.data);
                            } else {
                                $('#registros').fadeOut(); 
                            }
                        }
                    });
                } else {  
                    $('#registros').fadeOut(); 
                }
            });

            $(document).on('click', '.dropdown-item', function(){  
                $('#search').val($(this).text());  
                $('#registros').fadeOut();  
            });
        });
    </script>
</html> 