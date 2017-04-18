<?php 
	session_start();	 
	include ('../framework/dbconf.php');

	$curs_para_codi=$_POST['curs_para_codi'];
	$params = array($curs_para_codi);
	$sql="{call curs_peri_mate_view(?)}";
	$stmt_mate = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	if ($curs_para_codi!=-1)
	{
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table_striped">
	<thead>
        <tr>
        	<th>COD.</th>
        	<th>MATERIA</th>
        	<th>PROFESOR</th>
        </tr>
    </thead>
  <tbody>
  <?php  
  	while ($row_mate = sqlsrv_fetch_array($stmt_mate)) 
	{ 
		$cc +=1; 
  ?>
  <tr>
        <td>
            <? echo $row_mate["mate_codi"];?>
        </td>
        <td>
            <? echo $row_mate["mate_deta"];?>
        </td>
        <td>
            <? echo $row_mate["prof_nomb"];?>
        </td>
      </tr>
  </tbody>
 <?php  }?>
</table>
<?
	}
?>