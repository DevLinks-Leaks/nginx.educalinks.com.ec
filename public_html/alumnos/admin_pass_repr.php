<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <?php include("template/scripts.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <?php include ('template/header.php');?>
      <?php $active="cons_estudiantes";include("template/menu.php");?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>Representante
            <small>Cambio de Contrase&ntilde;a</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-calendar"></i></a></li>
            <li class="active">Cambio de Contrase&ntilde;a</li>
          </ol>
        </section>
        <section class="content" id="mainPanel">
          <div id="information">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">
                  Cambio de Contrase&ntilde;a
                </h3>
              </div>
              <div class="panel-body">
                <?php  
                session_start();
                include ('../framework/dbconf.php');
                if(isset($_POST['current_pass'])){
                    $params = array($_SESSION['repr_codi']);
                    $sql="{call repr_info(?)}";
                    $stmt = sqlsrv_query($conn, $sql, $params);
                    if( $stmt === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
                    $usua_view= sqlsrv_fetch_array($stmt);
                    if($usua_view['repr_pass']==$_POST['current_pass']){
                        if ($_POST['new_pass_1']==$_POST['new_pass_2']){
                            $params_usua = array($_SESSION['repr_codi'],$_POST['new_pass_1']);
                            $sql_usua="{call repr_pass_upd(?,?)}";
                            $stmt_usua = sqlsrv_query($conn, $sql_usua, $params_usua);
                            if( $stmt_usua === false )
                            {
                                echo "Error in executing statement .\n";
                                die( print_r( sqlsrv_errors(), true));
                            }
                            else
                            {
                                ?>
                                <script>
                                    $.growl.notice({ title: "Listo!",message: "Se actualiz&oacute; la contrase&ntilde;a correctamente." });
                                </script>
                                <?
                            }
                        }
                        else
                        {
                            ?>
                            <script>
                                $.growl.error({ title: "<b>¡Error!</b>",message: "Las contraseñas no coinciden." });
                            </script>
                            <?
                        }
                    }
                    else
                    {
                        ?>
                        <script>
                            $.growl.error({ title: "<b>¡Error!</b>",message: "Las contraseña ingresada no es la correcta." });
                        </script>
                        <?
                    }
                }
                ?>

                <div class="alumnos_add_script admin_pass">
                    <form id="usua_pass_form" name="usua_pass_form" enctype="multipart/form-data" action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_pass">Contrase&ntilde;a Actual:</label>
                                    <input class="form-control" id="current_pass" name="current_pass" type="password" placeholder="Ingrese su clave actual..." value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_pass_1">Nueva Contrase&ntilde;a:</label>
                                    <input class="form-control" id="new_pass_1" name="new_pass_1" type="password" placeholder="Ingrese su nueva clave..." value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_pass_2">Confirme su nueva contrase&ntilde;a:</label>
                                    <input class="form-control" id="new_pass_2" name="new_pass_2" type="password" placeholder="Confirme su nueva clave..." value="">
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-offset-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary" id="pass_guardar" name="pass_guardar" type="submit" >Grabar</button>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
              
          </div><!-- Information -->
        </section>
        <?php include("template/menu_sidebar.php");?>
      </div>
      <form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
        <?php include("template/rutas.php");?>
      </form>
      <?php include("template/footer.php");?>
    </div>
    <!-- =============================== -->
    <input name="mens_de"     type="hidden" id="mens_de"    value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
    <input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
    <script src="../js/med_fichas.js"></script>
    
  </body>
</html>