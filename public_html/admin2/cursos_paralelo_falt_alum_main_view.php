<?php

	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	include ('script_cursos.php');

	if(isset($_GET['curs_para_codi'])){
		 $curs_para_codi=$_GET['curs_para_codi'];
	}
	if(isset($_POST['curs_para_codi'])){
		 $curs_para_codi=$_POST['curs_para_codi'];
	}

	if(isset($_POST['add_falt'])){

		$falt_tipo_codi= $_POST['falt_tipo_codi'];
	  	$alum_curs_para_codi= 	$_POST['alum_curs_para_codi'];
	  	$falt_fech=substr($_POST['falt_fech'],6,4)."".substr($_POST['falt_fech'],3,2)."".substr($_POST['falt_fech'],0,2);;
		$peri_dist_codi=$_POST['peri_dist_codi'];

		$params = array($falt_tipo_codi,$alum_curs_para_codi,$falt_fech,$peri_dist_codi);
		$sql="{call falt_add(?,?,?,?)}";

		sqlsrv_query($conn, $sql, $params);

		//Para auditoría
		$detalle="Código de tipo de falta: ".$falt_tipo_codi;
		$detalle.=" Código alumno curso paralelo: ".$alum_curs_para_codi;
		$detalle.=" Código periodo distribución: ".$peri_dist_codi;
		$detalle.=" Fecha de falta: ".$falt_fech;
		registrar_auditoria (20, $detalle);
	}

	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_falt_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);
	$cc = 0;

	$params = array($curs_para_codi);
	$sql="{call curs_para_info(?)}";
	$curs_para_info = sqlsrv_query($conn, $sql, $params);
 	$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
?>

<input  type="hidden" value="<?= $curs_para_codi; ?>" id="curs_para_codi"/>
<table  class="table_striped">
        <thead>
            <tr>
              <th width="290"  align="left">Alumnos</th>
              <th width="2%"   align="center" valign="middle">FI</th>
              <th width="2%"   align="center" valign="middle">FJ</th>
              <th width="2%"   align="center" valign="middle">AI</th>
              <th width="2%"  align="center" valign="middle">AJ</th>
              <th width="25%">Opciones</th>
            </tr>
        </thead>
        <tbody>





            <?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?>
            <tr>


              <td  >

                <table class="table_basic"  width="100%" >
                  <tr>
                    <?php
                    $file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';


                    if (file_exists($file_exi)) {
                      $pp=$file_exi;
                    } else {
                      $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
                    }
                    ?>
                    <td width="4%" class="center"><?php echo $cc; ?></td>
                    <td width="12%" class="center" ><img src="<?php echo $pp; ?>"   style=" text-align:right; border:none; width:40px; height:40px;"/></td>
                    <td width="228" class="left" ><?= $row_alum_curs_para_view["alum_apel"]; ?> <?= $row_alum_curs_para_view["alum_nomb"]; ?></td>
                  </tr>
                </table>

              </td>
              <td align="center" valign="middle"><span class="left">
                <?= $row_alum_curs_para_view["cc_fi"]; ?>
              </span></td>
              <td align="center" valign="middle"><span class="left">
                <?= $row_alum_curs_para_view["cc_fj"]; ?>
              </span></td>
              <td align="center" valign="middle"><span class="left">
                <?= $row_alum_curs_para_view["cc_ai"]; ?>
              </span></td>
              <td align="center" valign="middle"><span class="left">
                <?= $row_alum_curs_para_view["cc_aj"]; ?>
              </span></td>

              <td align="left">

                    <div class="menu_options">
                          <ul>
                           <li>

                              <a  class="option"   onclick="falt_set(<?= $row_alum_curs_para_view["alum_codi"]; ?>,'<?= $row_alum_curs_para_view["alum_apel"]; ?> <?= $row_alum_curs_para_view["alum_alum"]; ?>',<?= $row_alum_curs_para_view["alum_curs_para_codi"]; ?>)" data-toggle="modal" data-target="#ModalFalta" title="">
                                  <span class="icon-add icon"> </span> Agregar
                              </a>

                            </li>
                            <li>

                              <a href="cursos_paralelo_falt_alum_main_deta.php?alum_curs_para_codi=<?= $row_alum_curs_para_view["alum_curs_para_codi"]; ?>"  class="option" >
                                  <span class="icon-checkbox-checked"> </span> Ver Faltas
                              </a>

                            </li>
                          </ul>
                        </div>
                </td>
              </tr>
            <?php }?>

            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>

    </tbody>
</table>

<!--**************  MODAL    Cruso ************************** -->
<div
	class="modal fade"
    id="ModalFalta"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button
        	type="button"
            class="close"
            data-dismiss="modal">
            	<span aria-hidden="true">&times;</span>
                <span class="sr-only"s>Close</span>
		</button>
        <h4 class="modal-title" id="myModalLabel">
        	Nueva Falta de <label id="lb_nombre"></label>
		</h4>
      </div>
      <div id="modal_main" class="modal-body">
      <div id="falt_add">
		<input type="hidden" value="" id="f_alum_curs_para_codi"/>
        <input type="hidden" value="" id="f_codi_alum"/>
        <table width="100%">
          <tr>
            <td>Periodo:</td>
            <td>
            <?
				$peri_codi= $row_curs_para_info['peri_codi'];
				$peri_dist_nive= 2;

				$params = array($curs_para_codi,$peri_dist_nive);
				$sql="{call peri_dist_peri_nive_view_NEW(?,?)}";
				$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);
			?>
              <select name="f_peri_dist_codi" id="f_peri_dist_codi" style="width: 75%; margin-top: 10px;">
               <?php  while ($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view)) { ?>
                <option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi']; ?>"><?= $row_peri_dist_peri_nive_view['peri_dist_deta']; ?> (<?= $row_peri_dist_peri_nive_view['peri_dist_padr_deta']; ?>)</option>
                <? } ?>
            </select></td>
          </tr>
          <tr>
            <td>Tipo de Falta: </td>
            <td><?

				$params = array();
				$sql="{call falt_tipo_view()}";
				$falt_tipo_view = sqlsrv_query($conn, $sql, $params);

			?>
              <select name="f_falt_tipo_codi" id="f_falt_tipo_codi" style="width: 75%; margin-top: 10px;">
                <?php  while ($row_falt_tipo_view = sqlsrv_fetch_array($falt_tipo_view)) { ?>
                <option value="<?= $row_falt_tipo_view['falt_tipo_codi']; ?>">
                  <?= $row_falt_tipo_view['falt_tipo_deta']; ?>
        		</option>
                <? } ?>
            </select></td>
          </tr>
          <tr>
            <td>Fecha:</td>
            <td align="left" valign="middle" ><input id="f_falt_fech" name="f_falt_fech" type="text" value="<?= date('d/m/Y');?>" style="width: 25%; margin-top: 10px;"></td>
          </tr>
       </table>

 	<script>
		$("#f_falt_fech").datepicker();
	</script>

     </div>
     <div class="form_element">&nbsp;</div>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-primary" onclick="alum_curs_para_falt_add()" data-dismiss="modal" >Aceptar</button> &nbsp;&nbsp;&nbsp;
       <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
     </div>
   </div>
 </div>
</div>

 <!--**************  ///////// MODAL   /////////// ************************** -->
