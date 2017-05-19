
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
 	$op	= 2;
	if(isset($_POST['OP'])) 
		$op=$_POST['OP'];
	
	$mens_usua=$_SESSION['USUA_DE'];
	$mens_usua_tipo=$_SESSION['USUA_TIPO'];

	$params = array($op,$mens_usua,$mens_usua_tipo,$rowcount);
	$sql="{call mens_view_op(?,?,?,?)}";
	$mens_view_op = sqlsrv_query($conn, $sql, $params);  
	
	$page		= 0; 	/* Contador pagina */
	$cc_page	= 0;  	/* Contador division */
	$cc			= 0;  	/* Contador General */
	$page_div 	= 10;	/* Numero por pagina */
  
	$html_bandeja='
<div class="row">
	<div class="col-sm-12">
		<div class="lista">
			<table id="mensajes_table" name="mensajes_table" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="5%">
							<div style="font-size:x-small;text-align:center;" >
								<input style="display:none;" type="checkbox" id="ckb_codigoDocumento_head" name="ckb_codigoDocumento_head" onClick="js_gestionFactura_select_all(this)"></input>
							</div>
						</th>';
						switch($op)
						{   case 1: $html_bandeja.='
								<th width="20%" style="text-align: center;">Título</th>
								<th width="25%" style="text-align: center;" class="sort"><span class="icon-sort icon"></span>Enviado por</th>
								<th width="15%" style="text-align: center;" class="center"></span>Fecha Recibido</th>
								<th width="7%" style="text-align: center;" >Eliminar</th>';
								break;
							case 2: $html_bandeja.='
								<th width="20%" style="text-align: center;">Título</th>
								<th width="25%" style="text-align: center;" class="sort"><span class="icon-sort icon"></span>Enviado por</th>
								<th width="15%" style="text-align: center;" class="center"></span>Fecha Recibido</th>
								<th width="7%" style="text-align: center;">Eliminar</th>';
								break;
							case 3: $html_bandeja.='
								<th width="20%" style="text-align: center;">Título</th>
								<th width="25%" style="text-align: center;" class="sort"><span class="icon-sort icon"></span>Enviado a</th>
								<th width="15%" style="text-align: center;" class="center"></span>Fecha Enviado</th>
								<th width="15%" style="text-align: center;" class="center">Fecha Lectura</th>
								<th width="7%" style="text-align: center;">Eliminar</th>';
								break;
							case 4: $html_bandeja.='
								<th width="20%" style="text-align: center;">Título</th>
								<th width="20%" style="text-align: center;">Detalle</th>
								<th width="15%" style="text-align: center;" class="center"></span>Enviado a</th>
								<th width="15%" style="text-align: center;" class="center">Enviado por</th>
								<th width="5%" style="text-align: center;">Eliminar</th>';
								break;
						}
			$html_bandeja.='				
					</tr>
				</thead>
				<tbody>';
			$c=0;
			while ($row_mens_view_op = sqlsrv_fetch_array($mens_view_op)) 
			{	$cc +=1;
				$html_bandeja.='
				<tr id="tr_row_'.$row_mens_view_op["mens_codi"].'" name="tr_row_'.$row_mens_view_op["mens_codi"].'" style="font-size: small; vertical-align: middle; ">
					<td id="td_select_'.$c.'" name="td_select_'.$c.'" align="center"><div style="font-size:x-small;">'.
						'<input type="checkbox" id="ckb_codigoDocumento" name="ckb_codigoDocumento[]" value="'.$row_mens_view_op["mens_codi"].'"
							onclick="js_mensajes_select_check_ind (this, '.$c.')"></input>'.
						'</div>
					</td>
					<td class="titulares">
					  '. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
							<a style="cursor:pointer;"
							  class="option" 
							  data-toggle="modal" 
							  data-target="#modal_leer_ext"
							  onclick="load_ajax_mens_responder(\'modal_main_ext\',\'mensajes_info.php\','.$row_mens_view_op["mens_codi"].');mens_alert_upda();">
								<span class="fa '. ( $row_mens_view_op["mens_fech_lect"] == NULL ? 'fa-envelope' : 'fa-envelope-open-o').'"></span>&nbsp;'.$row_mens_view_op["mens_titu"].'
							</a>
					  '. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
					</td>';
					if($op==4)
					{	$html_bandeja.='
					  <td align="center">'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
							'.substr($row_mens_view_op["mens_deta"],0,40).'....'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
					  </td>';
					}else
					{	$html_bandeja.='
					  <td align="center">'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
							'.$row_mens_view_op["mens_nomb"].''. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
					  </td>';
					}
					if($op==4)
					{	$html_bandeja.='
					  <td align="center">'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
							'.$row_mens_view_op["mens_de_nomb"].''. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
					  </td>
					  <td align="center">'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
							'.$row_mens_view_op["mens_para_nomb"].''. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
					  </td>';
					}
					else
					{	$html_bandeja.='
					  <td align="center">'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
					   '.date_format( $row_mens_view_op["mens_fech_envi"], 'd/M/Y  h:m:s' ).'
						'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
					  </td>';
						if($op==1 or $op==2)
						{	//do nothing
						}
						else
						{	$html_bandeja.='
						<td align="center">'. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '<b>' : '').'
							'.date_format( $row_mens_view_op["mens_fech_lect"], 'd/M/Y  h:m:s' ).''. ( $row_mens_view_op["mens_fech_lect"] == NULL ? '</b>' : '').'
						</td>';
						}
					}
				$html_bandeja.='
				
				<td style="text-align: center;">';
					if($op==1 or $op==2 or $op==3)
					{	$html_bandeja.='<a 
								class="btn btn-danger" 
								onclick="elimina_mensaje('.$row_mens_view_op["mens_codi"].','.$op.');" >
								<span class="fa fa-trash-o"></span>
							  </a>';
					}
					$html_bandeja.='
					</td>
				</tr>';
				$c++;
			}
		$html_bandeja.='
				</tbody>
			</table>
		</div>
	</div>
