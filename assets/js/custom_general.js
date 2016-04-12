


/*=============================================================
    Authour URI: www.binarycart.com
    License: Commons Attribution 3.0

    http://creativecommons.org/licenses/by/3.0/

    100% To use For Personal And Commercial Use.
    IN EXCHANGE JUST GIVE US CREDITS AND TELL YOUR FRIENDS ABOUT US
    ========================================================  */


/*========================================================*/
///OUR CODE (TEAM-ISC) #Sii
/*========================================================*/

//Iniciando Componentes de JavaScript
$(function () {
// Inicializando jqBootstrapValidation
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
// Inicializando datepicker de formulario de registro de asistente y doctor
    $("#datepicker_doctor,#datepicker_asistente").datetimepicker({
        format: "ll",
        maxDate: new moment().format()
    });
// Inicializando datepickers en formulario de creacion de cita (fecha)
    $("#creacion_cita_fecha").datetimepicker({
        format : 'll',
        minDate: new moment().format()
    });
    $("#creacion_cita_hora").datetimepicker({
        format:  "h a",
        minDate: new moment().format()
    });
// Mostrando disponibilidad en formulario de creacion de cita
    $("#ver_disponibilidad").click(function () {
        var win = window.open('/index.php/colas/ver_disponibilidad_doctor','Disponibilidad del doctor', "width=1200, height=650");
    });

    $("#btn_ingreso_fila").click(function (e) {
        e.preventDefault();

        $("#modal_ingreso_fila").modal('show');
    });
});

/*========================================================*/
///Codigo del template
/*========================================================*/
$(function () {

    /*====================================
      LOAD APPROPRIATE MENU BAR
    ======================================*/
    $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    });
});
