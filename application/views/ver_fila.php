
<?= $template_header; ?>
<?= $template_navigation; ?>

<div class="page_container col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Turnos en el consultorio</h3>
        </div>
        <div class="panel-body" id="lista_turnos">
            <?= $turnos; ?>
        </div>
    </div>
</div>
<span class="hidden" id="animacion">
    <div class="text-center">
        <h1>Cambiando estado de cita en turno</h1>
        <h1>
            <i class="fa fa-refresh fa-2x fa-spin"></i>
        </h1>
    </div>
</span>

<?= $template_footer; ?>

<script src="/assets/js/custom_lista_turno.js"></script>
</body>
</html>
