<?php
	session_start();	 
	include ('../framework/dbconf.php');
?> 

<div class="admin_permisos">
<div class="zones">
	<div id="div_rol_usuario" class="zone">
		<?php 
        $sql_rol="{call rol_view()}";
        $stmt_rol = sqlsrv_query($conn, $sql_rol);
        if( $stmt_rol === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		$a=0;?>
        <label>Rol de Usuario:</label>
        <select id="rol_usuario" name="rol_usuario" onchange="carga_permisos('div_permi_roles',
                                                                'script_permisos.php',
                                                                this.value,document.getElementById('a').value);">
        <option value="0">Seleccione..</option>
        <?php while($rol_view= sqlsrv_fetch_array($stmt_rol)){?>
        <option value="<?= $rol_view['rol_codi'];?>"><?= $rol_view['rol_deta'];?></option>
        <?php }?>
        </select>
    </div>
</div>
<div class="zones">
    <div id="div_permi_roles">
    <input type="hidden" id="a" name="a" value="<?=$a ?>"/>
    </div>
</div>

</div>