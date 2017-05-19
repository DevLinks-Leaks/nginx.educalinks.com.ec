<div class="modal fade" id="modal_encu" tabindex="-1" role="document" aria-labelledby="pop_up_repr">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Encuesta</b></h4>
			</div>
			<div class="modal-body">
				<?=$_SESSION['encu_deta'];?>
			</div>
			<div class="modal-footer">
				<button id="btn_encuesta" type="button" class="btn btn-success" onclick="registrar_encuesta(<?=$_SESSION['encu_codi'];?>);">Completar encuesta</button>
			</div>
		</div>
	</div>
</div>
<style>
	.modal-body iframe{
		width:100%;
	}
</style>