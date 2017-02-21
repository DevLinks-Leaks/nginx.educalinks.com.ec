<?php
session_start();
include("../../framework/funciones.php");
session_activa();
$_SESSION['timeout'] = time();
if (($_SESSION['timeout'] + 25 * 60) < time()) {header("Location: ../index.php");}
if(isset($_POST['option'])){$option=$_POST['option'];}else{$option="";}
if(isset($_POST['fic_nombre'])){$fic_nombre=$_POST['fic_nombre'];}else{$fic_nombre="";}
if(isset($_POST['fic_codigo'])){$fic_codigo=$_POST['fic_codigo'];}else{$fic_codigo="";}
if(isset($_POST['fic_cam_pregunta'])){$fic_cam_pregunta=$_POST['fic_cam_pregunta'];}else{$fic_cam_pregunta="";}
if(isset($_POST['fic_cam_tipo'])){$fic_cam_tipo=$_POST['fic_cam_tipo'];}else{$fic_cam_tipo="";}
if(isset($_POST['fic_cam_codigo'])){$fic_cam_codigo=$_POST['fic_cam_codigo'];}else{$fic_cam_codigo="";}
if(isset($_POST['fic_cam_resp_respuesta'])){$fic_cam_resp_respuesta=$_POST['fic_cam_resp_respuesta'];}else{$fic_cam_resp_respuesta="";}
if(isset($_POST['fic_cam_resp_codigo'])){$fic_cam_resp_codigo=$_POST['fic_cam_resp_codigo'];}else{$fic_cam_resp_codigo="";}
switch ($option){
    case "carga_fichas_campos":
		include("../clases/Fichas.php");
		$fichas = new Fichas();
		$fichas->get_all_fichas_selectFormat();
        include("../combo_fichas.php");
        break;
    case "agrega_ficha":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
        $fichas->add_ficha($fic_nombre,$_SESSION['usua_codi']);
		$fichas->get_all_fichas_selectFormat();
        include("../combo_fichas.php");
        break;
	case "agrega_campo":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
        $fichas->add_ficha_campo($fic_codigo,$fic_cam_pregunta,$fic_cam_tipo,$_SESSION['usua_codi']);
		$fichas->get_all_fichas_campos($fic_codigo);
		include("../tabla_preguntas.php");
        break;
	case "borra_campo":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
        $fichas->del_ficha_campo($fic_cam_codigo);
		$fichas->get_all_fichas_campos($fic_codigo);
		include("../tabla_preguntas.php");
        break;
	case "edita_campo":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
        $fichas->edi_ficha_campo($fic_cam_codigo,$fic_cam_pregunta,$fic_cam_tipo);
		$fichas->get_all_fichas_campos($fic_codigo);
		include("../tabla_preguntas.php");
        break;
	case "carga_campos":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
		$fichas->get_all_fichas_campos($fic_codigo);
		include("../tabla_preguntas.php");
        break;
	case "carga_respuestas":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
		$fichas->get_all_fichas_campos_respuestas($fic_cam_codigo);
		include("../tabla_respuestas.php");
        break;
	case "agrega_respuesta":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
		$fichas->fichas_campos_respuesta_add($fic_cam_codigo,$fic_cam_resp_respuesta,$_SESSION['usua_codi']);
		include("../tabla_respuestas.php");
        break;
	case "borra_respuesta":
        include("../clases/Fichas.php");
        $fichas = new Fichas();
		$fichas->fichas_campos_respuesta_del($fic_cam_resp_codigo);
		include("../tabla_respuestas.php");
        break;
	case "carga_preguntas":
		include("../clases/Fichas.php");
        $fichas = new Fichas();
		$fichas->get_all_fichas_campos($fic_codigo);?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php $i=0;
		$respuestas = new Fichas();
		foreach($fichas->rows as $ficha){$i++;
			include("../ficha_preguntas.php");
        }
		?>
        </div>
        <?php
        break;
    default:
        break;
}