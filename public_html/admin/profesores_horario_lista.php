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
    <table class="table_striped">
    <thead>
    <tr>
    <th>D&iacute;as</th>
    <th>Hora Inicial</th>
    <th>Hora Final</th>
    <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
	<?php $c=0;
	while($row_hora_prof_view=sqlsrv_fetch_array($hora_prof_busq)){$c++;?>
	<tr>
    <td><?=$row_hora_prof_view['dia_large']?></td>
    <td><?=$row_hora_prof_view['hora_ini']?></td>
    <td><?=$row_hora_prof_view['hora_fin']?></td>
    <td> 
    	<div class="menu_options">
        	<ul>
            	<li><a onClick="hora_aten_del('hora_aten_main','script_profe_hora.php','<?=$row_hora_prof_view['hora_codi']?>','<?=$prof_codi?>')" class="option"><span class="icon-remove icon"></span>Eliminar</a></li>
            </ul>
        </div>
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

