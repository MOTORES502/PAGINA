$(document).ready(function () {
    $("#marca_id").change(function () {
        var url = $(this).val();

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
    });
});
