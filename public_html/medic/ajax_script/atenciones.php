<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}

if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
if(isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{$alum_codi="";}
if(isset($_POST['curs_para_codi'])){$curs_para_codi=$_POST['curs_para_codi'];}else{$curs_para_codi="";}
switch ($option){
    case "carga_materias":
        include("../combo_materias_alumno.php");
        break;    
    case "carga_alergias":
        include("../clases/Atenciones.php");
        $alergias = new Atenciones();
        $alergias->get_alumno_alergias($alum_codi);
        $html="<ul>";
        foreach($alergias->rows as $alergia){
            $html.="<li>".$alergia['alum_alerg_descripcion']."</li>";
        }
        $html.="</ul>";
        echo $alergias->mensaje;
        echo $html;
        break; 
    case "agrega_atencion":
        include("../clases/Atenciones.php");
        $atenciones = new Atenciones();
        $atencion=json_decode($_POST['atencion_json'],true);
        $atenciones->alum_codi=$atencion['cabecera']['alum_codi'];
        $usua_tipo=1;
        $atenciones->add_atencion_cabecera($atencion['cabecera']['alum_codi'],$atencion['cabecera']['mate_codi'],$atencion['cabecera']['curs_para_codi'],$atencion['cabecera']['prof_codi'],$atencion['cabecera']['motivo_id'],$atencion['cabecera']['observaciones'],$atencion['cabecera']['motivo'],$usua_tipo);
        $aten_codigo=$atenciones->aten_codigo;
        foreach($atencion['detalle'] as $detalle){
            $atenciones->add_atencion_detalle($aten_codigo,$detalle['med_codigo'],$detalle['med_cantidad'],$_SESSION['usua_codi']);
        }
        echo 
        include("../tabla_atenciones_hoy.php");
        break;
    case "pay_attention":
        require_once("../clases/Atenciones.php");
        $atenciones_search = new Atenciones();
        $atenciones_search->get_atenciones_search( $_POST['fechavenc_ini'], $_POST['fechavenc_fin'] );
		$atencion_detalles_hoy = new Atenciones();
        include("../tabla_atenciones_search.php");
        break;
    default:
	echo "resultado desconocido";
        break;
}