</div>';
if( $cc == 0)
	$html_bandeja='<br>&nbsp;&nbsp;No se encontraron mensajes en esta bandeja.<br><br>';
$recibidos = $eliminados = $enviados = $in_active = $trash_active = $sent_active = $bandeja_nombre = "";
if($op==1 or $op==2)
{	$recibidos = $cc;
	$in_active = ' class="active" ';
	$bandeja_nombre = ' Bandeja de entrada';
}
else if($op==4)
{	$eliminados =  $cc;
	$trash_active = ' class="active" ';
	$bandeja_nombre = ' Mensajes eliminados';
}
else
{	$enviados =  $cc;
	$sent_active = ' class="active" ';
	$bandeja_nombre = ' Mensajes enviados';
}
?>

						<div class="row">
							<div class="col-md-3">
								<a id='bt_aula_add' href="#" class="btn btn-danger btn-block margin-bottom"
									onclick="load_ajax_mens_nuev('div_mens_nuev','mensajes_nuevo_script.php','d=d');"
									data-toggle="modal" data-target="#nuev_mens">Redactar</a>
								<div class="box box-solid">
									<div class="box-header with-border">
										<h3 class="box-title">Carpetas</h3>
										<div class="box-tools">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div>
									</div>
									<div class="box-body no-padding">
										<ul class="nav nav-pills nav-stacked">
											<li <?php echo $in_active; ?>><a href="#" onclick="load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=2',4);"><i class="fa fa-inbox"></i> Inbox <span class="label label-primary pull-right"><?php echo $recibidos; /*variable traida de mensajes_view.php*/?></span></a></li>
											<li <?php echo $sent_active; ?>><a href="#" onclick="load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=3',5);"><i class="fa fa-envelope-o"></i> Enviados <span class="label label-primary pull-right"><?php echo $enviados;?></a></li>
											<li <?php echo $trash_active; ?>><a href="#" onclick="load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=4',5);"><i class="fa fa-trash-o"></i> Eliminados <span class="label label-primary pull-right"><?php echo $eliminados;?></a></li>
										</ul>
										<input type='hidden' id='hd_op' name='hd_op' value='<?php echo $op; ?>'></input>
									</div><!-- /.box-body -->
								</div><!-- /. box -->
							</div><!-- /.col -->
							<div class="col-md-9">
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title"><?php echo $bandeja_nombre; ?></h3>
										<div class="box-tools pull-right">
											<div class="has-feedback">
												<!--<input type="text" class="form-control input-sm" placeholder="Search Mail">
												<span class="glyphicon glyphicon-search form-control-feedback"></span>-->
											</div>
										</div><!-- /.box-tools -->
									</div><!-- /.box-header -->
									<div class="box-body">
										<!--<div class="mailbox-controls">
											 Check all button 
											<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
											<div class="btn-group">
												<button class="btn btn-default btn-sm" onclick='delete_checked("tbl_mailbox");'><i class="fa fa-trash-o"></i></button>
												<button class="btn bftn-default btn-sm" onclick='reply_checked("tbl_mailbox");'><i class="fa fa-reply"></i></button>
												<button class="btn btn-default btn-sm" onclick='share_checked("tbl_mailbox");'><i class="fa fa-share"></i></button>
											</div>
											<button class="btn btn-default btn-sm"  onclick='refresh_mailbox("tbl_mailbox");'><i class="fa fa-refresh"></i></button>
										</div>-->
										<div class="form-horizontal">
											<?php echo $html_bandeja; ?>
										</div><!-- /.mail-box-messages -->
									</div><!-- /.box-body -->
									<!--<div class="box-footer no-padding">
										<div class="mailbox-controls">
											
											<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
											<div class="btn-group">
											<button class="btn btn-default btn-sm" onclick='delete_checked("tbl_mailbox");'><i class="fa fa-trash-o"></i></button>
											<button class="btn btn-default btn-sm" onclick='reply_checked("tbl_mailbox");'><i class="fa fa-reply"></i></button>
											<button class="btn btn-default btn-sm" onclick='share_checked("tbl_mailbox");'><i class="fa fa-share"></i></button>
											</div>
											<button class="btn btn-default btn-sm"  onclick='refresh_mailbox("tbl_mailbox");'><i class="fa fa-refresh"></i></button>
											
										</div>-->
									</div>
								</div><!-- /. box -->
							</div><!-- /.col -->
						</div><!-- /.row -->