//Iniciando Componentes de JavaScript
$(function () {
//obtener fechas habilitadas
    $.ajax({
        url: '../colas/fechas_con_citas/',
        type: 'get',
        success: exito_obtener_fechas,
        error: error_fechas
    });
});

function cambiar_citas_fecha() {
    var target = $("#target_fecha_value").val();

    //cambiar html a animacion
    $("#lista_citas").html($("#animacion").html());

    setTimeout(function () {
        $.post("../colas/citas_en_fecha", { target_date: target })
         .done(exito_obtener_citas);
    }, 2000);
}


function exito_obtener_citas(data) {
    var res = $.parseJSON(data);

    $("#lista_citas").html(res.resultado);
}

function exito_obtener_fechas(data) {
    var res  = $.parseJSON(data);
    lista_fechas = res.resultado;

    //hay citas en calendario (pasadas, actuales o futuras)
    if(lista_fechas.length > 0){
        //Inicializando datepicker en vista ver_cita
        $("#datepicker_lista_citas").datetimepicker({
            format: "ll",
            enabledDates: lista_fechas
        });

        $("#datepicker_lista_citas").on("dp.hide", cambiar_citas_fecha);
    }
}

function error_citas(data) {
    //logica
    $("#lista_citas").html("<div class=\"alert alert-warning\">Ha ocurrido un error con el pedido de citas en fecha seleccionada.</div>");
}

function error_fechas(data) {
    //logica
    $("#lista_citas").html("<div class=\"alert alert-warning\">Ha ocurrido un error con el pedido de fechas habiles para citas.</div>");
}
