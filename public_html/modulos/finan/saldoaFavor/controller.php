<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('/../clientes/model.php');

function handler()
{   $saldo 		= get_mainObject('saldoaFavor');
	$settings	= get_mainObject('saldoaFavor');
    $event 		= get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
									VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
									VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $saldo_data = get_frontData();    
    $permiso 	= get_mainObject('General');
	$fecha	 	= get_mainObject('General');
	$cliente 	= get_mainObject('General');
	$clientePDF = get_mainObject('Cliente');

	if (!isset($_POST['busq'])){$saldo_data['busq'] = "";}else{$saldo_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla= "banc_table";}else{$tabla=$_POST['tabla'];}

    switch ($event)
	{   case PRINTREPVISOR:
		 	echo '
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-deuda" src="'.$saldo_data['url'].'"></iframe>
				</div>';
			break;
		case SET:
			$concepto = 0;
			if ( $saldo_data['valor'] >= 0 )
				$concepto = 12; //Ingreso directo
			else
				$concepto = 21; //Marcado como devuelto
            $saldo->set($saldo_data['valor'], $saldo_data['alum_codi'], $saldo_data['observacion'], $concepto, $saldo_data['tipo_persona'] );
            break;
        case GET:
			$saldo->get($saldo_data['banc_codigo']);
            $data = array(
                'banc_codigo'=>$saldo_data['banc_codigo'],
				'banc_nombre'=>$saldo->banc_nombre
              );
			retornar_formulario(VIEW_EDIT, $data);
            break;
		case GET_ALL_DATA:
            $saldo->get_all( $saldo_data['cuales'] );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Balance"] = "<div align='center'>
												<button onclick='js_saldoaFavor_balancear(".'"{codigo}"'.")' class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_balance' id='{codigo}_devolver' onmouseover='$(this).tooltip(".'"show"'.")' title='Balancear' data-placement='left'><span class='fa fa-balance-scale cursorlink' ></span></button>&nbsp;";
					$opciones["Imprimir"] = "	<button onclick='js_saldoaFavor_rep_hist(".'"{codigo}"'.")'  class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_rep' id='{codigo}_print' onmouseover='$(this).tooltip(".'"show"'.")' title='Historial'><span class=' fa fa-print cursorlink' style='color:#4285F4;'></span></button>
											</div>";
                }
                else
                {   $opciones["Eliminar"]="";
                }

				$data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:12px'>Cod. cartera.</div>",
											"<div style='font-size:12px'>Código cliente</div>",
											"<div style='font-size:12px'>Tipo Persona</div>",
											"<div style='font-size:12px'>Cliente</div>",
											"<div style='font-size:12px'>Saldo a favor</div>",
											"<div style='font-size:12px'>Fecha de última modificación</div>",
											"<div style='font-size:12px'>Estado</div>",
											"<div style='font-size:12px'>Opciones</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"per_codi");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_result($data);
            break;
		case GET_SAF_HIST:
            $saldo->get_saf_historico( $saldo_data['cabeSaf_codigo'] );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				$opciones["nothing"]="";

				$data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>'safHistorico_table_'.$saldo_data['cabeSaf_codigo'],
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:small;'>No.</div>",
											"<div style='font-size:small;'>Concepto</div>",
											"<div style='font-size:small;'>Movimiento</div>",
											"<div style='font-size:small;'>Monto</div>",
											"<div style='font-size:small;'>Total anterior</div>",
											"<div style='font-size:small;'>Total post.</div>",
											"<div style='font-size:small;'>Doc. ref.</div>",
											"<div style='font-size:small;'>F. movimiento</div>",
											"<div style='font-size:small;'>Usuario</div>",
											"<div style='font-size:small;'>Observación</div>"),
                                        "campo"=>"codigo");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_result($data);
            break;
		case GET_SAF_HIST_PDF:
			global $diccionario;
            $hoy = getdate();
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename='Hist_saldoaFavor.pdf'");
				
			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator("Redlinks");
			$pdf->SetAuthor("Redlinks");
			$pdf->SetTitle("Saldos a favor");
			$pdf->SetSubject("Saldos a favor");
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->SetFont('Helvetica', '', 9, '', 'false');
			$clientePDF->get( $saldo_data['cc'], $saldo_data['tp'] );
			$saldo->get_saf_historico( $saldo_data['tdrgcd'] );
			$tranx = $saldo->rows;
			$pdf->AddPage('L', 'A4');//P:Portrait, L=Landscape
			$html .= '<h3>Saldos a Favor de<br>'.$clientePDF->rows[0]['nombres'].' '.$clientePDF->rows[0]['apellidos'].' <br><span style="font-size:small;">Código: '.
						$saldo_data['cc'].'. C.I.:'.$clientePDF->rows[0]['numeroIdentificacion'].'</span></h3> ';
			$html .='<table width="100%" cellspacing="0" cellpadding="2" border="0"><tr><td><h5>Fecha de impresi&oacute;n: '.
					$hoy['mon'].'/'.$hoy['mday'].'/'.$hoy['year'] .'. Usuario: '.$_SESSION['usua_codi'].'.</h3></td>';
			$html .='<td align="right">'.$fecha->get_fecha_head_reportes().'</td></tr></table>';
			$html .= '<hr style="height:5px;border:none;color:#333;background-color:#333;"/>';									
			$html .='<table cellspacing="0" cellpadding="2" border="0">';
			$col=0;
			// Datos
			$saldo_total=0;
			
			// Print
			$html .= "<tr><td colspan=\"10\"></td></tr>";
			$html .= "<tr>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>No.</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Concepto</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Movimiento</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Monto</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>T. anterior</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>T. posterior</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Doc. ref.</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Fecha movimiento</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Usuario</strong></font></td>";
			$html .= "<td align=\"center\"><font size=\"8\"><strong>Observación</strong></font></td>";
			$html .= "</tr>";
			$nivel='';
			for($i=0;$i<count($tranx)-1;$i++)
			{	$col=0;
				$html .= "<tr>";
				foreach($tranx[$i] as $valor)
				{	$col=$col+1;
					/*if( $col == 3 || $col == 4 || $col == 5 )
					{	$html .= "<td align=\"right\">".$valor."</font></td>";
					}
					else
					{   $html .= "<td ><font size=\"9\">".$valor."</font></td>";
					}*/
					$html .= "<td  align=\"center\"><font size=\"9\">".$valor."</font></td>";
				}
				$html .= "</tr>";
				
			}
			$html .= "<tr><td colspan=\"10\"><hr/></td></tr>";
			$html .= "</table>";
			
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Hist_saldoaFavor.pdf', 'I');
            break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $saldo->get_all( 'not_zero' );
			
			if(count($saldo->rows)>0)
			{   global $diccionario;
				
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Balance"] = "<div align='center'>
												<button onclick='js_saldoaFavor_balancear(".'"{codigo}"'.")' class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_balance' id='{codigo}_devolver' onmouseover='$(this).tooltip(".'"show"'.")' title='Balancear' data-placement='left'><span class='fa fa-balance-scale cursorlink' ></span></button>&nbsp;";
					$opciones["Imprimir"] = "	<button onclick='js_saldoaFavor_rep_hist(".'"{codigo}"'.")'  class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_rep' id='{codigo}_print' onmouseover='$(this).tooltip(".'"show"'.")' title='Historial'><span class=' fa fa-print cursorlink' style='color:#4285F4;'></span></button>
											</div>";
                }
                else
                {   $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 187);
                if ($permiso->rows[0]['veri']==1)
                {   $data['disabled_agregar_banco']="";
                } 
                else
                {   $data['disabled_agregar_banco']="disabled='disabled'";
                }

				$data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:12px'>Cod. cartera.</div>",
											"<div style='font-size:12px'>Código cliente</div>",
											"<div style='font-size:12px'>Tipo Persona</div>",
											"<div style='font-size:12px'>Cliente</div>",
											"<div style='font-size:12px'>Saldo a favor</div>",
											"<div style='font-size:12px'>Fecha de última modificación</div>",
											"<div style='font-size:12px'>Estado</div>",
											"<div style='font-size:12px'>Opciones</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"per_codi");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
		
			retornar_vista(VIEW_GET_ALL, $data);
            break;
		case VIEW_GET_CLIENT:
			# Presenta el modal de Busqueda del cliente
			$data = array('{tablaCliente}' => array("elemento"  => "tabla",
													"clase" 	=> "table table-striped table-hover",  
													"id"		=> "clientes_table",  
													"datos"     => array(),
													"encabezado"=> array("Codigo",
																		  "Identificacion",
																		  "Nombres"),
													"options"   => array(),
													"campo"  	=> ""));
		retornar_formulario(VIEW_GET_CLIENT, $data);
			break;
		case GET_CLIENT:
			# Consulta los clientes a traves de los filtros (nombres e identificacion) y devuelve la tabla con los resultados
			$cliente->get_clientes($saldo_data);
			$data = array('{tablaCliente}' => array("elemento"  => "tabla",
													"clase" 	=> "table table-striped table-hover",  
													"id"		=> "clientes_table",  
													"datos"     => $cliente->rows,
													"encabezado"=> array("Codigo",
																		  "Identificacion",
																		  "Nombres"),
													"options"   => array(),
													"campo"  	=> ""));
			retornar_result($data);
			break;
		case GET_SAF_SETTINGS:
			$settings->get_saldoafavor_config();
			echo $settings->saldoafavor;
			break;
		case SET_SAF_SETTINGS:
			$genera_sf = "";
			if ( $saldo_data['check_generar_Saf_NC'] == 'true' )
				$genera_sf = 'S';
			else
				$genera_sf = 'N';
			$settings->set_saldoafavor_config( $genera_sf );
			print_r($settings->mensaje);
			break;
		/*
		case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
        	break;
		case DELETE:
            $saldo->delete($saldo_data['banc_codigo']);
            $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			$saldo->get_all( 'not_zero' );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Balance"] = "<div align='center'>
												<button onclick='js_saldoaFavor_balancear(".'"{codigo}"'.")' class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_balance' id='{codigo}_devolver' onmouseover='$(this).tooltip(".'"show"'.")' title='Balancear' data-placement='left'><span class='fa fa-balance-scale cursorlink' ></span></button>&nbsp;";
					$opciones["Imprimir"] = "	<button onclick='js_saldoaFavor_rep_hist(".'"{codigo}"'.")'  class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_rep' id='{codigo}_print' onmouseover='$(this).tooltip(".'"show"'.")' title='Historial'><span class=' fa fa-print cursorlink' style='color:#4285F4;'></span></button>
											</div>";
                }
                else
                {   $opciones["Eliminar"]="";
                }

				$data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:12px'>Cod. cartera.</div>",
											"<div style='font-size:12px'>Código cliente</div>",
											"<div style='font-size:12px'>Tipo Persona</div>",
											"<div style='font-size:12px'>Cliente</div>",
											"<div style='font-size:12px'>Saldo a favor</div>",
											"<div style='font-size:12px'>Fecha de última modificación</div>",
											"<div style='font-size:12px'>Estado</div>",
											"<div style='font-size:12px'>Opciones</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"per_codi");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_result($data);
            break;
        case DEVOLVER:
            $saldo->saldo_marcar_como_devuelto($saldo_data['banc_codigo']);
            $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			$saldo->get_all( 'not_zero' );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Balance"] = "<div align='center'>
												<button onclick='js_saldoaFavor_balancear(".'"{codigo}"'.")' class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_balance' id='{codigo}_devolver' onmouseover='$(this).tooltip(".'"show"'.")' title='Balancear' data-placement='left'><span class='fa fa-balance-scale cursorlink' ></span></button>&nbsp;";
					$opciones["Imprimir"] = "	<button onclick='js_saldoaFavor_rep_hist(".'"{codigo}"'.")'  class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_rep' id='{codigo}_print' onmouseover='$(this).tooltip(".'"show"'.")' title='Historial'><span class=' fa fa-print cursorlink' style='color:#4285F4;'></span></button>
											</div>";
                }
                else
                {   $opciones["Eliminar"]="";
                }

				$data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:12px'>Cod. cartera.</div>",
											"<div style='font-size:12px'>Código cliente</div>",
											"<div style='font-size:12px'>Tipo Persona</div>",
											"<div style='font-size:12px'>Cliente</div>",
											"<div style='font-size:12px'>Saldo a favor</div>",
											"<div style='font-size:12px'>Fecha de última modificación</div>",
											"<div style='font-size:12px'>Estado</div>",
											"<div style='font-size:12px'>Opciones</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"per_codi");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_result($data);
            break;
        case EDIT:
            $saldo->edit($saldo_data);
            break;
		case GET_ALL:
            $saldo->get_all( 'not_zero' );
			if(count($saldo->rows)>0)
			{   global $diccionario;
				
                $permiso->permiso_activo($_SESSION['usua_codigo'], 189);
                if ($permiso->rows[0]['veri']==1)
                {   $opciones["Balance"] = "<div align='center'>
												<button onclick='js_saldoaFavor_balancear(".'"{codigo}"'.")' class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_balance' id='{codigo}_devolver' onmouseover='$(this).tooltip(".'"show"'.")' title='Balancear' data-placement='left'><span class='fa fa-balance-scale cursorlink' ></span></button>&nbsp;";
					$opciones["Imprimir"] = "	<button onclick='js_saldoaFavor_rep_hist(".'"{codigo}"'.")'  class='btn btn-default' aria-hidden='true' data-toggle='modal' data-target='#modal_rep' id='{codigo}_print' onmouseover='$(this).tooltip(".'"show"'.")' title='Historial'><span class=' fa fa-print cursorlink' style='color:#4285F4;'></span></button>
											</div>";
                }
                else
                {   $opciones["Eliminar"]="";
                }

				$data['{tabla}']= array("elemento"=>"tabla_anidada",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$saldo->rows,
                                        "encabezado" => array(
											"<div style='font-size:12px'>Cod. cartera.</div>",
											"<div style='font-size:12px'>Código cliente</div>",
											"<div style='font-size:12px'>Tipo Persona</div>",
											"<div style='font-size:12px'>Cliente</div>",
											"<div style='font-size:12px'>Saldo a favor</div>",
											"<div style='font-size:12px'>Fecha de última modificación</div>",
											"<div style='font-size:12px'>Estado</div>",
											"<div style='font-size:12px'>Opciones</div>"),
                                        "options"=>array($opciones),
                                        "campo"=>"per_codi");
			}
			else
			{   $data = array('mensaje'=>$saldo->mensaje.$saldo->ErrorToString());
			}
            retornar_vista(VIEW_GET_ALL, $data);
            break;*/
    }
}
handler();
?>