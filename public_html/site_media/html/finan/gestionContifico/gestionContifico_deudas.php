<div id="frm_ingresoGrupoEconomico" >    
    <div class="row">
		<div class="col-sm-2">
			<button class="btn btn-success" type="button" aria-hidden='true' data-toggle='modal'  
				onclick="js_aniosPeriodo_migrarfacturas(document.getElementById('codigomes').value,'migrardeudasresult','{ruta_html_finan}/aniosPeriodo/controller.php')" {disabled_agregar_item}>
					<span class='glyphicon glyphicon-send'></span>&nbsp;Migrar lote</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div id="resultado"> 
				<input type="hidden" id="codigomes" name="codigomes" value="{mes}" />
				{tabladeudasmigrar}
			</div>
		</div>
	</div>
</div>