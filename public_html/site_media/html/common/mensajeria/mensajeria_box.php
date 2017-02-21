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
				<h3 class="box-title">Inbox</h3>
				<div class="box-tools pull-right">
					<div class="has-feedback">
						<input type="text" class="form-control input-sm" placeholder="Search Mail">
						<span class="glyphicon glyphicon-search form-control-feedback"></span>
					</div>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body no-padding">
				<div class="mailbox-controls">
					<!-- Check all button -->
					<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
					<div class="btn-group">
						<button class="btn btn-default btn-sm" onclick='delete_checked("tbl_mailbox");'><i class="fa fa-trash-o"></i></button>
						<button class="btn btn-default btn-sm" onclick='reply_checked("tbl_mailbox");'><i class="fa fa-reply"></i></button>
						<button class="btn btn-default btn-sm" onclick='share_checked("tbl_mailbox");'><i class="fa fa-share"></i></button>
					</div><!-- /.btn-group -->
					<button class="btn btn-default btn-sm"  onclick='refresh_mailbox("tbl_mailbox");'><i class="fa fa-refresh"></i></button>
				<!--<div class="pull-right">
					1-50/200
					<div class="btn-group">
						<button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
						<button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
					</div>
					</div>-- /.pull-right -->
			    </div>
			    <div class="table-responsive mailbox-messages">
					<table id='tbl_mailbox' name='tbl_mailbox' class="table table-hover table-striped">
						<tbody>
							{inbox_tbl_body}
						</tbody>
					</table><!-- /.table -->
				</div><!-- /.mail-box-messages -->
			</div><!-- /.box-body -->
			<div class="box-footer no-padding">
				<div class="mailbox-controls">
					<!-- Check all button -->
					<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
					<div class="btn-group">
											<button class="btn btn-default btn-sm" onclick='delete_checked("tbl_mailbox");'><i class="fa fa-trash-o"></i></button>
					<button class="btn btn-default btn-sm" onclick='reply_checked("tbl_mailbox");'><i class="fa fa-reply"></i></button>
					<button class="btn btn-default btn-sm" onclick='share_checked("tbl_mailbox");'><i class="fa fa-share"></i></button>
					</div><!-- /.btn-group -->
					<button class="btn btn-default btn-sm"  onclick='refresh_mailbox("tbl_mailbox");'><i class="fa fa-refresh"></i></button>
					<!--<div class="pull-right">
						1-50/200
						<div class="btn-group">
							<button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
							<button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
						</div>
					</div> /.pull-right -->
				</div>
			</div>
		</div><!-- /. box -->
	</div><!-- /.col -->
</div><!-- /.row -->