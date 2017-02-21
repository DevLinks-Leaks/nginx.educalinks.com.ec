<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';

	$curs_para_codi=$_POST['curs_para_codi'];
	$params = array($texto,$curs_para_codi,$_SESSION['peri_codi']);
	$sql="{call mate_busq_curs_para(?,?,?)}";
	$mate_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>
<div class="form_element">
<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
  <?php  while ($row_mate_busq = sqlsrv_fetch_array($mate_busq)) { $cc +=1; ?>
  <tr    >
    <td width="100%" colspan="2">
   	  <button type="button"   class="" style=" width:100%;text-align:left;"
        	onclick="curs_para_mate_add('<?php echo $_POST['curs_para_codi']; ?>','<?php echo $row_mate_busq["mate_codi"]; ?>');"  
            <?php  if ($row_mate_busq["existe"] > 0 ){?> disabled="disabled"  <?php  }?> >
            
		<?php echo $row_mate_busq["mate_codi"]."-".$row_mate_busq["mate_deta"]." (".$row_mate_busq["mate_abre"] .")"; ?>  
	   <?php  if ($row_mate_busq["existe"] > 0 ){?> <em><strong>[Ya Agregada]</strong></em>
<?php  }?> 
     
         
       </button>
    </td>
  </tr>
 
 <?php  }?>
</table>
</div>
<div class="form_element">&nbsp;</div>
