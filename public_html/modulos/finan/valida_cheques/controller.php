<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../../finan/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $validacheque = get_mainObject('valida_cheques');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $validacheque_data = get_frontData();    
    $permiso = get_mainObject('General');

	if (!isset($_POST['busq'])){$validacheque_data['busq'] = "";}else{$validacheque_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "validacheque_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case VIEW_BADGE_CHEQUES:
			$validacheque->get_menu_count_chequesPendienteToValidate();
			if(count($validacheque->rows)-1>0)
			{	if($validacheque->rows[0]['cheques_pendientes']>0) print $validacheque->rows[0]['cheques_pendientes'];
			}
			break;
		case SET:
            $validacheque->set($validacheque_data);
            break;		
        case GET:
			$validacheque->get($validacheque_data['banc_codigo']);
            $data = array(
                'banc_codigo'=>$validacheque_data['banc_codigo'],
				'banc_nombre'=>$validacheque->banc_nombre
              );
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case APROBAR:
            $validacheque->aprobar($validacheque_data);
		   	$validacheque->get_all();
			if(count($validacheque->rows)>0)
			{	global $diccionario;
                $opciones["Aprobado"] = "<button type='button' class='btn btn-default'   onclick='js_validacheques_aprobar(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_approve' id='{codigo}_aprobar' onmouseover='$(".'"#{codigo}_aprobar"'.").tooltip(".'"show"'.")' title='Aprobar' data-placement='left'><span style='color:green;' class='fa fa-check'></span></button>";
				$opciones["Protestado"] = "<button type='button' class='btn btn-default' onclick='js_validacheques_protestar_add(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_protestar' onmouseover='$(".'"#{codigo}_protestar"'.").tooltip(".'"show"'.")' title='Protestar' data-placement='top'><span style='color:red;' class='fa fa-times'></span></button>";
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$validacheque->rows,
                                        "encabezado" => array("Ref.","Cod. Alumno","Alumno","No. Cheque","Banco","Girador","Fecha de Dep&oacute;sito","Monto","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"cheq_codigo");
			}
			else
			{	$data = array('mensaje'=>$validacheque->mensaje.$validacheque->ErrorToString());
			}
            retornar_result($data);
            break;
        case PROTESTAR:
            $validacheque->protestar($validacheque_data);
		   	$validacheque->get_all();
			if(count($validacheque->rows)>0)
			{	global $diccionario;
				$opciones["Aprobado"] = "<button type='button' class='btn btn-default'   onclick='js_validacheques_aprobar(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_approve' id='{codigo}_aprobar' onmouseover='$(".'"#{codigo}_aprobar"'.").tooltip(".'"show"'.")' title='Aprobar' data-placement='left'><span style='color:green;' class='fa fa-check'></span></button>";
				$opciones["Protestado"] = "<button type='button' class='btn btn-default' onclick='js_validacheques_protestar_add(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_protestar' onmouseover='$(".'"#{codigo}_protestar"'.").tooltip(".'"show"'.")' title='Protestar' data-placement='top'><span style='color:red;' class='fa fa-times'></span></button>";
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$validacheque->rows,
                                        "encabezado" => array("Ref.","Cod. Alumno","Alumno","No. Cheque","Banco","Girador","Fecha de Dep&oacute;sito","Monto","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"cheq_codigo");
			}
			else
			{	$data = array('mensaje'=>$validacheque->mensaje.$validacheque->ErrorToString());
			}
            retornar_result($data);
            break;
		case GET_ALL:
            $validacheque->get_all( $validacheque_data['filtro'] );
			
			if(count($validacheque->rows)>0)
			{	global $diccionario;
				$opciones["Aprobado"] = "<button type='button' class='btn btn-default'   onclick='js_validacheques_aprobar(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_approve' id='{codigo}_aprobar' onmouseover='$(".'"#{codigo}_aprobar"'.").tooltip(".'"show"'.")' title='Aprobar' data-placement='left'><span style='color:green;' class='fa fa-check'></span></button>";
				$opciones["Protestado"] = "<button type='button' class='btn btn-default' onclick='js_validacheques_protestar_add(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_protestar' onmouseover='$(".'"#{codigo}_protestar"'.").tooltip(".'"show"'.")' title='Protestar' data-placement='top'><span style='color:red;' class='fa fa-times'></span></button>";
				/*$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$validacheque->rows,
                                        "encabezado" => array("Ref.","Cod. Alumno","Alumno","No. Cheque","Banco","Girador","Fecha de Dep&oacute;sito","Monto","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"cheq_codigo");*/
				$html.= '<table class="table table-bordered table-hover" id="'.$tabla.'" name="'.$tabla.'">';
					$html.= '	<thead><tr>';
					$html.= '		<th>Ref.</th>';
					$html.= '		<th>Cod. Alumno</th>';
					$html.= '		<th>Alumno</th>';
					$html.= '		<th>No. Cheque</th>';
					$html.= '		<th>Banco</th>';
					$html.= '		<th>Girador</th>';
					$html.= '		<th>Fecha de Dep&oacute;sito</th>';
					$html.= '		<th>Monto</th>';
					$html.= '		<th>Opciones</th>';
					//$html.= '		<th>Observaciones</th>';
					$html.= '	</tr></thead>';
					$html.= '<tbody>';
					foreach ( $validacheque->rows as $row )
					{	if ( !empty( $row ) )
						{	$html.= '	<tr>';
							$c = 0;
							$codigo = "";
							foreach ( $row as $valor )
							{   if ( $c != 8 && $c != 9 )
									$html.= '	<td>'.$valor.'</td>';
								if ( $c == 0)
									$codigo = $valor;
								$c++;
							}
							$opciones["Aprobado"] = str_replace( "{codigo}", $codigo, $opciones["Aprobado"] );
							$opciones["Protestado"] = str_replace( "{codigo}", $codigo, $opciones["Protestado"] );
							if ( $validacheque_data['filtro'] == 'PF' || $validacheque_data['filtro'] == 'PV') 
							{   $html.= '		<td>'.$opciones["Aprobado"];
								$html.= 		  	  $opciones["Protestado"].'</td>';
							}
							else //if ( $validacheque_data['filtro'] == 'PR' )
							{   $html.= '		<td style="font-size:small;"> -N/A- </td>';
							}
							$html.= '	</tr>';
						}
					}
					$html.= '</tbody>';
				$html.= '</table>';
				$data['tabla'] = $html;
			}
			else
			{	$data = array('mensaje'=>$validacheque->mensaje.$validacheque->ErrorToString());
			}
            retornar_result($data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            
			$validacheque->get_all();
			
			if(count($validacheque->rows)>0)
			{	global $diccionario;
				$opciones["Aprobado"] = "<button type='button' class='btn btn-default'   onclick='js_validacheques_aprobar(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_approve' id='{codigo}_aprobar' onmouseover='$(".'"#{codigo}_aprobar"'.").tooltip(".'"show"'.")' title='Aprobar' data-placement='left'><span style='color:green;' class='fa fa-check'></span></button>";
				$opciones["Protestado"] = "<button type='button' class='btn btn-default' onclick='js_validacheques_protestar_add(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/valida_cheques/controller.php"'.")' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_protestar' onmouseover='$(".'"#{codigo}_protestar"'.").tooltip(".'"show"'.")' title='Protestar' data-placement='top'><span style='color:red;' class='fa fa-times'></span></button>";
				/*$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$validacheque->rows,
                                        "encabezado" => array("Ref.","Cod. Alumno","Alumno","No. Cheque","Banco","Girador","Fecha de Dep&oacute;sito","Monto","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"cheq_codigo");*/
				$html.= '<table class="table table-bordered table-hover" id="'.$tabla.'" name="'.$tabla.'">';
					$html.= '	<thead><tr>';
					$html.= '		<th>Ref.</th>';
					$html.= '		<th>Cod. Alumno</th>';
					$html.= '		<th>Alumno</th>';
					$html.= '		<th>No. Cheque</th>';
					$html.= '		<th>Banco</th>';
					$html.= '		<th>Girador</th>';
					$html.= '		<th>Fecha de Dep&oacute;sito</th>';
					$html.= '		<th>Monto</th>';
					$html.= '		<th>Opciones</th>';
					//$html.= '		<th>Observaciones</th>';
					$html.= '	</tr></thead>';
					$html.= '<tbody>';
					foreach ( $validacheque->rows as $row )
					{	if ( !empty( $row ) )
						{	$html.= '	<tr>';
							$c = 0;
							$codigo = "";
							foreach ( $row as $valor )
							{   if ( $c != 8 && $c != 9 )
									$html.= '	<td>'.$valor.'</td>';
								if ( $c == 0)
									$codigo = $valor;
								$c++;
							}
							$opciones["Aprobado"] = str_replace( "{codigo}", $codigo, $opciones["Aprobado"] );
							$opciones["Protestado"] = str_replace( "{codigo}", $codigo, $opciones["Protestado"] );
							$html.= '		<td>'.$opciones["Aprobado"];
							$html.= 		  	  $opciones["Protestado"].'</td>';
							$html.= '	</tr>';
						}
					}
					$html.= '</tbody>';
				$html.= '</table>';
				$data['tabla'] = $html;
			}
			else
			{	$data = array('mensaje'=>$validacheque->mensaje.$validacheque->ErrorToString());
			}
			retornar_vista(VIEW_GET_ALL, $data);
            break;
        default:
			echo 'Resultado desconocido';
			break;
    }
}
handler();
?>