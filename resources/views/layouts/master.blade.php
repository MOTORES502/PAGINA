<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="es">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('template_new/css/bootstrap.css') }}">

    <link href="{{ asset('template_new/plugins/revolution/css/settings.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
    <link href="{{ asset('template_new/plugins/revolution/css/layers.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
    <link href="{{ asset('template_new/plugins/revolution/css/navigation.css') }}" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->

    <link rel="stylesheet" href="{{ asset('template_new/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template_new/css/responsive.css') }}">
    
    <!-- Extras -->
    <link rel="stylesheet" href="{{ asset('whatsapp/floating-wpp.css') }}">

    <link rel="stylesheet" href="{{ asset('select2/css/select2.css') }}">
    
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
                                                        <li><a href="{{ route('categoria', ['slug' => mb_strtolower($sub->name), 'value' => base64_encode($sub->id)]) }}">{{ $sub->name }}</a></li>             
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
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="{{ route('vehiculos') }}">Vehículos Publicados</a></li>
                                    <li><a href="vehicle-compare.html">Compare Vehicle</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="faq.html">FAQs</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                        <!-- Main Menu End-->
                    </div>
                </div>
            </div>
        
        </header>
        <!--End Main Header -->
    </div>

    @yield('content') 

    <div id="whatsapp"></div>
    
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
    <!--End Revolution Slider-->
    <script src="{{ asset('template_new/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('template_new/js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('template_new/js/jquery.fancybox-media.js') }}"></script>
    <script src="{{ asset('template_new/js/owl.js') }}"></script>
    <script src="{{ asset('template_new/js/appear.js') }}"></script>
    <script src="{{ asset('template_new/js/wow.js') }}"></script>
    <script src="{{ asset('template_new/js/main-slider-script.js') }}"></script>
    <script src="{{ asset('template_new/js/script.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('whatsapp/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('whatsapp/floating-wpp.min.js') }}"></script>
    <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
</body> 
    @yield('script')    
    <script type="text/javascript">
        $(function () {
            $('#whatsapp').floatingWhatsApp({
                phone: '50255792225',
                popupMessage: '¿Hola, en que podemos ayudarle?',
                showPopup: true,
                showOnIE: true,
                headerTitle: 'Whatsapp - Motores 502',
                position: 'right',
                autoOpenTimeout: 10000,
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
            $('.js-example-basic-multiple').select2();
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