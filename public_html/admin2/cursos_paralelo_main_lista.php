<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$peri_codi=$_SESSION['peri_codi'];	
	
	if(isset($_POST['add_curs_para'])){
		if($_POST['add_curs_para']=='Y'){	
		
			$peri_codi=$_POST['peri_codi'];
			$peri_dist_cabe_codi=$_POST['peri_dist_cabe_codi'];	
	 		$curs_codi=$_POST['curs_codi'];			
			$para_codi=$_POST['para_codi'];
			$curs_para_cupo=$_POST['curs_para_cupo'];		 
		
			$params = array($peri_codi,$peri_dist_cabe_codi,$curs_codi,$para_codi,$curs_para_cupo);
			$sql="{call curs_para_add(?,?,?,?,?)}";
			$curs_para_add = sqlsrv_query($conn, $sql, $params);  
			
		}
	}
	
	if(isset($_POST['del_curs_para'])){
		if($_POST['del_curs_para']=='Y'){		
	 		$curs_para_codi=$_POST['curs_para_codi'];	 
			$params = array($curs_para_codi);
			$sql="{call curs_para_del(?)}";
			$curs_para_del = sqlsrv_query($conn, $sql, $params);  
			if ($curs_para_del===false)
			{
				die (print_r(sqlsrv_errors(), true));
			}
			else
			{
				$detalle = "Curso paralelo materia: ".$curs_para_codi;
				registrar_auditoria (43, $detalle);
			}
		}
	}
	
	$params = array( $peri_codi, $search_by_curs_para_codi );
	$sql="{call curs_peri_view(?,?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>

