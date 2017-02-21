<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{
    $reporte 	= get_mainObject('Rep_notaCredito');
    $event 		= get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $cobranza_data = get_frontData(); //Obtiene todas las variables obtenidas por POST o GET.
    $permiso 	= get_mainObject('General');//instancias para llamar al model. Dos veces porque hay case donde tienes que usar dos variables.
	$periodos	= get_mainObject('General');//
	$usuariosFinancieros = get_mainObject('General');//
	$cursos		= get_mainObject('General');
	$reporte_aux= get_mainObject('General');
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
		case PRINTREP_NOTACREDITO:
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reporte_notaCredito.pdf'"); //considerar... USUARIO, ALUMNO si tiene esa opcion...
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Nota de Cr&eacute;dito");
			$pdf->SetSubject("Reporte de Nota de Cr&eacute;dito");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$reporte->get_reporte_notaCredito($_GET['cajero'],'%',$_GET['fi'],$_GET['ff']);
			$fila = $reporte->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$html .= '<h2>Reporte de Nota de Cr&eacute;dito</h2> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h3>Reporte de Nota de Cr&eacute;dito</h3></td>';
			$html .='<td align="right">'.$reporte_aux->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$saldo_total=0;
			$html .= "<tr><td colspan=\"5\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td align=\"center\" width='20%'><font size=\"10\"><strong>Codigo</strong></font></td>";
			$html .= "<td align=\"center\" width='20%'><font size=\"10\"><strong>Factura</strong></font></td>";
			$html .= "<td align=\"center\" width='15%'><font size=\"10\"><strong>Total Neto Factura</strong></font></td>";
			$html .= "<td align=\"center\" width='20%'><font size=\"10\"><strong>Total Nota de Cr&eacute;dito</strong></font></td>";
			$html .= "<td align=\"center\" width='25%'><font size=\"10\"><strong>Fecha Emisi&oacute;n</strong></font></td>";
			$html .= "</tr>";

			/*  0 usua_codi,
				1 Caja,
				2 alum_codi,
				3 alumno,
				4 cedula representante
				5 codigo,
				6 numeroFactura,
				7 totalNetoFactura,
				8 codigoNotaCredito,
				9 totalNetoNC,
				10 FechaEmision

				
				Se muestran: 1, 3, 4, --5, 6, $8, $9, 10
			*/

			$usuario='';
			$alumno='';
			$cedula='';
			$total1=0;
			$total2=0;
			foreach($fila as $row)
			{	$col=0;
				foreach($row as $valor)
				{	if($col==1)
					{	if($valor!=$usuario)
						{	$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
							$html .= "<tr><td colspan=\"5\"><font size=\"12\"><b>Usuario:</b> ".$reporte_aux->PrimeraMayuscula($valor)."</font></td></tr>";
							$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
							$usuario=$valor;
						}
					}
					if($col==3)
					{	if($valor!=$alumno)
						{	$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$html .= "<tr height='100px'><td colspan=\"5\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=\"11\"><b>Cliente:</b> ".$reporte_aux->PrimeraMayuscula($valor)."</font></td></tr>";
							$alumno=$valor;
						}
					}
					if($col==4)
					{	if($valor!=$cedula)
						{	$html .= "<tr height='100px'><td colspan=\"5\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size=\"9\"><b>Ced. representante:</b> ".$valor."</font></td></tr>";
							$html .= "<tr><td colspan=\"5\"><br></td></tr>";
							$cedula=$valor;
						}
					}
					if($col==5)
					{	$html .= "<tr><td align=\"center\"><font >".$valor."</font></td>";
					}
					if($col==6)
					{	$html .= "<td align=\"center\"><font>".$valor."</font></td>";
					}
					if($col==7)
					{	$html .= "<td align=\"right\"><font>$".number_format($valor,2,'.',',')."</font></td>";
						$total1 = $total1 + $valor;
					}
					if($col==9)
					{	$html .= "<td align=\"right\"><font>$".number_format($valor,2,'.',',')."</font></td>";
						$total2 = $total2 + $valor;
					}
					if($col==10)
					{	$html .= "<td align=\"center\"><font>".$valor."</font></td>";
					}
					$col++;
				}
				$html .= "</tr>";
			}
			$html .= "<tr><td colspan=\"5\"><br></td></tr>";
			$html .= "<tr><td colspan=\"5\"><hr/></td></tr>";
			$html .= "<tr><td align=\"left\" valign=\"middle\">
								<font size=\"10\"><b>Total Facturas: </b></font></td><td></td>
							
							<td align=\"right\" valign=\"middle\"><b>$".number_format($total1,2,'.',',')."</b></td><td></td><td></td></tr>";
			$html .= "<tr><td align=\"left\" valign=\"middle\">
								<font size=\"9\"><b>Total Notas de Cr&eacute;itos: </b></font></td><td></td><td></td>
							
							<td align=\"right\" valign=\"middle\"><b>$".number_format($total2,2,'.',',')."</b></td><td></td></tr>";
			
			$html .= "</table>";
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reporte_notaCredito.pdf', 'I');
			break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			global $diccionario;
			//$periodos->get_all_periodos();
			$usuariosFinancieros->get_all_financial_users(1,'CAJA','A');
			//$reporte->get_all_cajeros();
			$today=new DateTime('today');
			$tomorrow=new DateTime('tomorrow');
            $data=array('txt_fecha_ini'=>$today->format('d/m/Y'),
						'txt_fecha_fin'=>$tomorrow->format('d/m/Y'),
						'{combo_cajero}' => array(	"elemento"  => 	"combo", 
													"datos"     => 	$usuariosFinancieros->rows, 
                                                    "options"   => 	array(	"name"=>"cmb_cajero",
																			"id"=>"cmb_cajero",
																			"class"=>"form-control",
																			"required"=>"required",
																			),
													"selected"  => 	0));
			
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		
		case GET_ALL_CURSOS_LIST:
			global $diccionario;
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