<?php 

session_start();	 
include ('../framework/dbconf.php');

if(isset($_GET['curs_para_codi'])){
 $curs_para_codi=$_GET['curs_para_codi'];
}
if(isset($_GET['curs_para_codi'])){
 $curs_para_codi=$_GET['curs_para_codi'];
}

if(isset($_GET['curs_para_codi'])){
 $curs_para_codi=$_GET['curs_para_codi'];
}

if(isset($_GET['curs_para_codi'])){
 $curs_para_codi=$_GET['curs_para_codi'];
}


$params = array($curs_para_codi);
$sql="{call curs_peri_info(?)}";
$curs_peri_info = sqlsrv_query($conn, $sql, $params);  
$cc = 0;

?>
<?php if( $row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info) ){?>
<div class="row">
	<div class="col-sm-8">
		<div id="mate_view">
			<?php include ('cursos_paralelo_info_main_mate_view.php'); ?>   
		</div>
	</div>
	<div class="col-sm-4">
		<div id="alum_view">
			<?php include ('cursos_paralelo_info_main_alum_view.php'); ?>
		</div>
	</div>
</div>
<?php } ?>

<script >
  function texto_buscar_mate() {							   
   load_ajax('mate_main','cursos_paralelo_info_main_mate_diag.php','texto=' + document.getElementById('texto_mate').value + '&curs_para_codi=' + '<?php echo $curs_para_codi; ?>');
 }
 
 function texto_buscar_alum() {							   
   load_ajax('alum_main','cursos_paralelo_info_main_alum_diag.php','texto=' + document.getElementById('texto_alum').value + '&curs_para_codi=' + '<?php echo $curs_para_codi; ?>');
 }
 
function alum_mate_view(curs_para_codi, alum_curs_para_codi, alum_codi) {
   load_ajax('alum_mate_main','cursos_paralelo_info_main_mate_conf_diag.php','curs_para_codi=' + curs_para_codi + '&alum_curs_para_codi=' + alum_curs_para_codi + '&alum_codi=' + alum_codi);
 }
</script>



<!--**************  MODAL  ALUMNOS  ************************** -->
<div class="modal fade" id="ModalAlum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevos Alumnos</h4>
      </div>
      <div id="modal_main" class="modal-body">
        <div id="div_alumnos"> 
            <div class="form_element">
                <table style="width:100%;">
                  <tr>
                    <td style="padding-top: 15px;"><label for="texto">Búsqueda:</label>
                      <input id="texto_alum" value="" onkeypress="texto_buscar_alum();" style="width: 97%" autofocus="true">
                      <span class="fa fa-search" style="padding: auto"></span>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding-top: 15px;">
                       <div id="alum_main"  style="width: 100%; height: 300px; overflow-y: scroll;">
                       </div>
                     </td>
                   </tr>
            	</table>    
            </div>
            <div class="form_element">&nbsp;</div>                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--**************  ///////// MODAL  ALUMNOS /////////// ************************** -->

<!--**************  MODAL  MATERIAS  ************************** -->
<div class="modal fade" id="ModalMate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevas Materias</h4>
      </div>
      <div id="modal_main" class="modal-body">
        <div id="div_materias"> 
            <div class="form_element">
            <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
              <tr>
                <td style="padding-top: 15px;"><label for="texto">Búsqueda:</label>
                	<input id="texto_mate" value="" style="width: 70%"> 
                    <button class="btn btn-default" onclick="texto_buscar_mate();"><span class="fa fa-search" style="padding: auto"> Buscar</span></button>
				</td>
                </tr>
                <tr>
                  <td style="padding-top: 15px;">
                   <div id="mate_main"  style="width: 100%; height: 300px; overflow-y: scroll;">
                   </div>
                 </td>
               </tr>
             </table>
            </div>
            <div class="form_element">&nbsp;</div>                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--**************  ///////// MODAL  MATERIAS /////////// ************************** -->


<!--**************  Modal Curso ************************** -->
<div class="modal fade" id="ModalEditCurso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" 
        		class="close" 
                data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
		</button>
        <h4 class="modal-title" id="myModalLabel">Agregar/Modificar profesor</h4>
      </div>
      <div id="modal_main" class="modal-body">
        <div id="edit_curs_main"> 
                          
        </div>
      </div>
      <div class="modal-footer">
        <button 
           		type="button" 
                class="btn btn-primary" 
                onclick="alum_curs_para_mate_upd_save(document.getElementById('curs_para_mate_codi').value,document.getElementById('curs_para_mate_prof_codi').value,
                document.getElementById('prof_codi').value,
                document.getElementById('aula_codi').value,
				<?php echo $curs_para_codi; ?>)" 
                data-dismiss="modal">
                	Aceptar
           </button> &nbsp;&nbsp;&nbsp;
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--**************  ///////// MODAL   /////////// ************************** -->


<!--**************  Quitar o Agregar Materias ************************** -->
<div class="modal fade" id="ModalAlumMate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"s>Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar o quitar materias</h4>
      </div>
      <div id="modal_main" class="modal-body">
         <div id="alum_mate_main">
         </div>
     </div>
     <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     </div>
   </div>
 </div>
