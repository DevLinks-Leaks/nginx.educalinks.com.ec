<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=412;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title">
          	<h3>
            	<span class="icon-users icon"></span>Catálogo del Sistema
            </h3>
          </div>  
          <div class="options">
          	<ul>
            	<?php if (permiso_activo(160)){?>
                <li>
                  <a 
                  	class="button_text"
                    data-toggle="modal" 
                    data-target="#ModalCataAdd" 
                    title="">
                    <span class="icon-add icon"></span> Agregar Catálogo
                  </a>
                </li>
                <?php }?>
            </ul>
          </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_cata_sistema.js"></script> 
                        <div id="cata_sist_main" >
                             <?php include ('cata_sistema_main_lista.php'); ?>
                        </div>
                        <!--Inicio Modal agregar catálogo-->
                        <div 
                        	class="modal fade" 
                            id="ModalCataAdd" 
                            tabindex="-1" 
                            role="dialog" 
                            aria-labelledby="myModalLabel" 
                            aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                	<span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Agregar Catálogo</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_cata_add"> 
                                    <form 
                                    	id="frm_cata_add" 
                                        name="frm_cata_add" 
                                        method="post" 
                                        action="" 
                                        enctype="multipart/form-data">
                                    	<div class="form_element">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                            <tr>
                                                <td width="25%">
                                                    <label for="cata_grup_add">
                                                        Grupo: 
                                                    </label>
                                                </td>
                                                <td width="75%">
                                                    <select 
                                                        id="sl_cata_grup_add" 
                                                        name="cata_grup_add" 
                                                        style="width: 75%; margin-top: 5px;">
                                                        	<option value="0">SELECCIONE</option>
                                                        <? 
                                                        session_start();	 
                                                        include ('../framework/dbconf.php');
                                                        $params=array();
                                                        $sql="{call cata_view()}";
                                                        $cata_view = sqlsrv_query($conn, $sql, $params);  
                                                        while($row_cata = sqlsrv_fetch_array($cata_view))
                                                        {
                                                        ?>
                                                            <option value="<?= $row_cata['cata_codi']?>">
                                                                <?= $row_cata['cata_deta']?>
                                                            </option>
                                                        <? 
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="cata_sist_desc">
                                                        Descripción: 
                                                    </label>
                                                </td>
                                                <td>
                                                    <input 
                                                        type="text" 
                                                        id="cata_desc_add" 
                                                        style="width: 100%; margin-top: 5px;" 
                                                        name="cata_desc_add" 
                                                        value="">
                                                </td>
                                            </tr>
                                            </table>  
                                        </div>
                                        <div class="form_element">&nbsp;</div>                
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button 
                                	type="button" 
                                    class="btn btn-success" 
                                    onClick="load_ajax_add_cata_sist('cata_sist_main','script_cata_sistema.php','opc=add&cata_padr_codi='+document.getElementById('sl_cata_grup_add').value+'&cata_deta='+document.getElementById('cata_desc_add').value);" >
                                    Grabar
								</button>
                                <button 
                                	type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal">
                                    Cerrar
								</button>
                              </div>
                            </div>
                          </div>
                        </div>    
                        <!--Fin Modal agregar catálogo-->
                        
                        
                        
                        <!--Inicio Modal editar catálogo-->
                        <div 
                        	class="modal fade" 
                            id="ModalCataEdit" 
                            tabindex="-1" 
                            role="dialog" 
                            aria-labelledby="myModalLabel" 
                            aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                	<span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Editar Catálogo</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_cata_edi"> 
                                    <form 
                                    	id="frm_cata_edi" 
                                        name="frm_cata_edi" 
                                        method="post" 
                                        action="" 
                                        enctype="multipart/form-data">
                                    	<div class="form_element">
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                            <tr>
                                                <td width="25%">
                                                    <label for="cata_grup_edi">
                                                        Grupo: 
                                                    </label>
                                                </td>
                                                <td width="75%">
                                                    <select 
                                                        id="sl_cata_grup_edi" 
                                                        name="sl_cata_grup_edi" 
                                                        style="width: 75%; margin-top: 5px;">
                                                        	<option value="0">SELECCIONE</option>
                                                        <? 
                                                        session_start();	 
                                                        include ('../framework/dbconf.php');
                                                        $params=array();
                                                        $sql="{call cata_view()}";
                                                        $cata_view = sqlsrv_query($conn, $sql, $params);  
                                                        while($row_cata = sqlsrv_fetch_array($cata_view))
                                                        {
                                                        ?>
                                                            <option value="<?= $row_cata['cata_codi']?>">
                                                                <?= $row_cata['cata_deta']?>
                                                            </option>
                                                        <? 
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="cata_sist_desc_edi">
                                                        Descripción: 
                                                    </label>
                                                </td>
                                                <td>
                                                    <input 
                                                        type="text" 
                                                        id="cata_desc_edi" 
                                                        style="width: 100%; margin-top: 5px;" 
                                                        name="cata_desc_edi" 
                                                        value="">
                                                    <input
                                                    	type="hidden"
                                                        id="cata_codi_edi"
                                                        value="">
                                                </td>
                                            </tr>
                                            </table>  
                                        </div>
                                        <div class="form_element">&nbsp;</div>                
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button 
                                	type="button" 
                                    class="btn btn-success" 
                                    onClick="load_ajax_upd_para_sist('cata_sist_main','script_cata_sistema.php','opc=upd&cata_padr_codi='+document.getElementById('sl_cata_grup_edi').value+'&cata_deta='+document.getElementById('cata_desc_edi').value+'&cata_codi='+document.getElementById('cata_codi_edi').value);" >
                                    Grabar
								</button>
                                <button 
                                	type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal">
                                    Cerrar
								</button>
                              </div>
                            </div>
                          </div>
                        </div>    
                        <!--Fin Modal editar catálogo-->      
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	    $('#cata_sist_table').datatable({
			pageSize: 10,
			sort: [true, false, false],
			filters: [true, 'select', false],
			filterText: 'Escriba para buscar... '
		}) ;
} );

</script>
       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>