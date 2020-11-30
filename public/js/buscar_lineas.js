$(document).on('change', '#marca_id', function (e) {
    var url = $(this).val();
    console.log('llego');

    if (url) {
        $('.preloader').show()
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                var producto_select = '<option value="">Seleccione línea</option>'
                r.forEach(element => {
                    producto_select += '<option value="' + element.id + '">' + element.name + '</option>';
                });

                $("#linea_id").html(producto_select);
                $('.preloader').hide()
            }
        })
    } else {
        $('.preloader').hide()
    }
})