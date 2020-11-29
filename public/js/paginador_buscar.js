$(document).on('click', '.filtrar-pagina a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var registro = $('input[type=hidden]').val();

    if (url !== undefined && url != 'javascript:') {
        $('.preloader').show()
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                search: registro
            },
            dataType: 'json',
            success: function (r) {
                $('#carros_buscados').html(r.carro)
                $('.preloader').hide()
            }
        })
    }
})
