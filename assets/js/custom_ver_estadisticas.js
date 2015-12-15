$("#por_dia").click(function (e) {
    $("#grafica_consulta").html($("#animacion_grafica").html());

    setTimeout(function () {
        $.post("../colas/calcular_datos_estadistica", { criterio: "dia" })
         .done(cambio_grafica);
    },2000);
});

$("#por_mes").click(function (e) {
    $("#grafica_consulta").html($("#animacion_grafica").html());

    setTimeout(function () {
        $.post("../colas/calcular_datos_estadistica", { criterio: "mes" })
         .done(cambio_grafica);
    },2000);
});

function cambio_grafica(data) {
    var respuesta = $.parseJSON(data);

    $("#grafica_consulta").html('');

    new Morris.Line(respuesta.resultado);
}
