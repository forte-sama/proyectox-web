
<?= $template_header; ?>
<?= $template_navigation; ?>

<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        <?php
        $this->table->set_heading('Paciente', 'Telefono / Cedula', 'Hora llegada', 'Opciones cita (En desarrollo)');
        $this->table->set_template(array(
            'table_open'  => '<table class="table table-hover">',
            'thead_open'  => '<thead>',
            'thead_close' => '</thead>',
        ));
        echo $this->table->generate($turnos);
        ?>
    </div>
</div>

<?= $template_footer; ?>

</body>
</html>
