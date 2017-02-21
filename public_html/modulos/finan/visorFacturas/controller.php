<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('../general/model.php');
require_once('constants.php');
require_once('../facturas/model.php');
require_once('model.php');
require_once('view.php');

require_once('/../../../core/modelHTML.php');

include_once('../../../framework/switch.php');

function handler() {
    require('/../../../core/rutas.php');
    $permiso = get_mainObject('General');
    $event = get_actualEvents(array(INDEX, LOGIN, VIEW_MAIN, LOGOUT), VIEW_MAIN);
    $user_data = get_frontData();

    if (!isset($_POST['tabla'])){$tabla = "facturasAutorizadas_table";}else{$tabla =$_POST['tabla'];}

    switch ($event) {
        case INDEX:
            $_SESSION['IN']="KO";
            $_SESSION['ERROR_MSG']="Por favor inicie sesión";
            header("Location:".$ruta_visor);
            break;

		case LOGIN:
            // Obtengo información de la base de datos correcta a la que se debe redireccionar
            get_database_params();
            $_SESSION['dbname'] = $_SESSION['db'];
            $visorFacturas = new visorFacturas();
            $visorFacturas->existeCliente($user_data["cliente_numeroIdentificacion"]);
            if(count($visorFacturas->rows) > 0){
                if($visorFacturas->claveCliente != ""){
                    $visorFacturas->rows = array();
                    $visorFacturas->login($user_data["cliente_numeroIdentificacion"], $user_data["cliente_clave"]);
                    if(count($visorFacturas->rows) > 0){
                        // CREDENCIALES CORRECTAS
                        global $diccionario;
						//var_dump($visorFacturas);
                        $_SESSION['IN']="OK";
                        $_SESSION['usua_codigo']=$visorFacturas->codigoCliente;
                        $_SESSION['usua_nombres']=primeraMayuscula(strtolower($visorFacturas->nombresCliente));
                        $_SESSION['usua_apellidos']=primeraMayuscula(strtolower($visorFacturas->apellidosCliente));
                        $_SESSION['usua_numeroIdentificacion']=$visorFacturas->numeroIdentificacionCliente;
                        $_SESSION['usua_estado']=$visorFacturas->estadoCliente;
						
                        $factura = new Factura();
						$factura->get_facturas('AUTORIZADO', '', '','', $_SESSION['usua_numeroIdentificacion'], '', '','', '', '', '', '','P', '0', '0');
						$data['tabla'] = tablaFacturaAutorizada($tabla, $factura, $permiso, 'FAC');
						$diccionario['usua_datos']=array("usua_nombres"		=>primeraMayuscula(strtolower($visorFacturas->nombresCliente)),
														 "usua_apellidos"	=>primeraMayuscula(strtolower($visorFacturas->apellidosCliente)));
						
						$_SESSION['usua_codigo']=$visorFacturas->codigoCliente;
						
						$data['numeroIdentificacion']=$_SESSION['usua_numeroIdentificacion'];
						$data["ruta_logoEmpresa"] = $print_ruta_logo_desarrollo;
						$data["mensaje"] = "Titular: " . primeraMayuscula(strtolower($visorFacturas->nombresCliente)) ." ". primeraMayuscula(strtolower($visorFacturas->apellidosCliente))."";
                        retornar_vistaVisor(VIEW_MAIN, $data);
                    }
					else
					{	// CREDENCIALES INCORRECTAS
                        $_SESSION['IN']="KO";
                        $_SESSION['ERROR_MSG']="Credenciales incorrectas.";
                        header("Location:".$ruta_visor);
                    }
                }
				else
				{	// NO TIENE ASIGNADO UNA CLAVE
                    $_SESSION['IN']="KO";
                    $_SESSION['ERROR_MSG']="Cliente no tiene creada la clave";
                    $data['mensaje']="";
                    retornar_vistaVisor(VIEW_CREATE_PASS, $data);
                }
            }
			else
			{	// NO EXISTE UN CLIENTE CON TAL NUMERO DE IDENTIFICACION
                $_SESSION['IN']="KO";
                $_SESSION['ERROR_MSG']="No existe ningún cliente con ese número de identificación.";
                header("Location:".$ruta_visor);
            }
            break;
        case LOGOUT:
            if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$ruta_visor);}

            $_SESSION['IN'] = "KO";
            $_SESSION['usua_codigo'] = "";
            $_SESSION['usua_nombres'] = "";
            $_SESSION['usua_apellidos'] = "";
            $_SESSION['usua_numeroIdentificacion'] = "";
            $_SESSION['usua_estado'] = "";

            session_unset();
            session_destroy();
            header("Location:".$ruta_visor);
            break;
        case VIEW_CHANGE_PASS:

            retornar_vistaVisor(VIEW_CHANGE_PASS, array());
            break;
        case CHANGE_PASS:

            break;
        default:
            $_SESSION['IN']="KO";
            $_SESSION['ERROR_MSG']="Por favor inicie sesión";
            header("Location:".$ruta_visor);
            break;
    }
}

