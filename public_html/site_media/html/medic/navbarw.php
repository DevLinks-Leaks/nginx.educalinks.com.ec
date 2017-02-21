<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img alt="EDUCALINKS" src="../imagenes/LOGO_EDUCALINKS.png" class="img-responsive" /></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li <?php if($active=="inicio"){echo "class='active'";}?>><a href="index.php"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
            <li class="dropdown <?php if($active=="cons_estudiantes" || $active=="cons_visitantes"){echo "active";}?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus-sign"></span> Atenciones<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if($active=="cons_estudiantes"){echo "class='active'";}?>><a href="cons_estudiantes.php">Estudiantes</a></li>
                    <li <?php if($active=="cons_visitantes"){echo "class='active'";}?>><a href="cons_visitas.php">Visitas</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($active=="ficha_diseno" || $active=="ficha_datos" || $active=="ficha_ocupa"){echo "active";}?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-scale"></span> Fichas<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if($active=="ficha_diseno"){echo "class='active'";}?>><a href="ficha_diseno.php">Diseñar Fichas</a></li>
                    <li <?php if($active=="ficha_datos"){echo "class='active'";}?>><a href="ficha_datos.php">Ingresar Ficha</a></li>
                    <li <?php if($active=="ficha_ocupa"){echo "class='active'";}?>><a href="ficha_ocupacionales.php">Fichas Ocupacionales</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($active=="ingresos"||$active=="egresos"||$active=="presentaciones"){echo "active";}?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-erase"></span> Medicinas<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if($active=="ingresos"){echo "class='active'";}?>><a href="medi_medicinas.php">Ingresos</a></li>
                    <li <?php if($active=="presentaciones"){echo "class='active'";}?>><a href="medi_presentaciones.php">Presentaciones</a></li>
                </ul>
            </li>
            <li class="dropdown <?php if($active=="rep_inventarios" || $active=="rep_atenciones"){echo "active";}?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-duplicate"></span> Reportes<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if($active=="rep_inventarios"){echo "class='active'";}?>><a href="rep_inventarios.php">Inventario</a></li>
                    <li <?php if($active=="rep_atenciones"){echo "class='active'";}?>><a href="rep_atenciones.php">Atenciones</a></li>
                </ul>
            </li>
            <li><a href="../salir.php"><span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
</nav>