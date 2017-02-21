<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../finan/general/model.php');
require_once('../../finan/bancos/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{
    require('../../../core/rutas.php');
	
    $tarjeta 		= get_mainObject('tarjCredito');
	$banco 	 		= get_mainObject('tarjCredito');
    $permiso 		= get_mainObject('General');
    $event 	 		= get_actualEvents(array( SET, 		SET_GET_ALL, GET,	DELETE, 	EDIT, GET_ALL,
											  VIEW_SET, VIEW_SET_GET_ALL, 	VIEW_GET, 	VIEW_DELETE,
											  VIEW_EDIT,VIEW_GET_ALL), 		VIEW_GET_ALL);
    $tarjeta_data 	= get_frontData();

    if (!isset($_POST['busq'])){$tarjeta_data['busq'] = "";}else{$tarjeta_data['busq'] =$_POST['busq'];}
    if (!isset($_POST['tabla'])){$tabla= "tarjetaCredito";}else{$tabla=$_POST['tabla'];}

    switch ($event) {
        case SET:
            $tarjeta->set($tarjeta_data);
            break;      
        case GET:
            $para="";
            $banco->get_all_bancos($para);
            $tarjeta->get($tarjeta_data['tarjeta_codigo']);
            $data = array(
                'tarjCred_codigo'=>$tarjeta_data['tarjeta_codigo'],
                'tarjCred_nombre'=>$tarjeta->tarjCred_nombre,
                'banc_codigo'=>$tarjeta->banc_codigo,
                '{combo_bancos}' => array("elemento"  => "combo", 
                                       "datos"     => $banco->rows, 
                                       "options"   => array("name"=>"bancos", "id"=>"bancos", "class"=>"form-control", "required"=>"required"), 
                                       "selected"  => $tarjeta->banc_codigo));
			
			if( $tarjeta->rows[0]['tarCred_esInternacional'] == '0' )
				$data['nacional'] = 'selected = "selected"';
			else
				$data['internacional'] = 'selected = "selected"';
			
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $tarjeta->delete($tarjeta_data['tarjeta_codigo']);
            $data = array('mensaje'=>$tarjeta->mensaje.$tarjeta->ErrorToString());
            $tarjeta->get_all($tarjeta_data['busq']);
            if(count($tarjeta->rows)>0){
                global $diccionario;
                
                $permiso->permiso_activo($_SESSION['usua_codigo'], 113);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='js_tarjetaCredito_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 114);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='js_tarjetaCredito_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }

                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$tarjeta->rows,
                                        "encabezado" => array("Código de Tarjeta","Nombre","Banco","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"tarjCred_codigo");
            }else{
                $data = array('mensaje'=>$tarjeta->mensaje.$tarjeta->ErrorToString());
            }
            retornar_result($data);
            break;
        case EDIT:
            $tarjeta->edit($tarjeta_data);
            break;
        case GET_ALL:
            $tarjeta->get_all($tarjeta_data['busq']);
            if(count($tarjeta->rows)>0){
                global $diccionario;
                
                $permiso->permiso_activo($_SESSION['usua_codigo'], 113);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='js_tarjetaCredito_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 114);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='js_tarjetaCredito_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$pto_emision->rows,
                                        "encabezado" => array("Código de Tarjeta","Nombre","Banco","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"tarjCred_codigo");
            }else{
                $data = array('mensaje'=>$tarjeta->mensaje.$tarjeta->ErrorToString());
            }
            retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $tarjeta->get_all($tarjeta_data['busq']);
            if(count($tarjeta->rows)>0){
                global $diccionario;
                
                $permiso->permiso_activo($_SESSION['usua_codigo'], 113);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='js_tarjetaCredito_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 114);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='js_tarjetaCredito_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$tarjeta->rows,
                                        "encabezado" => array("Código de Tarjeta","Nombre","Banco","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"tarjCred_codigo");
            }else{
                $data = array('mensaje'=>$tarjeta->mensaje.$tarjeta->ErrorToString());
            }
            retornar_result($data);
            break;
        case VIEW_GET_ALL:
            if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            $tarjeta->get_all($tarjeta_data['busq']);
            if(count($tarjeta->rows)>0){
                global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 112);
               
             
           
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='js_tarjetaCredito_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 114);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='js_tarjetaCredito_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/tarjetasCredito/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$tarjeta->rows,
                                        "encabezado" => array("Código de Tarjeta","Nombre","Banco","Opciones"),
                                        "options"=>array($opciones),
                                        "campo"=>"tarjCred_codigo");
            }else{
                $data = array('mensaje'=>$tarjeta->mensaje.$tarjeta->ErrorToString());
            }
            retornar_vista(VIEW_GET_ALL, $data);
            break;
        case VIEW_ASIGN:
            $param_users="";
            $tarjeta->get_all_users($param_users);
            if(count($pto_emision->rows)>0){
                global $diccionario;
                $opciones = array("Asignar"=>"<span onclick='asign_user(".'"{codigo}"'.",".'"modal_asign_footer"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>");
                $data['{tabla_users}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
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
                $opciones = array("Eliminar"=>"<span onclick='js_tarjetaCredito_del_user_asigned(".'"{codigo}"'.",".'"modal_asign_footer"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/puntos_emision/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>");
                $data['{tabla_users_asigned}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
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
            $tarjeta->get_all_bancos($para);
            $data = array('{combo_bancos}' => array("elemento"  => "combo", 
                                                      "datos"     => $tarjeta->rows, 
                                                      "options"   => array("name"=>"bancos_add", "id"=>"bancos_add", "class"=>"form-control", "required"=>"required"),
                                                      "selected"  => 0));
            retornar_formulario(VIEW_SET, $data);
            break;
        default:
            $pto_emision->get_all($pto_data['busq']);
                if(count($pto_emision->rows)>0){
                    global $diccionario;
                    $permiso->permiso_activo($_SESSION['usua_codigo'], 112);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Asignar"] = "<span onclick='asign(".'"{codigo}"'.",".'"modal_asign_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/puntos_emision/controller.php"'.")' class='glyphicon glyphicon-check cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_asign'id='{codigo}_asignar'onmouseover='$(".'"#{codigo}_asignar"'.").tooltip(".'"show"'.")' title='Asignar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Asignar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 113);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Editar"] = "<span onclick='js_tarjetaCredito_edit(".'"{codigo}"'.",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/puntos_emision/controller.php"'.")' class='btn_opc_lista_editar glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='{codigo}_editar'onmouseover='$(".'"#{codigo}_editar"'.").tooltip(".'"show"'.")' title='Editar' data-placement='left'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Editar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 114);
                if ($permiso->rows[0]['veri']==1)
                {
                  $opciones["Eliminar"] = "<span onclick='js_tarjetaCredito_del(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/puntos_emision/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true' id='{codigo}_del'onmouseover='$(".'"#{codigo}_del"'.").tooltip(".'"show"'.")' title='Eliminar'>&nbsp;</span>";
                }
                else
                {
                  $opciones["Eliminar"]="";
                }
                    $data['{tabla}']= array("elemento"=>"tabla",
                                            "clase"=>"table table-bordered table-hover",
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