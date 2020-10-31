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
        <link href="{{ asset('card.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('footer.css') }}">
        
        <!-- Scripts -->
        <script src="{{ asset('template/jquery/jquery.min.js') }}" defer></script>
        <script src="{{ asset('template/bootstrap/js/bootstrap.js') }}" defer></script>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <style>
            .sidebar {
                position: fixed;
                height: 100%;
                width: 0;
                top: 0;
                left: 0;
                z-index: 1;
                background-color: white;
                overflow-x: hidden;
                transition: 0.4s;
                padding: 1rem 0;
                box-sizing:border-box;
            }
            .sidebar .boton-cerrar {
                position: absolute;
                top: 0.5rem;
                right: 1rem;
                font-size: 2rem;
                display: block;
                padding: 0;
                line-height: 1.5rem;
                margin: 0;
                height: 32px;
                width: 32px;
                text-align: center;
                vertical-align: top;
            }
            .sidebar a:hover{
                color:#fff;
                background-color: #545454;
            }
            .abrir-cerrar {
                color: white;
                font-size:1rem;   
            }
            .navbar a:hover{
                color: #eaeded;
                font-size:1rem;  
            }

            #cerrar {
                display:none;
            }

            .accordion {
                width: 100%;
                max-width: 384px;
                margin: 10px auto 20px;
                color: #545454;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 0px;
                list-style: none;
            }

            .accordion .link {
                cursor: pointer;
                display: block;
                padding: 15px 15px 15px 42px;
                color: #545454;
                font-size: 12px;
                font-weight: 700;
                border-bottom: 1px solid #CCC;
                position: relative;
                -webkit-transition: all 0.4s ease;
                -o-transition: all 0.4s ease;
                transition: all 0.4s ease
            }

            .accordion li:last-child .link {
                border-bottom: 0
            }

            .accordion li i {
                position: absolute;
                top: 16px;
                left: 5px;
                font-size: 12px;
                color:  #545454;
                -webkit-transition: all 0.4s ease;
                -o-transition: all 0.4s ease;
                transition: all 0.4s ease
            }

            .accordion li i.fa-chevron-down {
                right: 12px;
                left: auto;
                font-size: 16px
            }

            .accordion li.open .link {
                color:  #545454
            }

            .accordion li.open i {
                color:  #545454
            }

            .accordion li.open i.fa-chevron-down {
                -webkit-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                -o-transform: rotate(180deg);
                transform: rotate(180deg)
            }

            .submenu {
                display: none;
                font-size: 14px;
                list-style: none;
            }

            .submenu li {
                border-bottom: 1px solid #545454
            }

            .submenu a {
                display: block;
                text-decoration: none;
                color:#545454;
                padding: 12px;
                padding-left: 10px;
                -webkit-transition: all 0.25s ease;
                -o-transition: all 0.25s ease;
                transition: all 0.25s ease
            }
            .submenu a:hover {
                background:  #545454;
                color: #FFF
            }
            .box {
                position: relative;
                max-width: 600px;
                width: 90%;
                height: 100%;
                background: #fff;
                box-shadow: 0 0 15px rgba(0,0,0,.1);
            }

            /* common */
            .ribbon {
                font-size: 9px;
                width: 160px;
                height: 160px;
                overflow: hidden;
                position: absolute;
            }
            .ribbon::before,
            .ribbon::after {
                position: absolute;
                z-index: -1;
                content: '';
                display: block;
                border: 5px soli #545454;
            }
            .ribbon span {
                position: absolute;
                display: block;
                width: 225px;
                padding: 15px 0;
                background-color: #343a40;
                box-shadow: 0 5px 10px rgba(0,0,0,.1);
                color: #fff;
                font: 700 18px/1 'Lato', sans-serif;
                text-shadow: 0 1px 1px rgba(0,0,0,.2);
                text-transform: uppercase;
                text-align: center;
            }

            .card {
                font-size: 12px;
            }

            /* top left*/
            .ribbon-top-left {
                top: -10px;
                left: -10px;
            }
            .ribbon-top-left::before,
            .ribbon-top-left::after {
                border-top-color: transparent;
                border-left-color: transparent;
            }
            .ribbon-top-left::before {
                top: 0;
                right: 0;
            }
            .ribbon-top-left::after {
                bottom: 0;
                left: 0;
            }
            .ribbon-top-left span {
                right: -25px;
                top: 30px;
                transform: rotate(-45deg);
            }

            /* top right*/
            .ribbon-top-right {
                top: -10px;
                right: -10px;
            }
            .ribbon-top-right::before,
            .ribbon-top-right::after {
                border-top-color: transparent;
                border-right-color: transparent;
            }
            .ribbon-top-right::before {
                top: 0;
                left: 0;
            }
            .ribbon-top-right::after {
                bottom: 0;
                right: 0;
            }
            .ribbon-top-right span {
                left: -25px;
                top: 30px;
                transform: rotate(45deg);
            }

            /* bottom left*/
            .ribbon-bottom-left {
                bottom: -10px;
                left: -10px;
            }
            .ribbon-bottom-left::before,
            .ribbon-bottom-left::after {
                border-bottom-color: transparent;
                border-left-color: transparent;
            }
            .ribbon-bottom-left::before {
                bottom: 0;
                right: 0;
            }
            .ribbon-bottom-left::after {
                top: 0;
                left: 0;
            }
            .ribbon-bottom-left span {
                right: -25px;
                bottom: 30px;
                transform: rotate(225deg);
            }

            /* bottom right*/
            .ribbon-bottom-right {
                bottom: -10px;
                right: -10px;
            }
            .ribbon-bottom-right::before,
            .ribbon-bottom-right::after {
                border-bottom-color: transparent;
                border-right-color: transparent;
            }
            .ribbon-bottom-right::before {
                bottom: 0;
                left: 0;
            }
            .ribbon-bottom-right::after {
                top: 0;
                right: 0;
            }
            .ribbon-bottom-right span {
                left: -25px;
                bottom: 30px;
                transform: rotate(-225deg);
            }
            .modal button.close {
                right: 0;
                outline: 0;
            }
            
            #gallery-lightbox img {
                height: 100%;
                object-fit: cover;
                cursor: pointer;
            }
            #gallery-lightbox img:hover {
                opacity: 0.9;
                transition: 0.5s ease-out;
            }
        </style>
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
                        <form class="form-inline flex-nowrap mx-0 mx-lg-auto rounded p-1">
                        <input
                            style="width: 90%"
                            class="form-control mr-sm-2"
                            type="search"
                            placeholder="Buscar"
                            aria-label="Search"
                        />
                        <button class="btn btn-primary" type="submit">Buscar</button>
                        </form>
                    </div>
                </nav>
            </header>
        @show

        <div class="container">
            @yield('content')
        </div>

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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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
    </script>
</html>