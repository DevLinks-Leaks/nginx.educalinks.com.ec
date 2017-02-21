<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../nivelEconomico/model.php');


function handler() {
	$nivelEconomicoCursos = get_mainObject('NivelEconomicoCursos');
	$nivelEconomico = get_mainObject('NivelEconomico');
	$permiso = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "nivelEconomicoCursos_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{	case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
      
			$nivelEconomicoCursos->get_all($user_data['busq']);
    		if(count($nivelEconomicoCursos->rows)>0)
			{	global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 155);
				if ($permiso->rows[0]['veri']==1)
				{	$opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomicoCursos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'  id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				}
				else
				{	$opciones["Editar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 156);
				if ($permiso->rows[0]['veri']==1)
				{	$opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomicoCursos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				}
				else
				{	$opciones["Eliminar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 154);
				if ($permiso->rows[0]['veri']==1)
				{	$data['disabled_agrupar_curso']="";
				} 
				else
				{	$data['disabled_agrupar_curso']="disabled='disabled'";
				}
						$data['{tabla}']= array("elemento"=>"tabla",
										"clase"=>"table table-bordered table-hover",
										"id"=>$tabla,
										"datos"=>$nivelEconomicoCursos->rows,
										"encabezado" => array("Codigo",
															  "Curso",
															  "Nivel Económico",
															  "Opciones"),
															  "options"=>array($opciones),
															  "campo"=>"codigo");
				$data['mensaje'] = "Listado de Cursos agrupados por nivel econ&oacute;mico";
    		}
			else
			{	$data = array('mensaje'=>$nivelEconomicoCursos->mensaje.$nivelEconomicoCursos->ErrorToString());
    		}
    		retornar_vista(VIEW_GET_ALL, $data);
          break;
      case GET_ALL_DATA:
            $nivelEconomicoCursos->get_all($user_data['busq']);
            if(count($nivelEconomicoCursos->rows)>0)
			{	global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 155);
				if ($permiso->rows[0]['veri']==1)
				{   $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomicoCursos/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'  id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
				}
				else
				{   $opciones["Editar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 156);
				if ($permiso->rows[0]['veri']==1)
				{   $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomicoCursos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
				}
				else
				{   $opciones["Eliminar"]="";
				}
				$permiso->permiso_activo($_SESSION['usua_codigo'], 154);
				if ($permiso->rows[0]['veri']==1)
				{   $data['disabled_agrupar_curso']="";
				} 
				else
				{   $data['disabled_agrupar_curso']="disabled='disabled'";
				}
				$data['{tabla}'] = array(	"elemento"=>"tabla",
											"clase"=>"table table-bordered table-hover",
											"id"=>$tabla,
											"datos"=>$nivelEconomicoCursos->rows,
											"encabezado" => array("Codigo",
																  "Curso",
																  "Nivel Económico",
																  "Opciones"),
																  "options"=>array($opciones),
																  "campo"=>"codigo");
				$data['mensaje'] = "Listado:";
            }
			else
			{   $data = array('mensaje'=>$nivelEconomicoCursos->mensaje.$nivelEconomicoCursos->ErrorToString());
            }
            retornar_result($data);
            break;
        case VIEW_ADD:
            $nivelEconomico->get_niveles_economicos();
            $data['{combo_nivel_economico}'] = array ("elemento"    => "combo",
                                        "datos"     => $nivelEconomico->rows,
                                        "options"   =>  array("name"=>"nivel_economico_add","id"=>"nivel_economico_add","class"=>"form-control", "required"=>"required"),
                                        "selected"  =>  0);
            $nivelEconomicoCursos->get_cursos();
            $data['{combo_curso}'] = array ("elemento"    => "combo",
                                        "datos"     => $nivelEconomicoCursos->rows,
                                        "options"   =>  array("name"=>"curso_add","id"=>"curso_add", "class"=>"form-control", "required"=>"required"),
                                        "selected"  =>  0);
            retornar_formulario(VIEW_ADD, $data);
            break;
        case VIEW_EDIT:
            $nivelEconomico->get_niveles_economicos();
            $nivelEconomicoCursos->get_cursos("");
            $cursos=$nivelEconomicoCursos->rows;
            $nivelEconomicoCursos->get($user_data['codigo']);
            $data = array(
                 'codigo'=>$user_data['codigo'],
                 '{combo_nivel_economico}' => array ("elemento"    => "combo",
                                              "datos"     => $nivelEconomico->rows,
                                              "options"   =>  array("name"=>"nivel_economico_mod","id"=>"nivel_economico_mod", "required"=>"required", "class"=>"form-control"),
                                              "selected"  =>  $nivelEconomicoCursos->nivelEconomico),
                 '{combo_curso}' => array ("elemento"    => "combo",
                                              "datos"     => $cursos,
                                              "options"   =>  array("name"=>"curso_mod","id"=>"curso_mod", "required"=>"required", "disabled"=>"true", "class"=>"form-control"),
                                              "selected"  =>  $nivelEconomicoCursos->codigo)
                 );
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $nivelEconomicoCursos->set($user_data);
            break;
        case EDIT:            
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $nivelEconomicoCursos->edit($user_data);
            break; 
        case DELETE:            
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $nivelEconomicoCursos->delete($user_data);
            break; 
        default:
        	 break;
    }
}
handler();
?>