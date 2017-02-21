<?php
	include "../framework/dbconf.php";
	session_start();
	$params = array($_GET['alum_curs_para_codi']);
	$sql="{call alum_info_curs_para(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params); 
	$row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view);
	?>
	
	<table width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr>
            <th width="35%">Código:</th>
            <td width="40%"><?=$row_alum_curs_para_view['alum_codi'];?></td>
            <td width="25%" rowspan="6">
            <?php
			$file_exi = $_SESSION['ruta_foto_alumno'] . $row_alum_curs_para_view["alum_codi"] . '.jpg';

			if (file_exists($file_exi)) 
			{
				$pp=$file_exi;
			} 
			else 
			{
				$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
			}
			?>
			<img src="<?php echo $pp;?>" style="border-color:#F0F0F0; height:200px; width:200px;" class="img-polaroid"  />
            </td>
        
        <tr>
            <th>Nombres y Apellidos:</th>
            <td><?=$row_alum_curs_para_view['alum_apel']." ".$row_alum_curs_para_view['alum_nomb'];?></td>                                
        </tr>
        
        <tr>
            <th>Curso: </th>
            <td><?=$row_alum_curs_para_view['curs_deta']." / ".$row_alum_curs_para_view['para_deta'];?></td>
        </tr>
        
        <tr>
            <th>Fecha de Nacimiento:</th>
            <td><?=date_format($row_alum_curs_para_view['alum_fech_naci'],"d/m/Y");?></td>                   
        </tr>
        
        <tr>
            <th>Representante Legal:</th>
            <td><?=$row_alum_curs_para_view['repr_apel']." ".$row_alum_curs_para_view['repr_nomb'];?></td>
        </tr>
        
        <tr>
            <th>Direcci&oacute;n Domiciliaria:</th>
            <td><?=$row_alum_curs_para_view['alum_domi'];?></td>                                
        </tr>
        
        <tr>
            <th>Tel&eacute;fonos:</th>
            <td><?=$row_alum_curs_para_view['alum_telf'];?></td>                                
        </tr>
        
        <tr>
            <th>Tel&eacute;fono Celular:</th>
            <td><?=$row_alum_curs_para_view['alum_celu'];?></td>                                
        </tr>
        
        <tr>
            <th>Correo Electr&oacute;nico:</th>
            <td><?=$row_alum_curs_para_view['alum_mail'];?></td>                                
        </tr>
        
        <tr>
          <th>Emergencia:</th>
          <td><?=$row_alum_curs_para_view['alum_telf_emerg'];?></td>                          
     	</tr>
          </table>
