<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

	if(isset($_POST['texto'])) $texto=$_POST['texto'];    
	else   $texto='%';
  
	$params = array($texto,$_SESSION['peri_codi']);
	$sql="{call alum_peri_busq(?,?)}";
	$alum_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>

<div class="alumnos_main_lista">


<table class="table_striped" id="alum_table">
 <thead>
  <tr>
    <th width="10%" class="sort"><span class="icon-sort icon"></span>Código </th>
    <th width="25%" class="sort"><span class="icon-sort icon"></span>Nombre</th>
    <th width="15%" class="sort"><span class="icon-sort icon"></span>Curso</th>
    <th width="40%" class="center"><span class="icon-cog icon"></span>Opciones</th>
  </tr>
 </thead>
 
	<?php 
		
		$perm_22='N';
		$perm_81='N';
		$perm_23='N';
		$perm_24='N';
		if (permiso_activo(22)){  
			$perm_22='A';	
	  	}
		if (permiso_activo(81)){ 
			$perm_81='A';
   	 	}	 
		if (permiso_activo(23)){ 
			$perm_23='A';
   	 	}
		if (permiso_activo(24)){
			$perm_24='A';	
		}	
		if (permiso_activo(91)){
			$perm_91='A';	
		}	
	 ?>
 <tbody>
 <?php  
	while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)) 
	{
		$params_estado = array($row_alum_busq["alum_codi"], $_SESSION['peri_codi'], 'A');
		$sql_estado="{call alum_info_alum_est_info(?,?,?)}";
		$stmt_estado = sqlsrv_query($conn, $sql_estado, $params_estado);
		if( $stmt_estado === false )
		{
			echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
		}
		$alum_est_view= sqlsrv_fetch_array($stmt_estado);
		$alum_est_view['alum_est_peri_codi'];
		$alum_est_view['alum_est_det'];
		$nombre_completo=$row_alum_busq["alum_apel"]." ".$row_alum_busq["alum_nomb"];
		$cc +=1; ?>
  <tr>
    <td><?php echo $row_alum_busq["alum_codi"]; ?></td>
    <td><?php echo $nombre_completo; ?></td>
    <td><?php 
			if ($row_alum_busq["alum_curs_para_estado"]=='A')
			{	echo $row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]; 
			}else
			{
				echo '--';
			}?>
	</td>
	<td align='left'>
    <div class="menu_options">
      <ul>
      
        <?php 
		if ($perm_22=='A')
		{
			if ($row_alum_busq["bloq_cc"] == 0) 
			{
		?> 
        	<li>
            	<a 
                	class="option" 
					data-toggle="modal" 
                    data-target="#ModalMatri" 
                    onclick="
					document.getElementById('ModalMatri_title').innerHTML='<?php echo "Estados de ".PrimeraMayuscula($nombre_completo); ?>';
					document.getElementById('div_cambiar_estado').innerHTML='';
					document.getElementById('alum_codi').value='<?= $row_alum_busq['alum_codi']?>';
					document.getElementById('adm_est_alum_est_codi').value='<?= $alum_est_view['alum_est_peri_codi']?>';
					document.getElementById('adm_est_alum_est_det').value='<?= PrimeraMayuscula($alum_est_view['alum_est_det'])?>';
					document.getElementById('div_adm_est_alum_curs_para_codi').innerHTML='<?= PrimeraMayuscula($alum_est_view['alum_est_det'])?>';
					document.getElementById('adm_est_curs_para_codi').value='<?= $row_alum_busq['curs_para_codi']?>';
					document.getElementById('adm_est_alum_curs_para_codi').value='<?= $row_alum_busq['alum_curs_para_codi']?>';
					document.getElementById('peri_0').onchange();" >
					<span class="icon-signup icon"></span>Estado</a></li>
            <?php 
			}
			else 
			{
			?>
				<li>Bloqueado</li>
		<?php  
			}
		}
		if ($perm_81=='A')
		{
		if (($row_alum_busq['alum_curs_para_codi']!="")&& ($row_alum_busq["alum_curs_para_estado"]=='A'))
			{
		?>
			<li>
                <a 
                    class="option" 
                    href="reportes_generales/contrato_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=
					<?=$row_alum_busq['alum_curs_para_codi']?>" 
                    target="_blank">
                    	<span class="icon-print icon"></span>Convenio
               	</a>
             </li>
        <?php 
			}
		}
		if ($perm_23=='A')
		{?>
        	<li>
                <a 
                    class="option" 
                    onclick="goto_url('alumnos_add.php?alum_codi=<?=$row_alum_busq['alum_codi']?>');" >
                    <span class="icon-pencil2 icon"></span>Editar
                </a>
            </li>
        <?php 
		}
		if ($perm_24=='A')
		{
		?>
        	<li>
            	<a 
                	class="option" 
                    onclick="load_ajax_del_alum('alum_main','script_alum.php',
                    'opc=alum_del&alum_codi=<?= $row_alum_busq['alum_codi']?>
                    &alum_curs_para_codi=<?= $row_alum_busq['alum_curs_para_codi']?>')" >
                    <span class="icon-remove icon"></span>Bloquear</a>
            </li>
        <?php 
		}?>
      </ul>
	</div>
    </td>
</tr>
 
 <?php  
	}
	?>
 </tbody>
 <tfoot>
 <tr class="pager_table" >
   <td colspan="2"><span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc;?> )</td>
   <td colspan="2" class="right"><div class="paging"></div></td>
 </tr>
 </tfoot>
</table>


</div>