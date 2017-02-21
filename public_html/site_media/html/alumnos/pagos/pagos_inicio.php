<!-- Modal para mostrar pasos -->
<div class="modal fade" id="modal_CarouselPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id='modal_CarouselPago_header'>
				<h4 class="modal-title" id="myModalLabel">Educalinks informa: ¿Cómo funciona los pagos online?</h4>
			</div>
			<div class="modal-body" id="modal_CarouselPago_body">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
					<div class="item active">
					  <img src="../../includes/alumnos/boton_pagos/INSTRUCTIVO-BOTON-DE-PAGO-1.png" alt="Paso 1">
					</div>

					<div class="item">
					  <img src="../../includes/alumnos/boton_pagos/INSTRUCTIVO-BOTON-DE-PAGO-2.png" alt="Paso 2">
					</div>

					<div class="item">
					  <img src="../../includes/alumnos/boton_pagos/INSTRUCTIVO-BOTON-DE-PAGO-3.png" alt="Paso 3">
					</div>

					<div class="item">
					  <img src="../../includes/alumnos/boton_pagos/INSTRUCTIVO-BOTON-DE-PAGO-4.png" alt="Paso 4">
					</div>
					</div>

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
			<div class="modal-footer" >
				<button type="button" id='btn_modal_CarouselPago_close' name='btn_modal_CarouselPago_close' class="btn btn-default" data-dismiss="modal">Entiendo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal para mostrar pasos -->
<!-- Modal para mostrar el resultado del pago -->
<div class="modal fade" id="modal_resultadoPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id='modal_resultadoPago_header'>
				<h4 class="modal-title" id="myModalLabel">Educalinks informa</h4>
			</div>
			<div class="modal-body" id="modal_resultadoPago_body">
				...
			</div>
			<div class="modal-footer"  id='modal_resultadoPago_foot'>
				<button type="button" id='btn_modal_resultadoPago_close' name='btn_modal_resultadoPago_close' class="btn btn-default" data-dismiss="modal">Entiendo</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal para mostrar el resultado del pago -->
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-clipboard"></i> Deudas pendientes</a></li>
		<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-list"></i> Deudas pagadas</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			{deudas_pdtes}
		</div>
		<div class="tab-pane" id="tab_2">
			{deudas_pasadas}
		</div>
	</div>
</div>