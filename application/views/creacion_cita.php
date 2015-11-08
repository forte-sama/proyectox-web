
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
                        Nueva Cita
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <form action="form_asistente" method="post">
                                <input type="hidden" name="form" value="true">
                                <div class="col-md-6 col-md-offset-3">
                                  <div class="control-group">
                                      <label class="control-label">Telefono de Paciente</label>
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
                                  <label class="control-label">Fecha Programada</label>
                                  <div class="control-group">
                                      <div class='input-group date' id='datetimepicker3'>
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar"></span>
                                          </span>
                                          <input name="fecha" type='text' class="form-control" onkeydown="return false" required/>
                                      </div>
                                  </div>
                                  <p>
                                  <label class="control-label">Hora</label>
                                  <div class="control-group">
                                      <div class='input-group date' id='datetimepicker2'>
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar"></span>
                                          </span>
                                          <input name="hora_programada" type='text' class="form-control" onkeydown="return false" required/>
                                      </div>
                                  </div>


                                </div>


                                <div class="col-md-4 col-md-offset-4">
                                    <br><p>
                                    <button type="submit" class="btn btn-danger btn-block">Programar Cita</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS ESPECIFICOS PARA ESTA VISTA -->

<!-- VERIFY.JS SCRIPTS -->
<script src="/assets/js/verify.notify.js"></script>