handler();
function tablaFacturaAutorizada($tabla, $factura, $permiso, $tipo_documento)
{	global $diccionario;
	if ($tipo_documento=='FAC')
	{	$dir_tdoc_detail='factura';
	}
	else if ($tipo_documento=='NC')
	{	$dir_tdoc_detail='notaCredito';
	}
	else if ($tipo_documento=='ND')
	{	$dir_tdoc_detail='notaDebito';
	}
	$opciones="";
	$construct_table="
				<br>
				<table class='table table-bordered table-hover' id='".$tabla."'>
					<thead><tr>
						<th style='font-size:small;text-align:center;'>Ref.</th>
						<th style='font-size:small;text-align:center;'>Datos</th>
						<th style='font-size:small;text-align:center;'>T. Neto</th>
						<th style='font-size:small;text-align:center;'>C&oacute;digo</th>
						<th style='font-size:small;text-align:center;'>Estudiante</th>
						<th style='font-size:small;text-align:center;'>F. Emisión</th>
						<th style='font-size:small;text-align:center;'>Estado</th>
						<th style='font-size:small;text-align:center;'>Mail</th>
						<th style='font-size:small;text-align:center;'>XML</th>
						<th style='font-size:small;text-align:center;'>PDF</th>
						<th style='font-size:small;text-align:center;'>HTML</th>
					</tr></thead>";
	$body="<tbody>";
	$c=0;
	$aux=0;
	$archivo="";
	$archivoPDF = "";
	$archivoXML = "";
	$codigo="";
	$cedula="";
	foreach($factura->rows as $row)
	{	$aux++;
	}
	foreach($factura->rows as $row)
	{	if($c<($aux-1))
		{	$body.="<tr>";
			$x=0;
			$datos="";
			foreach($row as $column)
			{	if($x==1)
				{	$datos.="<div style=\"text-align:left;\">".
								"<table><tr><td style=\"vertical-align:top;\"><b>Titular:&nbsp;</b></td><td>". $column."</td></tr>";
				}
				elseif($x==2)
				{	$datos.="<tr><td><b>C&eacute;dula:&nbsp;</b></td><td>". $column."</td></tr>";
					$cedula = $column;
				}
				elseif($x==3)
				{	$archivo = $column;
				}
				elseif($x==4)
				{	$archivo.= "-" . $column;
				}
				elseif($x==5)
				{	$archivo.= "-" . $column;
					$datos.="<tr><td><b>".$tipo_documento.":&nbsp;</b></td><td>". $archivo."</td></tr></table></div>";
				}
				elseif($x==6)
				{	$body.= "<td style='font-size:small;'>".
								"<span class='detalle' id='".$codigo."_cliente_direccion' onmouseover='$(this).tooltip(".'"show"'.")' title='".$datos."' data-placement='bottom'>".
									"<span class='glyphicon glyphicon-search'></span></span></td>";
					$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
				}
				elseif($x==11)
				{	//: do nothing
				}
				else
				{	$body.="<td><div style='font-size:11px;'>".$column."</div></td>";
					if($x==0)
					{	$codigo = $column;
					}
				}
				$x++;
			}
			$dir_archivos = $ruta_visor."/documentos/autorizados/".$_SESSION['directorio']."/".$cedula."/";
			$archivoPDF = $tipo_documento.$archivo .".PDF";
			$archivoXML = $tipo_documento.$archivo .".XML";
			$spanMail="<span class='glyphicon glyphicon-envelope cursorlink' id='".$codigo."_enviar_correo' 		 onmouseover='$(this).tooltip(".'"show"'.")' title='Enviar al e-mail del titular.' 	data-placement='left' onclick='reenvio_factura(".'"'.$codigo.'"'.",".'"modal_resend_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/VerDocumentosAutorizados/controller.php"'.")'  aria-hidden='true' data-toggle='modal' data-target='#modal_resend'></span>";
			$spanPDF= "<span class='glyphicon glyphicon-download cursorlink' id='".$row['codigoFactura']."_printPDF' onmouseover='$(this).tooltip(".'"show"'.")' title='Descargar documento en PDF' 				data-placement='top'></span>";
			$spanXML= "<span class='glyphicon glyphicon-download cursorlink' id='".$row['codigoFactura']."_printXML' onmouseover='$(this).tooltip(".'"show"'.")' title='Descargar documento en XML' 				data-placement='bottom'></span>";
			$spanHTML="<span class='glyphicon glyphicon-print cursorlink'    id='".$codigo."_ver_factura' 			 onmouseover='$(this).tooltip(".'"show"'.")' title='Ver documento en HTML' 	  					data-placement='left'></span>";
			
			$body.="<td style='text-align:center'>".$spanMail."</td>";
			$body.="<td style='text-align:center'><a href=".$dir_archivos.$archivoXML." target='_blank'>".$spanXML."</a></td>";
			$body.="<td style='text-align:center'><a href=".$dir_archivos.$archivoPDF." target='_blank'>".$spanPDF."</a></td>";
			$body.="<td style='text-align:center'><a href='../../finan/documento/imprimir/".$dir_tdoc_detail."/".$codigo."' target='_blank'>".$spanHTML."</a></td>";
		}
		$body.="</tr>";
		$c++;
	}
	$construct_table.=$body;
	$construct_table.="</tbody></table>";
	return $construct_table;
}
?>