<div class="cursos_paralelo_main">
	<style>
		a {
			/*color: #424242;*/
		}
		a:hover {
			color: #4285F4;
		}
		.rTable {
			display: table;
			width: 100%;
		}
		.rTableRow {
			display: table-row;
		}
		.rTableHeading {
			display: table-header-group;
			background-color: #ddd;
		}
		.rTableCell, .rTableHead {
			display: table-cell;
			padding: 3px 10px;
			width: 33%;
			/*border: 1px solid #999999;*/
		}
		.rTableCell, .rTableHead {
			display: table-cell;
			padding: 3px 10px;
			width: 33%;
			/*border: 1px solid #999999;*/
		}
		.rTableHeading {
			display: table-header-group;
			background-color: #ddd;
			font-weight: bold;
		}
		.rTableFoot {
			display: table-footer-group;
			font-weight: bold;
			background-color: #ddd;
		}
		.rTableBody {
			display: table-row-group;
		}
		a,
		a label {
			cursor: pointer;
			text-decoration: none !important;
		}
	</style>
	<table id="table_cursos_paralelos" class="table table-striped table table-hover display responsive nowrap"  style='color:#2d3c4a;'>
        <thead>
            <tr>
              <th width="25%">Detalle</th>
              <th width="15%" style='text-align:center'>Info</th>
              <th width="50%">Opciones</th>
              <th width="10%" style='text-align:center'>Administrar</th>             
            </tr>
        </thead>
        <tbody>
			<?php  
			while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) 
			{ 
				$cc +=1;
				$opc_admin = $curso_info = $titulares = $tabla = "";
				$opciones = array();
				
				/* --------------------------------
				    TABLA DE INFORMACION DE CUPOS
				   --------------------------------*/
				$curso_info = "
					<div class='rTable' width:100%;' >
						<div class='rTableRow'>
							<div class='rTableCell' style='text-align:left;'>Matriculados:</div>
							<div class='rTableCell' style='text-align:right;'<strong>".$row_curs_peri_view["cc_alum"]."</strong></div>
						</div>
						<div class='rTableRow'>
							<div class='rTableCell' style='text-align:left;'>Reservados:</div>
							<div class='rTableCell' style='text-align:right;'><strong>".$row_curs_peri_view["cc_alum_res"]."</strong></div>
						</div>
						<div class='rTableRow'>
							<div class='rTableCell' style='text-align:left;'>Oyentes:</div>
							<div class='rTableCell' style='text-align:right;'><strong>".$row_curs_peri_view["cc_alum_oye"]."</strong></div>
						</div>
						<div class='rTableRow'>
							<div class='rTableCell' style='text-align:left;'>Retirados:</div>
							<div class='rTableCell' style='text-align:right;'><strong>".$row_curs_peri_view["cc_alum_ret"]."</strong></div>
						</div>
						<!--<div class='rTableRow'>
							<div class='rTableCell' style='text-align:left;'>Disponibles:</div>
							<div class='rTableCell' style='text-align:right;'><strong>".$row_curs_peri_view["curs_para_cupo"]."</strong></div>
						</div>-->
						<div class='rTableRow'>
							<div class='rTableCell' style='text-align:left;'><strong>Total Cupos:</strong></div>
							<div class='rTableCell' style='text-align:right;'><strong>".$row_curs_peri_view["curs_para_cupo"]."</strong></div>
						</div>
					</div>";
				/* ----------------
				    ADMINISTRATIVO
				   ----------------*/
				$opc_admin ="<div class='row'>
					<div class='col-sm-12' style='text-align:center'>";
				if (permiso_activo(32))
				{	$opc_admin.="
						<a class='btn btn-default' title='Administrar'
							href='cursos_paralelo_info_main.php?curs_para_codi=".$row_curs_peri_view["curs_para_codi"]."'>
								<i style='color:#5b5b5b;' class='fa fa-cog' style='margin-right:3px;'></i>
						</a>";
				}
				if (permiso_activo(33))
				{	$opc_admin.="
						<a class='btn btn-default' title='Eliminar'
							onclick='curs_para_del(".$row_curs_peri_view["curs_para_codi"].")'> 
							<i style='color:#dd4b39;' class='fa fa-trash btn_opc_lista_eliminar' style='margin-right:3px;'></i>
						</a>";
				}
				$opc_admin .="</div></div>";
				/* ----------------
				    OPCIONES
				   ----------------*/
				if (permiso_activo(212))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;' style='padding: 3px 10px;'>
						<a class='option'
							href='cursos_paralelo_notas_alum_main.php?peri_codi=".$row_curs_peri_view["peri_codi"] ."&curs_para_codi=". $row_curs_peri_view["curs_para_codi"] ."' >
							<span class='fa fa-users' style='margin-right:3px;'></span> Libretas
						</a>
					</div>";
				} 
				if (permiso_activo(30))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							href='cursos_paralelo_notas_mate_main_v2.php?peri_codi=". $row_curs_peri_view["peri_codi"] ."&curs_para_codi=". $row_curs_peri_view["curs_para_codi"] ."' >
							<span class='fa fa-address-book-o' style='margin-right:3px;'></span> Notas
						</a>
					</div>";
				}
				if (permiso_activo(213))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							href='cursos_paralelo_observaciones_alum_main.php?peri_codi=". $row_curs_peri_view["peri_codi"] ." &amp;curs_para_codi=". $row_curs_peri_view["curs_para_codi"] ." &amp;nive_codi=". $row_curs_peri_view["nive_codi"] ."' >
							<span class='fa fa-eye' style='margin-right:3px;'></span>
							Observaciones
						</a>
					</div>";
				}
				if (permiso_activo(29))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							data-toggle='modal'
							data-target='#list_sel'
							onclick='load_modal(".$row_curs_peri_view["curs_para_codi"].");'>
								<span class='fa fa-list-ul' style='margin-right:3px;'></span> Lista por Profesor
						</a>
					</div>";
				}
				if (permiso_activo(31))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							href='cursos_paralelo_falt_alum_main.php?curs_para_codi=".$row_curs_peri_view["curs_para_codi"]."' >
								<span class='fa fa-check-square-o' style='margin-right:3px;'></span> Faltas
						</a>
					</div>";
				}
				if (permiso_activo(29))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							target='_blank'
							href='reportes_generales/listado_alumnos.php?curs_para_codi=".$row_curs_peri_view["curs_para_codi"]."' >
								<span class='fa fa-list-ul' style='margin-right:3px;'></span> Lista
						</a>
					</div>";
				}
				if (permiso_activo(214))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							href='cursos_paralelo_clase_main.php?curs_para_codi=".$row_curs_peri_view["curs_para_codi"]."' >
							<span class='fa fa-align-justify' style='margin-right:3px;'></span> Control de profesor
						</a>
					</div>";
				}
				if (permiso_activo(228))
				{	$opciones[]="<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12' style='padding: 3px 10px;'>
						<a class='option'
							href='cursos_paralelo_hoja_vida_main.php?curs_para_codi=".$row_curs_peri_view["curs_para_codi"]."' >
							<span class='fa fa-user' style='margin-right:3px;'></span> Hoja de vida
						</a>
					</div>";
				}
				$tabla=cursos_paralelo_main_genera_div_form_horizontal($opciones);// función está en funciones.php
				$titulares = '
					<h4>
						<strong>'.$row_curs_peri_view["curs_deta"].' </strong> - '.$row_curs_peri_view["para_deta"].'&nbsp;
					</h4>
					<h6>'. $row_curs_peri_view["nive_deta"].'
						<br />
						(Clases en Curso: <strong>'.$row_curs_peri_view["cc_mate"].'</strong> )
					</h6>
					<h4>
						Jornada: <strong>'.$row_curs_peri_view['jorn_deta'].'</strong><br>
						<div class="visible-phone">
							<br>
							<div class="row">
								<div class="col-xs-6 col-sm-6" style="text-align:right;">
									<a class="btn btn-app" abindex="0" data-toggle="popover"
										title="<strong>'.$row_curs_peri_view["curs_deta"].' </strong> - '.$row_curs_peri_view["para_deta"].'"
										data-content="<div style=\'font-size:x-small\'>'.$curso_info.'</div>"
										data-placement="bottom"><span class="fa fa-eye"></span>Info
									</a>&nbsp;
								</div>
								<div class="col-xs-6 col-sm-6" style="text-align:left;">
									<a class="btn btn-app" tabindex="0" data-toggle="popover"
										title="<strong>'.$row_curs_peri_view["curs_deta"].' </strong> - '.$row_curs_peri_view["para_deta"].'"
										data-content="<div style=\'font-size:x-small\'>'.$tabla.'<br>'.$opc_admin.'</div>"
										data-placement="bottom"><span class="fa fa-list"></span>Opciones
									</a>
								</div>
							</div>
						</div>
					</h4>';
			?>
			<tr><td class="titulares">
					<?php echo $titulares; ?>
				</td>
				<td style='text-align:center'>
					<?php echo $curso_info ; ?>
				</td>
				<td align="left" >
					<?php echo $tabla; ?>
				</td>
				<td style='text-align:center'>
					<?php echo $opc_admin; ?>
				</td>
			</tr>
 <?php  }?>
			<div class="modal fade bd-example-modal-lg" id="list_sel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div width="100%" class="modal-content">
						<div class="modal-header">
								<button 
									type="button" 
									class="close" 
									data-dismiss="modal">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="ModalLabel">
									Listado curso paralelo
								</h4>
						</div>
						<div width="100%" id="modal_main" class="modal-body">
							
						</div>
						<div class="modal-footer">
							<button 
								type="button" 
								class="btn btn-primary"  
								onClick="abrirLista();" >
								Aceptar
							</button>
							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<button 
								type="button" 
								class="btn btn-default" 
								data-dismiss="modal">
								Cerrar
							</button>  
						</div>
					</div>
				</div>
			</div>
		</tbody>
	</table>
