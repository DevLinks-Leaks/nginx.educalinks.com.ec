<!DOCTYPE html>
<html>
    <?php
		session_start();
		require_once ('framework/switch.php');
		require_once ('framework/funciones.php');	
		get_database_params();
    ?>
    <head>    
	<?php
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
    <title>Educalinks | <?= para_sist(2);?></title>
    <link rel="shortcut icon" href="imagenes/logo_icon.png"> 
    

    <link href="theme/css/main.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>
</head>

    <body class="login" style="background:url(<?= background_index($_SESSION['codi']);?>) no-repeat center center fixed;-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
                <div class="logo_ingenium">
                    <img style="position:fixed;bottom:0px;right:1%;" src="theme/images/logo_ingenium.png">
                </div>
                
        <div class="pageContainer">
            <section>
                

                <div class="container">
			
                <section class="main">
                    <div style="max-width:320px; align-content:center; margin:0 auto;">
                        <img src="imagenes/clientes/<?= $_SESSION['directorio'];?>/logo_inicial_long.png" alt="">
                     </div>

                </section>
                <section class="log">
                <div class="title">
                    <h4>Ingreso de Usuario</h4>
                </div>
                <p style="background-color: #e74c3c;"> 
				<?php 
				session_start();
				if (isset($_SESSION['erro2'])){?>
                    <div class="comp_index">
                        <label><?php echo $_SESSION['erro2']?></label>
                        <?php 
						salir_stay();
						?>
                    </div>
                <?php }?>
                </p>
                    <form  action="script_recupera_clave.php" method="POST" enctype="multipart/form-data">
                        <div class="form_element">
                            <label for="usua">Usuario:</label>
                            <input type="text"  name="usua" id="usua" placeholder="Usuario" required>
                        </div>
                        <div class="form_element">
                            <input type="submit" name="submit" value="Recuperar Contraseña">
                        </div>
                    </form>​
                    <div class="remember">
                        <span>Regresar al Inicio de Sesi&oacute;n</span>
                        <a href="index.php">click aquí</a>
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
	</body>
</html>