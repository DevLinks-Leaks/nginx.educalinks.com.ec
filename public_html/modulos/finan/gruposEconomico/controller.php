<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');


function handler() {
  $grupoEconomico = get_mainObject('GrupoEconomico');
  $permiso = get_mainObject('General');
  $event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
  $user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
  if (!isset($_POST['tabla'])){$tabla = "grupoEconomico_table";}else{$tabla =$_POST['tabla'];}

    switch ($event) {
    	  case VIEW_GET_ALL:
			      if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            
            $grupoEconomico->get_all($user_data['busq']);
      			if(count($grupoEconomico->rows)>0){
      				global $diccionario;
              $permiso->permiso_activo($_SESSION['usua_codigo'], 147);
              if ($permiso->rows[0]['veri']==1)
              {
                $opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gruposEconomico/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit'  id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
              }
              else
              {
                $opciones["Editar"]="";
              }

              $permiso->permiso_activo($_SESSION['usua_codigo'], 148);
              if ($permiso->rows[0]['veri']==1)
              {
                $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gruposEconomico/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_resend'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'></span>";
              }
              else
              {
                $opciones["Eliminar"]="";
              }

              $permiso->permiso_activo($_SESSION['usua_codigo'], 146);
              if ($permiso->rows[0]['veri']==1)
              {
                $data['disabled_agregar_grupo']="";
              } 
              else
              {
                $data['disabled_agregar_grupo']="disabled='disabled'";
              }
      				$data['{tabla}']= array("elemento"=>"tabla",
                                      "clase"=>"table table-bordered table-hover",
                                      "id"=>$tabla,
                                      "datos"=>$grupoEconomico->rows,
                                      "encabezado" => array("Codigo",
                                                            "Nombre",
                                              					    "Descripcion",
                                                            "Opciones"),
                                      "options"=>array($opciones),
                                      "campo"=>"codigo");
              $data['mensaje'] = "Listado de grupos economico:";
      			}else{
      				$data = array('mensaje'=>$grupoEconomico->mensaje.$grupoEconomico->ErrorToString());
      			}
      			retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $grupoEconomico->get_all($user_data['busq']);
            if(count($grupoEconomico->rows)>0){
                global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 147);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='carga_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gruposEconomico/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar' onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }

                $permiso->permiso_activo($_SESSION['usua_codigo'], 148);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/gruposEconomico/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_resend'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 146);
                if ($permiso->rows[0]['veri']==1)
                {
                  $data['disabled_agregar_grupo']="";
                } 
                else
                {
                  $data['disabled_agregar_grupo']="disabled='disabled'";
                }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$grupoEconomico->rows,
                                        "encabezado" => array("Codigo",
                                                              "Nombre",
                                                              "Descripcion",
                                                              "Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"codigo");
            }
            retornar_result($data);
            break;
        case VIEW_SET:
            $data = array();
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $grupoEconomico->set($user_data);
            break;  
        case GET:
            $grupoEconomico->get($user_data['codigo']);

            $data = array('geconomico_codigo'=>$user_data['codigo'],
                          'geconomico_nombre'=>$grupoEconomico->nombre,
                          'geconomico_descripcion'=>$grupoEconomico->descripcion);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $grupoEconomico->delete($user_data['codigo']);
            break;
        case EDIT:
            $grupoEconomico->edit($user_data);
          break;
        default :
        	break;
    }
}

handler();
?>