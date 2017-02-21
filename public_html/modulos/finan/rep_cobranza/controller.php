<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('/../cobranza/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{
    $reporte 	= get_mainObject('Rep_cobranza');
    $event 		= get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $cobranza_data = get_frontData(); //Obtiene todas las variables obtenidas por POST o GET.
    $permiso 	= get_mainObject('General');//instancias para llamar al model. Dos veces porque hay case donde tienes que usar dos variables.
	$periodos	= get_mainObject('General');//
	$usuariosFinancieros = get_mainObject('General');//
	$cursos		= get_mainObject('General');
	$reporte_aux= get_mainObject('General');
	$cobranza = get_mainObject('Cobranzas');
	if (!isset($_POST['busq'])){$cobr_data['busq'] = "";}else{$cobr_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla= "cobr_table";}else{$tabla=$_POST['tabla'];}

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
        case EDIT:
            $banco->edit($banco_data);
            break;
		case PRINTREPVISOR:
			echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-deuda" src="'.$cobranza_data['url'].'"></iframe>
				</div>';
			break;
		case PRINTREP_COBRANZA:
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reporte_cobranza.pdf'"); //considerar... USUARIO, ALUMNO si tiene esa opcion...
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte Cobranza");
			$pdf->SetSubject("Reporte de Cobranza");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$reporte->get_reportecobranza($_GET['usrfn'],'%',$_GET['fi'],$_GET['ff']);
			//$reporte->get_reportecobranza($_GET['usuarioFinanciero'],$_GET['fechaInicio'],$_GET['fechaFin']);
			$fila = $reporte->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$html .= '<h2>Reporte de Cobranza</h2> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h3>Reporte de Cobranza</h3></td>';
			$html .='<td align="right">'.$reporte_aux->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$saldo_total=0;
			$html .= "<tr><td colspan=\"5\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Descripci&oacute;n</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Detalle</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Deuda pendiente</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Observaciones</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"10\"><strong>Fecha</strong></font></td>";
			$html .= "</tr>";

			/*  0 usua_codi,
				1 usuarioFinan,
				2 alum_codi,
				3 alumno,
				4 acerca_codigo,
				5 crm_resu_descripcion,
				6 deta_crm_resu_descripcion,
				7 deuda,
				8 observaciones,
				9 fecha */
				
			$usuario='';
			$alumno='';
			$total=0;
			
			for($i=0;$i<count($fila)-1;$i++)
			{	$col=0;
				$usuario_actual="";
				foreach($fila[$i] as $valor)
				{	
					if($col==1)
					{	$usuario_actual=$valor;
						if($valor!=$usuario)
						{	$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
							$html .= "<tr><td colspan=\"5\"><font size=\"12\"><b>Usuario:</b> ".$reporte_aux->PrimeraMayuscula($valor)."</font></td></tr>";
							$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
							$usuario=$valor;
						}
					}
					if($col==3)
					{	if($valor!=$alumno)
						{	$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr height='100px'><td colspan=\"5\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=\"10\"><b>Alumno:</b> ".$reporte_aux->PrimeraMayuscula($valor)."</font></td></tr>";
							$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$alumno=$valor;
						}
					}
					if($col==5)
					{	$html .= "<tr><td align=\"center\"><font>".$valor."</font></td>";
					}
					if($col==6)
					{	$html .= "<td align=\"center\"><font>".$valor."</font></td>";
					}
					if($col==7)
					{	$html .= "<td align=\"right\"><font>$ ".number_format($valor,2,'.',',')."</font></td>";
						$total = $total + $valor;
					}
					if($col==8)
					{	$html .= "<td align=\"left\"><font>".$valor."</font></td>";
					}
					if($col==9)
					{	$fecha = explode('-',$valor);
						$valor_result = $fecha[2].' de '.$meses[(int)$fecha[1]-1].', '.$fecha[0]. '.';
						$html .= "<td align=\"center\"><font>".$valor_result."</font></td>";
					}
					$col++;
				}
				$html .= "</tr>";
			}
			$html .= "<tr><td colspan=\"5\"><br></td></tr>";
			$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
			$html .= "<tr><td align=\"left\" valign=\"middle\">
								<font size=\"11\"><b>Total Cobranzas: </b></font></td><td></td>
							
							<td align=\"right\" valign=\"middle\"><b>$".number_format($total,2,'.',',')."</b></td><td></td></tr>";
			
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte_cobranza.pdf', 'I');
			break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			global $diccionario;
			//$periodos->get_all_periodos();
			$usuariosFinancieros->get_all_financial_users(1, '%', 'A');
			$today=new DateTime('today');
			$tomorrow=new DateTime('tomorrow');
            $data=array('txt_fecha_ini'=>$today->format('d/m/Y'),
						'txt_fecha_fin'=>$tomorrow->format('d/m/Y'),
						'{combo_usuario}' => array(	"elemento"  => 	"combo", 
													"datos"     => 	$usuariosFinancieros->rows, 
                                                    "options"   => 	array(	"name"=>"cmb_usuaFinan",
																			"id"=>"cmb_usuaFinan",
																			"required"=>"required",
																			"class"=>"form-control",
																			//"onChange"	=>	"cargaTabla('div_tablaAlumnos','".$diccionario['rutas_head']['ruta_html']."/rep_cobranza/controller.php')"
																			),
													"selected"  => 	0));
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            /*$cobranza->get_all($cobr_data['busq']);
            if(count($cobranza->rows)>0)
			{   global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 174);
                if ($permiso->rows[0]['veri']==1)
                {
                    $opciones["Acercamiento"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_crm_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/rep_cobranza/controller.php"'.")' class='glyphicon glyphicon-phone-alt cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_crm'id='{codigo}_crm'onmouseover='$(".'"#{codigo}_crm"'.").tooltip(".'"show"'.")' title='Reporte individual'>&nbsp;</span>";
                }
                else
                {
                    $opciones["Acercamiento"] = "";
                }
                $data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$cobranza->rows,
                                        "encabezado" => array("Código","Nombre","Deuda Pendiente","Fecha Vencido","Fecha Seguimiento","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"alum_codi");
            }
			else
			{   $data = array('mensaje'=>$cobranza->mensaje.$cobranza->ErrorToString());
            }*/
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		
		case GET_ALL_CURSOS_LIST:
			global $diccionario;
			//var_dump($cobranza_data);
			$cursos->get_all_cursos($cobranza_data['cod_peri']);
            $data['{combo}'] = array(				"elemento"  => 	"combo", 
													"datos"     => 	$cursos->rows, 
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"cursos",
																			"required"=>"required",
																			//"onChange"	=>	""
																			),
													"selected"  => 	0);
			retornar_result($data);
            break;

		case GET_ALL_CURSOS_BY_ECON_LEVEL_LIST:
			global $diccionario;
			//var_dump($cobranza_data);
			$cursos->get_all_cursos_by_econ_level($cobranza_data['cod_peri'],$cobranza_data['nivel_economico']);
            $data['{combo}'] = array(				"elemento"  => 	"combo", 
													"datos"     => 	$cursos->rows, 
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"cursos",
																			"required"=>"required",
																			"onChange"	=>	""),
													"selected"  => 	0);
			retornar_result($data);
            break;

		
		case VIEW_SET:
		
            retornar_formulario(VIEW_SET, $data);
        	break;
    }
}

handler();
?>