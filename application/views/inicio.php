<?= $template_header; ?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= base_url('site/login'); ?>">Inicia sesion</a></li>
                <li><a href="<?= base_url('registro'); ?>">Registrate</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- Page Content -->
<div class="home_container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <header class="header_home row" style="background-image: url(/assets/img/slider_item_2.jpg);">
                <div id="app_preview" class="col-md-4 col-md-offset-1">
                    <img class="header_image_full_vertical" alt="app preview" src="/assets/img/app_vertical.png"/>
                </div>
                <div id="slider_home" class="carousel slide col-md-7" data-ride="carousel">
                    <div class="col-md-12">
                        <h1 id="header_title">ProyectoX</h1>
                    </div>
                    <!-- Indicators -->
                    <!-- <ol class="carousel-indicators"> -->
                    <!-- <li data-target="#slider_home" data-slide-to="0" class="active"></li>
                    <li data-target="#slider_home" data-slide-to="1"></li> -->
                    <!-- </ol> -->

                    <!-- Wrapper for slides -->
                    <div id="home_slides" class="carousel-inner" role="listbox">
                        <div class="item active">
                            <div class="col-md-12">
                                <h1>Empieza a sacar provecho de tu smartphone cuando vayas a hacer fila.</h1>
                                <hr/>
                                <a href="#"><img src="/assets/img/google_play_badge.png" alt="" width="230px" /></a>
                            </div>
                        </div>
                        <!-- <div class="item">
                            <div class="col-md-12">
                                <h1>... Yo estoy harto?</h1>
                                <a class="btn btn-primary btn-block" href="#">manilo</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </header>
        </div>
    </div>
    <div class="row primary">
        <div class="col-md-12">
            <div class="col-md-4 col-md-offset-2">
                <h1>Que es ProyectoX?</h1>
            </div>
            <div class="col-md-4">
                <p>ProyectoX es un ecosistema creado para ofrecerte mas comodidad a la hora de hacer/manejar colas. Te permite hacer fila, sin tener que estar en ella... Ironico, no es asi?</p>
                <p>Este ecosistema esta compuesto de varias partes, dos partes que hacen frente a la misma situacion:</p>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row secundary">
        <div class="col-md-5 col-md-offset-1">
            <div class="text-center">
                <span class="fa-stack fa-5x">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-heartbeat fa-stack-1x fa-inverse"></i>
                </span>
                <h1>Doctores y Asistentes</h1>
            </div>
            <p>Podras manejar el estado de la cola de tu consultorio. Usando proyetoX en la web como uno de estos roles seras capaz de:</p>
            <ul>
                <li>Ver quienes estan haciendo fila en tu consultorio.</li>
                <li>Dar entrada a los pacientes para iniciar una consulta.</li>
                <li>Crear citas para tus pacientes.</li>
                <li>Ver las todas las citas en el calendario.</li>
                <li>Consultar estadisticas de los tiempos de tus consultas.</li>
            </ul>
        </div>
        <div class="col-md-5">
            <div class="text-center">
                <span class="fa-stack fa-5x">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                </span>
                <h1>Pacientes</h1>
            </div>
            <p>Usando la aplicacion de ProyectoX podras aprovechar al maximo tu tiempo mientras haces fila, ya que ProyectoX</p>
            <ul>
                <li>Te recuerda cuanto tiempo tienes disponible para cada fila en la que hayas entrado.</li>
                <li>Avisa cuando tu turno esta por llegar y tu estas lejos del consultorio.</li>
                <li>Avisa si tu turno ha sido corrido ya que no estabas en el lugar correcto.</li>
                <li>Te dice en que lugar estas haciendo fila, en caso de que lo hayas olvidado.</li>
            </ul>
        </div>
    </div>
    <div class="row primary">
        <div class="col-md-12">
            <div class="col-md-3 col-md-offset-3">
                <h1>Que esperas?</h1>
            </div>
            <div class="col-md-3">
                <p>Empieza a usar ProyectoX y aprovecha al maximo tu tiempo!</p>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- Footer -->
    <div class="row footer">
        <div class="col-md-3">
            <p>&copy; <?= date("Y"); ?></p>
        </div>

        <div class="col-md-3 col-md-offset-6">
            <p>
                <span class="fa-stack fa-lg" style="color: #D11919;">
                    <i class="fa fa-square fa-stack-2x"></i>
                    <i class="fa fa-code fa-stack-1x fa-inverse"></i>
                </span>
                Cocinado por chocoSoft
            </p>
        </div>
    </div>
    <!-- /.row -->
</div>

<?= $template_footer; ?>

</body>
</html>
