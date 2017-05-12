<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<?php include ('template/header.php');?>
		<?php $Menu=5;include("template/menu.php");?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Lista de citas</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-users"></i></a></li>
					<li class="active">Lista de citas</li>
				</ol>
			</section>
			<section class="content" id="mainPanel">
				<div id="information">
					<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
						<div class="panel-heading">
							<h3 class="panel-title"><span class="fa fa-search"></span>&nbsp;Búsqueda
							</h3>
						</div>
						<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
							<div id="tbl_search" class="form-horizontal" role="form">
								<div class='col-md-10 col-sm-12'>
									<div class='form-group'>
										<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_codi_in'>Fecha a consultar:</label>
										<div class="col-md-4 col-sm-8">
											<input class='form-control input-sm' id="hora_aten_repr_fecha" name="hora_aten_repr_fecha" type="text"  value="<? echo date("d/m/Y"); ?>">
										</div>
									</div>
								</div>
								<div class='col-md-2 col-sm-12'>
									<a id="bt_mate_add"  class="btn btn-default" target='_blank' onclick="javascript:getURL()"><span class="fa fa-print"></span> Imprimir Lista</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
		</div>
		<?php include("template/footer.php");?>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript"> 
			$("#hora_aten_repr_fecha").datepicker({
				onSelect: function(date){
					MostrarCitas (date);
				}
			});
			function getURL()
			{   var direccion;
				direccion="hora_aten_repr_listas_main_view.php?fecha=";
				direccion=direccion+document.getElementById('hora_aten_repr_fecha').value;
				window.open(direccion);
			}
			function MostrarCitas (fecha)
			{
				var xmlhttp;

				if (window.XMLHttpRequest)
				{
					xmlhttp = new XMLHttpRequest ();
				}
				else
				{
					xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
				}

				xmlhttp.onreadystatechange = function ()
				{
					if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						document.getElementById('div_citas').innerHTML=xmlhttp.responseText;
					}
				}

				xmlhttp.open("GET", "hora_aten_repr_listas_main_view.php?fecha="+fecha, true);
				xmlhttp.send();
			}
		</script>
	</body>
</html>