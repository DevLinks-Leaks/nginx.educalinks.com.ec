<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=213;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Materias</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-address-book-o"></i></a></li>
						<li class="active">Materias</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(37)){?>
									<a id="bt_mate_add"  class="btn btn-primary" onclick="document.getElementById('mate_deta').value='';" data-toggle="modal" data-target="#mate_nuev" >
										<span class="fa fa-plus"></span> Agregar Materia
									</a><?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								
								<div id="curs_mate_main" >
								   <?php include ('cursos_materias_main_lista.php'); ?>
								</div>
							</div>
						</div>
						<div class="modal fade" id="mate_nuev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nueva Materia</h4>
                              </div>
                              <div class="modal-body">
                               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>Nombre: </td>
                                <td><input id="mate_deta" name="mate_deta" type="text" value="" style="width: 100%;"></td>
                              </tr>
                        		</table>
                        
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="mate_add(document.getElementById('mate_deta').value)">Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                               
                              </div>
                            </div>
                          </div>
                        </div>
                         <?php include ('cursos_materias_main_modal.php'); ?> 
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
		<script src="js/funciones_mate.js?<?=$rand;?>"></script>
		<script type="text/javascript" src="../framework/funciones.js?<?=$rand;?>"> </script>
		<script>
			$(document).ready(function() {
			    $('#mate_table').DataTable({
			    	language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
			    });
			});
		</script>

	</body>