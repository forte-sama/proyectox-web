<?= $template_header; ?>
<?= $template_navigation; ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
      <div class="row">
          <div class="col-md-12">
              <h2>Programación de Cita</h2>
              <h5>Por favor llene los campos a continuación.</h5>
          </div>
      </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12 ">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Nuevo turno para la cola
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <ul>
                                <?= validation_errors(); ?>
                            </ul>
                            <?= $form_success; ?>
                        </div>
                        <div class="row">
                            <form action="<?= base_url('colas/crear_turno'); ?>" method="post">
                                <input type="hidden" name="form" value="true">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="control-group">
                                        <label class="control-label">Telefono</label>
                                        <div class="controls">
                                            <input type="text"
                                            class="form-control"
                                            name="telefono"
                                            placeholder="809-555-8888"
                                            maxlength="40"
                                            pattern="(8[024]9-)(\d{3}-)\d{4}"
                                            data-validation-pattern-message="Numero de telefono no valido para Rep. Dom."
                                            required
                                            />
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-md-offset-4">
                                        <br>
                                        <button type="submit" class="btn btn-danger btn-block">Programar Cita</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $template_footer; ?>

<!-- SCRIPTS ESPECIFICOS PARA ESTA VISTA -->
</body>
</html>
