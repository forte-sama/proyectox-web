<?= $template_header; ?>

<div class="page_container col-md-8 col-md-offset-2" >
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Deseo registrame como un...</h1>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <div class="well">
                    <div class="text-center clear">
                        <h1>
                            <span class="fa-stack fa-2x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stethoscope fa-stack-1x fa-inverse"></i>
                            </span>
                        </h1>
                        <h1>Medico</h1>
                    </div>
                    <p>Podre ver estadisticas de consultas realizadas, ver citas en el calendario y ver cola en mi consultorio, y mucho mas</p>
                    <p><a class="btn btn-primary btn-block" href="<?= base_url('registro/doctor/'); ?>" role="button">Registrarme como Medico</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="well media">
                    <div class="text-center clear">
                        <h1>
                            <span class="fa-stack fa-2x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-book fa-stack-1x fa-inverse"></i>
                            </span>
                        </h1>
                        <h1>Asistente</h1>
                    </div>
                    <p>Podre manejar estado de la cola en un consultorio, crear citas para su medico, y mucho mas</p><br />
                    <p><a class="btn btn-primary btn-block" href="<?= base_url('registro/asistente/'); ?>" role="button">Registrarme como Asistente</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $template_footer; ?>
