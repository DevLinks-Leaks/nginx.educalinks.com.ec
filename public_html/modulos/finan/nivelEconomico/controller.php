<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');


function handler() {
  $nivelEconomico = get_mainObject('NivelEconomico');
  $permiso = get_mainObject('General');
  $event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
  $user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
  if (!isset($_POST['tabla'])){$tabla = "nivelEconomico_table";}else{$tabla =$_POST['tabla'];}

    switch ($event) {
	  case VIEW_GET_ALL:
	      if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
      
          $nivelEconomico->get_all($user_data['busq']);
    			if(count($nivelEconomico->rows)>0){
    				global $diccionario;
            $permiso->permiso_activo($_SESSION['usua_codigo'], 151);
            if ($permiso->rows[0]['veri']==1)
            {
              $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomico/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
            }
            else
            {
              $opciones["Editar"]="";
            }

            $permiso->permiso_activo($_SESSION['usua_codigo'], 152);
            if ($permiso->rows[0]['veri']==1)
            {
              $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomico/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
            }
            else
            {
              $opciones["Eliminar"]="";
            }

            $permiso->permiso_activo($_SESSION['usua_codigo'], 150);
            if ($permiso->rows[0]['veri']==1)
            {
              $data['disabled_agregar_nivel_economico']="";
            } 
            else
            {
              $data['disabled_agregar_nivel_economico']="disabled='disabled'";
            }
    				$data['{tabla}']= array("elemento"=>"tabla",
                                    "clase"=>"table table-bordered table-hover",
                                    "id"=>$tabla,
                                    "datos"=>$nivelEconomico->rows,
                                    "encabezado" => array("Codigo",
                                                          "Nombre",
                                                          "Descripción",
                                                          "Opciones"),
                                                          "options"=>array($opciones),
                                                          "campo"=>"codigo");
            $data['mensaje'] = "Listado de niveles económicos:";
    			}else{
    				$data = array('mensaje'=>$nivelEconomico->mensaje.$nivelEconomico->ErrorToString());
    			}
    			retornar_vista(VIEW_GET_ALL, $data);
          break;
      case GET_ALL_DATA:
            $nivelEconomico->get_all($user_data['busq']);
            if(count($nivelEconomico->rows)>0){
              global $diccionario;
              $permiso->permiso_activo($_SESSION['usua_codigo'], 151);
              if ($permiso->rows[0]['veri']==1)
              {
                $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomico/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>";
              }
              else
              {
                $opciones["Editar"]="";
              }

              $permiso->permiso_activo($_SESSION['usua_codigo'], 152);
              if ($permiso->rows[0]['veri']==1)
              {
                $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/nivelEconomico/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
              }
              else
              {
                $opciones["Eliminar"]="";
              }
              $permiso->permiso_activo($_SESSION['usua_codigo'], 150);
              if ($permiso->rows[0]['veri']==1)
              {
                $data['disabled_agregar_nivel_economico']="";
              } 
              else
              {
                $data['disabled_agregar_nivel_economico']="disabled='disabled'";
              }
              $data['{tabla}'] = array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$nivelEconomico->rows,
                                        "encabezado" => array("Codigo",
                                                              "Nombre",
                                                              "Descripción",
                                                              "Opciones"),
                                                              "options"=>array($opciones),
                                                              "campo"=>"codigo");
              //$data['mensaje'] = "Listado de niveles económicos:";
            }else{
              $data = array('mensaje'=>$nivelEconomico->mensaje.$nivelEconomico->ErrorToString());
            }

            retornar_result($data);
            break;
        case VIEW_ADD:
			$nivelEconomico->getGrupoEconomico_SelectFormat("");
            $data = array('{combo_grupoeco}' => array("elemento"  => "combo", 
                                                       "datos"     => $nivelEconomico->rows,
                                                       "options"   => array("name"=>"codigoGrupoEconomico_add","id"=>"codigoGrupoEconomico_add",
                                                                                  "class"=>"form-control","required"=>"required"),
                                                       "selected"  => 0));
            retornar_formulario(VIEW_ADD, $data);
            break;
        case VIEW_EDIT:
			$nivelEconomico->getGrupoEconomico_SelectFormat("");
			$niveles=$nivelEconomico->rows;
            $nivelEconomico->get($user_data['codigo']);
            $data = array(
                 'codigo'=>$user_data['codigo'],
                 'nombre'=>$nivelEconomico->nombre,
                 'descripcion'=>$nivelEconomico->descripcion,
				 '{combo_grupoeco}' => array("elemento"  => "combo", 
                                                       "datos"     => $niveles,
                                                       "options"   => array("name"=>"codigoGrupoEconomico_mod","id"=>"codigoGrupoEconomico_mod",
                                                                                  "class"=>"form-control","required"=>"required"),
                                                       "selected"  => $nivelEconomico->grupoeconomico)
                 );
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $nivelEconomico->set($user_data);
            break;
        case EDIT:            
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $nivelEconomico->edit($user_data);
            break; 
        case DELETE:            
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $nivelEconomico->delete($user_data);
            break; 
        default:
        	 break;
    }
}

handler();
?>