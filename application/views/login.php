<?= $template_header; ?>

<!-- <div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="well well-lg">
<div class="row"> -->
<div class="modal fade" id="logini" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Inicio de sesion</h3>
            </div>
            <form action="<?= base_url('site/login'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="form" value="true">
                    <div class="control-group">
                        <label class="control-label">Nombre de usuario o Email</label>
                        <div class="controls">
                            <input type="text"
                            class="form-control"
                            name="login_name"
                            value="<?= set_value("login_name"); ?>"
                            maxlength="40"
                            pattern="(\w|[^ ])*"
                            data-validation-pattern-message="No deberia contener espacios"
                            required
                            />
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Contraseña</label>
                        <div class="controls">
                            <input type="password"
                            class="form-control"
                            name="password"
                            minlength="8"
                            maxlength="25"
                            data-validation-minlength-message="No debe ser tan corta (Debe ser de 8 a 25 letras)"
                            required
                            />
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="row">
                        <?= validation_errors(); ?>
                        <?= $no_user_pass; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <button type="submit" class="btn btn-danger btn-block">Iniciar sesion</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- </div>
</div>
</div>
</div> -->

<?= $template_footer; ?>

<script type="text/javascript">
$('#logini').modal({
  backdrop: 'static'
})
</script>
