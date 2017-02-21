<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	require('../../../core/rutas.php');
	$periodo = get_mainObject('Periodo');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();

    switch ($event)
	{	case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $periodo->get_all();
      		if(count($periodo->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"table table-bordered table-hover",
								  "id"=>"tbl_periodos",
								  "datos"=>$periodo->rows,
								  "encabezado" => array("Código",
														"Descripción",
														"Año",
														"Nota max.",
														"Tipo",
														"F. Inicio",
														"F. Fin",
														"Estado",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"peri_codi");
				$data['mensaje'] = "Listado de periodos";
      		}
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $periodo->get_all();
			if(count($periodo->rows)>0)
			{	
				global $diccionario;
				$opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/periodo/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"table table-bordered table-hover",
								  "id"=>"tbl_periodos",
								  "datos"=>$periodo->rows,
								  "encabezado" => array("Código",
														"Descripción",
														"Año",
														"Nota max.",
														"Tipo",
														"F. Inicio",
														"F. Fin",
														"Estado",
														"Opciones"),
														"options"=>array($opciones),
														"campo"=>"peri_codi");
				$data['mensaje'] = "Listado de periodos:";
      		}
			else
			{	
				$data = array('mensaje'=>$periodo->mensaje.$categoria->ErrorToString());
      		}
            retornar_result($data);
            break;
        case VIEW_SET:
            $data = array ();
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['usua_codigo'] = $_SESSION['usua_codigo'];
            $resultado = $periodo->set($user_data);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
            break;  
        case GET:
            $periodo->get($user_data['codigo']);
            $data = array('periodo_codigo'=>$user_data['codigo'],
                          'periodo_descripcion'=>$periodo->peri_deta,
                          'periodo_anio'=>$periodo->peri_ano,
                          'periodo_nota_max'=>$periodo->peri_nota_max,
            			  'periodo_fechainicio'=>$periodo->peri_fecha_ini,
            			  'periodo_fechafin'=>$periodo->peri_fecha_fin);
			if ( $periodo->peri_tipo == 'R')
				$data['peri_tipo_r']=" selected='selected' ";
			if ( $periodo->peri_tipo == 'V')
				$data['peri_tipo_v']=" selected='selected' ";
			if ( $periodo->peri_tipo == 'A')
				$data['peri_tipo_a']=" selected='selected' ";
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
        	$user_data["usua_codigo"]="SYSTEM";
            $periodo->delete($user_data);
            break;
        case EDIT:
        	$user_data['usua_codigo'] = $_SESSION['usua_codigo'];
            $resultado = $periodo->edit($user_data);
			$data = array("mensaje" => $resultado->mensaje);
			retornar_result($data);
          break;
        default :
        	break;
    }
}

handler();
?>