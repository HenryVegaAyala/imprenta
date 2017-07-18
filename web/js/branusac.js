$("#contenedorCliente").hide();
$("#line").hide();

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