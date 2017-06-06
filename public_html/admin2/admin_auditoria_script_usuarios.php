<?php 
	session_start();	 
	include ('../framework/dbconf.php');
?>
			<div class='form-group'>
				<div class='col-sm-12'>
					<div class='input-group input-group-sm'>
						<span id="span_tipousuario" name="span_tipousuario" class="input-group-addon">Filtro de usuarios</span>
						<select class='form-control input-sm' id='cmb_tipousuario' name='cmb_tipousuario'
								onchange='js_call_usuario_tipos(this.value);'>
							<option value='-1'>- Mostrar todos -</option>
							<option value='1'>Mostrar usuarios administrativos</option>
							<option value='2'>Mostrar Profesores</option>
						</select>
					</div>
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-12' style='text-align:right;'>
					<button class='btn btn-default' type='button' id='ckb_codigoUsuario_head2' name='ckb_codigoUsuario_head2'
							onClick='js_users_all( )'>
							<span id='span_codigoUsuario_head1' class='fa fa-square-o'></span>&nbsp;
							<span id='span_codigoUsuario_head2'>Marcar todos</span></button>
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-12'>
					<div class="auditoriaTipo">
						<!--<a class="all" href="javascript:seleccionar_todos_usuarios()"><label>TODOS</label></a> - 
						<a class="none" href="javascript:deseleccionar_todos_usuarios()"><label>NINGUNO</label></a>-->
						<table id='tbl_lista_usuarios' name='tbl_lista_usuarios' class="table table-striped">
							<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
								<tr>
									<th><div style="font-size:x-small;text-align:center;" >
											<input style="display:none;" type="checkbox" id="ckb_codigoUsuario_head" name="ckb_codigoUsuario_head" onClick="js_users_all(this)"></input>
										</div>
									</th>
									<th>Usuarios</th>
								</tr>
							</thead>
							<?php
							
							if (isset( $_POST['usua_tipo_codi'] ) )
								$usua_tipo_codi = $_POST['usua_tipo_codi'];
							else
									$usua_tipo_codi = -1;
							$params = array($usua_tipo_codi);
							$sql="{call usua_audi_view (?)}";
							$usua_cons = sqlsrv_query($conn, $sql, $params);
							$c = 0;
							while ($row_usua_view = sqlsrv_fetch_array($usua_cons))
							{   echo "<tr id='tr_row_".$row_usua_view["usua_codi"]."' name='tr_row_".$row_usua_view["usua_codi"]."' 
									style='font-size: small; vertical-align: middle; '>
										<td><input type='checkbox' name='usuarios[]' value='".$row_usua_view['usua_codi']."'
												onclick='js_usuarios_select_check_ind (this, ".$c.")'/></td>
										<td>".$row_usua_view['nombres']."</td></tr>";
								$c++;
							}
							?>
						</table>
						<input type='hidden' id='hd_op2' name='hd_op2' value='<?php echo $op; ?>'></input>
					</div>
				</div>
			</div>