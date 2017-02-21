<div class="modal fade" id="modal_cirugia" tabindex="-1" role="dialog" aria-labelledby="modal_cirugia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_cirugia">Cirug&iacute;as de {per_nombre_completo}</h4>
			</div>
			<div class="modal-body" id="modal_cirugia_body">
				<div class="grid">
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_cid_fecha' name='{per}_lbl_cid_fecha'>Fecha de la cirug&iacute;a</label>
							<input type="text" class='form-control' id="{per}_cir_fecha" name="{per}_cir_fecha" value='{per_cir_fecha}' />
						</div>
					</div>
					<div class="row"><div class="col-sm-12"><br></div></div>
					<div class="row">
						<div class="col-sm-12">
							<label class="control-label" id='{per}_lbl_cir_nombre_desc' name='{per}_lbl_cir_nombre_desc'>Observaciones la cirug&iacute;a</label>
							<input type="text" class='form-control' id="{per}_cir_nombre_desc" name="{per}_cir_nombre_desc" value='{per_cir_nombre_desc}' />
						</div>
					</div>
					<div class="row"><div class="col-sm-12"><br></div></div>
					<div class="row">
						<div class="col-sm-2">
							<label>Localizaci&oacute;n</label>
						</div>
						<div class="col-sm-10">
							<input type="radio" id="{per}_rdb_localizacion" name="{per}_rdb_localizacion" value="INT" {cir_local_int}> Interna
							<input type="radio" id="{per}_rdb_localizacion" name="{per}_rdb_localizacion" value="EXT" {cir_local_ext}> Externa
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<label>Extensi&oacute;n</label>
						</div>
						<div class="col-sm-10">
							<input type="radio" id="{per}_rdb_extension" name="{per}_rdb_extension" value="MAY" {cir_ext_may}> Mayor
							<input type="radio" id="{per}_rdb_extension" name="{per}_rdb_extension" value="MEN" {cir_ext_men}> Menor
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
							<label>Prop&oacute;sito</label>
						</div>
						<div class="col-sm-10">
							<input type="radio" id="{per}_rdb_proposito" name="{per}_rdb_proposito" value="CUR" {cir_prop_cur}> Curativa
							<input type="radio" id="{per}_rdb_proposito" name="{per}_rdb_proposito" value="REP" {cur_prop_rep}> Reparadora
							<input type="radio" id="{per}_rdb_proposito" name="{per}_rdb_proposito" value="PAL" {cir_prop_pal}> Paliativa
							<input type="radio" id="{per}_rdb_proposito" name="{per}_rdb_proposito" value="COS" {cir_prop_cos}> Cosm&eacute;tica
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn bg-purple" 
						onclick="js_ficha_set_cirugia('{div_show_result}','{fmex_codi}',
									document.getElementById('{per}_cir_fecha'),
									document.getElementById('{per}_cir_nombre_desc'),
									document.getElementById('{per}_rdb_localizacion'),
									document.getElementById('{per}_rdb_extension'),
									document.getElementById('{per}_rdb_proposito'),
									'{per}')">
							<span class='fa fa-plus'></span>&nbsp;Agregar
				</button>
			</div>
		</div>
	</div>
</div>
