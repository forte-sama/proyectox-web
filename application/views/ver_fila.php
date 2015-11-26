
<?= $template_header; ?>
<?= $template_navigation; ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        <div id="lista_turnos">
            <?= $turnos; ?>
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
</div>

<?= $template_footer; ?>

<script src="/assets/js/custom_lista_turno.js"></script>
</body>
</html>
