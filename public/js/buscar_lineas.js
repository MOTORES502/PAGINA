$(document).on('change', '#marca_id', function (e) {
    var id = $(this).val();
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'lineas/' + id,
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
        var producto_select = '<option value="">Seleccione línea</option>'
        $("#linea_id").html(producto_select);
        $('.preloader').hide()
    }
})

$(document).on('change', '#marca_id_one', function (e) {
    var id = $(this).val();
    $('#icono_carro_one').show()
    $('#imagen_carro_one').hide()
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'lineas/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                var producto_select = '<option value="">Seleccione línea</option>'
                r.forEach(element => {
                    producto_select += '<option value="' + element.id + '">' + element.name + '</option>';
                });

                $("#linea_id_one").html(producto_select);
                $('.preloader').hide()
            }
        })
    } else {
        var producto_select = '<option value="">Seleccione línea</option>'
        $("#linea_id_one").html(producto_select);
        producto_select = '<option value="">Seleccione un código de vehículo</option>'
        $("#codigo_id_one").html(producto_select);
        $('.preloader').hide()
    }
})

$(document).on('change', '#marca_id_two', function (e) {
    var id = $(this).val();
    $('#icono_carro_two').show()
    $('#imagen_carro_two').hide()
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'lineas/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                var producto_select = '<option value="">Seleccione línea</option>'
                r.forEach(element => {
                    producto_select += '<option value="' + element.id + '">' + element.name + '</option>';
                });

                $("#linea_id_two").html(producto_select);
                $('.preloader').hide()
            }
        })
    } else {
        var producto_select = '<option value="">Seleccione línea</option>'
        $("#linea_id_two").html(producto_select);
        producto_select = '<option value="">Seleccione un código de vehículo</option>'
        $("#codigo_id_two").html(producto_select);
        $('.preloader').hide()
    }
})

$(document).on('change', '#linea_id_one', function (e) {
    var id = $(this).val();
    $('#icono_carro_one').show()
    $('#imagen_carro_one').hide()
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'codigos/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                var producto_select = '<option value="">Seleccione un código de vehículo</option>'
                r.forEach(element => {
                    producto_select += '<option value="' + element.id + '">' + element.name + '</option>';
                });

                $("#codigo_id_one").html(producto_select);
                $('.preloader').hide()
            }
        })
    } else {
        var producto_select = '<option value="">Seleccione un código de vehículo</option>'
        $("#codigo_id_one").html(producto_select);
        $('.preloader').hide()
    }
})

$(document).on('change', '#linea_id_two', function (e) {
    var id = $(this).val();
    $('#icono_carro_two').show()
    $('#imagen_carro_two').hide()
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'codigos/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                var producto_select = '<option value="">Seleccione un código de vehículo</option>'
                r.forEach(element => {
                    producto_select += '<option value="' + element.id + '">' + element.name + '</option>';
                });

                $("#codigo_id_two").html(producto_select);
                $('.preloader').hide()
            }
        })
    } else {
        var producto_select = '<option value="">Seleccione un código de vehículo</option>'
        $("#codigo_id_two").html(producto_select);
        $('.preloader').hide()
    }
})

$(document).on('change', '#codigo_id_one', function (e) {
    var id = $(this).val();
    $('#icono_carro_one').show()
    $('#imagen_carro_one').hide()
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'imagenes/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                if (r.image !== 'undefined') {
                    var imagen = '<img alt="' + r.concat + '" style="background-blend-mode: normal; background-image: url(' + r.image + '); background-size: 100% 100%; background-repeat: no-repeat;" src="' + r.marca + '" />'
                    $("#imagen_carro_one").html(imagen);
                    $('#icono_carro_one').hide()
                    $('#imagen_carro_one').show()
                    $('.preloader').hide()
                } else {
                    $('#icono_carro_one').show()
                    $('#imagen_carro_one').hide()
                    $('.preloader').hide()
                }
            }
        })
    } else {
        $('.preloader').hide()
    }
})

$(document).on('change', '#codigo_id_two', function (e) {
    var id = $(this).val();
    $('#icono_carro_two').show()
    $('#imagen_carro_two').hide()
    if (id) {
        $('.preloader').show()
        $.ajax({
            url: 'imagenes/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                if (r.image !== 'undefined') {
                    var imagen = '<img alt="' + r.concat + '" style="background-blend-mode: normal; background-image: url(' + r.image + '); background-size: 100% 100%; background-repeat: no-repeat;" src="' + r.marca + '" />'
                    $("#imagen_carro_two").html(imagen);
                    $('#icono_carro_two').hide()
                    $('#imagen_carro_two').show()
                    $('.preloader').hide()
                } else {
                    $('#icono_carro_two').show()
                    $('#imagen_carro_two').hide()
                    $('.preloader').hide()
                }
            }
        })
    } else {
        $('.preloader').hide()
    }
})