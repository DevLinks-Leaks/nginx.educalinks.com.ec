<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{
    $reporte 	= get_mainObject('Rep_saldosafavor');
    $event 		= get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                        VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                        VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $saldosafavor_data = get_frontData(); //Obtiene todas las variables obtenidas por POST o GET.
    $permiso 	= get_mainObject('General');//instancias para llamar al model. Dos veces porque hay case donde tienes que usar dos variables.
	$periodos	= get_mainObject('General');
	$niveles	= get_mainObject('General');
	$cursos		= get_mainObject('General');
	$fecha		= get_mainObject('General');
	$reporte_aux= get_mainObject('General');
	if (!isset($_POST['busq']))
	{	$banco_data['busq'] = "";
	}else{
		$banco_data['busq'] = $_POST['busq'];
	}
	if (!isset($_POST['tabla']))
	{	$tabla= "banc_table";
	}else{
		$tabla=$_POST['tabla'];
	}

    switch ($event) {
        case PRINTREPVISOR:
		 	
			echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-deuda" src="'.$saldosafavor_data['url'].'"></iframe>
				</div>';
			
			break;
		case PRINTREP_SALDOSAFAVOR:
			$hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Reportesaldosafavor.pdf'");
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Reporte de Saldos a favor");
			$pdf->SetSubject("Reporte de Saldos a favor");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			
			$reporte->get_reportesaldosafavor($_GET['periodofinal'],$_GET['nivelEcon'],$_GET['curso']);
			$tranx = $reporte->rows;
			$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
			$html .= '<h2>Reporte de Saldos a favor </h2> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h5>Fecha de impresi&oacute;n: '.
					$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3></td>';
			$html .='<td align="right">'.$fecha->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$col=0;
			// Datos
			$saldo_total=0;
			
			// Print
			$html .= "<tr><td colspan=\"6\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td><font size=\"12\"><strong>Código</strong></font></td>";
			$html .= "<td colspan=\"2\"><font size=\"12\" ><strong>Nombre</strong></font></td>";
			$html .= "<td><font size=\"12\"><strong>Curso</strong></font></td>";
			$html .= "<td align=\"right\"><font size=\"12\"><strong>Saldo</strong></font></td>";
			$html .= "<td align=\"right\"><font size=\"12\"><strong>Estado</strong></font></td>";
			$html .= "</tr>";
			$nivel='';
			for($i=0;$i<count($tranx)-1;$i++)
			{	
				$col=0;
				
				foreach($tranx[$i] as $valor)
				{	$col=$col+1;
					if($col==1)
					{
						if($valor!=$nivel)
						{	$html .= "<tr><td colspan=\"6\"><hr/></td></tr>";
							$html .= "<tr><td colspan=\"6\"><font size=\"10\">Nivel Económico: ".$valor."</font></td></tr>";
							$html .= "<tr><td colspan=\"6\"><hr/></td></tr>";
							$nivel=$valor;
							$html .= "<tr>";
						}else
						{	$html .= "<tr>";
					}
					}
					if($col==3)
					{
						$html .= "<td colspan=\"2\"><font size=\"9\">".$valor."</font></td>";
					}
					else
					{
						if($col==5)
						{	$saldo_total+=$valor;
							$html .= "<td align=\"right\"><font size=\"9\">$ ".number_format($valor,2,'.',',')."</font></td>";
						}
						else
						{
							if ($col!=1) $html .= "<td ><font size=\"9\">".$valor."</font></td>";					
						}
					}
				}
				$html .= "</tr>";
				
			}
			$html .= "<tr><td colspan=\"6\"><hr/></td></tr>";
			$html .= "<tr>";
			$html .= "<td><font size=\"10\"><strong>Total</strong></font></td>";
			$html .= "<td colspan=\"2\"></td>";
			$html .= "<td></td>";
			$html .= "<td align=\"right\"><font size=\"10\"><strong>$ ".number_format($saldo_total,2,'.',',')."</strong></font></td>";
			$html .= "</tr>";
			$html .= "</table>";
			
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Reportesaldosafavor.pdf', 'I');
			
			break;
		case VIEW_GET_ALL:
			
			if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			global $diccionario;
			$periodos->get_all_periodos();
			$niveles->get_all_niveles_economicos();
            $data=array('{combo_periodo}' => array(	"elemento"  => 	"combo", 
													"datos"     => 	$periodos->rows, 
                                                    "options"   => 	array(	"name"=>"periodos",
																			"id"=>"periodos",
																			"class"=>"input-sm",
																			"required"=>"required",
																			"onChange"	=>	"cargaCursos('comboCursos','".$diccionario['rutas_head']['ruta_html_finan']."/rep_saldosafavor/controller.php')"),
													"selected"  => 	0),
						'{combo_nivel}' => array(	"elemento"  => 	"combo", 
													"datos"     => 	$niveles->rows, 
                                                    "options"   => 	array(	"name"=>"cmb_nivelesEconomicos",
																			"id"=>"cmb_nivelesEconomicos",
																			"class"=>"input-sm",
																			"required"=>"required",
																			"onChange"	=>	"cargaCursosPorNivelEconomico('comboCursos','".$diccionario['rutas_head']['ruta_html_finan']."/general/controller.php')"),
													"selected"  => 	0),
						'{combo_curso}' => array(	"elemento"  => 	"combo", 
													"datos"     => array(0 => array(0 => -1, 
                                                                                        1 => '- Seleccione curso -',
                                                                                        3 => ''), 
                                                                            1=> array()),
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"curso",
																			"class"=>"input-sm",
																			"required"=>"required",
																			"onChange"	=>	""),
													"selected"  => 	0));
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		
		case GET_ALL_CURSOS_LIST:
			global $diccionario;
			//var_dump($saldosafavor_data);
			$cursos->get_all_cursos($saldosafavor_data['cod_peri']);
            $data['{combo}'] = array(				"elemento"  => 	"combo", 
													"datos"     => 	$cursos->rows, 
                                                    "options"   => 	array(	"name"=>"cursos",
																			"id"=>"curso",
																			"class"=>"input-sm",
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