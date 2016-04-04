<div class="col-md-10 col-md-offset-2">
    <div class="row">
        <div class="col-md-4" style="height: 8em;">
            <button id="btn_salir_consulta" num_turno="<?= $turno_actual['num_turno']; ?>" class="btn btn-danger btn-lg btn-block">Dar salida<br>del consultorio</button>
        </div>
        <div class="col-md-2 col-md-offset-1">
            <h2><i class="fa fa-user fa-3x"></i></h2>
        </div>
        <div id="turno_actual" class="col-md-4">
            <div class="row">
                <div class="col-md-2">
                    <h4><i class="fa fa-hand-o-right"></i></h4>
                </div>
                <div class="col-md-10">
                    <h4><?= $turno_actual['display_info']['nombre']; ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h4><i class="fa <?= (strlen($turno_actual['display_info']['identificador']) == 12 ? 'fa-phone' : 'fa-newspaper-o'); ?>"></i></h4>
                </div>
                <div class="col-md-10">
                    <h4><?= $turno_actual['display_info']['identificador']; ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <h4><i class="fa fa-clock-o"></i></h4>
                </div>
                <div class="col-md-10">
                    <h4><?= $turno_actual['display_info']['hora_llegada']; ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
