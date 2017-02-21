<div class="row">
	<div class="col-md-3">
		<a href="#"  onclick='js_mensajeria_compose();' class="btn btn-danger btn-block margin-bottom">Redactar</a>
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Carpetas</h3>
				<div class="box-tools">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body no-padding">
				<ul class="nav nav-pills nav-stacked">
					<li {active_in}><a href="#" onclick='get_box("active_in","../mensajeria/controller.php","formulario");'><i class="fa fa-inbox"></i> Inbox {inbox_count}</a></li>
					<li {active_sent}><a href="#" onclick='get_box("active_sent","../mensajeria/controller.php","formulario");'><i class="fa fa-envelope-o"></i> Enviados</a></li>
					<!--<li {active_draft}><a href="#" onclick='get_box("active_draft","../mensajeria/controller.php"),"formulario";'><i class="fa fa-file-text-o"></i> Borradores</a></li>-->
					<li {active_trash}><a href="#" onclick='get_box("active_trash","../mensajeria/controller.php","formulario");'><i class="fa fa-trash-o"></i> Eliminados {trash_count}</a></li>
				</ul>
			</div><!-- /.box-body -->
		</div><!-- /. box -->
	</div><!-- /.col -->
	<div class="col-md-9">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Read Mail</h3>
				<div class="box-tools pull-right">
					<a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
					<a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body no-padding">
				<div class="mailbox-read-info">
                    <h3>{mens_tema}</h3>
                    <h5>De: {mens_de} <span class="mailbox-read-time pull-right">{mens_fech_envi}</span></h5>
					<h5>Para: {mens_para}</h5>
				</div><!-- /.mailbox-read-info -->
				<div class="mailbox-controls with-border text-center">
                    {opciones_mensaje_top}
                    <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></button>
				</div><!-- /.mailbox-controls -->
				<div class="mailbox-read-message">
					{contenido_mensaje}
				</div><!-- /.mailbox-read-message -->
			</div><!-- /.box-body -->
			<div class="box-footer">
			</div><!-- /.box-footer -->
			<div class="box-footer">
				{opciones_mensaje_bottom}
                  <button class="btn btn-default" onclick='window.print();'><i class="fa fa-print"></i> Print</button>
			</div><!-- /.box-footer -->
		</div><!-- /. box -->
	</div><!-- /.col -->	
</div><!-- /.row -->