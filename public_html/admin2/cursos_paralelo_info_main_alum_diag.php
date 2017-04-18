<div class="alumnos_main_lista">


 

<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';

	$curs_para_codi=$_POST['curs_para_codi'];
	$peri_codi=$_SESSION['peri_codi'];
	$params = array($texto, $curs_para_codi, $peri_codi);
	$sql="{call alum_busq_curs_para(?,?,?)}";
	$alum_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>



<table width="100%">
 
  <?php  while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)) { $cc +=1; ?>
  <tr onclick="" >
    <td width="100%" colspan="3"> 
     <button type="button" class="" style=" width:100%;text-align:left;"  
   		    <?php  if ($row_alum_busq["existe"] > 0 ){?> disabled="disabled"  <?php  }?> 
     		onclick="curs_para_alum_add('<?php echo $_POST['curs_para_codi']; ?>','<?php echo $row_alum_busq["alum_codi"]; ?>');" >
				<?php echo $row_alum_busq["alum_apel"]." ".$row_alum_busq["alum_nomb"]; ?>
                 <?php  if ($row_alum_busq["existe"] > 0 ){?> <em><strong>[Ya Agregado]</strong></em>
<?php  }?> 
    
    </button>    </td>
    </tr>
 
 <?php  }?>
  </table>


</div>