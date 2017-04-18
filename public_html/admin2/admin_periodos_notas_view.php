 <?php 	
	  include ('../framework/dbconf.php');
	  
	  session_start();
	  
	  
	  $peri_dist_cab_codi = $_GET['peri_dist_cab_codi'];
	  
	  
	  $params = array($peri_dist_cab_codi);
	  $sql="{call peri_dist_peri_cab_view(?)}";
	  $peri_dist_peri_view = sqlsrv_query($conn, $sql, $params); 
                                    
?> 
<input type="hidden" id="in_peri_dist_cab_codi" value="<?= $peri_dist_cab_codi ?>" />
<script type="text/javascript" src="../framework/funciones.js"></script>
<div class="zones">
	<div class="admin_periodos_notas_view">
		<table class="table_basic">
		<tbody>
		  <tr>
			<td>
			<?php   while ($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view)){ ?>
					<div  class="level<?= $row_peri_dist_peri_view['peri_dist_nive'] ; ?>"  onclick="peri_dist_codi_view_in_acc(<?= $row_peri_dist_peri_view['peri_dist_codi'] ; ?>);">			
					<?= $row_peri_dist_peri_view['peri_dist_deta'] ; ?> (N<?= $row_peri_dist_peri_view['peri_dist_codi'] ; ?>)  
							<div style="float:right">
								<? if($row_peri_dist_peri_view['peri_dist_nive'] <> 0){ ?>
								<button type="button" class="btn btn-default btn-xs" onclick="nota_refe_add()" style="float:right">
									<span class="icon-minus icon"></span>  
								</button>
								<?php 	 } ?>
								<button type="button" class="btn btn-default btn-xs" onclick="nota_refe_add()" style="float:right">
									<span class="icon-add icon"></span>  
								</button>
							   
							</div>
					<?php  if (  $row_peri_dist_peri_view['peri_dist_nota_tipo'] ==  'IN'){?>
					 --- INGRESO ---
					<?php 	 } ?>
					 </div>     
				<?php 	 } ?>
			</td>
		  </tr>
		  </tbody>
		</table>
	</div>
	<div id="cab_notas"  >
	 <?php 	
	  $params = array($peri_dist_cab_codi);
	  $sql="{call nota_refe_cab_view(?)}";
	  $nota_refe_cab_view = sqlsrv_query($conn, $sql, $params); 
	 ?>
		<div class="admin_periodos_notas_view_script_acc"  style="height:40px; background:#b2d7e9; text-align:center;" >
			MODELO DE CALIFICACIÓN:
			<select name="cb_nota_refe_cab_codi" id="cb_nota_refe_cab_codi"  class="form-control" style=" width:50%;" onchange="peri_dist_codi_view_in_acc(0)">
			<?php
			while ($row_nota_refe_cab_view = sqlsrv_fetch_array($nota_refe_cab_view)){ ?>
			<option value="<?= $row_nota_refe_cab_view['nota_refe_cab_codi'] ; ?>">
				<?= $row_nota_refe_cab_view['nota_refe_cab_deta'] ; ?>
			</option>
			<? } ?>
			</select>
	  </div>          


	</div>

		<div id="in_notas">
		</div>

		<div id="acc_nota">
		</div>
</div>