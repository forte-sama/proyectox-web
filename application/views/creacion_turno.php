<?= $template_header; ?>
<?= $template_navigation; ?>

<div class="page_container col-md-6 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Ingreso de Nuevo Paciente a la cola</h2>
            <h5>Por favor llene los campos a continuación.</h5>
        </div>
        <div class="panel-body">
            <div class="row">
                <ul class="text-danger">
                    <?= validation_errors(); ?>
                </ul>
                <?= $form_success; ?>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <form action="<?= base_url('colas/crear_turno'); ?>" method="post">
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
                        <div class="col-md-6 col-md-offset-3">
                            <br>
                            <button type="submit" class="btn btn-danger btn-block">Entrar a la cola</button>
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
