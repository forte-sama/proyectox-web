<?= $template_header; ?>
<?= $template_navigation; ?>

<div class="page_container col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Turnos en el consultorio</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <div id="turno_actual" class="row">
                    <?= $info_turno_actual; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="well text-info text-center">
                        <b># Pacientes en fila, # citas pendientes</b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="lista_turnos" class="col-md-12">
                    <?= $turnos; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="hidden" id="animacion_lista_turnos">
    <div class="text-center">
        <h1>Completando accion en la fila</h1>
        <h1>
            <i class="fa fa-refresh fa-2x fa-spin"></i>
        </h1>
    </div>
</span>
<span class="hidden" id="animacion_turno_actual">
    <div class="text-center">
        <h1>Completando accion con el turno</h1>
        <h1>
            <i class="fa fa-refresh fa-2x fa-spin"></i>
        </h1>
    </div>
</span>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger" id="myModalLabel">No es posible ingresar otro paciente</h4>
            </div>
            <div class="modal-body">
                Ya hay un paciente en el consultorio.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_confirmacion_entrada" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-warning">Confirmando</h4>
            </div>
            <div class="modal-body">
                <p>Esta seguro que quiere ingresar a este paciente?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary aceptar">Ingresar Paciente</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_confirmacion_salida_fila" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-warning">Confirmando</h4>
            </div>
            <div class="modal-body">
                <p>Esta seguro que quiere sacar a este paciente de la fila?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger aceptar">Sacar Paciente</button>
            </div>
        </div>
    </div>
</div>
<?= $template_footer; ?>

<script src="/assets/js/custom_lista_turno.js"></script>
</body>
</html>
