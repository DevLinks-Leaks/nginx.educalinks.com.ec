<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=418;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php  
					session_start();	 
					include ('../framework/dbconf.php');
					include ('script_cursos.php'); 
					
					$peri_codi=$_GET['peri_codi'];
					$params = array($peri_codi);
					$sql="{call peri_info(?)}";
					$peri_info = sqlsrv_query($conn, $sql, $params);  
					$row_peri_info = sqlsrv_fetch_array($peri_info);
					?>
					<h1>Etapas Periodo <?= $row_peri_info['peri_deta']; ?> </h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Etapas Periodo</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(68)){?>
									<a class="btn btn-primary" id="bt_peri_add" data-toggle="modal" data-target="#peri_nuev" >
										<span class="fa fa-plus"></span> Nueva Etapa del Periodo
									</a><?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<input type="hidden" value="<?= $peri_codi?>" id="e_peri_codi">
								<script src="../framework/funciones.js"></script>
								<script src="js/funciones_periodo_etapa.js?<?=$rand;?>"></script>
								<div id="peri_etap_view">
									<?php include ('admin_periodos_etapas_view.php'); ?>
								</div>
							</div>
						</div>
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
        <!-- Modal -->
        <div 
            class="modal fade" 
            id="peri_nuev" 
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
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Nueva Etapa</h4>
              </div>
              <div class="modal-body">
               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="25%">Etapas: </td>
                        <td>
                            <?php  
                                $params = array();
                                $sql="{call peri_etap_view()}";
                                $peri_etap_view = sqlsrv_query($conn, $sql, $params);  
                            ?> 
                            <select 
                                name="n_peri_etap_codi"   
                                id="n_peri_etap_codi" 
                                onchange="peri_dist_peri_libt_view(<?= $peri_codi; ?>,this.value)"
                                style="width: 100%; margin-top: 5px;">
                                <?php  
                                while ($row_peri_etap_view = sqlsrv_fetch_array($peri_etap_view)) 
                                { 
                                ?>     
                                <option 
                                    value="<?= $row_peri_etap_view['peri_etap_codi']; ?>/<?= $row_peri_etap_view['peri_etap_unid']; ?>">
                                    <?= $row_peri_etap_view['peri_etap_deta']; ?>    
                                </option>
                                <?php 
                                }  
                                ?>    
                            </select>
                        </td> 
                    </tr>
                    <tr class="dynamic_2" style="display: none;">
                        <td width="25%">
                            Periodo a preinscribir:
                        </td>
                        <td width="75%">
                        <?
                            $params = array();
                            $sql="{call peri_view()}";
                            $peri_view = sqlsrv_query($conn, $sql, $params);
                        ?>
                        <select
                            name="sl_peri_codi_dest"
                            id="sl_peri_codi_dest"
                            style="width:75%; margin-top:10px;" >
                                <option value="0">Elija</option>
                           <?php  while ($row_peri_view = sqlsrv_fetch_array($peri_view)) { 
                                    if($row_peri_view['peri_codi']!=$peri_codi){
                            ?>
                                <option value="<?= $row_peri_view['peri_codi']; ?>">
                                    <?= $row_peri_view['peri_deta']; ?> - Año :<?= $row_peri_view['peri_ano']; ?>  
                                </option>
                            <?} } ?>
                        </select>
                        </td>
                    </tr>
                    <tr class="dynamic_3" style="display: none;">
                          <td width="25%">
                              Código HTML encuesta:
                          </td>
                          <td width="75%">
                            <textarea id="txt_encuesta" style="width:100%; margin-top:10px;"  rows="3" ></textarea>
                          </td>
                    </tr>
                    <tr class="dynamic_1" style="display: none;">
                        <td width="25%">
                            Tipo periodo:
                        </td>
                        <td width="75%">
                        <?
                            $params = array($peri_codi);
                            $sql="{call peri_dist_cab_view(?)}";
                            $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
                        ?>
                        <select
                            name="sl_peri_dist_cab"
                            id="sl_peri_dist_cab"
                            style="width:75%; margin-top:10px;"
                            
                            onChange="CargarUnidades(this.value, 1);">
                                <option value="0">Elija</option>
                           <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { ?>
                                <option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
                                    <?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
                                </option>
                            <? } ?>
                        </select>
                        </td>
                    </tr>
                    <tr class="dynamic_1"  style="display: none;">
                        <td>
                            Unidad: 
                               </td>
                        <td> 
                        <div id="div_unidad">
                            <select 
                                name="pg_peri_dist_codi"   
                                id="pg_peri_dist_codi" 
                                style="width: 75%; margin-top: 5px;"
                                > 
                            </select> 
                        </div>  
                        </td>
                    </tr>
                    <tr>
                        <td>Desde:</td>                                
                        <td>
                            <input 
                                id="n_peri_fech_ini"   
                                type="text" 
                                value="<?= date('Y-m-d');?>"
                                style="width: 25%; margin-top: 5px;">
                        </td>
                    </tr>
                    <tr>
                        <td>Hasta: </td>                             
                        <td>
                            <input 
                                id="n_peri_fech_fin"   
                                type="text" 
                                value="<?= date('Y-m-d');?>"
                                style="width: 25%; margin-top: 5px;">
                        </td>
                    </tr>
                    
                </table>
                <div class="form_element">&nbsp;</div> 
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancelar
                </button>
                <button 
                    id="btn_etapa_add"
                    type="button" 
                    class="btn btn-success"  
                    onClick="peri_acti_add(<?= $peri_codi;?>)"><span class='fa fa-save'></span> Guardar cambios
                </button>
              </div>
            </div>
          </div>
        </div>
		<script>
			$(document).ready(function(){
				$("#n_peri_fech_ini").datepicker({ format: 'yyyy-mm-dd' });
				$("#n_peri_fech_ini").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
				$("#n_peri_fech_fin").datepicker({ format: 'yyyy-mm-dd' });
				$("#n_peri_fech_fin").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
			});
		</script>
	</body>
</html>
