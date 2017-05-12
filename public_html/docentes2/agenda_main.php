<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=2;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Agenda</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-calendar"></i></a></li>
						<li class="active">Agenda</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a  href='agenda.php'
										class="btn btn-warning">
											<span class="fa fa-chevron-left"></span> Volver
									</a>
									<a  id="bt_agen_add"
										class="btn btn-primary"
										data-toggle="modal"
										data-target="#agen_nuev">
											<span class="fa fa-plus"></span> Agenda
									</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/agenda.js">
								</script>
								<div id="para_main">
									<?php include ('agenda_main_view.php'); ?>
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
				$("#agen_fech_ini").datepicker();
				$("#agen_fech_fin").datepicker();
				$("#tbl_agenda_main_view").DataTable();
			} );
		</script>
	</body>
</html>
<div 
	class="modal fade" 
	id="agen_nuev" 
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
				<span aria-hidden="true">
					&times;
				</span><span class="sr-only">Close</span>
		</button>
		<h4 class="modal-title" id="myModalLabel">Agendar Nueva Actividad</h4>
	  </div>
	  <div class="modal-body">
	  <div id="div_mate_edi"> 
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="25%">
					Fecha inicio
				</td>
				<td>
					<input class='form-control input-sm'
						id="agen_fech_ini" 
						name="agen_fech_ini" 
						type="text" value="<?= date('d/m/Y');?>"
						style="width:30%; margin-top: 10px">
				</td>
			  </tr>
			  <tr>
				<td>
					Fecha de Finalización
				</td>
				<td>
					<input class='form-control input-sm'
						id="agen_fech_fin" 
						name="agen_fech_fin" 
						type="text" 
						value="<?= date('d/m/Y');?>"
						style="width:30%; margin-top: 10px">
				</td>
			  </tr>
			  <tr>
				<td>
					Título
				</td>
				<td>
					<input class='form-control input-sm'
						name="agen_titu" 
						maxlength="30"
						type="text" 
						id="agen_titu" 
						value=""
						style="width:100%; margin-top: 10px;">
				</td>
			  </tr>
			  <tr>
				<td>
					Detalle
				</td>
				<td>&nbsp;
					
				</td>
			  </tr>
			  <tr>
				<td colspan="2">
					<textarea 
						name="agen_deta" 
						id="agen_deta" 
						cols="45" 
						rows="5"
						style="width:100%; margin-top: 10px; resize:none;"></textarea>
					<input class='form-control input-sm'
						type="hidden" 
						id="curs_para_mate_codi" 
						name="curs_para_mate_codi" 
						value="<?= $_GET['curs_para_mate_prof_codi'];?>">
				</td>
			  </tr>
			</table>
	  </div>
	  <div class="form_element">&nbsp;</div>
	  </div>
	  <div class="modal-footer">
		 <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="agen_add('para_main','script_agen.php','<?= $_GET['curs_para_mate_prof_codi'];?>','<?= $_GET['curs_para_mate_codi'];?>') ">Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	   
	  </div>
	</div>
  </div>
</div>