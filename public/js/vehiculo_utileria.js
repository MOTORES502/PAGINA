$(document).ready(function () {
    $('#guardar').hide()
    $('#guardar_test').hide()
    $("#calcular").click();
});

function mayus(e) {
    e.value = e.value.toUpperCase();
}

function min(e) {
    e.value = e.value.toLowerCase();
}

var input = document.querySelector("#phone"),
    errorMsg = document.querySelector("#error-msg"),
    number_test = document.querySelector("#number_test");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Número inválido", "Código de país no válido", "Cantidad de dígitos inválido", "Cantidad de dígitos inválido", "Número inválido", "Número inválido"];

// initialise plugin
var iti = window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function (callback) {
        $.get('https://ipinfo.io', function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "gt";
            callback(countryCode);
        });
    },
    utilsScript: "/assets/js/utils.js"
});
var iit_number_test = window.intlTelInput(number_test, {
    initialCountry: "auto",
    geoIpLookup: function (callback) {
        $.get('https://ipinfo.io', function () {}, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "gt";
            callback(countryCode);
        });
    },
    utilsScript: "{{ asset('assets/js/utils.js') }}"
});

var reset = function () {
    input.classList.remove("text-danger");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
};

var reset_dos = function () {

};


// on blur: validate
input.addEventListener('keyup', function () {
    reset();
    if (input.value.trim()) {
        if (iti.isValidNumber()) {
            input.classList.remove("text-danger");
            input.classList.add("text-success");
            $('#guardar').show();
        } else {
            input.classList.remove("text-success");
            input.classList.add("text-danger");
            var errorCode = iti.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
            errorMsg.classList.add("text-danger");
            $('#guardar').hide();
        }
    }
});

number_test.addEventListener('keyup', function () {
    if (number_test.value.trim()) {
        if (iit_number_test.isValidNumber()) {
            number_test.classList.remove("text-danger");
            number_test.classList.add("text-success");
            $('#guardar_test').show();
        } else {
            number_test.classList.remove("text-success");
            number_test.classList.add("text-danger");
            $('#guardar_test').hide();
        }
    }
});

// on keyup / change flag: reset
input.addEventListener('keyup', reset);
input.addEventListener('change', reset);
number_test.addEventListener('keyup', reset_dos);
number_test.addEventListener('change', reset_dos);


function getlink() {
    var aux = document.createElement("input");
    aux.setAttribute("value", window.location.href);
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);
}