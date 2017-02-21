<?php include("../clases/medicamentos.php");?>
<!-- =============================== -->
<div class="box box-default">
	<div class="box-header">
	  <h3 class="box-title">Búsqueda</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="resultado">
			<form action="../../medic/rep_inventarios_pdf/" target="_blank" enctype="multipart/form-data" method="post">
				<div class="row">
					<div class="col-md-3 col-xs-12 col-sm-12 bottom_10">
						<div class="input-group">
							<span class="input-group-addon" id="fecha_ini_addon">Fecha Inicio:</span>
							<input type="text" class="form-control" id="fecha_ini" name="fecha_ini" placeholder="dd/mm/yyyy" aria-describedby="fecha de inicio de movimientos">
						</div>
					</div>

					<div class="col-md-3 col-xs-12 col-sm-12 bottom_10">
						<div class="input-group">
							<span class="input-group-addon" id="fecha_fin_addon">Fecha Fin:</span>
							<input type="text" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="dd/mm/yyyy" aria-describedby="fecha de fin de movimientos">
						</div>
					</div>

					<div class="col-md-3 col-xs-12 col-sm-12 bottom_10">
						<div class="input-group">
							<?php
							$medicamentos = new Medicamentos();
							$medicamentos->get_all_medicamentos();
							?>
							<span class="input-group-addon" id="medicamentos_addon">Medicamento:</span>
							<select class="form-control" id="medicamentos" name="medicamentos" onchange="carga_stock('stock_div','../ajax_script/medicamentos.php',this.value);">
								<option value="">Todos...</option>
								<?php
								foreach($medicamentos->rows as $medicamento){
								?>
								<option value="<?=$medicamento['med_codigo'];?>"><?=$medicamento['med_descripcion'];?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-3 col-xs-12 col-sm-12 bottom_10">
						<div class="input-group">
							<button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


