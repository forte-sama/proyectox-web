<?= $template_header; ?>
<?= $template_navigation; ?>

<!-- /. NAV SIDE  -->
<div class="page_container col-md-7 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Creacion de Nueva Cita</h2>
            <h5>Por favor llene los campos a continuación.</h5>
        </div>
        <div class="panel-body">
            <div class="row">
                <?= $form_success;?>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <form action="<?= base_url('colas/crear_cita'); ?>" method="post">
                        <input type="hidden" name="form" value="true">
                        <div class="control-group">
                            <label class="control-label">Nombre del paciente</label>
                            <div class="controls">
                                <input type="text"
                                class="form-control"
                                name="nombre"
                                value="<?= set_value("nombre"); ?>"
                                placeholder="Juan Perez"
                                maxlength="80"
                                pattern="([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*"
                                data-validation-pattern-message="Solo letras y espacio entre nombres"
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Telefono / Documento de identidad</label>
                            <div class="controls">
                                <input type="text"
                                class="form-control"
                                name="identificador"
                                value="<?= set_value("identificador"); ?>"
                                placeholder="809-555-8888 / 402-2284587-3"
                                maxlength="20"
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Fecha Programada</label>
                            <div class="controls">
                                <div class='input-group date' id='creacion_cita_fecha'>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                    <input name="fecha" type='text' class="form-control" onkeydown="return false" required/>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hora</label>
                            <div class="controls">
                                <div class='input-group date' id='creacion_cita_hora'>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                    <input name="hora_programada" type='text' class="form-control" onkeydown="return false" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-md-offset-3">
                            <br>
                            <button type="submit" class="btn btn-danger btn-block">Programar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $template_footer; ?>

<!-- SCRIPTS ESPECIFICOS PARA ESTA VISTA -->
</body>
</html>
