<?= $template_header; ?>

<div class="page_container col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Registro de Asistente de Doctor</h2>
            <h5>Por favor llene los campos a continuación.</h5>
        </div>
        <div class="panel-body">
            <div class="row">
                <ul>
                    <?= validation_errors(); ?>
                </ul>
                <?= $form_success; ?>
            </div>
            <div class="row">
                <form action="<?= base_url('registro/asistente'); ?>" method="post">
                    <input type="hidden" name="form" value="true">
                    <div class="col-md-6">
                        <h3>Datos de Cuenta</h3>
                        <div class="control-group">
                            <label class="control-label">Nombre de usuario</label>
                            <div class="controls">
                                <input type="text"
                                class="form-control"
                                name="username"
                                value="<?= set_value("username"); ?>"
                                maxlength="40"
                                pattern="([a-z])([a-z]|[0-9]|_)*"
                                data-validation-pattern-message="Debe comenzar con letra, luego cualquier cantidad de numeros, letras, o _"
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
                        <div class="control-group">
                            <label class="control-label">Confirmar contraseña</label>
                            <div class="controls">
                                <input type="password"
                                class="form-control"
                                name="password2"
                                minlength="8"
                                maxlength="25"
                                data-validation-match-match="password"
                                data-validation-match-message="Las contraseñas no coinciden"
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Correo Electronico</label>
                            <div class="controls">
                                <input type="email"
                                class="form-control"
                                name="email"
                                value="<?= set_value("email"); ?>"
                                minlength="11"
                                maxlength="45"
                                data-validation-minlength-message="Email muy corto, intenta con otro"
                                data-validation-email-message="Formato de email no valido (usuario@ejemplo.com)"
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Doctor asociado</label>
                            <select name="doctor_cod_doctor" class="form-control">
                                <?php
                                foreach($doctores as $doctor){
                                    $item = $doctor->cod_doctor . ":&emsp;" . $doctor->username . ", " . $doctor->titulo;
                                    echo "<option value=\"" . $doctor->cod_doctor . "\">" . $item . "</option>\n";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Datos de Usuario</h3>
                        <div class="control-group">
                            <label class="control-label">Nombre/s</label>
                            <div class="controls">
                                <input type="text"
                                class="form-control"
                                name="nombre"
                                value="<?= set_value("nombre"); ?>"
                                maxlength="40"
                                pattern="([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*"
                                data-validation-pattern-message="Solo letras y espacio entre nombres"
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Apellido/s</label>
                            <div class="controls">
                                <input type="text"
                                class="form-control"
                                name="apellido"
                                value="<?= set_value("apellido"); ?>"
                                maxlength="40"
                                pattern="([a-z]|[A-Z])+(([a-z]|[A-Z])|\ )*"
                                data-validation-pattern-message="Solo letras y espacio entre apellidos"
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Telefono</label>
                            <div class="controls">
                                <input type="text"
                                class="form-control"
                                name="telefono"
                                value="<?= set_value("telefono"); ?>"
                                placeholder="809-555-8888"
                                maxlength="40"
                                pattern="(8[024]9-)(\d{3}-)\d{4}"
                                data-validation-pattern-message="Numero de telefono no valido para Rep. Dom."
                                required
                                />
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Sexo</label><br/>
                            <div class="radio-inline">
                                <label>
                                    <input type="radio" name="sexo" value="M" checked/>Masculino
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    <input type="radio" name="sexo" value="F"/Welcome/>Femenino
                                </label>
                            </div>
                        </div>
                        <br>
                        <label class="control-label">Fecha de nacimiento</label>
                        <div class="control-group">
                            <div class='input-group date' id='datepicker_asistente'>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                                <input name="fecha_nacimiento" type='text' class="form-control" onkeydown="return false" value="<?= set_value("fecha_nacimiento"); ?>" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-offset-3">
                        <br>
                        <button type="submit" class="btn btn-danger btn-block">Registrarme</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $template_footer; ?>
<!-- SCRIPTS ESPECIFICOS PARA ESTA VISTA -->

</body>
</html>