</div>
<!--**************  ///////// MODAL   /////////// ************************** -->

<!--Inicio modal modificar cupo-->
<div class="modal fade" id="ModalEditCupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modificar cupo</h4>
      </div>
      <div id="modal_main" class="modal-body">
        <div id="div_cupo_edi"> 
            <div class="form_element">
            <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                <tr>
                    <td>
                        <label for="curs_para_cupo">Cupo: </label>
                    </td>
                    <td>
                        <input type="number" id="curs_para_cupo_edit" style="width: 25%; margin-top: 5px;" name="curs_para_cupo_edit" value="" />
                    </td>
                </tr>
            </table>  
            </div>
            <div class="form_element">&nbsp;</div>                
        </div>
      </div>
      <div class="modal-footer">
        <button 
        	type="button" 
            class="btn btn-success" 
            onClick="curs_para_cupo_edit(<?php echo $curs_para_codi; ?>, document.getElementById('curs_para_cupo_edit').value);" >
        	Grabar
        </button>
        <button 
        	type="button" 
            class="btn btn-default" 
            data-dismiss="modal" >
        	Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
<!--Fin modal modificar cupo-->




<!--Inicio modal copiar materias a curso paralelo-->
<div class="modal fade" id="ModalCopiadeMaterias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalCopiadeMaterias">Copia de Materias</h4>
      </div>
      <div id="modal_main" class="modal-body">
        <div id="div_cupo_edi"> 
            <div class="form_element">
            <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                <tr>
                    <td width="25%" style="padding-top: 15px;">
                        <label for="curs_para">Paralelo: </label>
                    </td>
                    <td style="padding-top: 15px;">
                    	<input type="hidden" id="alum_curs_para_codi" value="" />
                        <select id="sl_curs_para_codi_2" 
                        		style="width: 75%;" 
                                onchange="load_ajax('div_materias_curso',
                                		'curs_para_mate_view.php',
                                        'curs_para_codi='+ this.value);">
						<option value="-1">Elija</option>
                         <?
							$params=array($_GET["curs_para_codi"]);
							$sql="{call curs_para_peri_cons (?)}";
							$stmt=sqlsrv_query($conn, $sql, $params);
							while ($row = sqlsrv_fetch_array($stmt))
							{
                   		 ?>
                        	<option value="<?= $row["curs_para_codi"]?>">
								<?= $row["peri_deta"].' '.$row["curs_deta"]." - Paralelo: ".$row["para_deta"];?>
                            </option>
                         <?
							}
						 ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 15px;">
                    	<div id="div_materias_curso">
                        	
                        </div>
                    </td>
                </tr> 
            </table>  
            </div>
            <div class="form_element">&nbsp;</div>                
        </div>
      </div>
      <div class="modal-footer">
        <button 
        	type="button" 
            class="btn btn-success" 
            onClick="(document.getElementById('num_materias').value>0?
            		alert ('Ya existen materias agregadas'):
                    copy_curs_mate(document.getElementById('sl_curs_para_codi_2').value, 
									<? echo $curs_para_codi; ?>))" >
        	Copiar
        </button>
        <button 
        	type="button" 
            class="btn btn-default" 
            data-dismiss="modal" >
        	Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
<!--Fin modal copiar materias a curso paralelo-->

<!--Inicio modal Asignar Modelo calificación-->
<div class="modal fade" id="ModalAsignarModelo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalCopiadeMaterias">Asignar modelo de calificación</h4>
      </div>
      <div id="modal_main" class="modal-body">
        <div id="div_cupo_edi"> 
            <div class="form_element">
            <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                <tr>
                    <td width="25%" style="padding-top: 15px;">
                        <label>Modelo Calificación: </label>
                        <input type="hidden" id="curs_para_mate_codi" value=""/>
                    </td>
                    <td style="padding-top: 15px;">
					<? 	
						$params = array($row_curs_peri_info['peri_dist_cabe_codi']);
						$sql="{call nota_refe_cab_view(?)}";
						$stmt = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    <select 
                    	id="sl_modelos" 
                        style="width: 75%;" 
                        onchange="">
                    		<option value="0">Seleccione...</option>
					<? 
					while($row_mode_cali_view = sqlsrv_fetch_array($stmt))
					{ 
					?>
                      <option 
                      	value="<?= $row_mode_cali_view['nota_refe_cab_codi'];?>">
                        		<?= 
									$row_mode_cali_view['nota_refe_cab_deta'];
								?>
                      </option>
					<?php
                    }
                    ?>
                    </select> 
                    </td>
                </tr>
            </table>  
            </div>
            <div class="form_element">&nbsp;</div>                
        </div>
      </div>
      <div class="modal-footer">
        <button 
        	type="button" 
            class="btn btn-success" 
            onClick="alum_curs_para_mate_mode_upd(document.getElementById('curs_para_mate_codi').value,document.getElementById('sl_modelos').value, <? echo $curs_para_codi; ?>);" >
        	Aceptar
        </button>
        <button 
        	type="button" 
            class="btn btn-default" 
            data-dismiss="modal" >
        	Cerrar
        </button>
      </div>
    </div>
  </div>
</div>
<!--Fin modal asignar modelo de calificación-->