<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	
	if (isset($_POST['curs_para_mate_prof_codi']))
	{
		$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi'];
	}
	else
	{
		if(isset($_GET['curs_para_mate_prof_codi']))  
		{
			$curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
		}
		else
		{
			$curs_para_mate_prof_codi=0;
		}
	} 					 
	
	$params_lista = array( $curs_para_mate_prof_codi, $tipo);
	$sql_lista="{call agen_curs_para_mate_view(?,?)}";
	$agen_curs_para_mate_view = sqlsrv_query($conn, $sql_lista, $params_lista);  
	$cc = 0; 
	
	
?>

 
<table id='tbl_agenda_main_view' class="table table-striped">
<thead>
  <tr>
    <th width="9%" align="left">Fecha Inicio</th>
    <th width="9%" align="left">Fecha Fin&nbsp;</th>
    <th width="67%" align="left">Detalles</th>
     <th width="15%" style='text-align:center'>Opciones</th>
  </tr>
</thead> 
<tbody>
   <?php  while ($row_agen_curs_para_mate_view = sqlsrv_fetch_array($agen_curs_para_mate_view)) { $cc +=1; ?>
  <tr>
    <td align="left"><?=  date_format( $row_agen_curs_para_mate_view["agen_fech_ini"], 'd/M/Y' ); ?></td>
    <td align="left"><?=  date_format( $row_agen_curs_para_mate_view["agen_fech_fin"], 'd/M/Y' ); ?> </td>
  
    <td align="left">
    	<h4><?= $row_agen_curs_para_mate_view["agen_titu"]; ?></h4>
        <h5><?= $row_agen_curs_para_mate_view["agen_deta"] ?> ...</h5>    
    </td>
      <td style='text-align:center'>
		<a class="btn btn-default" onclick="agen_del(<?= $row_agen_curs_para_mate_view["agen_codi"]; ?>)"
			title='Eliminar' onmouseover='$(this).tooltip("show")'>
			<span class="fa fa-trash btn_opc_lista_eliminar"></span> </a></td>
  </tr>
  <? } ?> 
  </tbody>
</table>