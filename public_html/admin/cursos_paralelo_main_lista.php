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

	$params = array($peri_codi);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>

<div class="cursos_paralelo_main">
	<table class="table_striped">
        <thead>
            <tr>
              <th>Detalle
              <th>Cupos</td>
              <th>Opciones</td>
              <th>Admin</td>             
            </tr>
        </thead>
        <tbody>
	 	<?php  
		while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) 
		{ 
			$cc +=1; 
		?>
        <tr>
            <td class="titulares">
            <h4>
            	<strong>
					<?= $row_curs_peri_view["curs_deta"]; ?>
				</strong> - 
				<?= $row_curs_peri_view["para_deta"]; ?>
			</h4>
            <h6>
				<?= $row_curs_peri_view["nive_deta"]; ?> 
                <br />
					(Clases en Curso: 
                	<strong>
						<? echo $row_curs_peri_view["cc_mate"]; ?>
					</strong> ) 
			</h6>
            </td>
            <td class="center">
            	<strong>
					<? echo $row_curs_peri_view["cc_alum"]; ?>
				</strong>/
				<?= $row_curs_peri_view["curs_para_cupo"]; ?>
			</td>
            <td align="left" >
                <div class="menu_options" style="text-align:left;">
                  <ul>
                	<?php 
					if (permiso_activo(212))
					{
					?>
                    <li>
                        <a 
                        	class="option" 
                            href="cursos_paralelo_notas_alum_main.php?peri_codi=<?php echo $row_curs_peri_view["peri_codi"]; ?>&amp;curs_para_codi=<?php echo $row_curs_peri_view["curs_para_codi"]; ?>">
                        	<span class="icon-users icon"></span>
                            Libretas
                        </a>
                    </li>
                 	<?php 
				 	} 
				 	if (permiso_activo(30))
					{
					?>
                 	<li>
                        <a 
                        	class="option" 
                            href="cursos_paralelo_notas_mate_main_v2.php?peri_codi=<?php echo $row_curs_peri_view["peri_codi"]; ?>&amp;curs_para_codi=<?php echo $row_curs_peri_view["curs_para_codi"]; ?>">
                        	<span class="icon-tree icon"></span>Notas
                        </a>
                    <?php 
					}
				 	if (permiso_activo(213))
					{
					?>
                 	</li>
                    <li>
                        <a 
                        	class="option" 
                            href="cursos_paralelo_observaciones_alum_main.php?peri_codi=<?php echo $row_curs_peri_view["peri_codi"]; ?>&amp;curs_para_codi=<?php echo $row_curs_peri_view["curs_para_codi"]; ?>&amp;nive_codi=<?php echo $row_curs_peri_view["nive_codi"]; ?>">
                        	<span class="icon-eye icon"></span>
                            Observaciones
                        </a>
                    </li>
                    <?php 
                	}
					if (permiso_activo(29))
					{
					?>  
                    <li>
                        <a 
                        	class="option" 
                            data-toggle="modal"
                            data-target="#list_sel" 
                            onclick="load_modal(<?= $row_curs_peri_view["curs_para_codi"]; ?>);">
                                <span class="icon-list icon"></span> Lista por Profesor
						</a>
                    </li>
					<?
					}
					?>
				</ul>
				<ul>
                	<?php 
					if (permiso_activo(31))
					{
					?>  
        			<li>
                        <a 
                            class="option" 
                            href="cursos_paralelo_falt_alum_main.php?curs_para_codi=<?= $row_curs_peri_view["curs_para_codi"]; ?>" >
                                <span class="icon-checkbox-checked"></span> Faltas
                        </a>	
                    </li>
                	<?php 
					}
					if (permiso_activo(29))
					{
					?>
					<li>
                        <a 
                        	class="option" 
                            target="_blank"
                            href="reportes_generales/listado_alumnos.php?curs_para_codi=<?= $row_curs_peri_view["curs_para_codi"]; ?>">
                                <span class="icon-list icon"></span> Lista
						</a>
                    </li>
                 	<?php 
				 	}
					if (permiso_activo(214))
					{
					?>
					<li>
                        <a 
                        	class="option" 
                            href="cursos_paralelo_clase_main.php?curs_para_codi=<?= $row_curs_peri_view["curs_para_codi"]; ?>">
                        	<span class="icon-menu icon"></span> Control de profesor
                        </a>
					</li>
                	<?php 
					}
					if (permiso_activo(228))
					{
					?>
					<li>
                        <a 
                        	class="option" 
                            href="cursos_paralelo_hoja_vida_main.php?curs_para_codi=<?= $row_curs_peri_view["curs_para_codi"]; ?>">
                        	<span class="icon-user icon"></span> Hoja de vida
                        </a>
					</li>
					<?
					}
					?>
				</ul>
			   </div>
			</td>
            <td>
            <div class="menu_options" style="text-align:left;">
              <ul>
                <li>
            	<?php 
				if (permiso_activo(32))
				{
				?>
                    <a  
                        class="option" 
                        href="cursos_paralelo_info_main.php?curs_para_codi=<?php echo $row_curs_peri_view["curs_para_codi"]; ?>">
                            <span class="icon-briefcase icon"></span>Administrar
                    </a>
                </li>
            	<?php 
				}
				if (permiso_activo(33))
				{
				?>
            	<li>
                	<a 
                        class="option" 
                        onclick="curs_para_del(<?php echo $row_curs_peri_view["curs_para_codi"]; ?>)"> 
                        <span class="icon-remove icon"></span> Eliminar
                    </a>
            	</li> 
            <?php }?>
              </ul>
            </div>
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
   <tr class="pager_table">
    <td colspan="4"><span class="icon-users icon"></span>Total de Cursos ( <?php echo $cc;?> )</td>

  </tr>

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
