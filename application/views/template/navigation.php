
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?= base_url('site/'); ?>">
                <i class="fa fa-bolt"></i>
                ProyectoX
            </a>
        </div>

        <?= $user_options; ?>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Jornada <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?= base_url('site/shutdown/'); ?>">
                            <span  class="text-danger">
                                <i class="fa fa-power-off fa-lg"></i> Terminar Jornada
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="<?= base_url('site/logout/'); ?>"><i class="fa fa-sign-out fa-lg"></i> Cerrar sesion</a></li>
        </ul>
    </div>
</nav>
