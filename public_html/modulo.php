<!DOCTYPE html>
<html>
    <?php
    	session_start();   
    ?>
    <head>   
     <?php
		//Set no cachinh
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate"); 
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

        /*$domain=$_SERVER['HTTP_HOST'];
        $serverName = "certuslinks.com";         
        $Database= "Certuslinks_admin"; 
        $UID= "sa";$PWD= "R3dlink5";

        $connectionInfo = array("Database"=>$Database, "UID"=>$UID, "PWD"=>$PWD, "CharacterSet"=>"UTF-8");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        if( $conn === false){
            echo "Error in connection.\n";
            die( print_r( sqlsrv_errors(), true));
        }*/
		include("framework/dbconf_main.php");
		include("framework/funciones.php");
		
        $params = array($domain);
        $sql="{call dbo.clie_info_domain(?)}";
        $resu_login = sqlsrv_query($conn, $sql, $params);  
        $row = sqlsrv_fetch_array($resu_login);
        $_SESSION['host']=$row['clie_instancia_db'];
        $_SESSION['user']=$row['clie_user_db'];
        $_SESSION['pass']=$row['clie_pass_db'];
        $_SESSION['dbname']=$row['clie_base'];

	?>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Educalinks </title>
    <link rel="shortcut icon" href="../favicon.ico"> 
    

    <link href="theme/css/main.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="theme/js/select.js"></script>

    
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
                 	 <h4></h4>
                    
                </section>
                
                

                <section class="log">
                <div class="title">
                    <h4>Seleccione el módulo</h4>
                </div>

                <p style="background-color: #e74c3c;"> 

                            <?php 
				session_start();
				if (isset($_SESSION['erro'])){?>
                    <div class="comp_index">
                        <label><?php echo $_SESSION['erro']?></label>
                    </div>
                <?php }?>
                </p>
                    <form id="frm_modulo" method="POST">
                        <div class="form_element" style="text-align:center;">
                        <table width="100%">
                            <tr>
                                <td width="50%"><?php if($_SESSION['certus_acad']){ ?><button onClick="SeleccionarModulo(1)">ACADÉMICO</button><?php }?></td>
                                <td width="50%"><?php if($_SESSION['certus_finan']){ if($_SESSION['rol_finan']==1){?><button onClick="SeleccionarModulo(2)">FINANCIERO</button><?php }}?></td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                            <tr>
								<td width="50%"><?php if($_SESSION['certus_biblio']){ if($_SESSION['rol_biblio']==1){?><button onClick="SeleccionarModulo(4)">BIBLIOTECA</button><?php }}?></td>
                                <td width="50%"><?php if($_SESSION['certus_medic']){ if($_SESSION['rol_medico']==1){?><button onClick="SeleccionarModulo(3)">MÉDICO</button><?php }}?></td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
							<tr>
                                <td width="50%"><?php if($_SESSION['certus_admisiones']){ ?><button onClick="SeleccionarModulo(5)">ADMISIONES</button><?php }?></td>
                                
								<td width="50%"></td>
                            </tr>
                        </table>
                           
                           
                        </div>
                       
                    </form>​                
                </section>
                </div>

            </section>
        </div>


    <script>     

        function SeleccionarModulo (valor)
        {
            //valor= $("#sl_modulo").val();        
            if (valor==1)
            {
                $("#frm_modulo").attr("action", "admin/index.php");
            }

            if (valor==2)
            {
                $("#frm_modulo").attr("action", "main_finan.php");
            }
            if (valor==3)
            {
                $("#frm_modulo").attr("action", "main_medic.php");
            }
            if (valor==4)
            {
                $("#frm_modulo").attr("action", "biblio/index.php");
            }
            if (valor==5)
            {
                $("#frm_modulo").attr("action", "main_admisiones.php");
            }
        }
    </script>

	</body>
</html>