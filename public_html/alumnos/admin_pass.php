<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->
  
  <?php include ('head.php');?>

	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=0;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 
			
      <?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
        <?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
            <div class="titleBar">
              <div class="title"><h3><span class="icon-lock icon"></span>Cambio de Contrase&ntilde;a</h3></div>
            </div>
           	 
             <?php
              session_start();
              include ('../framework/dbconf.php');
              if(isset($_POST['current_pass']))
              {
                $params = array($_SESSION['alum_codi']);
                $sql="{call alum_info(?)}";
                $stmt = sqlsrv_query($conn, $sql, $params);
                if( $stmt === false )
                {
                    echo "Error in executing statement .\n";
                    die( print_r( sqlsrv_errors(), true));
                }
                $usua_view= sqlsrv_fetch_array($stmt);
                if($usua_view['alum_pass']==$_POST['current_pass'])
                {
    					if ($_POST['new_pass_1']==$_POST['new_pass_2'])
    					{
                    $params_usua = array($_SESSION['alum_codi'],$_POST['new_pass_1']);
                    $sql_usua="{call alum_pass_upd(?,?)}";
                    $stmt_usua = sqlsrv_query($conn, $sql_usua, $params_usua);
                    if( $stmt_usua === false )
                    {
                        echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
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
        		} }
      			?>

            <div class="alumnos_add_script admin_pass">
              <form id="usua_pass_form" name="usua_pass_form" enctype="multipart/form-data" action="" method="post">
                  <div class="form_element">
                    <label for="current_pass">Contrase&ntilde;a Actual:</label>
                    <input id="current_pass" name="current_pass" type="password" placeholder="Ingrese su clave actual..." value="">
                  </div>
                  <div class="form_element">
                    <label for="new_pass_1">Nueva Contrase&ntilde;a:</label>
                    <input id="new_pass_1" name="new_pass_1" type="password" placeholder="Ingrese su nueva clave..." value="">
                  </div>
                  <div class="form_element">
                    <label for="new_pass_2">Confirme su nueva contrase&ntilde;a:</label>
                    <input id="new_pass_2" name="new_pass_2" type="password" placeholder="Confirme su nueva clave..." value="">
                  </div>
                  <div class="buttons">
                  <ul>
                    <li>
                      <button id="pass_guardar" name="pass_guardar" type="submit" >Grabar</button>
                    </li>
                  </ul>
                 </div>
              </form>
            </div>
          </div><!-- Information -->
				</div>
			</div>
	</div><!-- Page Container -->
      
  <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
</body>

</html>