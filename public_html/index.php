<!DOCTYPE html>
<html style="height: 100%">
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
    <link rel="shortcut icon" href="imagenes/favicon.png">
    <link href="theme/css/main.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>
	<script src="theme/js/bootstrap.js"></script>
    
</head>
    <body class="login" style="background:url(<?= background_index($_SESSION['codi']);?>) no-repeat center center fixed;-webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
    
    <div class="logo_ingenium" style="">
                    <img style="position:fixed;bottom:0px;right:1%;" src="theme/images/logo_ingenium.png">
                </div>
               
    <div class="pageContainer">
      <section>
          <div class="container">
                <section class="main">
                    <div style="max-width:320px; align-content:center; margin:0 auto;">
                        <img src="imagenes/clientes/<?= $_SESSION['directorio'];?>/logo_inicial_long.png" alt="">
                     </div>
                     <!--<h4>
					<?php /*echo para_sist(3); */?>
					</h4>-->
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
               
					<form  action="framework/main_valid.php" method="POST"  id="form_main">

            			<div class="form_element login" style="width:80%; margin-left:10%;">
                            <label for="usua">Usuario:</label>
                            <input type="text"  name="usua" id="usua" placeholder="Usuario" required>
                        </div>
                        <div class="form_element login" style="width:80%; margin-left:10%;">
                            <label for="password">Contraseña:</label>
                            <input type="password" name='pass' id="pass" placeholder="Contraseña" required> 
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="form_element">
       
                            <label>Perfil</label>
            			</div>   
                           <input type="hidden" id="que2" name="que2" value="IN_API">
                           <input type="hidden" id="tipo" name="tipo" value="">
                     <div class="form_element">
                     
                     </div>
                                            
                  </form>​
                     <div class="btn-group" data-toggle="buttons">
                      <label class="btn btn-primary <? if ($_COOKIE['tipo']==1) echo 'active'; ?>">
                        <input type="radio" name="option" id="option1" autocomplete="off" value="1" <? if ($_COOKIE['tipo']==1) echo 'checked'; ?> >
                        <span class="icon-pencil"></span> Alumnos </label>
                      <label class="btn btn-primary <? if ($_COOKIE['tipo']==2) echo 'active'; ?>">
                        <input type="radio" name="option" id="option3" autocomplete="off" value="2" <? if ($_COOKIE['tipo']==2) echo 'checked'; ?> >
                        <span class="icon-users"></span> Representantes</label>
                      <label class="btn btn-primary <? if ($_COOKIE['tipo']==3) echo 'active'; ?>">
                        <input type="radio" name="option" id="option2" autocomplete="off" value="3" <? if ($_COOKIE['tipo']==3) echo 'checked'; ?> >
                        <span class="icon-user"></span> Docentes </label>
                      <label class="btn btn-primary <? if ($_COOKIE['tipo']==4 or !isset($_COOKIE['tipo'])) echo 'active'; ?>">
                        <input type="radio" name="option" id="option4" autocomplete="off" value="4" <? if ($_COOKIE['tipo']==4 or !isset($_COOKIE['tipo'])) echo 'checked';?> >
                        <span class="icon-cog"></span> Administrativos</label>
                    </div>
                    <div class="row">&nbsp;</div>
                  	<div class="form_element">
                       <button type="button" class="btn btn-primary btn" onClick="main_in();"> Ingresar</button>
                    </div>  
                    <div class="remember">
                        <span>Olvidaste tu contraseña?...</span>
                        <a href="recupera_clave.php">click aquí</a>
                    </div>
                </section>			
                </div>
            </section>
        </div>
	<script>
        $(document).ready(function(){
		$('#usua').focus();
        $('.select').fancySelect();
        }); 
		
		function main_in(){
			if (document.getElementById('option1').checked) document.getElementById('tipo').value=document.getElementById('option1').value;
			if (document.getElementById('option2').checked) document.getElementById('tipo').value=document.getElementById('option2').value;
			if (document.getElementById('option3').checked) document.getElementById('tipo').value=document.getElementById('option3').value;
			if (document.getElementById('option4').checked) document.getElementById('tipo').value=document.getElementById('option4').value;
			
			document.getElementById("form_main").submit();
			
		}

		$('.login').keypress(function(e) {
		    if(e.which == 13) {
		    	if (document.getElementById('option1').checked) document.getElementById('tipo').value=document.getElementById('option1').value;
				if (document.getElementById('option2').checked) document.getElementById('tipo').value=document.getElementById('option2').value;
				if (document.getElementById('option3').checked) document.getElementById('tipo').value=document.getElementById('option3').value;
				if (document.getElementById('option4').checked) document.getElementById('tipo').value=document.getElementById('option4').value;
				
				document.getElementById("form_main").submit();
		    }
		});
    </script>
    </body>
</html>