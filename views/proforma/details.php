<script language="javascript" type="text/javascript">

    function stopRKey(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type == "text")) {

            return false;
        }
    }
    document.onkeypress = stopRKey;

    function jsAgregar(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        if (evt.keyCode == 13) {
            //alert ('Has pulsado enter');
            var AddButton = $("#agregarCampo");
            //alert ('Has pulsado enter '+AddButton);
            AddButton.click();
        }
    }
</script>


<html>
<div style="margin-top: 2%"></div>
<button type="button" id="agregarCampo" class='btn btn-success btn-sm addmore'><a
            class="fa fa-plus fa-lg"
            style="color: white;"></a> Agregar
    Productos
</button>
<button type="button" class='btn btn-danger btn-sm delete' onclick="jsCalcular()">
    <a class="fa fa-close fa-lg" style="color: white;" onclick="jsCalcular()"></a>
    Eliminar
</button>
<br><br>

<table class="table table-bordered table-condensed table-responsive table-striped table-hover table-wrapper"
       id="tableP">
    <tr>
        <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
        <th>N°</th>
        <th>Descripción</th>
        <th>Codigo</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
    </tr>

</table>
<br>

</html>

<script>

    var valor;

    function redondear2decimales(numero) {
        var original = parseFloat(numero);
        var result = Math.round(original * 100) / 100;
        return result;
    }

    function NumCheck(e, field) {
        jsAgregar(e);
        key = e.keyCode ? e.keyCode : e.which
        // backspace
        if (key == 8) return true
        // 0-9
        if (key > 47 && key < 58) {
            if (field.value == "") return true
            regexp = /.[0-9]{2}$/
            return !(regexp.test(field.value))
        }
        // .
        if (key == 46) {
            if (field.value == "") return false
            regexp = /^[0-9]+$/
            return regexp.test(field.value)
        }
        // other key
        return false

    }

    function totalNaN(valor) {
        if (isNaN(valor)) {
            return '0.00';
        } else if (valor == '') {
            return '0.00';
        } else if (valor == null) {
            return '0.00';
        } else if (valor == '0.00') {
            return '0.00';
        } else if (valor === '0.00') {
            return '0.00';
        } else {
            return valor;
        }
    }

    function validadorNaN(Subtotal, Monto) {
        var totales;
        totales = Subtotal + Monto;
        if (isNaN(totales)) {
            return '0.00';
        } else if (valor == '') {
            return '0.00';
        } else if (valor == null) {
            return '0.00';
        } else if (valor == '0.00') {
            return '0.00';
        } else if (valor === '0.00') {
            return '0.00';
        } else {
            return totales;
        }
    }

    var total = document.getElementsByName("VAL_MONT_UNID[]").value;
    totalNaN(total);

    var total = document.getElementsByName("NRO_UNID[]").value;
    totalNaN(total);


    function jsCalcular() {

        var arr_uni = document.getElementsByName("NRO_UNID[]");
        var arr_pre = document.getElementsByName("VAL_PREC[]");
        var arr_total = document.getElementsByName("VAL_MONT_UNID[]");
        for (var x = 0; x < arr_uni.length; x++) {

            cantidad = parseFloat(arr_uni[x].value, 2);
            precunit = parseFloat(arr_pre[x].value, 2);
            totalitem = parseFloat((precunit * cantidad), 2);
            arr_total[x].value = totalNaN(redondear2decimales(totalitem));
        }

        sumaSubTotal = eval(0);
        for (var x = 0; x < arr_total.length; x++) {
            sumaSubTotal = parseFloat(sumaSubTotal, 2) + parseFloat(arr_total[x].value, 2);
        }
        montoIGV = parseFloat(parseFloat(sumaSubTotal, 2) * parseFloat(eval(18), 2), 2);
        total = parseFloat(sumaSubTotal, 2) + parseFloat(montoIGV, 2);

        document.getElementById("OC_TOT_MONT_ORDE").value = redondear2decimales(sumaSubTotal);
        document.getElementById("OC_TOT_MONT_IGV").value = redondear2decimales(montoIGV);
        document.getElementById("OC_TOT_FACT").value = redondear2decimales(total);
    }

    $(".delete").on('click', function () {
        $('.case:checkbox:checked').parents("tr").remove();
        $('.check_all').prop("checked", false);
//        check();
        jsCalcular();
    });
    var i = $('#tableP tr').length;
    $(".addmore").on('click', function () {

        //debe validar que no se ingrese registros duplicados
        var x = document.getElementsByName("COD_PROD[]");
        primeraFila = 0;
        ultimaFila = x.length - 1;
        //i=x.length+1;
        //Calucalr Total/Subotal/IGV


        for (k = 0; k <= ultimaFila; k++) {
            cod = x[k].value;
            for (j = k + 1; j <= ultimaFila; j++) {
                cod2 = x[j].value;
                // alert(cod + ' - '+cod2);
                if (cod === cod2) {
                    alert("Existen 2 codigos de productos duplicados o espacios blanco, por favor revisar");
                    return;
                }
            }
        }

        count = $('#tableP tr').length;
        //alert(count);
        var data = "<tr><td><input type='checkbox' class='case'/></td><td><span id='snum" + i + "'>" + count + "</span></td>";
        data += '\n\\n\
                                <td>\n\
                                    <input type="text" id="DES_LARG_' + i + '" name="DES_LARG[]" size="45" class="form-control input-sm " />\n\
                                </td> \n\
                                <td>\n\
                                    <input type="text" id="COD_PROD_' + i + '" name="COD_PROD[]" size="10" class="form-control input-sm " readonly="true" value="0.00"/>\n\
                                </td>\n\
                                <td>\n\
                                    <input type="text" id="NRO_UNID_' + i + '" name="NRO_UNID[]" size="10" class="form-control input-sm  " onchange="jsCalcular()"  onkeyup="jsCalcular();" onkeypress="return NumCheck(event, this);" value="0.00" />\n\
                                </td>   \n\
                                <td>\n\
                                    <input type="text" id="VAL_PREC_' + i + '" name="VAL_PREC[]" size="10" class="form-control input-sm " onchange="jsCalcular()"  onkeyup="jsCalcular();" onkeypress="return NumCheck(event, this);" value="0.00" />\n\
                                </td>\n\
                                <td>\n\
                                    <input type="text" id="campo_VAL_MONT_UNID' + i + '" name="VAL_MONT_UNID[]" size="10" class="form-control input-sm " readonly="true" value="0.00"/>\n\
                                </td>\n\
                                </tr>';
        $('#tableP').append(data);

        crearFunciones(i);
        $('#DES_LARG_' + i).focus();
        i++;
    });

    function select_all() {
        $('input[class=case]:checkbox').each(function () {
            if ($('input[class=check_all]:checkbox:checked').length == 0) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }
        });
    }

    function crearFunciones(i) {
        //  for(i=0; i< fila;i++){
        //alert('crearFunciones '+i);
        psclient = document.getElementById('OC_COD_CLIE').value;
        pstienda = document.getElementById('OC_COD_TIEN').value;
        row = i;
        $('#DES_LARG_' + i).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'ajax.php',
                    dataType: "json",
                    data: {
                        nombre_producto: request.term,
                        type: 'produc_tiend',
                        clie: psclient,
                        tienda: pstienda,
                        row_num: i
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            //alert(item)
                            var code = item.split("|");
                            return {
                                label: code[0],
                                value: code[0],
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var names = ui.item.data.split("|");
//                console.log(names[1], names[2], names[3]);
                cad = names[1];
                if (cad !== '') {
                    $('#COD_PROD_' + i).val(names[1]);
                    $('#NRO_UNID_' + i).val(names[2]);
                    $('#VAL_PREC_' + i).val(names[3]);

                    $('#NRO_UNID_' + i).prop('readonly', false);
                    $('#VAL_PREC_' + i).prop('readonly', false);
                    $('#NRO_UNID_' + i).focus();
                } else {
                    $('#COD_PROD_' + i).prop('readonly', true);
                    $('#NRO_UNID_' + i).prop('readonly', true);
                    $('#VAL_PREC_' + i).prop('readonly', true);

                }
            }
        });
    }
</script>