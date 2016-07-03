<?= $template_header; ?>

<div class="page_container col-md-8 col-md-offset-2">
    <div class="row">
        <div class="col col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Pruebas Unitarias ProyectoX: Web</h3>
                </div>
                <div class="panel-body">
                    <p><?= 'Aqui van las pruebas unitarias' ?></p>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3>Pruebas de Caja Blanca ProyectoX: Web</h3>
                </div>
                <div class="panel-body">
                    <p><?= 'Aqui van las pruebas de caja blanca' ?></p>
                </div>
            </div>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3>Pruebas de Caja Negra ProyectoX: Web</h3>
                </div>
                <div class="panel-body">
                    <h4>Prueba login de doctor correcto</h4>
                    <p><?= $pruebas_caja_negra_login["login_doctor_correcto"] ?></p>
                    <h4>Prueba login de asistente correcto</h4>
                    <p><?= $pruebas_caja_negra_login["login_asistente_correcto"] ?></p>
                    <h4>Prueba login de usuario incorrecto</h4>
                    <p><?= $pruebas_caja_negra_login["login_usuario_incorrecto"] ?></p>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3>Pruebas de Integracion ProyectoX: Web</h3>
                </div>
                <div class="panel-body">
                    <p><?= 'Aqui van las pruebas de integracion' ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $template_footer; ?>

</body>
</html>
