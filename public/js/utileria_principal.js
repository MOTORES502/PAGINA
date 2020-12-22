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
        phone: '50256914466',
        popupMessage: '¿Hola, en que podemos ayudarle?',
        showPopup: true,
        showOnIE: true,
        headerTitle: 'Whatsapp - Motores 502',
        position: 'right',
        headerColor: '#545454',
        size: '60px',
        backgroundColor: '#eaeded'
    });
});

window.fbAsyncInit = function () {
    FB.init({
        xfbml: true,
        version: 'v8.0'
    });
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(document).ready(function () {
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
    $('#search').keyup(function () {
        var query = $(this).val();
        $('#registros').fadeOut();
        if (query != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/autocomplete',
                method: "POST",
                data: {
                    query: query,
                    _token: _token
                },
                success: function (data) {
                    if (data.existe) {
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

    $(document).on('click', '.dropdown-item', function () {
        $('#search').val($(this).text());
        $('#registros').fadeOut();
    });
});

function link_vehiculo(slug, value) {
    window.location.href = '/vehiculo/' + slug + '/' + value
}

function link_categoria(slug, value) {
    window.location.href = '/categoria/' + slug + '/' + value
}

function link_marca(slug, value) {
    window.location.href = '/marca/' + slug + '/' + value
}