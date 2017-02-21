<?php
session_start();
require_once('../../../core/controllerBase.php');
require_once('../../common/general/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{   $mensaje = get_mainObject('Mensaje');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_MAIL), VIEW_GET_ALL);
	$user_data = get_frontData();
	
	if (!isset($_POST['busq'])){$user_data['busq'] = "";}else{$user_data['busq'] = $_POST['busq'];}
	global $diccionario;
    switch ($event)
	{   case VIEW_BADGE_SMS:
			print valida_get_menu_count_smsPendienteLeer();
			break;
		case VIEW_BADGE_DETAIL:
			print valida_get_menu_detail_smsPendienteLeer();
			break;
		case VIEW_GET_ALL:
			if($_SESSION['IN']!="OK")
			{	$_SESSION['IN']="KO";
				$_SESSION['ERROR_MSG']="Por favor inicie sesión";
				header("Location:".$domain);
			}
			$mensaje->get_smsInbox($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO']);
			$data = get_box($mensaje, 'active_in');
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
		case FAVORITE:
			$resultado = $mensaje->set_favorite($user_data['mens_codi']);
			$data =array("mensaje" => $resultado->mensaje);
			retornar_result($data);
			break;
		case VIEW_MAIL:
			$data = leer_mensaje($user_data['mens_codi']);
			$data[$user_data['box']] = 'class="active"';
      		retornar_formulario(VIEW_MAIL, $data);
			break;
        case GET_BOX:
			if($user_data['box']=='active_in')
				$mensaje->get_smsInbox($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
			if($user_data['box']=='active_sent')
				$mensaje->get_smsSentbox($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
			if($user_data['box']=='active_draft')
				$mensaje->get_smsDraftbox($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
			if($user_data['box']=='active_trash')
				$mensaje->get_smsTrashbox($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
			$data = get_box($mensaje, $user_data['box']);
            retornar_formulario(VIEW_GET_ALL, $data);
            break;
        case SET:
            $user_data['codigoUsuario'] = $_SESSION['usua_codigo'];
            $mensaje->set($user_data);
            break;  
        case DELETE:
            $mensaje->delete($user_data['mens_codi']);
            break;
        case EDIT:
            $mensaje->edit($user_data['mens_codi']);
			break;
		case SEND:
            $mensaje->edit($user_data['mens_codi']);
			break;
        default :
        	break;
    }
}
handler();
function get_box($mensaje, $active_in)
{   global $diccionario;
	$data['inbox_count'] = valida_get_menu_count_smsIn();
	$data['trash_count'] = valida_get_menu_count_smsTrash();
	$data[$active_in] = 'class="active"';
	$inbox="";
	$adjunto=false;$adjunto_class=' ';
	if(count($mensaje->rows)-1>0)
	{	for($c=0;$c<(count($mensaje->rows)-1);$c++)
		{   if ($mensaje->rows[$c]['mens_favorite'] == false)
				$favorite_class='fa fa-flag-o text-red';
			else
				$favorite_class='fa fa-flag text-red';
			/*if ($adjunto == false)
				$adjunto_class=' ';
			else
				$adjunto_class='<i class="fa fa-paperclip"></i>';*/
			$inbox.= '<tr>
				  <td><input id="'.$mensaje->rows[$c]['mens_codi'].'_ckb_select" name="'.$mensaje->rows[$c]['mens_codi'].'_ckb_select" type="checkbox"
						onclick="check_if_one(\''.$diccionario['rutas_head']['ruta_html_common'].'/mensajeria/controller.php\',\'tbl_mailbox\');"></td>
				  <td class="mailbox-star"><a href="#" '.
					'onclick="check_favorite(this,\''.$diccionario['rutas_head']['ruta_html_common'].'/mensajeria/controller.php\',\''.$mensaje->rows[$c]['mens_codi'].'\')">'.
						'<i class="'.$favorite_class.'"></i></a></td>
				  <td class="mailbox-name"><a href="#" '.
					'onclick="leer_mensaje(\''.$diccionario['rutas_head']['ruta_html_common'].'/mensajeria/controller.php\',\''.$mensaje->rows[$c]['mens_codi'].'\',\''.$active_in.'\',\'formulario\')">'
						.$mensaje->rows[$c]['mens_de_nomb'].'</a></td>
				  <td class="mailbox-subject"><b>'.$mensaje->rows[$c]['mens_titu'].'</b> - '.$mensaje->rows[$c]['mens_deta'].'</td>
				  <td class="mailbox-attachment"></td>
				  <td class="mailbox-date">'.$mensaje->rows[$c]['mens_fech_envi'].'</td>
				</tr>';
		}
	}else
	{   $inbox.= '<tr>
				  <td colspan="6" style="text-align:center;">Tu buz&oacute;n est&aacute; vac&iacute;o</td>
				</tr>';
	}
	$data['inbox_tbl_body'] = $inbox;
	return $data;
}
function valida_get_menu_count_smsPendienteLeer()
{	global $diccionario;
	$mensaje = new Mensaje();
	$mensaje->get_menu_count_smsPendienteLeer($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
	if(count($mensaje->rows)-1>0)
	{	if($mensaje->rows[0]['Mensajes_pendientes']>0) 
			return $mensaje->rows[0]['Mensajes_pendientes'];
		else
			return 0;
	}else
	{   return 0;
	}
}
function valida_get_menu_detail_smsPendienteLeer()
{   global $diccionario;
	$mensaje = new Mensaje();
	$mensaje->get_menu_detail_smsPendienteLeer($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
	$html='';
	if(count($mensaje->rows)-1>0)
	{	for($c=0;$c<(count($mensaje->rows)-1);$c++)
		{   $html.="<li>
				<a href='#' onclick=\"leer_mensaje('".$diccionario['rutas_head']['ruta_html_common']."/mensajeria/controller.php','".$mensaje->rows[$c]['mens_codi']."','active_in','formulario')\">
				  <div class'pull-left'
					<img src=\"../".$_SESSION['ruta_foto_usuario']."admin.jpg\" class=\"img-circle\" alt=\"User Image\">
				  </div>
				  <h4>
					".$mensaje->rows[$c]['mens_de_nomb']."
					<small><i class='fa fa-clock-o'></i> ".$mensaje->rows[$c]['mens_fech_envi']."</small>
				  </h4>
				  <p>".$mensaje->rows[$c]['mens_titu']."</p>
				</a>
			  </li>";
		}
	}else
	{   $html.="<li></li>";
	}
	return $html;
}
function valida_get_menu_count_smsTrash()
{	global $diccionario;
	$mensaje = new Mensaje();
	$mensaje->get_menu_count_smsTrash($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
	if(count($mensaje->rows)-1>0)
	{	if($mensaje->rows[0]['Mensajes_pendientes']>0) 
			return "<span class='label label-warning pull-right'>".$mensaje->rows[0]['Mensajes_pendientes']."</span>";
		else
			return 0;
	}else
	{   return 0;
	}
}
function valida_get_menu_count_smsIn()
{	global $diccionario;
	$mensaje = new Mensaje();
	$mensaje->get_menu_count_smsIn($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO'] );
	if(count($mensaje->rows)-1>0)
	{	if($mensaje->rows[0]['Mensajes_pendientes']>0) 
			return "<span class='label label-primary pull-right'>".$mensaje->rows[0]['Mensajes_pendientes']."</span>";
		else
			return 0;
	}else
	{   return 0;
	}
}
function leer_mensaje($mens_codi)
{   global $diccionario;
	$mensaje = new Mensaje();
	$data['inbox_count'] = valida_get_menu_count_smsIn();
	$data['trash_count'] = valida_get_menu_count_smsTrash();
	$mensaje->get_mensaje_para_leer($mens_codi);
	if(count($mensaje->rows)>0)
	{	$data['mens_tema'] = $mensaje->rows[0]['mens_titu'];
		$data['mens_de'] = $mensaje->rows[0]['mens_de_nomb'];
		$data['mens_para'] = $mensaje->rows[0]['mens_para_nomb'];
		$data['contenido_mensaje'] = $mensaje->rows[0]['mens_deta'];
		$data['mens_fech_envi'] = $mensaje->rows[0]['mens_fech_envi'];
		$data['opciones_mensaje_top']  =  '
			<div class="btn-group">
				<button class="btn btn-default btn-sm" onclick=\'delete_mail("'.$mens_codi.'")\' data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o"></i></button>
				<button class="btn btn-default btn-sm" onclick=\'reply_mail("'.$mens_codi.'")\' data-toggle="tooltip" title="Reply"><i class="fa fa-reply"></i></button>
				<button class="btn btn-default btn-sm" onclick=\'share_mail("'.$mens_codi.'")\' data-toggle="tooltip" title="Forward"><i class="fa fa-share"></i></button>
			</div>';
		$data['opciones_mensaje_bottom']  =  '
		  <div class="pull-right">
			  <button class="btn btn-default" onclick=\'reply_mail("'.$mens_codi.'")\'><i class="fa fa-reply"></i> Responder</button>
			  <button class="btn btn-default" onclick=\'share_mail("'.$mens_codi.'")\'><i class="fa fa-share"></i> Compartir</button>
		  </div>
		  <button class="btn btn-default" onclick=\'delete_mail("'.$mens_codi.'")\'><i class="fa fa-trash-o"></i> Eliminar</button>';
	}
	return $data;
}
?>