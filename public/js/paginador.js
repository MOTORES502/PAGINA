$(document).on('click', '.filtrar-pagina a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    
    if (url !== undefined) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                $('#categorias_paginas').html(r.sub)
                $('#carros_paginas').html(r.carro)
            }
        })
    }
})