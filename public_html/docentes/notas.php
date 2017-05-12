<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=4;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Notas</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-clipboard"></i></a></li>
						<li class="active">Notas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<div class="col-lg-12 col-sm-12 input-group input-group-sm">
										<span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver</span>
										<select id="cmb_mostrarMat" name="cmb_mostrarMat" class="form-control" 
											onchange='js_observaciones_clase_select(this.value);
													  view_accordeon("accordion-subinner_"+$(this).find(":selected").data("place"),$(this).find(":selected").data("curs_para_mate_prof_codi"))' 
											disabled='disabled'>
											<option value="">- Seleccione una materia -</option>
											<?php 
												$params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
												$sql_mate="{call prof_curs_para_mate_view(?,?)}";
												$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate);
												$aux_cmb = 1;
												while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
												{   echo '<option data-place="'.$aux_cmb.'" data-curs_para_mate_prof_codi="'.$row_curs_mate_view["curs_para_mate_prof_codi"].'" value="'.$row_curs_mate_view['curs_para_mate_codi'].'">'.
														$row_curs_mate_view["curs_deta"]." ".$row_curs_mate_view["para_deta"]." - ".$row_curs_mate_view["mate_deta"].'</option>';
													$aux_cmb++;
												}
											?>
										</select>
									</div>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div  id="notas_view">
									 <?php 	include('notas_viewv2.php') ?>
								</div> 
								<form id="form_notas" name="form_notas" action="" method="POST">
									<input type="hidden" name="curs_para_mate_prof_codi" id="curs_para_mate_prof_codi" value=""/>
									<input type="hidden" name="curs_para_mate_codi" id="curs_para_mate_codi" value=""/>
									<input type="hidden" name="peri_dist_codi" id="peri_dist_codi" value=""/>
									<input type="hidden" name="nota_perm_codi" id="nota_perm_codi" value=""/>
									<input type="hidden" name="opc" id="opc" value="upload_view"/>
								</form>                    
								<script src="js/notasv2.js?<?=$rand;?>"></script>
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
			$( document ).ready(function() {
				document.getElementById( "div_ini_wait" ).innerHTML = '';
				document.getElementById( "cmb_mostrarMat" ).disabled = false;
				document.getElementById( "cmb_mostrarMat" ).focus();
			});
			function js_observaciones_clase_select( value )
			{	var num_materias = document.getElementById( "hd_num_materias" ).value;
				var i = 0;
				for (i = 0; i < num_materias; i++ )
				{   document.getElementsByName( "mate_h_" + i )[0].style.display ='none';
				}
				document.getElementById( "mate_h_" + value ).style.display ='inline';
				//$.growl({ title: "Educalinks informa", message: "Materia seleccionada" });
			}
		</script>
	</body>
</html>