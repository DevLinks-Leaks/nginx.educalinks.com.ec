<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=607;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Actas de calificaciones</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-bookmark"></i></a></li>
						<li class="active">Actas de calificaciones</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
                            <script type="text/javascript" src="js/select_actas.js?<?=$rand?>"></script>
                            <div class="box box-default">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <select class="form-control" onchange="CargarPeriodosDistribucion(this.value);CargarCursosParalelos(this.value);CargarCursosParalelosMaterias(0);"
                                                        style="width: 200px">
                                                        <?
                                                            $peri_codi=$_SESSION['peri_codi'];
                                                            $params = array($peri_codi);
                                                            $sql="{call peri_dist_cab_view(?)}";
                                                            $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
														?>
                                                    <option value="0">Elija</option>
                                                    <?php
                                                        while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view))
                                                        {
                                                    ?>
                                                    <option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
                                                        <?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
                                                    </option>
                                                    <?
                                                        }
                                                    ?>
                                                </select>
                                            </div>
				                            <div class="form-group col-md-3" id="div_sl_periodo_dist">
                                                <select class="form-control"
                                                        id="sl_periodo_dist"
                                                        disabled="disabled"
														style="width: 200px">
                                                        <option value="0">Parcial/Quimestre</option>
                                                </select>
											</div>
                                            <div class="form-group col-md-3" id="div_sl_paralelos">
                                                <select class="form-control"
                                                    disabled="disabled"
                                                    style="width: 200px"
													id="sl_paralelos">
													<option value="0">Curso/Paralelo</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3" id="div_sl_asignatura">
                                                <select class="form-control"
                                                    id="sl_asignatura"
                                                    name="sl_asignatura"
                                                    disabled="disabled"
                                                    style="width: 200px">
                                                    <option value="0"> Asignatura</option>
                                                </select>
                                            </div>
                                        </div>
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row alumnos_main_lista" >
                                    <div class="col-md-12">
                                        <table class="table table-striped" id="alum_table">
                                            <thead>
                                                <tr>
                                                    <th width="5%">&nbsp;</th>
                                                    <th width="65%" class="sort"><span class="icon-sort icon"></span>Reporte</th>
                                                    <th width="30%" class="sort"><span class="icon-cog icon"></span>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td><div id='acta_001_qm'></div></td><td><div id='acta_001_titulo'></div></td><td align='center'><div id='acta_001_opc'></div></td></tr>
                                                <tr><td><div id='acta_002_pm'></div></td><td><div id='acta_002_titulo'></div></td><td align='center'><div id='acta_002_opc'></div></td></tr>
                                                <tr><td><div id='acta_003_cq'></div></td><td><div id='acta_003_titulo'></div></td><td align='center'><div id='acta_003_opc'></div></td></tr>
                                                <tr><td><div id='acta_004_cf'></div></td><td><div id='acta_004_titulo'></div></td><td align='center'><div id='acta_004_opc'></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
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
		<script>
			function getURL()
			{   var direccion;
				direccion="cursos_paralelo_profe_listas_main_view.php?curs_para_codi=";
				direccion=direccion+document.getElementById('curso').value;
				window.location.href=direccion;
			}
		</script>
	</body>
</html>