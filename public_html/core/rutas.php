<?php
session_start();
$domain = $_SERVER['HTTP_HOST'];

$protocol = "";

if ( $_SESSION['modulo'] == 'alumnos' )
{	$protocol = "https://";
	$ruta_main_ssl="https://".$domain."/";
}
else 
{	$protocol = "http://";
	$ruta_index_header="Location:http://".$domain."/";
}
/*if (isset($_SERVER['HTTPS'])) {
    
} else {
    $protocol = "http://";
}*/
$ruta_html_common = $protocol.$domain."/modulos/common";
$ruta_js_common = $protocol.$domain."/site_media/js/common";
$ruta_imagenes_common = $protocol.$domain."/site_media/imagenes/common";
$ruta_css_common = $protocol.$domain."/site_media/css/common";
$ruta_includes_common = $protocol.$domain."/includes/common";

$ruta_html_finan = $protocol.$domain."/modulos/finan";
$ruta_js_finan = $protocol.$domain."/site_media/js/finan";
$ruta_imagenes_finan = $protocol.$domain."/site_media/imagenes/finan";
$ruta_css_finan = $protocol.$domain."/site_media/css/finan";
$ruta_includes_finan = $protocol.$domain."/includes/finan";
$ruta_includes_visor = $protocol.$domain."/includes/common";

$ruta_html_admisiones = $protocol.$domain."/modulos/admisiones";
$ruta_js_admisiones = $protocol.$domain."/site_media/js/admisiones";
$ruta_imagenes_admisiones = $protocol.$domain."/site_media/imagenes/admisiones";
$ruta_css_admisiones = $protocol.$domain."/site_media/css/admisiones";
$ruta_includes_admisiones = $protocol.$domain."/includes/admisiones";

$ruta_html_encuestas = $protocol.$domain."/modulos/encuestas";
$ruta_js_encuestas = $protocol.$domain."/site_media/js/encuestas";
$ruta_imagenes_encuestas = $protocol.$domain."/site_media/imagenes/encuestas";
$ruta_css_encuestas = $protocol.$domain."/site_media/css/encuestas";
$ruta_includes_encuestas = $protocol.$domain."/includes/encuestas";

$ruta_html_acad = $protocol.$domain."/modulos/acad";
$ruta_js_acad = $protocol.$domain."/site_media/js/acad";
$ruta_imagenes_acad = $protocol.$domain."/site_media/imagenes/acad";
$ruta_css_acad = $protocol.$domain."/site_media/css/acad";
$ruta_includes_acad = $protocol.$domain."/includes/acad";

$ruta_html_alumnos = $protocol.$domain."/modulos/alumnos";
$ruta_js_alumnos = $protocol.$domain."/site_media/js/alumnos";
$ruta_imagenes_alumnos = $protocol.$domain."/site_media/imagenes/alumnos";
$ruta_css_alumnos = $protocol.$domain."/site_media/css/alumnos";
$ruta_includes_alumnos = $protocol.$domain."/includes/alumnos";

$ruta_html_biblio = $protocol.$domain."/modulos/biblio";
$ruta_js_biblio = $protocol.$domain."/site_media/js/biblio";
$ruta_imagenes_biblio = $protocol.$domain."/site_media/imagenes/biblio";
$ruta_css_biblio = $protocol.$domain."/site_media/css/biblio";
$ruta_includes_biblio = $protocol.$domain."/includes/biblio";

$ruta_html_medic = $protocol.$domain."/modulos/medic";
$ruta_js_medic = $protocol.$domain."/site_media/js/medic";
$ruta_imagenes_medic = $protocol.$domain."/site_media/imagenes/medic";
$ruta_css_medic = $protocol.$domain."/site_media/css/medic";
$ruta_includes_medic = $protocol.$domain."/includes/medic";

$ruta_main=$protocol.$domain."/";

