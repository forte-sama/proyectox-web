<ul class="nav navbar-nav navbar-left">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Citas <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?= base_url('colas/crear_cita'); ?>"><i class="fa fa-calendar-plus-o fa-lg"></i> Crear Nueva Cita</a></li>
            <li><a href="<?= base_url('colas/ver_cita'); ?>"><i class="fa fa-calendar fa-lg"></i> Ver Citas</a></li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cola <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="<?= base_url('colas/crear_turno'); ?>"><i class="fa fa-user-plus fa-lg"></i> Ingresar Pacientes</a></li>
            <li><a href="<?= base_url('colas/ver_fila'); ?>"><i class="fa fa-list-ol fa-lg"></i> Ver Turnos</a></li>
        </ul>
    </li>
</ul>
