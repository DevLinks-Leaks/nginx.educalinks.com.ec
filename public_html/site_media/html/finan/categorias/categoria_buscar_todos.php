<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Categor&iacute;a</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" 
					onclick="edit(document.getElementById('codigo_mod').value,'resultado','{ruta_html_finan}/categorias/controller.php')">
						<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<!-- Modal Agregar-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Categor&iacute;a</h4>
			</div>
			<div class="modal-body" id="modal_add_body">
			  ...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" data-dismiss="modal" 
					onclick="add('resultado','{ruta_html_finan}/categorias/controller.php')">
					<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Agregar-->
<div class="box box-default">
	<div class="box-header with-border" >
	  <h3 class="box-title">
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
				onclick="carga_add('modal_add_body','{ruta_html_finan}/categorias/controller.php')" {disabled_agregar_categoria}
				data-placement='right' onmouseover='$(this).tooltip("show")' title='Agregar nueva categoría'>
			<span class='glyphicon glyphicon-tag'></span>&nbsp;<li class='fa fa-plus'></li></button>
			</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>
