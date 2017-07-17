function dataCliente(id) {

    var parametros = {
        "id": id,
    };

    $.ajax({
        async: true,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        timeout: 4000,
        data: parametros,
        url: 'proforma/cliente',
        type: 'post',

        beforeSend: function () {
            $("#contenedorCliente").show();
        },

        success: function (response) {

            cadena = response.split('/');

            console.log(cadena);

            // var
            // Codigo_Cliente,
            // nombre,
            // apellido,
            // Profesion,
            // Edad,
            // Estado_Civil,
            // Distrito,
            // Direccion,
            // Telefono_Casa,
            // Telefono_Casa2,
            // Telefono_Celular,
            // Telefono_Celular2,
            // Telefono_Celular3,
            // Email,
            // Traslado,
            // Tarjeta_De_Credito,
            // Promotor,
            // Local,
            // Local,
            // dni,
            // Super_Promotor,
            // Jefe_Promotor;
            //
            // Codigo_Cliente = document.getElementById('cliente-codigo_cliente').value = cadena[0];
            // nombre = document.getElementById('cliente-nombre').value = cadena[1];
            // apellido = document.getElementById('cliente-apellido').value = cadena[2];
            // Profesion = document.getElementById('cliente-profesion').value = cadena[3];
            // Edad = document.getElementById('cliente-edad').value = cadena[4];
            // Estado_Civil = document.getElementById('cliente-estado_civil').value = cadena[5];
            // Distrito = document.getElementById('cliente-distrito').value = cadena[6];
            // Direccion = document.getElementById('cliente-direccion').value = cadena[7];
            // Telefono_Casa = document.getElementById('cliente-telefono_casa').value = cadena[8];
            // Telefono_Casa2 = document.getElementById('cliente-telefono_casa2').value = cadena[9];
            // Telefono_Celular = document.getElementById('cliente-telefono_celular').value = cadena[10];
            // Telefono_Celular2 = document.getElementById('cliente-telefono_celular2').value = cadena[11];
            // Telefono_Celular3 = document.getElementById('cliente-telefono_celular3').value = cadena[12];
            // Email = document.getElementById('cliente-email').value = cadena[13];
            // Traslado = document.getElementById('cliente-traslado').value = cadena[14];
            // Tarjeta_De_Credito = document.getElementById('cliente-tarjeta_de_credito').value = cadena[15];
            // // Promotor = document.getElementById('cliente-promotor').value = cadena[16];
            // // Local = document.getElementById('cliente-local').value = cadena[17];
            // dni = document.getElementById('cliente-dni').value = cadena[18];
            // // Super_Promotor = document.getElementById('cliente-super_promotor').value = cadena[19];
            // // Jefe_Promotor = document.getElementById('cliente-jefe_promotor').value = cadena[20];
        }
    });


}