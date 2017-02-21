<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
if(isset($_POST['recu_codi'])){$recu_codi=$_POST['recu_codi'];}else{$recu_codi=0;}
switch($opc){
	case 'add':
		/**CARATULA init */
		$target_dir = '../files/'.$_SESSION['directorio'].'/libros/';
		$imageFileType = pathinfo($_FILES["recu_cara"]["name"],PATHINFO_EXTENSION);
		/**fin**/

		if(isset($_POST['recu_titu'])){$recu_titu=$_POST['recu_titu'];}else{$recu_titu="";}
		if(isset($_POST['recu_tipo_codi'])){$recu_tipo_codi=$_POST['recu_tipo_codi'];}else{$recu_tipo_codi="";}
		if(isset($_POST['recu_edit_codi'])){$recu_edit_codi=$_POST['recu_edit_codi'];}else{$recu_edit_codi="";}
		if(isset($_POST['recu_cole_codi'])){$recu_cole_codi=$_POST['recu_cole_codi'];}else{$recu_cole_codi="";}
		if(isset($_POST['recu_fech_publ'])){$recu_fech_publ=$_POST['recu_fech_publ'];}else{$recu_fech_publ="";}
		if(isset($_POST['recu_isbn'])){$recu_isbn=$_POST['recu_isbn'];}else{$recu_isbn="";}
		if(isset($_POST['recu_issn'])){$recu_issn=$_POST['recu_issn'];}else{$recu_issn="";}
		if(isset($_POST['recu_vide_dura'])){$recu_vide_dura=$_POST['recu_vide_dura'];}else{$recu_vide_dura="";}
		if(isset($_POST['recu_vide_resu'])){$recu_vide_resu=$_POST['recu_vide_resu'];}else{$recu_vide_resu="";}

		$autor_json = $_POST['recu_auto'];
		$autor_json = json_decode($autor_json);

		$descriptor_json = $_POST['recu_desc'];
		$descriptor_json = json_decode($descriptor_json);

		$categorias_json = $_POST['recu_cate'];
		$categorias_json = json_decode($categorias_json);

		$xml_categoria = new DOMDocument("1.0","UTF-8");
		$root_cate = $xml_categoria->createElement("root");
		foreach($categorias_json as $categorias){
			$recu_cate = $xml_categoria->createElement("recu_cate");
			$recu_cate->setAttribute('cate_codi',$categorias->cate_codi);
			$root_cate->appendChild($recu_cate);
		}
		$xml_categoria->appendChild($root_cate);

		$xml_descriptor = new DOMDocument("1.0","UTF-8");
		$root_desc = $xml_descriptor->createElement("root");
		foreach($descriptor_json as $descriptor){
			$recu_desc = $xml_descriptor->createElement("recu_desc");
			$recu_desc->setAttribute('desc_codi',$descriptor->desc_codi);
			$root_desc->appendChild($recu_desc);
		}
		$xml_descriptor->appendChild($root_desc);

		$xml_autor = new DOMDocument("1.0","UTF-8");
		$root_auto = $xml_autor->createElement("root");
		foreach($autor_json as $autor){
			$recu_auto = $xml_autor->createElement("recu_auto");
			$recu_auto->setAttribute('auto_codi',$autor->auto_codi);
			$recu_auto->setAttribute('auto_tipo',$autor->auto_tipo);
			$root_auto->appendChild($recu_auto);
		}
		$xml_autor->appendChild($root_auto);
		
		if($recu_codi>0){
			$params = array($recu_codi,$recu_titu,$recu_isbn,$recu_issn,$recu_fech_publ,$recu_vide_dura,$recu_vide_resu,
						$recu_tipo_codi,$recu_edit_codi,$recu_cole_codi,$xml_autor->saveXML(),
						$xml_categoria->saveXML(),$xml_descriptor->saveXML());
			$sql	= "{call lib_recu_edit (?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		}
		else{
			$params = array($recu_titu,$recu_isbn,$recu_issn,$recu_fech_publ,$recu_vide_dura,$recu_vide_resu,
						$recu_tipo_codi,$recu_edit_codi,$recu_cole_codi,$xml_autor->saveXML(),
						$xml_categoria->saveXML(),$xml_descriptor->saveXML());
			$sql	= "{call lib_recu_add (?,?,?,?,?,?,?,?,?,?,?,?)}";
		}
		$stmt 	= sqlsrv_query($conn,$sql,$params);

		if ($stmt === false)
		{	$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el recurso.' ));
		}else{
			if($recu_codi>0){
				$target_file = $target_dir . $recu_codi .'.'. $imageFileType;
				$uploadOk = 1;
				// Check if image file is a actual image or fake image
			    $check = getimagesize($_FILES["recu_cara"]["tmp_name"]);
			    if($check == true or $_FILES["recu_cara"]["size"]>0) {
			        //echo "File is an image - " . $check["mime"] . ".";
			        // Check file size
					if ($_FILES["recu_cara"]["size"] > 400000) {
					    $mensaje .= "la imagen de caratula es muy grande. ";
					    $uploadOk = 0;
					}
					// Allow certain file formats
					if( $imageFileType != "png" ) {
					    $mensaje .= "solo archivos PNG son permitidos. ";
					    $uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						$result= json_encode(array ('state'=>'warning',
								'result'=>'Lo sentimos, tu imagen de caratula no fue subida debido a.. '.$mensaje ));
					    
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["recu_cara"]["tmp_name"], $target_file)) {
					    	
					        $result= json_encode(array ('state'=>'success',
								'result'=>"Recurso agregado con éxito." ));
					    	$result= json_encode(array ('state'=>'success',
								'result'=>"Recurso agregado con éxito." ));
					        
					    } else { 
					        $result= json_encode(array ('state'=>'warning',
								'result'=>'Lo sentimos, hubo un error al subir la imagen de caratula.' ));
					    }
					}

			    } else {
			        $result= json_encode(array ('state'=>'success',
								'result'=>"Recurso agregado con éxito." ));
			    }
				
				/*AUDITORIA*/
		    	$detalle = 'Código: '.$recu_codi;
		    	$detalle.= ' Titulo: '.$recu_titu;
		    	$detalle.= ' Tipo: ' . $recu_tipo_codi;
		    	$detalle.= ' ISBN: ' . $recu_isbn;
		    	$detalle.= ' ISSN: ' . $recu_issn;
		    	$detalle.= ' Fecha Publicacion: ' . $recu_fech_publ;
		    	registrar_auditoria (301, $detalle);
		    	/*FIN AUDITORIA*/
			}else{
				sqlsrv_fetch($stmt);
				$stmt=sqlsrv_get_field($stmt,0);
				if($stmt>0)
				{
					$target_file = $target_dir . $stmt .'.'. $imageFileType;
					$uploadOk = 1;
					// Check if image file is a actual image or fake image
				    $check = getimagesize($_FILES["recu_cara"]["tmp_name"]);
				    if($check == true or $_FILES["recu_cara"]["size"]>0) {
				        //echo "File is an image - " . $check["mime"] . ".";
				        // Check file size
						if ($_FILES["recu_cara"]["size"] > 400000) {
						    $mensaje .= "la imagen de caratula es muy grande. ";
						    $uploadOk = 0;
						}
						// Allow certain file formats
						if( $imageFileType != "png" ) {

						    $mensaje .= "solo archivos PNG son permitidos. ";
						    $uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							$result= json_encode(array ('state'=>'warning',
									'result'=>'Lo sentimos, tu imagen de caratula no fue subida debido a.. '.$mensaje ));
						    
						// if everything is ok, try to upload file
						} else {
						    if (move_uploaded_file($_FILES["recu_cara"]["tmp_name"], $target_file)) {
						    	$result= json_encode(array ('state'=>'success',
									'result'=>"Recurso agregado con éxito." ));
						        
						    } else {
						        
						        $result= json_encode(array ('state'=>'warning',
									'result'=>'Lo sentimos, hubo un error al subir la imagen de caratula.' ));
						    }
						}

				    } else {
				        $result= json_encode(array ('state'=>'success',
									'result'=>"Recurso agregado con éxito." ));
				    }
				        
			    } else {
			    	$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el recurso.' ));
			    }
			    /*AUDITORIA*/
		    	$detalle = 'Código: '.$stmt;
		    	$detalle.= ' Titulo: '.$recu_titu;
		    	$detalle.= ' Tipo: ' . $recu_tipo_codi;
		    	$detalle.= ' ISBN: ' . $recu_isbn;
		    	$detalle.= ' ISSN: ' . $recu_issn;
		    	$detalle.= ' Fecha Publicacion: ' . $recu_fech_publ;
		    	registrar_auditoria (300, $detalle);
		    	/*FIN AUDITORIA*/
			}
		}
		echo $result;
		// echo $xml_autor->saveXML().$xml_categoria->saveXML().$xml_descriptor->saveXML();
	break;

	case 'del':
		$recu_codi=$_POST['recu_codi']; 
		$params = array($recu_codi);
		$sql="{call lib_recu_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el recurso.' ));
		}else{
			/*AUDITORIA*/
	    	$detalle = 'Código: '.$recu_codi;
	    	registrar_auditoria (302, $detalle);
	    	/*FIN AUDITORIA*/
			$result= json_encode(array ('state'=>'success',
					'result'=>'Recurso eliminado con éxito.' ));
		} 

		echo $result;
	break;

	case 'change':
		$tipo_codi=$_POST['tipo_codi'];
		if($recu_codi!=""){
			$array_auto = [];

	        $params = array($recu_codi);
	        $sql="{call lib_recu_auto_view(?)}";
	        $recu_auto_view= sqlsrv_query($conn, $sql, $params);
	        while($row_recu_auto_view = sqlsrv_fetch_array($recu_auto_view)){
	             $array_auto[$row_recu_auto_view['auto_codi']] = $row_recu_auto_view['auto_tipo'];
	        }

	        $params = array($recu_codi);
	        $sql="{call lib_recu_info(?)}";
	        $lib_recu_info= sqlsrv_query($conn, $sql, $params);  
	        $row_lib_recu_info = sqlsrv_fetch_array($lib_recu_info);
			$recu_isbn=$row_lib_recu_info['recu_isbn'];
			$recu_issn=$row_lib_recu_info['recu_issn'];
			$recu_vide_dura=date_format( $row_lib_recu_info['recu_vide_dura'], 'H:i' );
        	$recu_vide_resu=$row_lib_recu_info['recu_vide_resu'];
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
                $selected = '';
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                        if($array_auto[$row_lib_auto_view['auto_codi']]!=null && $array_auto[$row_lib_auto_view['auto_codi']]=='A')
                            $selected = 'selected';
                        else
                        	$selected = '';
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" '.$selected.' >
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
                	if($array_auto[$row_lib_auto_view['auto_codi']]!=null && $array_auto[$row_lib_auto_view['auto_codi']]=='A')
                            $selected = 'selected';
                        else
                        	$selected = '';
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" '.$selected.' >
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
		                        <textarea rows="3" class="form-control" id="recu_vide_resu" name="recu_vide_resu" placeholder="Resumen...">'.$recu_vide_resu.'</textarea>
		                    </div>
		                </div>';
		        
		        $params = array();
                $sql="{call lib_auto_view()}";
                $lib_auto_view= sqlsrv_query($conn, $sql, $params);  
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                	if($array_auto[$row_lib_auto_view['auto_codi']]!=null && $array_auto[$row_lib_auto_view['auto_codi']]=='D')
                            $selected = 'selected';
                        else
                        	$selected = '';
                    $option_director.='<option value="'.$row_lib_auto_view["auto_codi"].'" '.$selected.' >
	                              '.$row_lib_auto_view["auto_apel"].' '.$row_lib_auto_view["auto_nomb"].'
	                           </option>';
                    if($array_auto[$row_lib_auto_view['auto_codi']]!=null && $array_auto[$row_lib_auto_view['auto_codi']]=='AC')
                            $selected = 'selected';
                        else
                        	$selected = '';
                	$option_actor.='<option value="'.$row_lib_auto_view["auto_codi"].'" '.$selected.' >
	                              '.$row_lib_auto_view["auto_apel"].' '.$row_lib_auto_view["auto_nomb"].'
	                           </option>';
                }

                $director = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Director:</span>
			                        <select id="recu_dire_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_dire_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option_director.'
			                        </select>
			                    </div>
			                </div>';
			    $duracion =	'<div class="form-group">
			                    <div class="input-group bootstrap-timepicker timepicker">
			                        <span class="input-group-addon" >Duración:</span>
			                        <input type="text" id="recu_vide_dura" name="recu_vide_dura" class="form-control" value="'.$recu_vide_dura.'">
			                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
			                    </div>   
			                </div>';

		        $actorP = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Actores:</span>
			                        <select id="recu_acto_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_acto_codi[]" multiple="multiple" data-placeholder="Seleccione los autores" class="form-control">
			                        '.$option_actor.'
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
			                	'.$duracion.'
			            	</div>
			            	<div class="col-md-6">
			                	'.$resumen.'
			            	</div>';
				break;

			default:
				$resumen = '<div class="form-group">
			                    <div class="input-group">
			                        <span class="input-group-addon" >Resumen:</span>
			                        <textarea rows="3" class="form-control" id="recu_vide_resu" name="recu_vide_resu" placeholder="Resumen..."></textarea>
			                    </div>
			                </div>';
		        
		        $params = array();
                $sql="{call lib_auto_view()}";
                $lib_auto_view= sqlsrv_query($conn, $sql, $params);  
                while ($row_lib_auto_view = sqlsrv_fetch_array($lib_auto_view)) {
                	if($array_auto[$row_lib_auto_view['auto_codi']]!=null && $array_auto[$row_lib_auto_view['auto_codi']]=='A')
                            $selected = 'selected';
                	$option.='<option value="'.$row_lib_auto_view["auto_codi"].'" '.$selected.' >
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