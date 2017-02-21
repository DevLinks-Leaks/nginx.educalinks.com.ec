<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->

    <?php include ('head.php');?>

	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=6; ?>
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 
			
            <?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
                <?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
                        <div class="titleBar">
                        <!-- InstanceBeginEditable name="Titulo Top" -->
                            <div class="title"><h3><span class="icon-eye icon"></span>OBSERVACIONES</h3></div> 

                           <div class="options">
                              <ul>
                                <li class="titleBar_select">
                                <div class="button_text">
                                  Seleccione el tipo de observación: 
                                    <?php
                                    $sql="{call tipo_observacion_view()}";
                                    $tipo_obs_view = sqlsrv_query($conn, $sql); 
                                    ?>
                                    <select id="tipo_obs" name="tipo_obs" onchange="MostrarObservaciones(this.value);">
                                        <?php while($row_tipo_obs_view = sqlsrv_fetch_array($tipo_obs_view)){?>
                                        <option value="<?=$row_tipo_obs_view['obse_tipo_codi']?>"><?=$row_tipo_obs_view['obse_tipo_deta']?></option>
                                        <?php }?>
                                        <option value="-1" selected>TODAS</option>
                                    </select>
                                 </div>
                                </li>
                              </ul>
                          </div>
                        </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript">
                        //Para que al cargar la página por primera vez se muestren todas las observaciones
                        MostrarObservaciones (document.getElementById('tipo_obs').value);
                        function MostrarObservaciones (tipo_observacion)
                        {
                            var xmlhttp;
                    
                            if (window.XMLHttpRequest)
                            {
                                xmlhttp = new XMLHttpRequest ();
                            }
                            else
                            {
                                xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
                            }
                    
                            xmlhttp.onreadystatechange = function ()
                            {
                                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                                {
                                    document.getElementById('div_observaciones').innerHTML=xmlhttp.responseText;
                                }
                            }
                    
                            xmlhttp.open("GET", "observaciones_view.php?tipo_observacion="+tipo_observacion, true);
                            xmlhttp.send();
                        }
                        </script>
                        
                        <div id="div_observaciones">
                        
                        </div>
						<!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>
	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>


<!-- InstanceEnd --></html>