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

        <!-- Styles -->
        <link href="{{ asset('template/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-multiselect.css') }}">
        <link href="{{ asset('card.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('footer.css') }}">
        
        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('assets/css/intlTelInput.css') }}">

        <script src="{{ asset('template/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('template/bootstrap/js/bootstrap.js') }}"></script>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        
        <script type="text/javascript" src="{{ asset('whatsapp/jquery-3.3.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('whatsapp/floating-wpp.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('whatsapp/floating-wpp.min.css') }}">

        <link rel="stylesheet" href="{{ asset('select2/css/select2.css') }}">
        <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
    </head>
    <body style="background: #eaeded;" class="text-uppercase">
        @section('sidebar')
            <div id="sidebar" class="sidebar">
                <a href="#" class="btn boton-cerrar" onclick="ocultar()"><h4>&times;</h4></a>
                <br>
                <ul id="accordion" class="accordion">
                    @foreach ($menus as $item)
                    <li>
                        <div class="link"><i class="fa fa-eye" aria-hidden="true"></i>{{ $item['nombre'] }}<i class="fa fa-chevron-down"></i></div>
                        <ul class="submenu">
                            @foreach ($item['subs'] as $sub)
                                <li><a href="{{ route('categoria', ['slug' => mb_strtolower($sub->name), 'value' => base64_encode($sub->id)]) }}">{{ $sub->name }}</a></li>             
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>

            <header>
                <nav class="navbar navbar-expand-lg navbar-dark text-center" style="background-color: #545454">
                    <a id="abrir" class="abrir-cerrar" href="javascript:void(0)" onclick="mostrar()"><i class="fa fa-bars fa-5x" aria-hidden="true"></i></a>
                    <a class="navbar-brand" href="{{ route('home') }}" style="width: 150px"
                        ><img src="{{ asset('img/logo_s_fondo_mrm.png') }}" alt="Motores502" width="75%"
                    /></a>
                    
                    <div class="flex-grow-1">
                        <form class="form-inline form-group flex-nowrap mx-0 mx-lg-auto rounded p-1" action="{{ route('buscar.personalizada') }}" method="get" role="search" autocomplete="off">
                            <input
                                style="width: 90%"
                                class="form-control mr-sm-2"
                                type="search"
                                name="search"
                                placeholder="Buscar"
                                aria-label="Search"
                                id="search"
                            />
                            <div id="registros"></div>
                            <button type="submit" class="btn btn-info">Buscar</button>
                        </form>
                    </div>
                </nav>
            </header>
        @show

        <div class="container">
            @yield('content')
        </div>

        <div id="whatsapp"></div>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h6>About</h6>
                    <p class="text-justify">Scanfcode.com <i>CODE WANTS TO BE SIMPLE </i> is an initiative  to help the upcoming programmers with the code. Scanfcode focuses on providing the most efficient code or snippets as the code wants to be simple. We will help programmers build up concepts in different programming languages that include C, C++, Java, HTML, CSS, Bootstrap, JavaScript, PHP, Android, SQL and Algorithm.</p>
                </div>

                <div class="col-xs-6 col-md-3">
                    <h6>Categories</h6>
                    <ul class="footer-links">
                    <li><a href="http://scanfcode.com/category/c-language/">C</a></li>
                    <li><a href="http://scanfcode.com/category/front-end-development/">UI Design</a></li>
                    <li><a href="http://scanfcode.com/category/back-end-development/">PHP</a></li>
                    <li><a href="http://scanfcode.com/category/java-programming-language/">Java</a></li>
                    <li><a href="http://scanfcode.com/category/android/">Android</a></li>
                    <li><a href="http://scanfcode.com/category/templates/">Templates</a></li>
                    </ul>
                </div>

                <div class="col-xs-6 col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="footer-links">
                    <li><a href="http://scanfcode.com/about/">About Us</a></li>
                    <li><a href="http://scanfcode.com/contact/">Contact Us</a></li>
                    <li><a href="http://scanfcode.com/contribute-at-scanfcode/">Contribute</a></li>
                    <li><a href="http://scanfcode.com/privacy-policy/">Privacy Policy</a></li>
                    <li><a href="http://scanfcode.com/sitemap/">Sitemap</a></li>
                    </ul>
                </div>
                </div>
                <hr>
            </div>
            <div class="container">
                <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2017 All Rights Reserved by 
                <a href="#">Scanfcode</a>.
                    </p>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <ul class="social-icons">
                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>   
                    </ul>
                </div>
                </div>
            </div>
        </footer>
    </body>    
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
                size: '75px',
                backgroundColor: '#eaeded'
            });
        });
    </script>   
    <script>
        function mostrar() {
            document.getElementById("sidebar").style.width = "350px";
            document.getElementById("abrir").style.display = "none";
            document.getElementById("cerrar").style.display = "inline";
        }

        function ocultar() {
            document.getElementById("sidebar").style.width = "0";
            document.getElementById("abrir").style.display = "inline";
            document.getElementById("cerrar").style.display = "none";
        } 

        $(function() {
            var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            var links = this.el.find('.link');

            links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
            }

            Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
            $this = $(this),
            $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
            };
            }

            var accordion = new Accordion($('#accordion'), false);
        });
        
        $(document).ready(function(){
            $('.js-example-basic-single').select2();
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