$("#contenedorCliente").hide();
$("#line").hide();

$("#cancelar").click(function () {
    $("#contenedorCliente").hide();
    $("#line").hide();
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