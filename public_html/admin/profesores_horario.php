<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	<link href="../theme/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../theme/BootstrapFormHelpers/dist/css/bootstrap-formhelpers.min.css" media="screen" rel="stylesheet">
        
        <script type="text/javascript" src="../theme/BootstrapFormHelpers/dist/js/bootstrap-formhelpers.min.js"></script>
        <script type="text/javascript" src="../theme/BootstrapFormHelpers/js/bootstrap-formhelpers-timepicker.js"></script>

      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=207;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <?php 
		  		session_start();	 
				include ('../framework/dbconf.php');
				include ('../framework/funciones.php');
		  		$params = array($_GET['prof_codi']);
				$sql="{call prof_info(?)}";
				$prof_busq = sqlsrv_query($conn, $sql, $params);  
				$row_prof_busq = sqlsrv_fetch_array($prof_busq);?>
          <div class="title"><h3><span class="icon-calendar icon"></span><?= $row_prof_busq['prof_nomb']." ".$row_prof_busq['prof_apel'];?></h3></div>
		  <div class="options">
          	<ul>
            	
                <li>
                  <a class="button_text"  data-toggle="modal" data-target="#ModalUsuaAdd" title="">
                    <span class="icon-add icon"></span> Agregar Horario de Atenci&oacute;n
                  </a>
                </li>
                
            </ul>
          </div>
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_profe_hora.js"></script> 
                        <div id="hora_aten_main" >
                             <?php include ('profesores_horario_lista.php'); ?>
                        </div>
                        
                        <div class="modal fade  bs-example-modal-sm" id="ModalUsuaAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nuevo Horario de Atenci&oacute;n</h4>
                              </div>
                              <div width="100%" id="modal_main" class="modal-body">
                                    <form id="frm_usua_add" name="frm_usua_add" method="post" action="" enctype="multipart/form-data">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                          <tr>
                                          <td width="30%" ><label style="width: 30%;" for="dia_week">D&iacute;as: </label></td>
                                          <td width="70%"><select style="width: 70%;" id="dia_week" name="dia_week">
                                                  <?php
                                                      for($i=1;$i<=7;$i++){
                                                          switch($i){
                                                              case 1: $day="Lunes";
                                                              break;
                                                              case 2: $day="Martes";
                                                              break;
                                                              case 3: $day="Mi&eacute;rcoles";
                                                              break;
                                                              case 4: $day="Jueves";
                                                              break;
                                                              case 5: $day="Viernes";
                                                              break;
                                                              case 6: $day="S&aacute;bado";
                                                              break;
                                                              case 7: $day="Domingo";
                                                              break;
                                                          }?>
                                                          <option value="<?=$i?>"><?=$day?></option>
                                                  <?php	}
                                                  ?>
                                              </select></td>
                                              
                                          </tr>

                                          <tr>
                                            <td width="30%" style="padding-top: 15px;"><label style="width: 30%;" for="horario_ini">Hora Inicial:</label></td>
                                            <td width="70%" style="padding-top: 15px;">
                                                <div style="width: 70%;" id="dp_ini" data-name="horario_ini" data-input="form-control horario_ini" class="bfh-timepicker" data-time="now">
                                                    
                                                </div>
                                            </td>
                                                </div>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td width="30%" style="padding-top: 15px;"><label style="width: 30%;" for="horario_fin">Hora Final: </label></td>
                                            <td width="70%" style="padding-top: 15px;">
                                                <div style="width: 70%;" id="dp_fin" data-name="horario_fin" data-input="form-control horario_fin" class="bfh-timepicker" data-time="now">
                                                    
                                                </div>
                                            </td>
                                          </tr>
                                          
                                        </table>                                        
                                    </form>
                                    <div class="form_element">&nbsp;</div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="hora_aten_add('hora_aten_main','script_profe_hora.php','<?=$_GET['prof_codi']?>','<?=$_SESSION['peri_codi']?>')" >Agregar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>         
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
    <!-- Modal SELECCION DE PERIODO -->
    <div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">SELECCION DE PERIODO ACTIVO</h4>
          </div>
          <div class="modal-body">
           
                <table>
                    <tr>
                        <td>PERIODOS</td>                        
                        
                    </tr>
                            
                     <? 	
						$params = array();
						$sql="{call peri_view()}";
						$peri_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    
                     <? while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
                     <tr>    
     					<td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button></td>
                    </tr>
                    <?php  } ?>


                     
                   
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div>
    <style TYPE="text/css">
      .input-group .form-control{
        position: relative;
        z-index: 2;
        float: left;
        width: 100%;
        margin-bottom: 0;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.428571429;
        color: #555;
        vertical-align: middle;
        border: 1px solid #ccc;
        border-radius: 4px;
      }
      .form-control:focus{
        border-color: #66afe9;
        outline: 0;    
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
      }
          
    </style>
    
<!-- InstanceBeginEditable name="EditRegion4" -->

       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>