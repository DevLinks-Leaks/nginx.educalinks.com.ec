<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');

require_once('constants.php');
require_once('model.php');
require_once('view.php');


function handler() {
  $liquidez = get_mainObject('Liquidez');
  $event = get_actualEvents(array(VIEW_GET_ALL, GET_ALL_DATA), VIEW_GET_ALL);
  $becas =get_mainObject('Liquidez');
  $user_data = get_frontData();
  $permiso = get_mainObject('General');
  $bancos= get_mainObject('Liquidez');
  $anos= get_mainObject('Liquidez');
  $productos= get_mainObject('Liquidez');
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "liquidez_table";}else{$tabla =$_POST['tabla'];}
	if (!isset($_POST['tablabancos'])){$tablabancos = "tablabancos";}else{$tabla =$_POST['tablabancos'];}
    switch ($event) {
	  case VIEW_GET_ALL:
	      if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
          $liquidez->get_all($user_data['busq']);
		  $bancos->get_all_bancos();
		  $becas->get_becasdescuentos();
    			if(count($liquidez->rows)>0){
    				global $diccionario;
					$permiso->permiso_activo($_SESSION['usua_codigo'], 122);
					if ($permiso->rows[0]['veri']==1){
					  $data['disabled_generar_reporte']="";
					}else{
					  $data['disabled_generar_reporte']="disabled='disabled'";
					}
					
					$data['becas']= $becas->rows[0]['becasdescuentos'];
					$data['{tabla}']= array("elemento"=>"tabla",
									"clase"=>"table table-striped table-hover",
									"id"=>$tabla,
									"datos"=>$liquidez->rows,
									"encabezado" => array("Codigo",
														  "Nombre",
														  "Cuenta Contable",
														  "Tipo",
														  "Grupo",
														  "Opciones"),
														  "options"=>array($opciones),
														  "campo"=>"codigo");
														  
					 $data['{tabla_bancos}']= array("elemento"=>"tablaInputsencilla",
									"clase"=>"table table-striped table-hover",
									"id"=>$tablabancos,
									"datos"=>$bancos->rows,
									"encabezado" => array("SALDO EN BANCOS"),
														  "options"=>array($opciones),
														  "campo"=>"codigo");									 
					$data['mensaje'] = "Datos para el reporte:";
					
    			}else{
    				$data = array('mensaje'=>$liquidez->mensaje.$liquidez->ErrorToString());
    			}
    			retornar_vista(VIEW_REP_EDIT, $data);
          break;
      case GET_ALL_DATA:
            $liquidez->get_all($user_data['busq']);
            if(count($liquidez->rows)>0){
              global $diccionario;
              $permiso->permiso_activo($_SESSION['usua_codigo'], 122);
              if ($permiso->rows[0]['veri']==1){
                $data['disabled_generar_reporte']="";
              }else{
                $data['disabled_generar_reporte']="disabled='disabled'";
              }
              $data['{tabla}'] = array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$liquidez->rows,
                                        "encabezado" => array("Codigo",
                                                              "Nombre",
                                                              "Cuenta Contable",
                                                              "Tipo",
                                                              "Grupo",
                                                              "Opciones"),
                                                              "options"=>array($opciones),
                                                              "campo"=>"codigo");
              $data['mensaje'] = "Datos para el reporte:";
            }else{
              $data = array('mensaje'=>$liquidez->mensaje.$liquidez->ErrorToString());
            }

            retornar_result($data);
            break;
			
		case PRINTREP_LIQUIDEZ:
				header("Content-type:application/pdf");
				header("Content-Disposition:attachment;filename='Reporteliquidez.pdf'");
				
				$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetCreator("Redlinks");
				$pdf->SetAuthor("Redlinks");
				$pdf->SetTitle("Reporte de Liquidez");
				$pdf->SetSubject("Reporte de Liquidez");
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				$pdf->SetFont('Helvetica', '', 9, '', 'false');
				$pdf->AddPage('P', 'A4');//P:Portrait, L=Landscape
				
				$pdf->writeHTML($_SESSION['htmlLiquidez'], true, false, true, false, '');
				$pdf->Output('Reporteliquidez.pdf', 'I');
			
			break;
			
			case CREARHTML:
				
				$anos->get_all_anosanteriores();
				$bancos->get_all_bancos();
				$liquidez->get_rept_liquidez();
				$tranx=$liquidez->rows;
				$tranxanosanteriores=$anos->rows;
				$tranxbancos=$bancos->rows;
				$productos->get_all_productos('');
				$tranxproductos=$productos->rows;
				$porcentaje2=round(($user_data['sumabancos']*100)/$user_data['saldobancos'],2);
				$porcentaje3=round(($user_data['chequesgirados']*100)/$user_data['saldobancos'],2);
				$porcentaje4=round(($user_data['depositodia']*100)/$user_data['saldobancos'],2);
				$porcentaje5=round(($user_data['rolneto2quincena']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje6=round(($user_data['Desc2quincena']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje7=round(($user_data['IESS']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje8=round(($user_data['SRI']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje9=round(($user_data['bonificacion']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje10=round(($user_data['dividendoInversionista']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje11=round(($user_data['prestamos']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje12=round(($user_data['liqui_proveedores']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje13=round(($user_data['rol1quincena']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje14=round(($user_data['Desc1quincena']*100)/$user_data['sumacuentasxpagar'],2);
				$porcentaje15=round(($user_data['becasdescuentos']*100)/$cuentasxcobraractual,2);
				$porcentaje16=round(($user_data['tarjetas']*100)/$cuentasxcobraractual,2);
				$porcentaje17=round(($user_data['chequesposfechado']*100)/$cuentasxcobraractual,2);
				
				$datosbancos=array();
				$datosbancos=json_decode($user_data['bancovalores'], true);
				$cuentasxcobraractual=$tranx[0]['cuentasxcobrartotal']+$user_data['subtotal'];
			
				$liquidezaactual=$cuentasxcobraractual+$tranxanosanteriores[0]['carteravencida']+$user_data['saldobancos']-$user_data['sumacuentasxpagar'];
			
				$html = '<h2 align="center">Reporte de Liquidez al: '.$tranx[0]['fechactual'].' <br/> Usuario: '.$_SESSION['usua_codi'].'</h2><hr/> ';
				
			
				$html .='<table style="font-size:10px;" width="50%" border="0" cellspacing="0" cellpadding="0"> 
						<tr><td></td><td></td></tr>
						<tr><td width="215"><strong><font size="10">SALDO EN BANCOS:</font></strong>';
				
				$html .=' </td><td><strong><font size="12">$'.$user_data['saldobancos'].'</font></strong></td></tr>
						  <tr><td colspan="2"><hr/></td></tr>';
				for($i=0;$i<count($bancos->rows)-1;$i++){
				$porcentaje1=round(($datosbancos['valor'][$i]*100)/$user_data['saldobancos'],2);
				$html .='
				<tr>
				
						<td width="215">'.$datosbancos['nombre'][$i].'</td>
						<td width="100">$'.$datosbancos['valor'][$i].'</td>
						<td ><font size="7">'.$porcentaje1.'%</font></td></tr>
				';
				}
				$html .='<tr><td></td><td><hr/></td></tr>
						<tr>
						<td>SUMA TOTAL DE BANCOS</td>
						
						<td width="100">'.$user_data['sumabancos'].'</td>
						<td ><font size="7">'.$porcentaje2.'%</font></td>
						</tr>		
						<tr>
						<td width="215">-:CHEQ GIRADOS Y NO COBRADOS</td>
						<td>$'.$user_data['chequesgirados'].'</td>
						<td ><font size="7">'.$porcentaje3.'%</font></td>
						</tr>
						<tr>
						<td>DEPOSITOS DEL DIA</td>
						<td>$'.$user_data['depositodia'].'</td>
						<td ><font size="7">'.$porcentaje4.'%</font></td>
						</tr>
						';
						
				$html .='<tr><td></td><td></td></tr>				
						<tr><td width="215"><strong><font size="10">CARTERA VENCIDA</font></strong></td></tr>
						<tr><td colspan="2"><hr/></td></tr>';
						for($i=0;$i<count($anos->rows)-1;$i++){
						$porcentaje19=round(($user_data['cuentasxcobrar']*100)/$tranxanosanteriores[0]['carteravencida'],2);	
						$html .='
						<tr>
						
								<td width="215">CUENTAS POR COBRAR '.$tranxanosanteriores[$i]['nombre'].'</td>
								<td >$'.$tranxanosanteriores[$i]['cuentasxcobrar'].'</td>
								<td >'.$porcentaje19.'%</td>
								</tr>
						';
						}
			    $html .='<tr><td></td><td></td></tr>	
						<tr><td width="215"><strong>CARTERA VENCIDA</strong></td>
						<td width="215"><strong>'.$tranxanosanteriores[0]['carteravencida'].'</strong></td>
						
						</tr>
						
						
						
						
						';
				
				$html .='<tr><td></td><td></td></tr>				
						<tr><td width="215"><strong><font size="10">CUENTAS POR COBRAR '.$tranx[0]['periodoactivo'].'</font></strong></td></tr>
						 <tr><td colspan="2"><hr/></td></tr>';
						
						
						for($i=0;$i<count($liquidez->rows)-1;$i++){
						$porcentaje18=round(($tranx[$i]['cuentasxcobraractual']*100)/$cuentasxcobraractual,2);
						$html .='
						<tr>
							<td width="215">'.strtoupper ($tranx[$i]['prod_descripcion']).'</td>
							<td width="100">$'.$tranx[$i]['cuentasxcobraractual'].'</td>
							<td ><font size="7">'.$porcentaje18.'%</font></td>
							</tr>
						';
						}
			   $html .='<tr><td>BECAS Y DESCUENTOS</td>
						<td>-$'.$user_data['becasdescuentos'].'</td>
						<td ><font size="7">'.$porcentaje15.'%</font></td>
						</tr>
						<tr><td>TARJETAS</td>
						<td> $'.$user_data['tarjetas'].'</td>
						<td ><font size="7">'.$porcentaje16.'%</font></td>
						</tr>
						<tr><td>CHEQUES POS FECHADO</td>
						<td> $'.$user_data['chequesposfechado'].'</td>
						<td ><font size="7">'.$porcentaje17.'%</font></td>
						</tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SUB TOTAL</td>
						<td> '.$user_data['subtotal'].'</td></tr>
						<tr><td></td><td></td></tr>
						<tr><td width="215"><strong>CUENTAS POR COBRAR '.$tranx[0]['periodoactivo'].'</strong></td>
						<td> <strong>'.$cuentasxcobraractual.'</strong></td></tr>
						';
				
				
				$html .='<tr><td></td><td></td></tr>				
						<tr><td width="215"><strong><font size="10">CUENTAS POR PAGAR: ANEXO 3</font></strong></td></tr>
						<tr><td width="215"><strong><font size="10">CUENTAS POR PAGAR</font></strong></td></tr> 
						<tr><td colspan="2"><hr/></td></tr>
						<tr><td>ROL NETO PRIMERA QUINCENA</td>
						<td width="100">$'.$user_data['rol1quincena'].'</td>
						<td><font size="7">'.$porcentaje13.'%</font></td>
						</tr>
						<tr><td>DESC. A EMPLEADOS 1° QUINCENA</td>
						<td width="100">$'.$user_data['Desc1quincena'].'</td>
						<td><font size="7">'.$porcentaje14.'%</font></td>
						</tr>
						<tr><td>ROL NETO SEGUNDA QUINCENA</td>
						<td width="100">$'.$user_data['rolneto2quincena'].'</td>
						<td><font size="7">'.$porcentaje5.'%</font></td>
						</tr>
						<tr><td>DESC. A EMPLEADOS 2° QUINCENA</td>
						<td width="100">$'.$user_data['Desc2quincena'].'</td>
						<td><font size="7">'.$porcentaje6.'%</font></td>
						</tr>
						<tr><td>IESS 9.35% +12.15 PATRONAL</td>
						<td width="100">$'.$user_data['IESS'].'</td>
						<td><font size="7">'.$porcentaje7.'%</font></td>
						</tr>
						<tr><td>S.R.I</td>
						<td width="100">$'.$user_data['SRI'].'</td>
						<td><font size="7">'.$porcentaje8.'%</font></td>
						</tr>
						<tr><td>BONIFICACION</td>
						<td width="100">$'.$user_data['bonificacion'].'</td>
						<td><font size="7">'.$porcentaje9.'%</font></td>
						</tr>
						<tr><td>DIVIDENDO INVERSIONISTA</td>
						<td width="100">$'.$user_data['dividendoInversionista'].'</td>
						<td><font size="7">'.$porcentaje10.'%</font></td>
						</tr>
						<tr><td>PRESTAMOS</td>
						<td width="100">$'.$user_data['prestamos'].'</td>
						<td><font size="7">'.$porcentaje11.'%</font></td>
						</tr>
						<tr><td>PROVEEDORES</td>
						<td width="100">$'.$user_data['liqui_proveedores'].'</td>
						<td><font size="7">'.$porcentaje12.'%</font></td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr><td width="215"><strong>CUENTAS POR PAGAR: </strong>
						</td><td><strong>'.$user_data['sumacuentasxpagar'].'</strong></td></tr>
						<tr><td colspan="2"><hr/></td></tr>
						<tr><td width="215"><strong><font size="12">LIQUIDEZ ACTUAL </font></strong></td>
						<td><strong><font size="12">'.$liquidezaactual.'</font></strong></td></tr>
						
						
						';		
				
				
				
				
				
				
				
				$html .='</table>';
				
				

				$_SESSION['htmlLiquidez']=$html;
				
				echo 'OK';
			
			break;	
		case PRINTREPVISOR:
		 
			echo '<div class="embed-responsive embed-responsive-16by9">
				  	<iframe class="embed-responsive-liquidez" src="'.$user_data['url'].'"></iframe>
				  </div>';
			
			break;
        default:
        	 break;
    }
}

handler();
?>