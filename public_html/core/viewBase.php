<?php
session_start();
require_once("modelHTML.php");
require_once("rutas.php");
require_once("diccionario_menu.php");


# ======================================================
# Procedimientos de soporte para las interfaces
# ======================================================
function get_template($form='get') {
    $file = '../../../site_media/html/'.HTML_FILES.$form.'.php';
    $template = file_get_contents($file);
    return $template;
}
function get_menu(){
	global $diccionario_menu;
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/menu.php';
	$menu=file_get_contents($file);
	for($i=0;$i<count($_SESSION['usua_permiso'])-1;$i++){
		foreach($diccionario_menu as $campo => $valor){
			$array = explode("</span>", $valor['texto']);
			if(trim($valor['permiso'])==trim($_SESSION['usua_permiso'][$i][0])){
				if($valor['href']=='../../finan/gestionFacturas/'){
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_fac_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/gestionNotascredito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nc_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/gestionNotasdebito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nd_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/convenio_pago/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cp_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/gestionContifico/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_contifico"></span></a>',$menu);
				}
				elseif($valor['href']=='../../finan/valida_cheques/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cheques_in"></span></a>',$menu);
				}
				else{
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].'</span></a>',$menu);
				}
			}
		}
	}
	foreach($diccionario_menu as $campo => $valor){
		if(trim($valor['permiso'])!=trim($_SESSION['usua_permiso'][$i][0])){
			$menu=str_replace($campo,'',$menu);
		}
	}
	$print_foto="";
	
	$file_exi = '../../'.$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
	
	if ( file_exists( $file_exi ) )
	{   $print_foto = '../'.$_SESSION["ruta_foto_usuario"].$_SESSION["usua_codi"].'.jpg';
	}
	else
	{	$print_foto = '../'.$_SESSION["ruta_foto_usuario"].'admin.jpg';
	}
	$menu = str_replace('{fotoUsuario}', $print_foto, $menu);
	$menu = str_replace('{logo_institucion}',   '../../'.$_SESSION['dir_logo_cliente_bg'],  $menu);
	$menu = str_replace('{nombre_institucion}', $_SESSION['menu_institucion'],$menu);
	$menu = str_replace('{nombre_del_modulo}',  $_SESSION['nombre_del_modulo'], $menu);
	
	if ( $_SESSION["modulo"] == 'alumnos' )
	{   if( !$_SESSION['cita_medica'] )
			$menu = str_replace('{citas_display}', " style='display:none;' ",$menu);
	}
	
	//$_SESSION['print_dir_logo_cliente'];
	//$_SESSION['print_dir_logo_cliente_bg'];
	
	return $menu;
}
function get_menuNew(){
	global $diccionario_menu;
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/menu.php';
	$menu=file_get_contents($file);
	for($i=0;$i<count($_SESSION['usua_permiso'])-1;$i++){
		foreach($diccionario_menu as $campo => $valor){
			if(trim($valor['permiso'])==trim($_SESSION['usua_permiso'][$i][0])){
				if($valor['href']=='../gestionFacturas/'){
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_fac_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionNotascredito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nc_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionNotasdebito/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_nd_in"></span></a>',$menu);
				}
				elseif($valor['href']=='../gestionContifico/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_contifico"></span></a>',$menu);
				}
				elseif($valor['href']=='../valida_cheques/'){
					
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].' </span><span id="badge_gest_cheques_in"></span></a>',$menu);
				}
				else{
					$menu=str_replace($campo,'<a href="'.$valor['href'].'"title="'.$array[1].'"><span class="submenu">'.$valor['texto'].'</span></a>',$menu);
				}
			}
		}
	}
	foreach($diccionario_menu as $campo => $valor){
		if(trim($valor['permiso'])!=trim($_SESSION['usua_permiso'][$i][0])){
			$menu=str_replace($campo,'',$menu);
		}
	}
	return $menu;
}
function get_navbar(){
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/navbar.php';
	$navbar=file_get_contents($file);
	
	$print_foto="";
	
	$file_exi = '../../'.$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
	
	if ( file_exists( $file_exi ) )
	{   $print_foto = '../'.$_SESSION["ruta_foto_usuario"].$_SESSION["usua_codi"].'.jpg';
	}
	else
	{	$print_foto = '../'.$_SESSION["ruta_foto_usuario"].'admin.jpg';
	}
	
	$navbar = str_replace('{fotoUsuario}', $print_foto, $navbar);
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
	return $navbar;
}
function get_navbar_alumnos()
{   $file='../../../site_media/html/'.$_SESSION['modulo'].'/navbar.php';
	$navbar=file_get_contents($file);
	
	$print_foto="";
	
	$file_exi = '../../'.$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
	
	if ( file_exists( $file_exi ) )
	{   $print_foto = '../'.$_SESSION["ruta_foto_usuario"].$_SESSION["usua_codi"].'.jpg';
	}
	else
	{	$print_foto = '../'.$_SESSION["ruta_foto_usuario"].'admin.jpg';
	}
	
	$navbar = str_replace('{select_alumno}', $_SESSION['cmb_alum_sel'], $navbar);
	$navbar = str_replace('{ruta_foto_header}', $_SESSION['ruta_foto_header'], $navbar);
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
	return $navbar;
}
function get_menu_sidebar(){
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/menu_sidebar.php';
	$sidebar=file_get_contents($file);
	$cmb = str_replace("value='".$_SESSION['peri_codi']."'", "value='".$_SESSION['peri_codi']."' selected='selected' " , $_SESSION['cmb_sidebar_periodo'] );
	$boton_de_pago = '<div class="form-group">
					<label class="control-sidebar-subheading">
						Botón de pagos
						<button type="button" class="pull-right btn btn-default btn-xs fa fa-edit" onclick="js_general_config_bdp();"></button>
					</label>
					<p>
						Configuración de botón de pagos.
					</p>
				</div>';
	$sidebar = str_replace('{cmb_sidebar_periodo}', $cmb, $sidebar );

	$acad = '	<li>
					<a href="../../../admin/index.php" title="Ir al módulo académico">
						<i class="menu-icon fa fa-graduation-cap bg-yellow"></i>
						<div class="menu-info">
							<h4 class="control-sidebar-subheading">Académico</h4>
							<p>Notas, tutoría, clase virtual</p>
						</div>
					</a>
				</li>';
	$admisiones = '<li>
					<a href="../../../main_admisiones.php" title="Ir al módulo de admisiones">
						<i class="menu-icon fa fa-child bg-purple"></i>
						<div class="menu-info">
							<h4 class="control-sidebar-subheading">Admisiones</h4>
							<p>Módulo de Pre-selección</p>
						</div>
					</a>
				</li>';
	$admisiones = '';
	$finan = '<li>
					<a href="../../../main_finan.php" title="Ir al módulo financiero">
						<i class="menu-icon fa fa-usd bg-green"></i>
						<div class="menu-info">
							<h4 class="control-sidebar-subheading">Financiero</h4>
							<p>Colecturía, cobranza y facturación electrónica</p>
						</div>
					</a>
				</li>';
	$biblio = '<li>
					<a href="../../../biblio/index.php" title="Ir al módulo biblioteca">
					  <i class="menu-icon fa fa-book bg-light-blue"></i>
					  <div class="menu-info">
						<h4 class="control-sidebar-subheading">Biblioteca</h4>
						<p>Mantenimiento de inventario de biblioteca</p>
					  </div>
					</a>
				</li>';
	$medico = '<li>
					<a href="../../../main_medic.php" title="Ir al módulo médico">
					  <i class="menu-icon fa fa-medkit bg-red"></i>
					  <div class="menu-info">
						<h4 class="control-sidebar-subheading">Médico</h4>
						<p>Inventario médico y ficha médica ocupacional</p>
					  </div>
					</a>
				</li>';
	$encuesta = '<li>
					<a href="../../../main_encuestas.php" title="Ir al módulo de encuestas">
						<i class="menu-icon fa fa-book bg-orange"></i>
						<div class="menu-info">
							<h4 class="control-sidebar-subheading">Encuestas</h4>
							<p>Creación de cuestionarios y estadísticas</p>
						</div>
					</a>
				</li>';
				
	$sidebar = str_replace('{sidebar_modulo_acad}', $acad, $sidebar );
	$sidebar = str_replace('{sidebar_modulo_admisiones}', $admisiones, $sidebar );
	if($_SESSION['rol_finan']==1)
		$sidebar = str_replace('{sidebar_modulo_finan}', $finan, $sidebar );
	else
		$sidebar = str_replace('{sidebar_modulo_finan}', "", $sidebar );
	if($_SESSION['rol_biblio']==1)
		$sidebar = str_replace('{sidebar_modulo_biblio}', $biblio, $sidebar );
	else
		$sidebar = str_replace('{sidebar_modulo_biblio}', "", $sidebar );
	if($_SESSION['rol_medico']==1)
		$sidebar = str_replace('{sidebar_modulo_medico}', $medico, $sidebar );
	else
		$sidebar = str_replace('{sidebar_modulo_medico}', "", $sidebar );
	
	if ($_SESSION['rol_pagoweb']==1)
		$sidebar = str_replace('{bdp}', $boton_de_pago, $sidebar );
	else
		$sidebar = str_replace('{bdp}', '', $sidebar );
	return $sidebar;
}
function get_footer(){
	$file='../../../site_media/html/'.$_SESSION['modulo'].'/footer.php';
	$footer=file_get_contents($file);
	return $footer;
}
function get_menuVisor(){
    $file='../../../site_media/html/'.$_SESSION['modulo'].'/menuVisor.php';
    $menu=file_get_contents($file);
    return $menu;
}
function get_navbarVisor(){
    $file='../../../site_media/html/finan/navbarVisor.php';
	$navbar = str_replace('{navbar_logo_educalinks}', '../..'.$_SESSION['dir_logo_educalinks_long'] , $navbar);
	$navbar = str_replace('{navbar_logo_educalinks_small}', '../..'.$diccionario['rutas_head'].$_SESSION['dir_logo_educalinks_long_small'] , $navbar);
    $navbar=file_get_contents($file);
	return $navbar;
}
function add_rutas( $this )
{   require('../../../core/rutas.php');
	$this['rutas_head']=array(
			'rutas_all'  =>'
			<input type="hidden" id="hd_ui_skin" name="hd_ui_skin" value="{ui_skin}" />
			
			<input type="hidden" id="ruta_imagenes_acad" name="ruta_imagenes_acad" value="{ruta_imagenes_acad}" />
			<input type="hidden" id="ruta_html_acad" name="ruta_html_acad" value="{ruta_html_acad}" />
			<input type="hidden" id="ruta_js_acad" name="ruta_js_acad" value="{ruta_js_acad}" />
			<input type="hidden" id="ruta_css_acad" name="ruta_css_acad" value="{ruta_css_acad}" />
			
			<input type="hidden" id="ruta_imagenes_alumnos" name="ruta_imagenes_alumnos" value="{ruta_imagenes_alumnos}" />
			<input type="hidden" id="ruta_html_alumnos" name="ruta_html_alumnos" value="{ruta_html_alumnos}" />
			<input type="hidden" id="ruta_js_alumnos" name="ruta_js_alumnos" value="{ruta_js_alumnos}" />
			<input type="hidden" id="ruta_css_alumnos" name="ruta_css_alumnos" value="{ruta_css_alumnos}" />
			
			<input type="hidden" id="ruta_imagenes_admisiones" name="ruta_imagenes_admisiones" value="{ruta_imagenes_admisiones}" />
			<input type="hidden" id="ruta_html_admisiones" name="ruta_html_admisiones" value="{ruta_html_admisiones}" />
			<input type="hidden" id="ruta_js_admisiones" name="ruta_js_admisiones" value="{ruta_js_admisiones}" />
			<input type="hidden" id="ruta_css_admisiones" name="ruta_css_admisiones" value="{ruta_css_admisiones}" />
			
			<input type="hidden" id="ruta_imagenes_biblio" name="ruta_imagenes_biblio" value="{ruta_imagenes_biblio}" />
			<input type="hidden" id="ruta_html_biblio" name="ruta_html_biblio" value="{ruta_html_biblio}" />
			<input type="hidden" id="ruta_js_biblio" name="ruta_js_biblio" value="{ruta_js_biblio}" />
			<input type="hidden" id="ruta_css_biblio" name="ruta_css_biblio" value="{ruta_css_biblio}" />
			
			<input type="hidden" id="ruta_imagenes_medic" name="ruta_imagenes_medic" value="{ruta_imagenes_medic}" />
			<input type="hidden" id="ruta_html_medic" name="ruta_html_medic" value="{ruta_html_medic}" />
			<input type="hidden" id="ruta_js_medic" name="ruta_js_medic" value="{ruta_js_medic}" />
			<input type="hidden" id="ruta_css_medic" name="ruta_css_medic" value="{ruta_css_medic}" />
			
			<input type="hidden" id="ruta_imagenes_common" name="ruta_imagenes_common" value="{ruta_imagenes_common}" />
			<input type="hidden" id="ruta_html_common" name="ruta_html_common" value="{ruta_html_common}" />
			<input type="hidden" id="ruta_js_common" name="ruta_js_common" value="{ruta_js_common}" />
			<input type="hidden" id="ruta_css_common" name="ruta_css_common" value="{ruta_css_common}" />
			
			<input type="hidden" id="ruta_imagenes_finan" name="ruta_imagenes_finan" value="{ruta_imagenes_finan}" />
			<input type="hidden" id="ruta_html_finan" name="ruta_html_finan" value="{ruta_html_finan}" />
			<input type="hidden" id="ruta_js_finan" name="ruta_js_finan" value="{ruta_js_finan}" />
			<input type="hidden" id="ruta_css_finan" name="ruta_css_finan" value="{ruta_css_finan}" />',
			'ui_skin'					=> $_SESSION['ui_skin'],
			'sidebar_status'				=> $_SESSION['sidebar_status'],
			'ruta_css_finan'			=> $ruta_css_finan,
			'ruta_html_finan'			=> $ruta_html_finan,
			'ruta_js_finan'				=> $ruta_js_finan,
			'ruta_imagenes_finan'		=> $ruta_imagenes_finan,
			'ruta_includes_finan'		=> $ruta_includes_finan,
			'ruta_css_common'			=> $ruta_css_common,
			'ruta_html_common'			=> $ruta_html_common,
			'ruta_js_common'			=> $ruta_js_common,
			'ruta_imagenes_common'		=> $ruta_imagenes_common,
			'ruta_includes_common'		=> $ruta_includes_common,
			'ruta_css_acad'				=> $ruta_css_acad,
			'ruta_html_acad'			=> $ruta_html_acad,
			'ruta_js_acad'				=> $ruta_js_acad,
			'ruta_imagenes_acad'		=> $ruta_imagenes_acad,
			'ruta_includes_acad'		=> $ruta_includes_acad,
			'ruta_css_alumnos'			=> $ruta_css_alumnos,
			'ruta_html_alumnos'			=> $ruta_html_alumnos,
			'ruta_js_alumnos'			=> $ruta_js_alumnos,
			'ruta_imagenes_alumnos'		=> $ruta_imagenes_alumnos,
			'ruta_includes_alumnos'		=> $ruta_includes_alumnos,
			'ruta_css_admisiones'		=> $ruta_css_admisiones,
			'ruta_html_admisiones'		=> $ruta_html_admisiones,
			'ruta_js_admisiones'		=> $ruta_js_admisiones,
			'ruta_imagenes_admisiones'	=> $ruta_imagenes_admisiones,
			'ruta_includes_admisiones'	=> $ruta_includes_admisiones,
			'ruta_css_medic'			=> $ruta_css_medic,
			'ruta_html_medic'			=> $ruta_html_medic,
			'ruta_js_medic'				=> $ruta_js_medic,
			'ruta_imagenes_medic'		=> $ruta_imagenes_medic,
			'ruta_includes_medic'		=> $ruta_includes_medic,
			'ruta_css_biblio'			=> $ruta_css_biblio,
			'ruta_html_biblio'			=> $ruta_html_biblio,
			'ruta_js_biblio'			=> $ruta_js_biblio,
			'ruta_imagenes_biblio'		=> $ruta_imagenes_biblio,
			'ruta_includes_biblio'		=> $ruta_includes_biblio,
			'ruta_index_header'			=> $ruta_index_header,
			'ruta_main'					=> $ruta_main,
			'ruta_main_ssl'				=> $ruta_main_ssl,
			'proyecto'					=> 'Educalinks'
		);
	return $this;
}
function activa_menu($vista,$html){
	global $diccionario;
    $html = str_replace($diccionario['active_menu']['mainmenu'] , 'in', $html);
    $html = str_replace($diccionario['active_menu']['submenu'] , 'active', $html);
	$html = str_replace($diccionario['active_menu']['open'] , 'active', $html);
	return $html;
}
function render_dinamic_content($html, $data){
    foreach ($data as $clave=>$valor) {
        if( $clave[0]=="{" && $clave[strlen($clave)-1]=="}" ){
            # Elementos HTML con contenido dinamico
            switch ($valor['elemento']) {
				case 'a':
                    $html = str_replace($clave, HTML::a($valor['href'],$valor['content'],$valor['optional']), $html);
					break;
				case 'barChart':
                    $html = str_replace($clave, HTML::barChart($valor['datos'], $valor['label'], $valor['contenedor']), $html);
                    break;
				case 'lineChart':
                    $html = str_replace($clave, HTML::lineChart($valor['datos'], $valor['label'], $valor['contenedor']), $html);
                    break;
				case 'pieChart':
                    $html = str_replace($clave, HTML::pieChart($valor['datos'], $valor['contenedor']), $html);
                    break;
                case 'combo':
                    $html = str_replace($clave, HTML::select($valor['datos'],$valor['options'],$valor['selected']), $html);
                    break;
				case 'div':
                    $html = str_replace($clave, HTML::div($valor['content'],$valor['optional']), $html);
                    break;
                case 'tabla':
                    $html = str_replace($clave, HTML::table($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo']), $html);
                    break;
				case 'tabla_deudas':
                    $html = str_replace($clave, HTML::TableDeudasPendientes($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo']), $html);
                    break;
                case 'tabla_anidada':
                    $html = str_replace($clave, HTML::table_anidada($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
					break;
				case 'lista':
                    $html = str_replace($clave, HTML::ul($valor['datos'],$valor['options']), $html);
                    break;
                case 'text_box':
                    $html = str_replace($clave, HTML::input($valor['valor'], $valor['options']), $html);
                    break;
                case 'tablaSencilla':
                    $html = str_replace($clave, HTML::singleTable($valor['datos'], $valor['encabezado'], $valor['atributos']), $html); 
					break;                   
				case 'checkListBox':
                    $html = str_replace($clave, HTML::checkListBox($valor['datos'], $valor['campoVisualizacion'], $valor['campoValor'], /*$valor['atributos'],*/ $valor['valoresSeleccionados'], $valor['funcion']), $html);                
                    break;
                case 'tablaVisor':
                    $html = str_replace($clave, HTML::tableVisor($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
                    break;
				case 'tablaArrayIn':
                    $html = str_replace($clave, HTML::tableArrayIn($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
                    break;
                default:
                    break;
			 case 'tablaInputsencilla':
                    $html = str_replace($clave, HTML::tablaInputsencilla($valor['datos'], $valor['encabezado'], $valor['id'], $valor['clase'], $valor['options'],$valor['campo'], (array_key_exists('anidada', $valor)?$valor['anidada']:false )), $html);
					break;   
            }
        }else{
            # Datos estaticos
            $html = str_replace('{'.$clave.'}', $valor, $html);
        }
    }
    return $html;
}

# ======================================================
# Interfaces para el controlador
# ======================================================

function retornar_vista_submit($vista, $data=array()) {
	
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{navbar}', get_navbar(), $html);
	$html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	$html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data)) {
        $mensaje = $data['mensaje'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{menu}', get_menu(), $html);
	$html = str_replace('{navbar}', get_navbar(), $html);
	$html = str_replace('{menu_sidebar}', get_menu_sidebar(), $html);
	$html = str_replace('{footer}', get_footer(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
	$html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data)) {
        $mensaje = $data['mensaje'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
function retornar_vista_in($vista, $data_in=array()) {
    global $diccionario;
    $html = get_template($vista);
    $html = render_dinamic_content($html, $data_in);
        
    if(array_key_exists('mensaje_in', $data_in)) {
        $mensaje = $data_in['mensaje_in'];
    } else {
        $mensaje = '';
    }
    $html = str_replace('{mensaje_in}', $mensaje, $html);
	return $html;
    
}
function retornar_formulario($vista, $data=array()) {
    global $diccionario;
    $html = get_template($vista);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, $data);
    $html = str_replace('{mensaje}', $mensaje, $html);
    print $html;
}

function retornar_result($data=array()){
    $html = "";
    foreach ($data as $elemento => $valor) {
        if( $elemento[0]=="{" && $elemento[strlen($elemento)-1]=="}" ){
            $html .= $elemento;
        }else{
            $html .= "{".$elemento."}";
        }
    }
    $html = render_dinamic_content($html,$data);

    print $html;
}

function retornar_pagina($vista, $data=array()) {
    $html = get_template($vista);
    $html = render_dinamic_content($html, $data);
    print $html;
}

function retornar_mensaje($mensaje) {
    //$html = get_template($vista);
    $html = $mensaje;
    print $html;
}


function retornar_vistaVisor($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{navbar}', get_navbarVisor(), $html);
    $html = render_dinamic_content($html, $diccionario['form_actions']);
    $html = render_dinamic_content($html, $diccionario['rutas_head']);
    $html = render_dinamic_content($html, $diccionario['links_menu']);
    $html = render_dinamic_content($html, $diccionario['usua_datos']);
    $html = render_dinamic_content($html, $data);
    $html = activa_menu($vista, $html);
        
    if(array_key_exists('mensaje', $data))
	{   $mensaje = $data['mensaje'];
    }else
	{   $mensaje = 'Listado de usuarios:';
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
?>