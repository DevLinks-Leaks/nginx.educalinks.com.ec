<!DOCTYPE html>
<html> <!-- Proceso 4 -->
    <?php
    session_start();
	require_once ('framework/switch.php');
	require_once ('framework/funciones.php');	
	get_database_params();
    ?>
    <head>    <?php
//Set no cachinh
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Educalinks | Unidad Educativa <?= para_sist(2);?></title>
    <link rel="shortcut icon" href="imagenes/logo_icon.png"> 
   

    <link href="theme/css/main.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>

    
</head>
  <body class="login" style="background:url(<?= background_index($_SESSION['codi']);?>);">
               
        <div class="pageContainer">
            <section>
                <div class="container">
                <section class="main">
                    
                        <img src="imagenes/clientes/<?= $_SESSION['directorio'];?>/logo_inicial_long.png" alt="">
                     
                    <h4><?php echo para_sist(3); ?></h4>
                    <h3>
							<?php 
							//echo "<strong> Base de datos: ".$_SESSION['db']."</strong>";
							//echo "<strong> Cliente: ".$_SESSION['codi']."</strong>";
							?>
                    </h3>
                </section>
                <section class="log">
                <div class="title">
                    <h4>Ingreso de Usuario</h4>
                </div>

                <p style="background-color: #e74c3c;"> 

				<?php 
					//session_start();
					if (isset($_SESSION['erro'])){?>
                    <div class="comp_index">
                        <label><?php echo $_SESSION['erro']; ?></label>
                    </div>
                <?php }?>
                </p>

                    <form  action="framework/main_valid.php" method="POST">
                        <div class="form_element">
                            <label for="usua">Usuario:</label>
                            <input type="text"  name="usua" id="usua" placeholder="Usuario" required>
                        </div>
                        <div class="form_element">
                            <label for="password">Contraseña:</label>
                            <input type="password" name='pass' id="pass" placeholder="Contraseña" required> 
                        </div>
                        <div class="form_element">
       
                            <label>Perfil</label>
                            <select class="select" name="tipo" id="tipo">
                                <option value="1" selected>Alumno</option>
                                <option value="2">Representante</option>
                                <option value="3">Docente</option>
                                <option value="4">Administrativo</option>
                            </select>
 
                        </div>
                        <div class="form_element">
                            <input type="submit" name="submit" value="Ingresar al Sistema">
                            <input type="hidden" id="que2" name="que2" value="IN_API">
                        </div>                        
                    </form>​
                
                    <div class="remember">
                        <span>Olvidaste tu contraseña?...</span>
                        <a href="recupera_clave.php">click aquí</a><br><br>

                        
                    </div>
                </section>			
                </div>
            </section>
        </div>
    <script>
        $(document).ready(function(){
        $('.select').fancySelect();
        }); 
    </script>
<div  style="float:right;"> v. 1.0012 </div>
	</body>
</html>