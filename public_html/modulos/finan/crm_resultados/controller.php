<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    require('../../../core/rutas.php');
    $resultados = get_mainObject('ResultadosCRM');
    $resultados2 = get_mainObject('ResultadosCRM');
    $permiso = get_mainObject('General');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                                    VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                                    VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $resul_data = get_frontData();

    if (!isset($_POST['busq'])){$resul_data['busq'] = "";}else{$resul_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla= "resul_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $resultados->set($resul_data);
            break;      
        case GET:
            $resultados->get($resul_data['crm_resu_codigo']);
            $data = array(
                'crm_resu_codigo'=>$resul_data['crm_resu_codigo'],
                'crm_resu_descripcion'=>$resultados->crm_resu_descripcion,
                'crm_resu_estado'=>$resultados->crm_resu_estado);
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $resultados->delete($resul_data['crm_resu_codigo']);           
            break;
        case EDIT:
            $resultados->edit($resul_data);
            break;
        case GET_ALL_DATA:
            $resultados->get_all($resul_data['busq']);
            if(count($resultados->rows)>0){
                global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 176);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Asignar"] = "<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_asignar glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign' id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar detalle' data-placement='left'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Asignar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 177);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Editar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 178);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Eliminar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 190);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $data['disabled_agregar_resultado']="";
                  } 
                  else
                  {
                    $data['disabled_agregar_resultado']="disabled='disabled'";
                  }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$resultados->rows,
                                        "encabezado" => array("Código","Descripción","Estado","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"crm_resu_codigo");
            }else{
                $data = array('mensaje'=>$resultados->mensaje.$resultados->ErrorToString());
            }
            retornar_result($data);
            break;
        case VIEW_GET_ALL:
            if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $resultados->get_all($resul_data['busq']);
            if(count($resultados->rows)>0){
                global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 176);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Asignar"] = "<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_asignar glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign' id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar detalle' data-placement='left'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Asignar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 177);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Editar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 178);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Eliminar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 190);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $data['disabled_agregar_resultado']="";
                  } 
                  else
                  {
                    $data['disabled_agregar_resultado']="disabled='disabled'";
                  }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$resultados->rows,
                                        "encabezado" => array("Código","Descripción","Estado","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"crm_resu_codigo");
                $data['mensaje'] = "Listado de Resultados de CRM";
            }else{
                $data = array('mensaje'=>$resultados->mensaje.$resultados->ErrorToString());
            }
            retornar_vista(VIEW_GET_ALL, $data);
            break;
        case VIEW_SET:
            retornar_formulario(VIEW_SET, $data);
            break;
        case ASIGN:
            $resultados->asign($resul_data);
            print $resultados->mensaje;
            break;
        case VIEW_ASIGN:
			$resultados2 = new ResultadosCRM();
            $resultados2->get($resul_data['codigo']);
			$data = array('resultado_deta'=>$resultados2->crm_resu_descripcion);			
			$resultados->get_all_deta($resul_data['codigo']);
            if(count($resultados->rows)>0){
                global $diccionario;
                $opciones = array("Eliminar"=>"<span onclick='del_deta(".'"{codigo}"'.",".'"resultado_detalles"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'></span>");
                $data['{tabla_detalles}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla."_deta",
                                        "datos"=>$resultados->rows,
                                        "encabezado" => array("Código","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"deta_crm_resu_codigo");
                retornar_formulario(VIEW_ASIGN, $data);
            }
            break;
        case DEL_ASIGN:
            $resultados->del_asign($resul_data['deta_crm_resu_codigo']);
            break;
        case GET_ALL_DETAS:
            $resultados->get_all_deta($resul_data['crm_resu_codigo']);
            if(count($resultados->rows)>0){
                global $diccionario;
                $opciones = array("Eliminar"=>"<span onclick='del_deta(".'"{codigo}"'.",".'"resultado_detalles"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'></span>");
                $data['{tabla_detalles}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla."_deta",
                                        "datos"=>$resultados->rows,
                                        "encabezado" => array("Código","Descripción","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"deta_crm_resu_codigo");
            }else{
                $data = array('mensaje'=>$resultados->mensaje.$resultados->ErrorToString());
            }
            retornar_result($data);
            break;
        default:
            $resultados->get_all($resul_data['busq']);
                if(count($resultados->rows)>0){
                    global $diccionario;
                    $permiso->permiso_activo($_SESSION['usua_codigo'], 176);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Asignar"] = "<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_asignar glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign' id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar detalle' data-placement='left'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Asignar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 177);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $opciones["Editar"] = "<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Editar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 178);
                  if ($permiso->rows[0]['veri']==1)
                  {
				  $opciones["Eliminar"] = "<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/crm_resultados/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                  }
                  else
                  {
                    $opciones["Eliminar"]="";
                  }
                  $permiso->permiso_activo($_SESSION['usua_codigo'], 190);
                  if ($permiso->rows[0]['veri']==1)
                  {
                    $data['disabled_agregar_resultado']="";
                  } 
                  else
                  {
                    $data['disabled_agregar_resultado']="disabled='disabled'";
                  }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$resultados->rows,
                                        "encabezado" => array("Código","Descripción","Estado","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"crm_resu_codigo");
                }else{
                    $data = array('mensaje'=>$resultados->mensaje.$resultados->ErrorToString());
                }
                
            retornar_vista($event, $data);
    }
}

handler();
?>