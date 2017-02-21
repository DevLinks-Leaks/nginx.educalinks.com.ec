<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'change':
		if(isset($_POST['recu_codi'])){$recu_codi=$_POST['recu_codi'];}else{$recu_codi="";}
		$tipo_codi=$_POST['tipo_codi'];
		if($recu_codi!=""){
			//Aqui va codigo para cuando sea update se carguen los campos ya hechos
		}
		$result='';
		switch ($tipo_codi) {
			case 1:
				$isbn = '<div class="form-group">
		                    <div class="input-group">
		                        <span class="input-group-addon" >ISBN:</span>
		                        <input type="text" class="form-control" id="recu_isbn" name="recu_isbn" placeholder="ISBN" value="'.$recu_isbn.'">
		                    </div>
		                </div>';
		        
		        $params = array();
                $sql="{call lib_auto_view()}";
                $lib_auto_view= sqlsrv_query($conn, $sql, $params);  
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" >
	                              '.$row_lib_auto_view["auto_apel"].' '.$row_lib_auto_view["auto_nomb"].'
	                           </option>';
                }

		        $autor = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Autor:</span>
			                        <select id="recu_auto_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_auto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option.'
			                        </select>
			                    </div>   
			                </div>';

				$result = '	<div class="col-md-6">
			                	'.$isbn.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$autor.'
			            	</div>';
				break;
			case 2:
				$issn = '<div class="form-group">
		                    <div class="input-group">
		                        <span class="input-group-addon" >ISSN:</span>
		                        <input type="text" class="form-control" id="recu_issn" name="recu_issn" placeholder="ISSN" value="'.$recu_issn.'">
		                    </div>
		                </div>';
		        
		        $params = array();
                $sql="{call lib_auto_view()}";
                $lib_auto_view= sqlsrv_query($conn, $sql, $params);  
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" >
	                              '.$row_lib_auto_view["auto_apel"].' '.$row_lib_auto_view["auto_nomb"].'
	                           </option>';
                }

		        $autor = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Autor:</span>
			                        <select id="recu_auto_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_auto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option.'
			                        </select>
			                    </div>   
			                </div>';

				$result = '	<div class="col-md-6">
			                	'.$issn.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$autor.'
			            	</div>';
				break;

			case 3:
				$resumen = '<div class="form-group">
		                    <div class="input-group">
		                        <span class="input-group-addon" >Resumen:</span>
		                        <textarea rows="3" class="form-control" id="recu_resumen" name="recu_resumen" placeholder="Resumen..."></textarea>
		                    </div>
		                </div>';
		        
		        $params = array();
                $sql="{call lib_auto_view()}";
                $lib_auto_view= sqlsrv_query($conn, $sql, $params);  
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" >
	                              '.$row_lib_auto_view["auto_apel"].' '.$row_lib_auto_view["auto_nomb"].'
	                           </option>';
                }

                $director = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Director:</span>
			                        <select id="recu_direc_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_auto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option.'
			                        </select>
			                    </div>
			                </div>';

		        $actorP = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Actores P.:</span>
			                        <select id="recu_auto_codi_p" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_auto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option.'
			                        </select>
			                    </div>   
			                </div>';

                $actorS = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Actores S.:</span>
			                        <select id="recu_auto_codi_s" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_auto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option.'
			                        </select>
			                    </div>   
			                </div>';

				$result = '	<div class="col-md-6">
			                	'.$director.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$actorP.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$actorS.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$resumen.'
			            	</div>';
				break;

			default:
				$resumen = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Resumen:</span>
			                        <textarea rows="3" class="form-control" id="recu_resumen" name="recu_resumen" placeholder="Resumen..."></textarea>
			                    </div>
			                </div>';
		        
		        $params = array();
                $sql="{call lib_auto_view()}";
                $lib_auto_view= sqlsrv_query($conn, $sql, $params);  
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" >
	                              '.$row_lib_auto_view["auto_apel"].' '.$row_lib_auto_view["auto_nomb"].'
	                           </option>';
                }

                

		        $autor = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Autor:</span>
			                        <select id="recu_auto_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_auto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option.'
			                        </select>
			                    </div>   
			                </div>';

				$result = '	<div class="col-md-6">
			                	'.$autor.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$resumen.'
			            	</div>';
				break;
		}

		echo $result;
	break;
}
?>