// Educalinks Admisiones
$ruta_documentos_requisitos = $protocol.$domain."/documentos/requisitos/";
$ruta_documentos_sintesis = $protocol.$domain."/documentos/sintesis/";
$ruta_documentos_fotos = $protocol.$domain."/documentos/solicitudes_fotos/";
//. Educalinks Admisiones
$pass_firma = "Gustavo123";
$ruta_documentosAutorizados = "C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/documentos/autorizados/".$_SESSION['directorio']."/";
$rutallave = "C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/finan/";
$rutallavedesarrollo = "C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/finan/";
$llavebabahoyo = "ruth_marlene_rizzo_maldonado.p12";
$llavedelfos = "jhonny_cristobal_salas_jaramillo.p12";
$llavedesarrollo = "gustavo_alfonso_decker_zambrano.p12";
$llaveliceonaval = "stiven_guido_martinez_chavez.p12";
$llaveliceopanamericano = "julio_alberto_cordova_empuno.p12";
$llavemoderna = "luz__maria_pesantes_fajardo.p12";
$llavenovus = "cesar_humberto_rodriguez_larrea.p12";
$llavecolegioamericanoguayaquil = "fersen_harold_leon_villamar.p12";
$clavellavebabahoyo = "Ec0mund0";	   
$clavellavedelfos = "Sarai676750";
$clavellaveliceonaval = "Guido.900";
$clavellaveliceopanamericano = "Liceo2020";
$clavellavemoderna = "RLgg2016";
$clavellavenovus = "Pepita1978001";
$clavecolegioamericanoguayaquil = "FL8239ad";
$clavellavedesarrollo = "Gustavo123";
/* *** Logos institucionales *** */
$ruta_logo_links						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/logo-links.png";
$ruta_logo_links_md						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/logo-links-md.png";
$ruta_logo_educalinks					="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/logo-educalinks.png";
$ruta_logo_educalinks_long_red			="/includes/common/logos/LOGO_EDUCALINKS_red.png";
$ruta_logo_educalinks_long_red_sm		="/includes/common/logos/LOGO_EDUCALINKS_red_small.png";
$ruta_logo_educalinks_long_white		="/includes/common/logos/LOGO_EDUCALINKS_white.png";
$ruta_logo_educalinks_long_white_sm		="/includes/common/logos/LOGO_EDUCALINKS_white_small.png";
$ruta_logo_educalinks_long_white_red	="/includes/common/logos/LOGO_EDUCALINKS_white_red.png";
$ruta_logo_redlinks_white				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/logo-redlinks-white.png";
$ruta_logo_redlinks_black				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/logo-redlinks-black.png";
$ruta_logo_redlinks_red_white			="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/logo-redlinks-red-&-white.png";

/* *** Logos clientes *** */
$ruta_logo_delfos				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/delfos/logo_distr.png";
$ruta_logo_delfosvesp			="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/delfosvesp/logo_distr.png";
$ruta_logo_desarrollo			="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/ecobab/logo_distr.png";
$ruta_logo_ecobab				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/ecobab/logo_distr.png";
$ruta_logo_ecobabvesp			="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/ecobabvesp/logo_distr.png";
$ruta_logo_liceonaval			="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceonaval/logo_inicial.png";
$ruta_logo_liceonavalvesp		="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceonavalvesp/logo_inicial.png";
$ruta_logo_liceopanamericano	="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceopanamericano/logo_inicial.png";
$ruta_logo_liceopanamericanosur	="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceopanamericanosur/logo_inicial.png";
$ruta_logo_moderna				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/moderna/logo_distr.png";
$ruta_logo_novus				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/novus/logo_distr.png";
$ruta_logo_uemag				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/uemag/logo_inicial.png";
$ruta_logo_cag					="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/cag/logo_inicial.png";

/* * Logos para impresion  institucionales** */

$print_ruta_logo_links				="includes/common/logos/logo-links.png";
$print_ruta_logo_links_md			="includes/common/logos/logo-links-md.png";
$print_ruta_logo_educalinks			="includes/common/logos/logo-educalinks.png";
$print_ruta_logo_educalinks_long_sm	="includes/common/logos/logo-educalinks-long-sm.png";
$print_ruta_logo_redlinks_white		="includes/common/logos/logo-redlinks-white.png";
$print_ruta_logo_redlinks_black		="includes/common/logos/logo-redlinks-black.png";
$print_ruta_logo_redlinks_red_white	="includes/common/logos/logo-redlinks-red-&-white.png";

