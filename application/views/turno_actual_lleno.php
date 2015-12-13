<div class="col-md-8 col-md-offset-2">
    <div class="row">
        <div class="col-md-12">
            <button id="btn_salir_consulta" num_turno="<?= $turno_actual['num_turno']; ?>" class="btn btn-danger btn-lg btn-block">Dar salida del consultorio</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-3">
            <h2><i class="fa fa-user fa-5x"></i></h2>
        </div>
        <div id="turno_actual" class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <h3><i class="fa fa-hand-o-right"></i></h3>
                </div>
                <div class="col-md-10">
                    <h3><?= $turno_actual['display_info']['nombre']; ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h3><i class="fa <?= (strlen($turno_actual['display_info']['identificador']) == 12 ? 'fa-phone' : 'fa-newspaper-o'); ?>"></i></h3>
                </div>
                <div class="col-md-10">
                    <h3><?= $turno_actual['display_info']['identificador']; ?></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h3><i class="fa fa-clock-o"></i></h3>
                </div>
                <div class="col-md-10">
                    <h3><?= $turno_actual['display_info']['hora_llegada']; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
