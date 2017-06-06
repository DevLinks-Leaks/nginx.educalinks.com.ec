<?php 
	session_start();	 
	include ('../framework/dbconf.php');
?>
			<div class='form-group'>
				<div class='col-sm-12'>
					<div class='input-group input-group-sm'>
						<span id="span_filtromodulo" name="span_filtromodulo" class="input-group-addon">Módulo</span>
						<select class='form-control input-sm' id='cmb_filtromodulo' name='cmb_filtromodulo'
								onchange='js_call_auditoria_tipos(this.value);'>
							<option value='-1'>- Todos -</option>
							<option value='ACA'><span class='fa fa-graduation-cap'></span> Académico</option>
							<?php echo ($_SESSION['certus_finan']  == 1 ? '<option value="FIN">Financiero</option>': '' ); ?>
							<?php echo ($_SESSION['certus_biblio'] == 1 ? '<option value="BIB">Biblioteca</option>': '' ); ?>
							<?php echo ($_SESSION['certus_medic']  == 1 ? '<option value="MED">Médico</option>': '' ); ?>
						</select>
					</div>
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-12' style='text-align:right;'>
					<button class='btn btn-default' type='button' id='ckb_codigoTipo_head2' name='ckb_codigoTipo_head2'
							onClick='js_audi_types_all( )'>
							<span id='span_codigoTipo_head1' class='fa fa-square-o'></span>&nbsp;
							<span id='span_codigoTipo_head2'>Marcar todos</span></button>
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-12'>
					<div class="auditoriaTipo"> 
						<!--<a class="all" href="javascript:seleccionar_todos_acciones()"><label>TODOS</label></a> - 
						<a class="none" href="javascript:deseleccionar_todos_acciones()"><label>NINGUNO</label></a>-->
						<table id ='tbl_audi_tipo' name ='tbl_audi_tipo' class="table table-striped">		
							<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
								<tr>
									<th><div style="font-size:x-small;text-align:center;" >
											<input style="display:none;" type="checkbox" id="ckb_codigoTipo_head" name="ckb_codigoTipo_head" onClick="js_users_all(this)"></input>
										</div>
									</th>
									<th>Tipos de auditoría</th>
								</tr>
							</thead>
							<?php
							
							if (isset( $_POST['audi_tipo_codi'] ) )
								$audi_tipo_codi = $_POST['audi_tipo_codi'];
							else
									$audi_tipo_codi = 'ZZZ';
								
							$params = array( $audi_tipo_codi );
							$sql="{call acci_audi_view (?)}";
							$audi_cons = sqlsrv_query($conn, $sql, $params);
							$c = 0;
							while ($row_audi_view = sqlsrv_fetch_array($audi_cons))
							{   echo "<tr id='tr_row_".$row_audi_view["audi_tipo_codi"]."' name='tr_row_".$row_audi_view["audi_tipo_codi"]."' 
									style='font-size: small; vertical-align: middle; '>
										<td><input type='checkbox' name='acciones[]' value='".$row_audi_view['audi_tipo_codi']."' 
												onclick='js_audi_tipo_select_check_ind (this, ".$c.")'/></td>
										<td>".$row_audi_view['audi_tipo_deta']."</td></tr>";
								$c++;
							}
							?>
						</table>
						<input type='hidden' id='hd_op1' name='hd_op1' value='<?php echo $op; ?>'></input>
					</div>
				</div>
			</div>