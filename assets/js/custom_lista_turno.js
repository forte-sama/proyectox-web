//Iniciando Componentes de JavaScript
$(function () {
    cambio_lista_turnos();
    cambio_turno_actual();

    asignar_acciones_confirmacion();
});

function asignar_acciones_confirmacion() {
    /*== BOTON ENTRADA CONSULTA ==*/
    //ventana confirmacion de ingreso
    var ventana_conf_entrada = $("#modal_confirmacion_entrada");

    //boton de confirmar ingreso
    var btn_entrada = ventana_conf_entrada.find(".aceptar");

    //inicio de llamada ajax
    btn_entrada.click(function (e) {
        ventana_conf_entrada.modal('hide');

        $("#turno_actual").html($("#animacion_turno_actual").html());

        setTimeout(function () {
            $.post("../colas/entrada_consulta", { numero_turno: btn_entrada.attr('num_turno') })
             .done(exito_entrada_paciente);
        },2000);
    });

    /*== BOTON SALIDA FILA ==*/
    //ventana confirmacion salida de fila
    var ventana_conf_salida = $("#modal_confirmacion_salida_fila");

    //boton confirmacion de salida de fila
    var btn_salida = ventana_conf_salida.find(".aceptar");

    //inicio de llamada ajax
    btn_salida.click(function (e) {
        ventana_conf_salida.modal('hide');

        $("#lista_turnos").html($("#animacion_lista_turnos").html());

        setTimeout(function () {
            $.post("../colas/salida_fila", { numero_turno: btn_salida.attr("num_turno") })
             .done(exito_cambio_estado_fila);
        },2000);
    });
}

function cambio_lista_turnos() {
    //boton de cambio de estado de cita
    $("button.cambio_estado").click(function (e) {
        var turno = $(this).attr('num_turno');

        $("#lista_turnos").html($("#animacion_lista_turnos").html());

        setTimeout(function () {
            $.post("../colas/cambio_estado_turno_cita", { numero_turno: turno })
             .done(exito_cambio_estado_fila);
        },2000);
    });
    //boton de salida de fila
    $("button.btn_salida_fila").click(function (e) {
        var turno = $(this).attr('num_turno');

        //mostrar confirmacion de ingreso
        var ventana_conf = $("#modal_confirmacion_salida_fila");
        ventana_conf.find(".aceptar").attr('num_turno',turno);
        ventana_conf.modal('show');
    });
    //boton de salida de fila
    $("button.btn_entrada_consulta").click(function (e) {
        //valor del turno que se desea ingresar
        var turno = $(this).attr('num_turno');

        //mostrar confirmacion de ingreso
        var ventana_conf = $("#modal_confirmacion_entrada");
        ventana_conf.find(".aceptar").attr('num_turno',turno);
        ventana_conf.modal('show');
    });
}

function cambio_turno_actual() {
    $("button#btn_salir_consulta").click(function (e) {
        var turno = $(this).attr('num_turno');

        $("#turno_actual").html($("#animacion_turno_actual").html());

        setTimeout(function () {
            $.post("../colas/salida_consulta", { numero_turno: turno })
             .done(exito_salida_consulta);
        },2000);
    });
}

function exito_cambio_estado_fila(data) {
    var respuesta = $.parseJSON(data);

    if(respuesta.estado == 'exito') {
        $("#lista_turnos").html(respuesta.resultado);
    }

    cambio_lista_turnos();
}

function exito_entrada_paciente(data) {
    var respuesta = $.parseJSON(data);

    if(respuesta.estado == 'exito') {
        //success
    }
    else if(respuesta.estado == 'fallo'){
        //fail
        $("#myModal").modal('show');

        setTimeout(function () {
            $("#myModal").modal('hide');
        },4500);
    }

    $("#turno_actual").html(respuesta.resultado_turno_actual);
    $("#lista_turnos").html(respuesta.resultado_fila);

    cambio_turno_actual();
    cambio_lista_turnos();
}

function exito_salida_consulta(data) {
    var respuesta = $.parseJSON(data);

    if(respuesta.estado == 'exito') {
        $("#turno_actual").html(respuesta.resultado);
    }

    cambio_turno_actual();
}