/* *** Logos para impresion clientes *** */
$print_ruta_logo_delfos						="includes/common/logos/clientes/delfos/logo_distr.png";
$print_ruta_logo_delfosvesp					="includes/common/logos/clientes/delfosvesp/logo_distr.png";
$print_ruta_logo_desarrollo					="includes/common/logos/clientes/ecobab/logo_distr.png";
$print_ruta_logo_ecobab						="includes/common/logos/clientes/ecobab/logo_distr.png";
$print_ruta_logo_ecobabvesp					="includes/common/logos/clientes/ecobabvesp/logo_distr.png";
$print_ruta_logo_liceonaval					="includes/common/logos/clientes/liceonaval/logo_distr.png";
$print_ruta_logo_liceonavalvesp				="includes/common/logos/clientes/liceonavalvesp/logo_distr.png";
$print_ruta_logo_liceopanamericano			="includes/common/logos/clientes/liceopanamericano/logo_distr.png";
$print_ruta_logo_liceopanamericanosur		="includes/common/logos/clientes/liceopanamericanosur/logo_distr.png";
$print_ruta_logo_moderna					="includes/common/logos/clientes/moderna/logo_distr.png";
$print_ruta_logo_novus						="includes/common/logos/clientes/novus/logo_distr.png";
$print_ruta_logo_uemag						="includes/common/logos/clientes/uemag/logo_inicial.png";
$print_ruta_logo_cag						="includes/common/logos/clientes/cag/logo_inicial.png";

/* *** Logos (long) para web clientes *** */
$ruta_logo_delfos_bg						="includes/common/logos/clientes/delfos/logo_inicial_bg.png";
$ruta_logo_delfosvesp_bg					="includes/common/logos/clientes/delfosvesp/logo_inicial_bg.png";
$ruta_logo_desarrollo_bg					="includes/common/logos/clientes/ecobab/logo_inicial_bg.png";
$ruta_logo_ecobab_bg						="includes/common/logos/clientes/ecobab/logo_inicial_bg.png";
$ruta_logo_ecobabvesp_bg					="includes/common/logos/clientes/ecobabvesp/logo_inicial_bg.png";
$ruta_logo_liceonaval_bg					="includes/common/logos/clientes/liceonaval/logo_inicial_bg.png";
$ruta_logo_liceonavalvesp_bg				="includes/common/logos/clientes/liceonavalvesp/logo_inicial_bg.png";
$ruta_logo_liceopanamericano_bg				="includes/common/logos/clientes/liceopanamericano/logo_inicial_bg.png";
$ruta_logo_liceopanamericanosur_bg			="includes/common/logos/clientes/liceopanamericanosur/logo_inicial_bg.png";
$ruta_logo_moderna_bg						="includes/common/logos/clientes/moderna/logo_inicial_bg.png";
$ruta_logo_novus_bg							="includes/common/logos/clientes/novus/logo_inicial_bg.png";
$ruta_logo_uemag_bg							="includes/common/logos/clientes/uemag/logo_inicial_bg.png";
$ruta_logo_cag_bg							="includes/common/logos/clientes/cag/logo_inicial_bg.png";

/* *** Logos (long) para impresion clientes *** */
$print_ruta_logo_delfos_bg						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/delfos/logo_inicial_bg.png";
$print_ruta_logo_delfosvesp_bg					="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/delfosvesp/logo_inicial_bg.png";
$print_ruta_logo_desarrollo_bg					="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/ecobab/logo_inicial_bg.png";
$print_ruta_logo_ecobab_bg						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/ecobab/logo_inicial_bg.png";
$print_ruta_logo_ecobabvesp_bg					="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/ecobabvesp/logo_inicial_bg.png";
$print_ruta_logo_liceonaval_bg					="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceonaval/logo_inicial_bg.png";
$print_ruta_logo_liceonavalvesp_bg				="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceonavalvesp/logo_inicial_bg.png";
$print_ruta_logo_liceopanamericano_bg			="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceopanamericano/logo_inicial_bg.png";
$print_ruta_logo_liceopanamericanosur_bg		="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/liceopanamericanosur/logo_inicial_bg.png";
$print_ruta_logo_moderna_bg						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/moderna/logo_inicial_bg.png";
$print_ruta_logo_novus_bg						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/novus/logo_inicial_bg.png";
$print_ruta_logo_uemag_bg						="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/uemag/logo_inicial_bg.png";
$print_ruta_logo_cag_bg							="C:/Xampp/htdocs/nginx.educalinks.com.ec/public_html/includes/common/logos/clientes/cag/logo_inicial_bg.png";
?>