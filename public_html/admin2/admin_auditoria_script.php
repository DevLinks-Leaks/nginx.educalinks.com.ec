<?php 
	session_start();	 
	include ('../framework/dbconf.php');
?>
<div class="form-horizontal">
	<div class="row">
		<div class="col-sm-6">
			<table class="table table-striped" id="auditoria_table">
				<thead>
					<th>Auditor&iacute;a de:</th>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="auditoriaTipo"> 
								<a class="all" href="javascript:seleccionar_todos_acciones()"><label>TODOS</label></a>
								<a class="none" href="javascript:deseleccionar_todos_acciones()"><label>NINGUNO</label></a>
								<table class="table table-striped">		
									<?
									$sql="{call acci_audi_view ()}";
									$audi_cons = sqlsrv_query($conn, $sql);  
									while ($row_audi_view = sqlsrv_fetch_array($audi_cons))
									{   echo "<tr><td><input type='checkbox' name='acciones[]' value='".$row_audi_view['audi_tipo_codi']."' />".
												$row_audi_view['audi_tipo_deta']."</td></tr>";
									}
									?>
								</table>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-6">
			<div class="zone-last">
				<table class="table table-striped" id="auditoria_table">
					<thead>
						<th width="45%">De los siguientes usuarios:</th>
					</thead>
					<tbody>
						<tr>
							<td width="45%">
								<div class="auditoriaTipo"> 
									<a class="all" href="javascript:seleccionar_todos_usuarios()"><label>TODOS</label></a>
									<a class="none" href="javascript:deseleccionar_todos_usuarios()"><label>NINGUNO</label></a>
									<table class="table table-striped">
										 <?
										$sql="{call usua_audi_view ()}";
										$usua_cons = sqlsrv_query($conn, $sql);  
										while ($row_usua_view = sqlsrv_fetch_array($usua_cons))
										{   echo "<tr><td><input type='checkbox' name='usuarios[]' value='".$row_usua_view['usua_codi']."'>".
												$row_usua_view['nombres']."</td></tr>";
										}
										?>
									</table>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>