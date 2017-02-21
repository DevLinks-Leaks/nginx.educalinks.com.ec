<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}
if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
if(isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{$alum_codi="";}
switch ($option){
    case "get_ficha_med_listado_individual":
		global $diccionario;
		include("../clases/Ficha_medica.php");
		$fichas = new Ficha_medica();
		$fichas->get_ficha_medica_listado_individual( -1, $alum_codi );
        if( ( count( $fichas->rows ) ) > 0 )
		{	$tabla="<table id='tbl_ficha_med_consulta' class='table table-striped table-bordered'>
					<thead>
						<tr><th style='text-align:center'>Ref.</th>
							<th style='text-align:center'>Código</th>
							<th style='text-align:center'>Nombre</th>
							<th style='text-align:center'>Tipo Ficha</th>
							<th style='text-align:center'>Última modificación</th>
							<th style='text-align:center'>Usuario modificación</th>
							<th style='text-align:center'>PDF</th>
						</tr>
					</thead><tbody>";
			foreach ( $fichas->rows as $ficha )
			{   if ( !empty( $ficha ) )
				{  	$tabla.="<tr>";
					$tabla.="<td>".$ficha["fmex_codi"]."</td>".
							"<td>".$ficha["per_codi"]."</td>".
							"<td>".$ficha["nombre"]."</td>".
							"<td>".$ficha["fmex_tipo_ficha"]."</td>".
							"<td>".$ficha["fmex_fecha_ingr"]."</td>".
							"<td>".$ficha["fmex_usua_ingr"]."</td>".
							"<td><button type='button' onclick='carga_ficha_med_formulario_pdf( \"".$ficha["fmex_codi"]."\")' ".
								" class='btn btn-default' aria-hidden='true' id='".$ficha["fmex_codi"]."_pdf' " .
								" onmouseover='$(this).tooltip(\"show\")' title='Ver PDF' ".
								" data-placement='left'><i style='color:red;' class='fa fa-file-pdf-o'></i></button>
							</td>
						</tr>";
				}
			}
			$tabla.="</tbody></table>";
			echo $tabla;
		}
		else
			echo "- Sin registro de ficha médica -";
        break;
    default:
        break;
}