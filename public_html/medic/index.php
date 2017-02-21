<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body role="document">
    <?php $active="inicio";include("template/navbar.php");?>
    <div class="container-fluid theme-showcase" role="main">
        <!-- region de edicion -->
        <div class="row">
        	<div class="col-md-12 bottom_10">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    	<h3 class="panel-title">Opciones Principales</h3>
                    </div>
                    <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="images/atenciones.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Nueva Atención de Alumnos</h3>
                                    <p class="text-justify">Registro de Informacion de una nueva atención médica de un estudiante de la institución.</p>
                                    <p class="text-center"><a href="cons_estudiantes.php" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Atención de Alumnos</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="images/atenciones_personal.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Nueva Atención de Personal</h3>
                                    <p class="text-justify">Registro de Informacion de una nueva atención médica de personal docente o administrativo.</p>
                                    <p class="text-center"><a href="cons_visitas.php" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Atención de Personal</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="images/reportes.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Reporte de Atenciones</h3>
                                    <p class="text-justify">Reporte detallado de las atenciones realizadas el día especificado por el usuario</p>
                                    <p class="text-center"><a href="rep_atenciones.php" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Reporte de Atenciones</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="thumbnail">
                                <img src="images/fichas.jpg" class="img-responsive" alt="...">
                                <div class="caption">
                                    <h3 class="text-center">Ingreso de Ficha</h3>
                                    <p class="text-justify">Registro de Informacion médica de una persona para conocimiento del Director del Departamento Médico.</p>
                                    <p class="text-center"><a href="ficha_datos.php" class="btn btn-primary" role="button"><span class="glyphicon glyphicon-list-alt"></span>  Ingreso de Ficha</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!--=============================== -->
    </div><!-- /container -->        
    <?php include("template/scripts.php");?>
    <script type="text/javascript">        
       $(document).ready(function(){  
           
       });
    </script>
  </body>
</html>
