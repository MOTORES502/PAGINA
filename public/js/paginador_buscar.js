$(document).on('click', '.filtrar-pagina a', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');

    var registro = $('input[type=hidden]').val();
    var categoria_select = document.getElementById("categoria");
    var categoria_seleccionada = categoria_select.selectedIndex;
    var categoria_id = categoria_select.options[categoria_seleccionada].value;

    var precio_select = document.getElementById("precio");
    var precio_seleccionada = precio_select.selectedIndex;
    var precio_id = precio_select.options[precio_seleccionada].value;

    var modelo_select = document.getElementById("modelo");
    var modelo_seleccionada = modelo_select.selectedIndex;
    var modelo_id = modelo_select.options[modelo_seleccionada].value;

    let datos = new Object;
    datos.search = registro;
    if (categoria_id != 0) {
        datos.sub_categoria = categoria_id;
    }
    if (precio_id == 'ASC' || precio_id == 'DESC') {
        datos.ordenar_precio = precio_id;
    }
    if (modelo_id == 'ASC' || modelo_id == 'DESC') {
        datos.ordenar_modelo = modelo_id;
    }

    if (url !== undefined && url != 'javascript:') {
        $('.preloader').show()
        $.ajax({
            url: url,
            type: 'GET',
            data: datos,
            dataType: 'json',
            success: function (r) {
                $('#carros_buscados').html(r.carro)
                $('.preloader').hide()
            }
        })
    }
})

$(document).on('click', '#consultar', function (e) {
    var url = window.location.href.split('?')[0];

    var registro = $('input[type=hidden]').val();
    var categoria_select = document.getElementById("categoria");
    var categoria_seleccionada = categoria_select.selectedIndex;
    var categoria_id = categoria_select.options[categoria_seleccionada].value;

    var precio_select = document.getElementById("precio");
    var precio_seleccionada = precio_select.selectedIndex;
    var precio_id = precio_select.options[precio_seleccionada].value;

    var modelo_select = document.getElementById("modelo");
    var modelo_seleccionada = modelo_select.selectedIndex;
    var modelo_id = modelo_select.options[modelo_seleccionada].value;

    let datos = new Object;
    datos.search = registro;
    if (categoria_id != 0) {
        datos.sub_categoria = categoria_id;
    }
    if (precio_id == 'ASC' || precio_id == 'DESC') {
        datos.ordenar_precio = precio_id;
    }
    if (modelo_id == 'ASC' || modelo_id == 'DESC') {
        datos.ordenar_modelo = modelo_id;
    }

    if (url !== undefined && url != 'javascript:') {
        $('.preloader').show()
        $.ajax({
            url: url,
            type: 'GET',
            data: datos,
            dataType: 'json',
            success: function (r) {
                $('#carros_buscados').html(r.carro)
                $('.preloader').hide()
            }
        })
    }
})