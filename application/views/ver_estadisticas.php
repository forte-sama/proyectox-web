<?= $template_header; ?>
<?= $template_navigation; ?>

<div class="page_container col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Consulta de estadisticas</h2>
        </div>
        <div class="panel-body">
            <div class="well">
                <h3>Criterios de busqueda:</h3>
                <div class="btn-group btn" role="group" aria-label="...">
                    <button id="por_dia" type="button" class="btn btn-default"><b>Dias del ultimo mes</b></button>
                    <button id="por_mes" type="button" class="btn btn-default"><b>Meses del a&ntilde;o</b></button>
                </div>
            </div>
            <div class="well">
                <div id="grafica_consulta">
                    <h3>Seleccione algun criterio de busqueda</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<span class="hidden" id="animacion_grafica">
    <div class="text-center">
        <h1>Buscando datos de la consulta</h1>
        <h1>
            <i class="fa fa-refresh fa-2x fa-spin"></i>
        </h1>
    </div>
</span>

<?= $template_footer; ?>

<!-- SCRIPTS ESPECIFICOS PARA ESTA VISTA -->
<script src="/assets/js/custom_ver_estadisticas.js"></script>

</body>
</html>
