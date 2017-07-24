$("#contenedorCliente").hide();
$("#line").hide();
$("#validateProforma").hide();

$("#proforma-monto_subtotal").prop("readonly", true);
$("#proforma-monto_igv").prop("readonly", true);
$("#proforma-monto_total").prop("readonly", true);

$("#cancelar").click(function () {
    $("#contenedorCliente").hide();
    $("#line").hide();
});

$(document).on('click', '.remove-item', function () {
    var array_unidad;
    array_unidad = document.getElementsByName("cantidad[]");
    if (array_unidad.length === 0) {
        document.getElementById("proforma-monto_subtotal").value = '0.00';
        document.getElementById("proforma-monto_igv").value = '0.00';
        document.getElementById("proforma-monto_total").value = '0.00';
    } else {
        calcular();
    }
});

function dataCliente(id) {

    (id === '' || id === null) ? $("#contenedorCliente").hide() : $("#contenedorCliente").show();
    var parametros, cadena;
    parametros = {"id": id};

    $.ajax({
        async: true,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        timeout: 4000,
        data: parametros,
        url: 'proforma/cliente',
        type: 'post',

        beforeSend: function () {
            $("#line").show();
            $("#nameCompany").attr('disabled', true);
            $("#ruc").attr('disabled', true);
            $("#businessName").attr('disabled', true);
            $("#fiscalAddress").attr('disabled', true);
        },

        success: function (response) {
            cadena = response.split('/');
            document.getElementById('nameCompany').value = cadena[0];
            document.getElementById('ruc').value = cadena[1];
            document.getElementById('businessName').value = cadena[2];
            document.getElementById('fiscalAddress').value = cadena[3];
        }
    });
}

function formatDecimal(digito) {
    var numer, resultado;
    numer = parseFloat(digito);
    resultado = Math.round(numer * 100) / 100;
    return resultado === 0 ? '0.00' : resultado;
}

function validateNan(valor) {
    if (isNaN(valor)) {
        return '0.00';
    } else if (valor === '') {
        return '0.00';
    } else if (valor === null) {
        return '0.00';
    } else if (valor === '0') {
        return '0.00';
    } else {
        return valor;
    }
}

function calcular() {
    var array_unidad, array_precio, array_total, cantidad, precio, total;

    array_unidad = document.getElementsByName("cantidad[]");
    array_precio = document.getElementsByName("precio[]");
    array_total = document.getElementsByName("total[]");

    for (var i = 0; i < array_unidad.length; i++) {
        cantidad = parseFloat(array_unidad[i].value, 2);
        precio = parseFloat(array_precio[i].value, 2);
        total = parseFloat((precio * cantidad), 2);
        array_total[i].value = validateNan(formatDecimal(total));
    }

    sumaSubTotal = eval(0);
    for (var x = 0; x < array_total.length; x++) {
        sumaSubTotal = parseFloat(sumaSubTotal, 2) + parseFloat(array_total[x].value, 2);
    }
    igv = parseFloat(parseFloat(sumaSubTotal, 2) * parseFloat(0.18, 2), 2);
    subtotal = parseFloat(sumaSubTotal - igv, 2);
    total = parseFloat(sumaSubTotal, 2) + parseFloat(igv, 2);

    document.getElementById("proforma-monto_subtotal").value = formatDecimal(subtotal);
    document.getElementById("proforma-monto_igv").value = formatDecimal(igv);
    document.getElementById("proforma-monto_total").value = formatDecimal(sumaSubTotal)
}

function stopRKey(evt) {
    var node;
    evt = (evt) ? evt : ((event) ? event : null);
    node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    if ((evt.keyCode === 13) && (node.type === "text")) {
        return false;
    }
}

document.onkeypress = stopRKey;

function addField(evt) {
    var evt, AddButton;
    evt = (evt) ? evt : ((event) ? event : null);
    if (evt.keyCode === 13) {
        AddButton = $("#addItem");
        AddButton.click();
    }
}

function validateProforma(proforma) {

    var parametros = {"proforma": proforma};
    var resultado =
        '<div class="x_content bs-example-popovers">' +
        '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">×</span> </button>' +
        '<strong>La Proforma N° ' + proforma + '</strong> ya se encuentra registrado en el sistema.</div>' +
        '</div>';

    $.ajax({
        async: true,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        timeout: 4000,
        data: parametros,
        url: 'proforma/serie',
        type: 'post',

        beforeSend: function () {
            $("#btnGuardarProforma").attr('disabled', false);
        },

        success: function (response) {
            if (response === '' || response === null) {
                $("#validateProforma").hide();
            } else {
                $("#validateProforma").show();
                $("#validateProforma").html(resultado);
                $("#btnGuardarProforma").attr('disabled', true);
            }
        }
    });
}

function inactiveProforma() {
    var id = document.getElementById("proforma-num_proforma").value;
    (id === '' || id === null) ? $("#validateProforma").hide() : $("#validateProforma").hide();
    $("#btnGuardarProforma").attr('disabled', false);
}