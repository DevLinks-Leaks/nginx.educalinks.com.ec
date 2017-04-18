<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call nota_refe_cab_view(?)}";
		$params = array($_GET['peri_dist_cab_codi']);
		
		$stmt = sqlsrv_query($conn, $sql, $params);

		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			if (sqlsrv_has_rows($stmt))
			{		
				echo '<select id="sl_modelos" name="sl_modelos" style="width: 75%;">';
				echo '<option value="0">Seleccione...</option>';
				while($mode_view= sqlsrv_fetch_array($stmt))
				{
					$selected='';
					if ($_GET['nota_refe_cab_codi']==$mode_view["nota_refe_cab_codi"])
						$selected=' selected';
					echo '<option value="'.$mode_view["nota_refe_cab_codi"].'"'.$selected.'>'.$mode_view["nota_refe_cab_deta"].'</option>';
				}
				echo '</select>';
			}
			else
			{
				echo '<select id="sl_modelos" name="sl_modelos" style="width: 75%;" disabled="disabled">';
                echo '<option value="-1">Seleccione</option>';
                echo '</select>';
			}
		}
?>