//Iniciando Componentes de JavaScript
$(function () {
    attach_event();
});

function attach_event() {
    $("button.cambio_estado").click(function (e) {
        e.preventDefault();

        var turno = $(this).attr('num_turno');

        $("#lista_turnos").html($("#animacion").html());

        setTimeout(function () {
            $.post("../colas/cambio_estado_turno_cita", { numero_turno: turno })
             .done(exito_cambio_estado);
        },2000);
    });

    $("a.badge").click(function (e) {
        e.preventDefault();
    });
}

function exito_cambio_estado(data) {
    var respuesta = $.parseJSON(data);

    if(respuesta.estado == 'exito') {
        $("#lista_turnos").html(respuesta.resultado);
        attach_event();
    }
}
