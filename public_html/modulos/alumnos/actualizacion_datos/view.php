<?php
session_start();
require_once("../../../core/viewBase.php");
$diccionario = array(
    'subtitle'=>array(  VIEW_HOME=>'Actualización de datos',
                        VIEW_PASSWORD=>'Administrar contraseña',
                        VIEW_INFO_USER=>'Información del Usuario',
						VIEW_CONFIG_SIS=>'Información del Sistema',
    ),
    'active_menu'=>array(
		'open'  => '{open0}',
        'submenu'  => '{menu001}', 
        'mainmenu' => '{menu0}'
	),
	'rutas_head'=>array(),
    'links_menu'=>array(
        'cmb_sidebar_periodo'  => $_SESSION['cmb_sidebar_periodo']
    )
);
$diccionario = add_rutas( $diccionario ); //Llena 'rutas_head'=>array();
function get_main($form='main') {
    $file = '../../../site_media/html/'.HTML_FILES.$form.'.php';
    $template = file_get_contents($file);
    return $template;
}
function get_index() {
    /*$file = '../../index.php';
    $template = file_get_contents($file);
    return $template;*/
    global $diccionario;
    //echo $diccionario['rutas_head']['ruta_index_header'];
    header($diccionario['rutas_head']['ruta_index_header']);
}

function retornar_vista_general($vista, $data=array()) {
    global $diccionario;
    
    if($vista==VIEW_MAIN || $vista==VIEW_PASSWORD || $vista==VIEW_HOME || $vista==VIEW_INFO_USER || $vista==VIEW_CONFIG_SIS || $vista=PRINTREP_DEUDORES || $vista=PRINTREPVISOR)
	{   $html = get_main('main');
    }
	else
	{   $html = get_index();
    }
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_main($vista), $html);
    $html = str_replace('{navbar}', get_navbar_alumnos(), $html);
	$html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	
	include ('../../../framework/dbconf.php');
	
	if($_SESSION['USUA_TIPO']=='R')
	{   $alum_nombre = "";
		$params2 = array($_SESSION['repr_codi'],$_SESSION['peri_codi']);
		$sql2="{call repr_alum_info_princ_usua(?,?)}";
		$resu_alum_info = sqlsrv_query($conn, $sql2, $params2);  
		while($row_resu_alum_info = sqlsrv_fetch_array($resu_alum_info))
		{   if( $row_resu_alum_info['alum_codi'] == $_SESSION[ 'alum_codi' ] )
				$alum_nombre = $row_resu_alum_info['alum_apel']." ".$row_resu_alum_info['alum_nomb'];
		}
    }
	
	if($_SESSION['USUA_TIPO']=='R')
		$html = render_dinamic_content($html, array('usua_nombres'  => $_SESSION['repr_nomb'],'usua_apellidos' => $_SESSION['repr_apel'],'usua_codigo' => $_SESSION['repr_usua'],'cmb_sons' => $alum_nombre));
	else
		$html = render_dinamic_content($html, array('usua_nombres'  => $_SESSION['alum_nomb'],'usua_apellidos' => $_SESSION['alum_apel'],'usua_codigo' => $_SESSION['alum_usua'],'cmb_sons' => ""));
    
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html); 
        
    if(array_key_exists('mensaje', $data))
	{   $mensaje = $data['mensaje'];
    }
	else
	{   $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

?>