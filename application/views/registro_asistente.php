
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Registro</h2>
                <h5>Por favor llene los campos a continuación.</h5>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Registro
                    </div>
                    <div class="panel-body">
                        <div class="row">
<<<<<<< HEAD
                            <form>
                                <div class="col-md-6">
                                    <h3>Datos de Cuenta</h3>
=======
                            <div class="col-md-6">
                                <h3>Datos de Cuenta</h3>
                                <form role="form">
>>>>>>> T#39 Cambiar plantilla de registro para reflejar datos que contiene un doctor
                                    <div class="form-group">
                                        <label>Nombre de Usuario</label>
                                        <input class="form-control" placeholder="ejemplo789" />
                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" class="form-control" placeholder="******" />
                                    </div>
                                    <div class="form-group">
                                        <label>Correo Electronico</label>
                                        <input class="form-control" placeholder="correo@ejemplo.com" />
                                    </div>
                                    <div class="form-group">
                                        <label>Telefono</label>
                                        <input class="form-control" placeholder="809-222-2222" />
                                    </div>
                                    <div class="form-group">
                                        <label>Doctor asociado</label>
                                        <select class="form-control">
                                            <?php
                                            foreach($doctores as $doctor){
<<<<<<< HEAD
                                                $item = $doctor->cod_doctor . ":&emsp;" . $doctor->username . ", " . $doctor->titulo;
=======
                                                $item = $doctor->cod_doctor . ":&emsp;" . $doctor->username;
>>>>>>> T#39 Cambiar plantilla de registro para reflejar datos que contiene un doctor
                                                echo "<option value=\"" . $doctor->cod_doctor . "\">" . $item . "</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
<<<<<<< HEAD
                                </div>

                                <div class="col-md-6">
                                    <h3>Datos de Usuario</h3>
=======
                                </form>
                            </div>

                            <div class="col-md-6">
                                <h3>Datos de Usuario</h3>
                                <form role="form">
>>>>>>> T#39 Cambiar plantilla de registro para reflejar datos que contiene un doctor
                                    <div class="form-group">
                                        <label>Nombre/s</label>
                                        <input class="form-control" />
                                    </div>
                                    <div class="form-group">
<<<<<<< HEAD
                                        <label>Apellido/s</label>
=======
                                        <label>Apellidos</label>
>>>>>>> T#39 Cambiar plantilla de registro para reflejar datos que contiene un doctor
                                        <input class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Telefono</label>
                                        <input class="form-control" placeholder="809-222-2222" />
                                    </div>
                                    <label>Sexo</label>
                                    <div class="form-group">
<<<<<<< HEAD
=======

>>>>>>> T#39 Cambiar plantilla de registro para reflejar datos que contiene un doctor
                                        <div class="radio-inline">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="M" checked />Masculino
                                            </label>
<<<<<<< HEAD
                                        </div>
                                        <div class="radio-inline">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="F"/Welcome/>Femenino
                                            </label>
                                        </div>
                                    </div>
                                    <label>Fecha de nacimiento</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" onkeydown="return false"/>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-3">
                                    <a class="btn btn-danger btn-block">Registrarme</a>
                                </div>
                            </form>
=======
                                        </div>
                                        <div class="radio-inline">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="F"/Welcome/>Femenino
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Fecha de nacimiento</label>
                                        <input class="form-control" placeholder="809-222-2222" />
                                    </div>>
                                </form>
                            </div>
>>>>>>> T#39 Cambiar plantilla de registro para reflejar datos que contiene un doctor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
