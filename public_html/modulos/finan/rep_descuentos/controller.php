<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../tipo_descuento/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $reporte = get_mainObject('Rep_descuentos');
	$descuento = get_mainObject('DescuentosTipo');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $banco_data = get_frontData();    
    $permiso = get_mainObject('General');
	$periodos= get_mainObject('General');
	if (!isset($_POST['busq'])){$banco_data['busq'] = "";}else{$banco_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $banco->set($banco_data);
            break;		
        case GET:
			$banco->get($banco_data['banc_codigo']);
            $data = array(
                'banc_codigo'=>$banco_data['banc_codigo'],
				'banc_nombre'=>$banco->banc_nombre
              );
			retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $banco->delete($banco_data['banc_codigo']);
            $data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			$banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 188);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
            retornar_result($data);
            break;
        case EDIT:
            $banco->edit($banco_data);
            break;
		case GET_ALL:
            $banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 188);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
            retornar_vista(VIEW_GET_ALL, $data);
            break;
		case GET_ALL_DATA:
            $banco->get_all($banco_data['busq']);
			if(count($banco->rows)>0){
				global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 188);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {
                    $data['disabled_agregar_banco']="";
                } 
                else
                {
                    $data['disabled_agregar_banco']="disabled='disabled'";
                }
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
                                        "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
			}else{
				$data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
			}
            retornar_result($data);
            break;
			case PRINTREPVISOR:
		 	
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-deuda" src="'.$banco_data['url'].'"></iframe>
					
				  </div>';
			
			break;
		case PRINTREP_DESCUENTOS:
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reportedescuentos.pdf'");
			
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Descuentos Otorgados");
			$pdf->SetSubject("Reporte de Descuentos Otorgados");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');			
			
			$reporte->get_reportedescuentos($_GET['periodos'], $_GET['curso'], $_GET['tipo_descuentos']);

			$tranx = $reporte->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			
			$html .= '<h2>Reporte de Descuentos Otorgados </h2> ';	 
			$html .= '<h3>Reporte de Descuentos Otorgados</h3> ';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .= '<table cellspacing="0" cellpadding="2" border="0" width="100%">';
			
			//Datos
			$cursoactual="";
			$contadorcabec=0; 
			$grupo="";
			$sumatotal=0;
			$sumatoria=0;
			$col=0;
			
			$colspan=0;
			foreach($tranx[0] as $valor)
			{	$colspan++;
			}
			$html .= "<tr><td colspan=\"4\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td style=\"width:15%;text-align:left\"><font size=\"12\"><strong>Código</strong></font></td>";
			$html .= "<td style=\"width:50%;text-align:left\"><font size=\"12\"><strong>Nombre</strong></font></td>";
			$html .= "<td style=\"width:20%;text-align:left\"><font size=\"12\"><strong>Curso</strong></font></td>";
			$html .= "<td style=\"width:15%;text-align:right\"><font size=\"12\"><strong>Porcentaje</strong></font></td>";
			$html .= "</tr>";
			$html .= "<tr><td colspan=\"4\"><hr/></td></tr>";
			$desc_codigo_anterior='';
			$desc_codigo=0;
			$peri_codi=0;
			foreach($tranx as $row)
			{	$col=0;
				foreach($row as $valor)
				{	if($col==0)
					{	if ($valor!=$peri_codi)
						{	$peri_codi=$valor;
							$html .= "<tr><td colspan=\"4\"><font size=\"10\"><strong>Per&iacute;odo:</strong> ".$valor."</font></td></tr>";
							$html .= "<tr><td colspan=\"4\"><br></td></tr>";
						}
					}
					if($col==1) $desc_codigo=$valor;
					if($col==2)
					{	if ($desc_codigo!=$desc_codigo_anterior)
						{	$desc_codigo_anterior=$desc_codigo;
							$html .= "<tr><td colspan=\"4\"><hr/></td></tr>";
							$html .= "<tr><td colspan=\"4\"><font size=\"10\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Tipo de descuento:</strong> ".$valor."</font></td></tr>";
							$html .= "<tr><td colspan=\"4\"><br></td></tr>";
						}
					}
					if($col==3)
					{	$html .= "<tr><td><font size=\"9\">".$valor."</font></td>";
					}
					if($col==4)
					{	$html .= "<td><font size=\"9\">".$valor."</font></td>";
					}
					if($col==5)
					{	$html .= "<td><font size=\"9\">".$valor."</font></td>";
					}
					if($col==6)
					{	$html .= "<td style=\"text-align:right\"><font size=\"9\">".$valor."</font></td>";					
					}
					$col++;
				}
				$html .= "</tr>";
			}
			$html .= "<tr><td colspan=\"4\"><hr/></td></tr>";
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reportedescuentos.pdf', 'I');
			break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
			global $diccionario;
			$periodos->get_all_periodos();
			$descuento->getDscto_selectFormat();
            $data=array('{combo_periodo}' => array(	"elemento"  => 	"combo", 
													"datos"     => 	$periodos->rows, 
                                                    "options"   => 	array(	"name"=>"periodos",
																			"id"=>"periodos",
																			"required"=>"required",
																			"class"=>"form-control",
																			"onChange"	=>	"cargaCursos('comboCursos','".$diccionario['rutas_head']['ruta_html_finan']."/rep_saldosafavor/controller.php')"),
													"selected"  => 	0),
						'{combo_curso}' => array(	"elemento"  => 	"combo", 
													"datos"     => array(0 => array(0 => -1, 
                                                                                        1 => 'Seleccione...',
                                                                                        3 => ''), 
                                                                            1=> array()),
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"curso",
																			"class"=>"form-control",
																			"required"=>"required",
																			"onChange"	=>	""),
													"selected"  => 	0),
						'{combo_tipo_descuento}' => array(
												"elemento"  => "combo", 
                                                "datos"     => $descuento->rows, 
                                                "options"   => array(
																"name"=>"cmb_descuentos",
																"id"=>"cmb_tipo_descuentos",
																"required"=>"required",
																"class"=>"form-control",
																"onChange"=>""),
												"selected"  => 0));
		
		

			
			
			
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
        default:
			$banco->get_all($banco_data['busq']);
                if(count($banco->rows)>0){
					global $diccionario;
					$opciones = array("Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'>&nbsp;</span>",
                                      "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/bancos/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'>&nbsp;</span>");
				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$banco->rows,
       								    "encabezado" => array("Código de Banco","Nombre","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"banc_codigo");
                }else{
                    $data = array('mensaje'=>$banco->mensaje.$banco->ErrorToString());
                }
				
            retornar_vista($event, $data);
			break;
    }
}

handler();
?>