</div>
<script>
	function curs_para_del(curs_para_codi){
		if (confirm("Esta seguro que desea Eliminar el Curso")) {					 
			load_ajax('curs_para_main','cursos_paralelo_main_lista.php','curs_para_codi=' + curs_para_codi + '&del_curs_para=Y'); 					
		}				
	} 

	function load_modal(curs_para_codi){
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById("modal_main").innerHTML='<table border="0" cellspacing="0" cellpadding="0"><tr><td width="30%" class="text-right" style="padding-top: 15px;"><label for="mate_prof">Materia-Profesor:</label></td><td width="70%" style="padding-top: 15px;">'+xmlhttp.responseText+'</td></tr></table><div class="form_element">&nbsp;</div>';	
				
			}
		}
		var data="curs_para_codi="+curs_para_codi;
		xmlhttp.open("POST","cursos_paralelo_main_lista_modal_view.php",true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
	function abrirLista(){
		var mate_prof = document.getElementById("mate_prof");
		var seleccion = mate_prof.options[mate_prof.selectedIndex];
		var curs_para_mate_prof_codi = seleccion.value;
		window.open('reportes_generales/listado_alumnos_profesor_materia.php?curs_para_mate_prof_codi='+curs_para_mate_prof_codi,'_blank');
	}
</script>
<?php
function cursos_paralelo_main_genera_div_form_horizontal($array_con_col)
{	$aux = 0;
	$c = count($array_con_col);
	$body = "";
	$body.="<div class='form-horizontal'>";
	while ($aux < $c)
	{	$body.=  $array_con_col[$aux];
		$aux+=1;
	}
	$table= "<div class='row'>".$body."</div></div>";
	
	return $table;
}
?>