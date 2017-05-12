<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
    
<div class="main_lista">


<?php 	
	if(isset($_GET['prof_codi'])){$prof_codi=$_GET['prof_codi'];}else{if(isset($_POST['prof_codi'])){$prof_codi=$_POST['prof_codi'];}else{$prof_codi=0;}}
	
	$params_hora = array($prof_codi,$_SESSION['peri_codi']);
	$sql_hora="{call hora_prof_busq(?,?)}";
	$hora_prof_busq = sqlsrv_query($conn, $sql_hora, $params_hora);  
	$cc = 0;?>
    <div id="hora_lista">
    <table class="table table-striped">
    <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
    <tr>
    <th style='text-align:center;'>D&iacute;as</th>
    <th style='text-align:center;'>Hora Inicial</th>
    <th style='text-align:center;'>Hora Final</th>
    <th style='text-align:center;'>Eliminar</th>
    </tr>
    </thead>
    <tbody>
	<?php $c=0;
	while($row_hora_prof_view=sqlsrv_fetch_array($hora_prof_busq)){$c++;?>
	<tr>
    <td style='text-align:center;'><?=$row_hora_prof_view['dia_large']?></td>
    <td style='text-align:center;'><?=$row_hora_prof_view['hora_ini']?></td>
    <td style='text-align:center;'><?=$row_hora_prof_view['hora_fin']?></td>
    <td style='text-align:center;'><a onClick="hora_aten_del('hora_aten_main','script_profe_hora.php','<?=$row_hora_prof_view['hora_codi']?>','<?=$prof_codi?>')" class="btn btn-default">
		<span class="fa fa-trash btn_opc_lista_eliminar"></span></a></li>

    </td>
    </tr>	
	<?php }
	?>
    </tbody>
    <tfoot>
    <tr>
    <td colspan="3"><span class="icon-users icon"></span>Total de Horas Libres(<?=$c;?>)</td>
    </tr>
    </tfoot>
    </table>
    </div>
</div>

