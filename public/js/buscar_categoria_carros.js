$(document).on('click', '.filtrar-pagina a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    if (url !== undefined && url != 'javascript:') {
        $('.preloader').show()
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                $('#categorias_carros').html(r)
                $('.preloader').hide()
            }
        })
    }
})