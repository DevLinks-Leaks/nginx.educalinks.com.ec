<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=206;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Cursos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Cursos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(34)){?>
										  <a id="bt_curs_add" class="btn btn-primary" onclick="curs_nuev_dial();" data-toggle="modal" data-target="#curs_nuev" >
										  <span class="fa fa-plus"></span> Nuevo Curso
										  </a>
									<?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script src="js/funciones_curs.js"></script> 
								<div id="curs_curs_main" >
									<?php include ('cursos_cursos_main_lista.php'); ?>
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
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#rol_table').DataTable() ;
			} );
		</script>
	</body>
</html>
                    <div 
                    	class="modal fade" 
                        id="curs_nuev" 
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
                                	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
                            <h4 class="modal-title" id="myModalLabel">Nuevo curso</h4>
                          </div>
                          <div class="modal-body">
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>
                                    Nombre: 
                                </td>
                                <td>
                                    <input 
                                        id="n_curs_deta" 
                                        name="n_curs_deta" 
                                        type="text" 
                                        value=""
                                        style="width: 100%; margin-top: 5px;">
                                </td>
                              </tr>
                              <tr>
                                <td>Nivel: </td>
                                <td>
                                    <? 	
                                        $params = array();
                                        $sql="{call nive_view()}";
                                        $nive_view = sqlsrv_query($conn, $sql, $params);  
                                    ?>
                                    <select  id="n_nive_codi" style="width: 75%; margin-top: 10px;">
                                        <? while($row_nive_view = sqlsrv_fetch_array($nive_view)){ ?>
                                          <option value="<?= $row_nive_view['nive_codi'];?>" <? if ($row_nive_view['nive_codi']==$row_curs_view["nive_codi"] ) echo 'selected="selected"';?> >
                                            <?= $row_nive_view['nive_deta'];?></option>
                                        <? } ?>
                                    </select>     
          
                                </td>
                              </tr>
                            </table>
                    		<div class="form_element">&nbsp;</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="curs_add_upd()">
							Aceptar
						</button>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-default" data-dismiss="modal">
                        	Cerrar
						</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input id="n_curs_codi" name="n_curs_codi" type="hidden" value="">                  
                    <input id="n_que" name="n_que" type="hidden" value="">