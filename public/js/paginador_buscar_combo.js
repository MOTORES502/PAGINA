$(document).on('click', '.filtrar-pagina a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var marca_id = $("input[name=marca_idc]").val();
    var linea_id = $("input[name=linea_idc]").val();
    var precio_minimo = $("input[name=precio_minimoc]").val();
    var precio_maximo = $("input[name=precio_maximoc]").val();
    let _token = $('meta[name="csrf-token"]').attr('content');

    if (url !== undefined && url != 'javascript:') {
        $('.preloader').show()
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                marca_id: marca_id,
                linea_id: linea_id,
                precio_minimo: precio_minimo,
                precio_maximo: precio_maximo,
                _token: _token
            },
            dataType: 'json',
            success: function (r) {
                $('#carros_buscados').html(r.carro)
                $('.preloader').hide()
            }
        })
    }
})
