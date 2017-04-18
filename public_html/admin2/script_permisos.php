<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc']))
{
	$opc=$_POST['opc'];
}
else
{
	$opc="";
}
switch($opc){
	case 'carga_permisos':
		if(isset($_POST['tipo_permi'])){$tipo_permi=$_POST['tipo_permi'];}else{$tipo_permi="0";}
		if(isset($_POST['rol_usuario'])){$rol_usuario=$_POST['rol_usuario'];}else{$rol_usuario="0";}
		if(isset($_POST['a'])){$a=$_POST['a'];}else{$a="0";}
        $params_permi = array($tipo_permi);
        $sql_permi="{call permi_tipo_view(?)}";
        $stmt_permi = sqlsrv_query($conn, $sql_permi,$params_permi);
        if( $stmt_permi === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		?>
        <ul id='permi_ul' data-name='foo'>
		<?php  while($row_permi_view=sqlsrv_fetch_array($stmt_permi)){?>
        <?php $params_permi_rol = array($row_permi_view['perm_codi'],$rol_usuario);
        $sql_permi_rol="{call rol_permi_tipo_info(?,?)}";
        $stmt_permi_rol = sqlsrv_query($conn, $sql_permi_rol,$params_permi_rol);
        if( $stmt_permi_rol === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}
		$row_permi_rol = sqlsrv_fetch_array($stmt_permi_rol);
		?>
        	<li data-value='<? echo $a; $a++;?>' data-checked='<?=$row_permi_rol['veri']?>' onchange="graba_permi('<?=$a-1;?>','script_permisos.php','<?= $row_permi_view['perm_codi'];?>','<?=$rol_usuario?>')" disabled ><?=$row_permi_view['perm_deta'];?>
                <? if($row_permi_view['child']>0){
					$params_permi2 = array($row_permi_view['perm_codi']);
					$sql_permi2="{call permi_tipo_view(?)}";
					$stmt_permi2 = sqlsrv_query($conn, $sql_permi2,$params_permi2);
					if( $stmt_permi2 === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}?>
					<ul>
                    	<?php while($row_permi_view2=sqlsrv_fetch_array($stmt_permi2)){?>
                    	<?php $params_permi_rol2 = array($row_permi_view2['perm_codi'],$rol_usuario);
						$sql_permi_rol2="{call rol_permi_tipo_info(?,?)}";
						$stmt_permi_rol2 = sqlsrv_query($conn, $sql_permi_rol2,$params_permi_rol2);
						if( $stmt_permi_rol2 === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}
						$row_permi_rol2 = sqlsrv_fetch_array($stmt_permi_rol2);
						?>
						<li data-value='<? echo $a; $a++;?>' data-checked='<?=$row_permi_rol2['veri']?>' onchange="graba_permi('<?=$a-1;?>','script_permisos.php','<?= $row_permi_view2['perm_codi'];?>','<?=$rol_usuario?>')"><?= $row_permi_view2['perm_deta'];?>
                        <? if($row_permi_view2['child']>0){
							$params_permi3 = array($row_permi_view2['perm_codi']);
							$sql_permi3="{call permi_tipo_view(?)}";
							$stmt_permi3 = sqlsrv_query($conn, $sql_permi3,$params_permi3);
							if( $stmt_permi3 === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}?>
							<ul>
								<?php while($row_permi_view3=sqlsrv_fetch_array($stmt_permi3)){?>
                                <?php $params_permi_rol3 = array($row_permi_view3['perm_codi'],$rol_usuario);
								$sql_permi_rol3="{call rol_permi_tipo_info(?,?)}";
								$stmt_permi_rol3 = sqlsrv_query($conn, $sql_permi_rol3,$params_permi_rol3);
								if( $stmt_permi_rol3 === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}
								$row_permi_rol3= sqlsrv_fetch_array($stmt_permi_rol3);
								?>
								<li data-value='<? echo $a; $a++;?>' data-checked='<?=$row_permi_rol3['veri']?>' onchange="graba_permi('<?=$a-1;?>','script_permisos.php','<?= $row_permi_view3['perm_codi'];?>','<?=$rol_usuario?>')"><?= $row_permi_view3['perm_deta'];?>
                                
                                <? if($row_permi_view3['child']>0){
									$params_permi4 = array($row_permi_view3['perm_codi']);
									$sql_permi4="{call permi_tipo_view(?)}";
									$stmt_permi4 = sqlsrv_query($conn, $sql_permi4,$params_permi4);
									if( $stmt_permi4 === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}?>
									<ul>
										<?php while($row_permi_view4=sqlsrv_fetch_array($stmt_permi4)){?>
										<?php $params_permi_rol4 = array($row_permi_view4['perm_codi'],$rol_usuario);
										$sql_permi_rol4="{call rol_permi_tipo_info(?,?)}";
										$stmt_permi_rol4 = sqlsrv_query($conn, $sql_permi_rol4,$params_permi_rol4);
										if( $stmt_permi_rol4 === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}
										$row_permi_rol4= sqlsrv_fetch_array($stmt_permi_rol4);
										?>
										<li data-value='<? echo $a; $a++;?>' data-checked='<?=$row_permi_rol4['veri']?>' onchange="graba_permi('<?=$a-1;?>','script_permisos.php','<?= $row_permi_view4['perm_codi'];?>','<?=$rol_usuario?>')"><?= $row_permi_view4['perm_deta'];?>
										</li>
										<?php }?>
									</ul>
								<? }?>
                                
								</li>
								<?php }?>
							</ul>
						<? }?>
                        </li>
                        <?php }?>
                    </ul>
				<? }?>
            </li>
        <?php }?>
        </ul>
        <input type="hidden" id="a" name="a" value="<?=$a?>"/>
	<? 
	break;	
	case 'graba_permi':
		if(isset($_POST['tipo_permi'])){$tipo_permi=$_POST['tipo_permi'];}else{$tipo_permi="0";}
		if(isset($_POST['rol_usuario'])){$rol_usuario=$_POST['rol_usuario'];}else{$rol_usuario="0";}
		if(isset($_POST['tipo_activo'])){$tipo_activo=$_POST['tipo_activo'];}else{$tipo_activo="ACT";}
        $params_permi = array($tipo_permi,$rol_usuario,$tipo_activo);
        $sql_permi="{call permi_rol_add(?,?,?)}";
        $stmt_permi = sqlsrv_query($conn, $sql_permi, $params_permi);
        if( $stmt_permi === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
	break;
	case 'borra_permi':
		if(isset($_POST['tipo_permi'])){$tipo_permi=$_POST['tipo_permi'];}else{$tipo_permi="0";}
		if(isset($_POST['rol_usuario'])){$rol_usuario=$_POST['rol_usuario'];}else{$rol_usuario="0";}
		if(isset($_POST['tipo_activo'])){$tipo_activo=$_POST['tipo_activo'];}else{$tipo_activo="ACT";}
        $params_permi = array($tipo_permi,$rol_usuario,$tipo_activo);
        $sql_permi="{call permi_rol_del(?,?,?)}";
        $stmt_permi = sqlsrv_query($conn, $sql_permi, $params_permi);
        if( $stmt_permi === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
	break;
}
?>