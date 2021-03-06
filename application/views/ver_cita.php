<?= $template_header; ?>
<?= $template_navigation; ?>

<div class="page_container col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3">
                    <label class="control-label">Fecha</label>
                    <div class='input-group date' id='datepicker_lista_citas'>
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                        <span class="hidden" id="doc"><?= $ajax_doctor; ?></span>
                        <input id="target_fecha_value" name="fecha" type='text' class="form-control" onkeydown="return false"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div id="lista_citas">
                <h1>Lista de citas</h1>
                <p>Para empezar a ver las citas en el calendario, presiona el buscador arriba ( <span class="fa fa-calendar"></span> )</p>
                <p>Si no quieres ver las citas en el calendario puedes <a class="btn btn-success btn-md" href="<?= base_url('colas/crear_cita/'); ?>" role="button">Agregar Nueva Cita</a></p>
            </div>
        </div>
    </div>
</div>
<span class="hidden" id="animacion">
    <div class="text-center">
        <h1>Buscando citas en esa fecha</h1>
        <h1>
            <i class="fa fa-refresh fa-2x fa-spin"></i>
        </h1>
    </div>
</span>
<span class="hidden" id="lista_vacia">
    <div class="text-center">
        <h3>
            <i class="fa fa-plus-square"></i>
            No hay citas en esta fecha, quizas accediste a esta fecha por error.
        </h3>
    </div>
</span>

<?= $template_footer; ?>

<!-- SCRIPTS ESPECIFICOS PARA ESTA VISTA -->

<script src="/assets/js/custom_lista_cita.js"></script>
</body>
</html>
