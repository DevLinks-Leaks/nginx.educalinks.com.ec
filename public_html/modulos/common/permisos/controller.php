<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    require('/../../core/rutas.php');
    $pto_emision = get_mainObject('PtoEmision');
    $sucursales = get_mainObject('PtoEmision');
    $event = get_actualEvents(array(SET, SET_GET_ALL, GET, DELETE, EDIT, GET_ALL,
                                  VIEW_SET, VIEW_SET_GET_ALL, VIEW_GET, VIEW_DELETE, 
                                  VIEW_EDIT, VIEW_GET_ALL), VIEW_GET_ALL);
    $pto_data = get_frontData();

    if (!isset($_POST['busq'])){$pto_data['busq'] = "";}else{$pto_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla= "pto_emision_table";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $pto_emision->set($pto_data);
            break;      
        case GET:
            $para="";
            $sucursales->get_all_sucursales($para);
            $pto_emision->get($pto_data['puntVent_codigo']);
            $data = array(
                'puntVent_codigo'=>$pto_data['puntVent_codigo'],
                'puntVent_prefijo'=>$pto_emision->puntVent_prefijo,
                'puntVent_codigoSucursal'=>$pto_emision->puntVent_codigoSucursal,
                'puntVent_secuencia'=>$pto_emision->puntVent_secuencia,
                'puntVent_estado'=>$pto_emision->puntVent_estado,
                '{combo_sucursal}' => array("elemento"  => "combo", 
                                       "datos"     => $sucursales->rows, 
                                       "options"   => array("name"=>"pto_sucursal","id"=>"pto_sucursal","required"=>"required"), 
                                       "selected"  => $pto_emision->puntVent_codigoSucursal));
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $pto_emision->delete($pto_data['puntVent_codigo']);
            $data = array('mensaje'=>$pto_emision->mensaje.$pto_emision->ErrorToString());
            $pto_emision->get_all($pto_data['busq']);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Asignar"=>"<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>",
                                  "Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Código de punto de emisión","Prefijo ","Sucursal","Secuencia","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"puntVent_codigo");
            }else{
                $data = array('mensaje'=>$pto_emision->mensaje.$pto_emision->ErrorToString());
            }
            retornar_result($data);
            break;
        case EDIT:
            $pto_emision->edit($pto_data);
            break;
        case GET_ALL:
            $pto_emision->get_all($pto_data['busq']);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Asignar"=>"<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>",
                                  "Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Código de punto de emisión","Prefijo ","Sucursal","Secuencia","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"puntVent_codigo");
            }else{
                $data = array('mensaje'=>$pto_emision->mensaje.$pto_emision->ErrorToString());
            }
            retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $pto_emision->get_all($pto_data['busq']);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Asignar"=>"<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>",
                                  "Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Código de punto de emisión","Prefijo ","Sucursal","Secuencia","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"puntVent_codigo");
            }else{
                $data = array('mensaje'=>$pto_emision->mensaje.$pto_emision->ErrorToString());
            }
            retornar_result($data);
            break;
        case VIEW_GET_ALL:
            if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $pto_emision->get_all($pto_data['busq']);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Asignar"=>"<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>",
                                  "Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Código de punto de emisión","Prefijo ","Sucursal","Secuencia","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"puntVent_codigo");
            }else{
                $data = array('mensaje'=>$pto_emision->mensaje.$pto_emision->ErrorToString());
            }
            retornar_vista(VIEW_GET_ALL, $data);
            break;
        case VIEW_ASIGN:
            $param_users="";
            $pto_emision->get_all_users($param_users);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Asignar"=>"<span onclick='asign_user(".'"{codigo}"'.",".'"modal_asign_footer"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>");
                $data['{tabla_users}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla."_users",
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Username","Nombre","Email","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"usua_codi");
                retornar_formulario(VIEW_ASIGN, $data);
            }
            break;
        case ASIGN:
            $pto_emision->asign_user($pto_data);
            break;
        case DEL_ASIGN:
            $pto_emision->del_asign_user($pto_data['usuaPvta_codigo']);
            break;
        case VIEW_ASIGNED:
            $pto_emision->get_all_users_asigned($pto_data['puntVent_codigo']);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Eliminar"=>"<span onclick='del_user_asigned(".'"{codigo}"'.",".'"modal_asign_footer"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                $data['{tabla_users_asigned}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-striped table-hover",
                                        "id"=>$tabla."_users_asigned",
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Código","Username","Nombre","Email","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"usuaPvta_codigo");
                retornar_formulario(VIEW_ASIGNED, $data);
            }
            break;
        case VIEW_SET:
            $para="";
            $sucursales->get_all_sucursales($para);
            $data = array('{combo_sucursal}' => array("elemento"  => "combo", 
                                                      "datos"     => $sucursales->rows, 
                                                      "options"   => array("name"=>"pto_sucursal_add","id"=>"pto_sucursal_add","required"=>"required"),
                                                      "selected"  => 0));
            retornar_formulario(VIEW_SET, $data);
            break;
        default:
            $pto_emision->get_all($pto_data['busq']);
                if(count($pto_emision->rows)>0){
                    global $diccionario;
                    $opciones = array("Asignar"=>"<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>",
                                  "Editar"=>"<span onclick='edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar'>&nbsp;</span>",
                                  "Eliminar"=>"<span onclick='del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                    $data['{tabla}']= array("elemento"=>"tabla",
                                            "clase"=>"table table-striped table-hover",
                                            "id"=>$tabla,
                                            "datos"=>$pto_emision->rows,
                                            "encabezado" => array("Código de punto de emisión","Prefijo ","Sucursal","Secuencia","Opciones"),
                                            "options"=>array($opciones),
                                            "campo"=>"puntVent_codigo");
                }else{
                    $data = array('mensaje'=>$pto_emision->mensaje.$pto_emision->ErrorToString());
                }
                
            retornar_vista($event, $data);
    }
}

handler();
?>