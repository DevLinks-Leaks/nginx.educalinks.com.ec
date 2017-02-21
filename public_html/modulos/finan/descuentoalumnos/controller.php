<?php
session_start();
require_once('/../../../core/controllerBase.php');
require_once('/../general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');


function handler() {
	$descuentoalumnos = get_mainObject('descuentoalumnos');
	$permiso = get_mainObject('General');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();

	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] =$_POST['busq'];}
	if (!isset($_POST['tabla'])){$tabla = "descfacturas_table";}else{$tabla =$_POST['tabla'];}

    switch ($event)
	{	
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK"){$_SESSION['IN']="KO";$_SESSION['ERROR_MSG']="Por favor inicie sesión";header("Location:".$domain);}
            
            $descuentoalumnos->get_all($user_data['busq']);
      		if(count($descuentoalumnos->rows)>0)
			{	global $diccionario;
				$permiso->permiso_activo($_SESSION['usua_codigo'], 142);
				if ($permiso->rows[0]['veri']==1)
				{	$opciones["Eliminar"] = "<span onclick='js_descuento_alumno_delete(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/descuentoalumnos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'  data-toggle='modal' data-target='#modal_resend'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span>";
				}
				else
				{	$opciones["Eliminar"]="";
				}

				$permiso->permiso_activo($_SESSION['usua_codigo'], 140);
				if ($permiso->rows[0]['veri']==1)
				{	$data['disabled_agregar_item']="";
				} 
				else
				{	$data['disabled_agregar_item']="disabled='disabled'";
				}
				$data['{tabla}']= array("elemento"=>"tabla",
								  "clase"=>"table table-bordered table-hover",
								  "id"=>$tabla,
								  "datos"=>$descuentoalumnos->rows,
								  "encabezado" => array("Código",
														"Nombre",
														"Motivo",
														"(%)",
														"Días validez",
														"Período",
														"Asignado el",
														"Inactivar"),
								  "options"=>array($opciones),
								  "campo"=>"codigo");
				$data['mensaje'] = "Listado de estudiantes con descuento otorgado";
			
      		}else{
      			$data = array('mensaje'=>$descuentoalumnos->mensaje.$descuentoalumnos->ErrorToString());
      		}
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            $descuentoalumnos->get_all($user_data['busq']);
            if(count($descuentoalumnos->rows)>0)
			{	global $diccionario;
                $permiso->permiso_activo($_SESSION['usua_codigo'], 142);
                if ($permiso->rows[0]['veri']==1)
                {	$opciones["Eliminar"] = "<span onclick='js_descuento_alumno_delete(".'"{codigo}"'.",".'"resultado"'.",".'"'.$diccionario['rutas_head']['ruta_html_finan'].'/descuentoalumnos/controller.php"'.")' class='btn_opc_lista_eliminar glyphicon glyphicon-trash cursorlink' aria-hidden='true'  data-toggle='modal' data-target='#modal_resend'  id='{codigo}_eliminar' onmouseover='$(".'"#{codigo}_eliminar"'.").tooltip(".'"show"'.")' title='Eliminar' data-placement='left'></span>";
                }
                else
                {	$opciones["Eliminar"]="";
                }
                $permiso->permiso_activo($_SESSION['usua_codigo'], 140);
                if ($permiso->rows[0]['veri']==1)
                {	$data['disabled_agregar_item']="";
                } 
                else
                {	$data['disabled_agregar_item']="disabled='disabled'";
                }
                $data['{tabla}']= array("elemento"=>"tabla",
                                        "clase"=>"table table-bordered table-hover",
                                        "id"=>$tabla,
                                        "datos"=>$descuentoalumnos->rows,
                                        "encabezado" => array(	"Código",
																"Nombre",
																"Motivo",
																"(%)",
																"Días validez",
																"Período",
																"Asignado el",
																"Inactivar"),
                                        "options"=>array($opciones),
                                        "campo"=>"codigo");
            }
            retornar_result($data);
            break;
        case VIEW_SET:
            $descuentoalumnos->getCategorias_selectFormat("");
            $data = array('{combo_categoria}' => array("elemento"  => "combo", 
                                                       "datos"     => $descuentoalumnos->rows,
                                                       "options"   => array("name"=>"codigoCategoria_add","id"=>"codigoCategoria_add","required"=>"required"),
                                                       "selected"  => 0));
            retornar_formulario(VIEW_SET, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $descuentoalumnos->set($user_data);
            break;  
        case GET:
            $descuentoalumnos->getCategorias_selectFormat("");
            $categorias = $descuentoalumnos->rows;
            $descuentoalumnos->get($user_data['codigo']);

            $data = array('item_codigo'=>$user_data['codigo'],
                          'item_nombre'=>$descuentoalumnos->nombre,
                          'item_descripcion'=>$descuentoalumnos->descripcion,
                          'item_aplicaIVA'=> ($descuentoalumnos->aplicaIVA == 1)? 'checked':'',
                          'item_aplicaICE'=> ($descuentoalumnos->aplicaICE == 1)? 'checked':'',
                          'item_precioGeneral'=> ($descuentoalumnos->precioGeneral == 1)? 'checked':'',
						  'item_descuento'=> ($descuentoalumnos->descuento == 1)? 'checked':'',
						  'item_liquidez'=> ($descuentoalumnos->liquidez == 1)? 'checked':'',
						  'item_prontopago'=> ($descuentoalumnos->prontopago == 1)? 'checked':'',
                          'item_cuentaContable'=>$descuentoalumnos->cuentaContable,
                          '{combo_categoria}' => array("elemento"  => "combo", 
                                                       "datos"     => $categorias,
                                                       "options"   => array("name"=>"codigoCategoria_mod","id"=>"codigoCategoria_mod","required"=>"required"),
                                                       "selected"  => $descuentoalumnos->categoria));
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case DELETE:
            $descuentoalumnos->delete($user_data['codigo']);
            break;
        case EDIT:
            $descuentoalumnos->edit($user_data);
			break;
        default :
        	break;
    }
}
handler();
?>