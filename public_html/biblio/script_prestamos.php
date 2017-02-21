<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
if(isset($_POST['pres_codi'])){$pres_codi=$_POST['pres_codi'];}else{$pres_codi=0;}
switch($opc){
	case 'add':

		if(isset($_POST['pres_usua_codi'])){$pres_usua_codi=$_POST['pres_usua_codi'];}else{$pres_usua_codi="";}
		if(isset($_POST['pres_usua_tipo_codi'])){$pres_usua_tipo_codi=$_POST['pres_usua_tipo_codi'];}else{$pres_usua_tipo_codi="";}
		if(isset($_POST['pres_fech_devo'])){$pres_fech_devo=$_POST['pres_fech_devo'];}else{$pres_fech_devo="";}
		if(isset($_POST['pres_obse'])){$pres_obse=$_POST['pres_obse'];}else{$pres_obse="";}

		$item_json = $_POST['pres_item'];
		$item_json = json_decode($item_json);

		$xml_item = new DOMDocument("1.0","UTF-8");
		$root_item = $xml_item->createElement("root");
		foreach($item_json as $categorias){
			$pres_item = $xml_item->createElement("pres_item");
			$pres_item->setAttribute('item_codi',$categorias->item_codi);
			$root_item->appendChild($pres_item);
		}
		$xml_item->appendChild($root_item);
		
		if($pres_codi>0){
			$params = array($pres_codi,$pres_fech_devo);
			$sql	= "{call lib_pres_edit (?,?)}";
		}
		else{
			$params = array($pres_usua_codi,$pres_usua_tipo_codi,$pres_fech_devo,$pres_obse,$xml_item->saveXML());
			$sql	= "{call lib_pres_add (?,?,?,?,?)}";
		}
		$stmt 	= sqlsrv_query($conn,$sql,$params);

		if ($stmt === false)
		{	$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar el prestamo.' ));
		}else{
			if($pres_codi>0){
					/*AUDITORIA*/
			    	$detalle = 'Prestamo Código: '.$pres_codi;
			    	$detalle.= ' Fecha Devolucion: ' . $pres_fech_devo;
			    	registrar_auditoria (307, $detalle);
			    	/*FIN AUDITORIA*/
			        $result= json_encode(array ('state'=>'success',
								'result'=>"Prestamo agregado con éxito." ));
				
				
			}else{
				sqlsrv_fetch($stmt);
				$stmt=sqlsrv_get_field($stmt,0);
				if($stmt>0)
				{
					/*AUDITORIA*/
			    	$detalle = 'Prestamo Código: '.$stmt;
			    	$detalle.= ' Prestamo Usuario Código: '.$pres_usua_codi;
			    	$detalle.= ' Prestamo Usuario Tipo Código: ' . $pres_usua_tipo_codi;
			    	$detalle.= ' Fecha Devolucion: ' . $pres_fech_devo;
			    	$detalle.= ' Observacion: ' . $pres_obse;
			    	registrar_auditoria (306, $detalle);
			    	/*FIN AUDITORIA*/
			        $result= json_encode(array ('state'=>'success',
									'result'=>"Prestamo agregado con éxito." ));    
			    } else {
			        $result= json_encode(array ('state'=>'error',
								'result'=>"Error al agregar el prestamo." ));
			    }	
			}
		}
		

		echo $result;
		// echo $xml_autor->saveXML().$xml_categoria->saveXML().$xml_descriptor->saveXML();
	break;

	case 'del':
		$pres_codi=$_POST['pres_codi']; 
		$params = array($pres_codi);
		$sql="{call lib_pres_del(?)}";
		$result = sqlsrv_query($conn, $sql, $params);
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar el prestamo.' ));
		}else{
			/*AUDITORIA*/
	    	$detalle = 'Prestamo Código: '.$pres_codi;
	    	registrar_auditoria (308, $detalle);
	    	/*FIN AUDITORIA*/
			$result= json_encode(array ('state'=>'success',
					'result'=>'Prestamo eliminado con éxito.' ));
		} 

		echo $result;
	break;

	case 'devo_item':
		$pres_item_codi=$_POST['pres_item_codi']; 
		$params = array($pres_item_codi);
		$sql="{call lib_pres_devo_item(?)}";
		$result = sqlsrv_query($conn, $sql, $params);
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al devolver el item.' ));
		}else{
			/*AUDITORIA*/
	    	$detalle = 'Prestamo Item Código: '.$pres_item_codi;
	    	registrar_auditoria (309, $detalle);
	    	/*FIN AUDITORIA*/
			$result= json_encode(array ('state'=>'success',
					'result'=>'Item devuelto con éxito.' ));
		} 

		echo $result;
	break;

	case 'devo':
		$pres_codi=$_POST['pres_codi']; 
		$params = array($pres_codi);
		$sql="{call lib_pres_devo(?)}";
		$result = sqlsrv_query($conn, $sql, $params);
		//$row_mate_add = sqlsrv_fetch_array($mate_add);
		
		if( $result === false ){
			//echo "Error in executing statement .\n";
			//die( print_r( sqlsrv_errors(), true));
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al devolver todos los items del prestamo.' ));
		}else{
			/*AUDITORIA*/
	    	$detalle = 'Prestamo Código: '.$pres_codi;
	    	registrar_auditoria (309, $detalle);
	    	/*FIN AUDITORIA*/
			$result= json_encode(array ('state'=>'success',
					'result'=>'Items de prestamo devueltos con éxito.' ));
		} 

		echo $result;
	break;
}
?>