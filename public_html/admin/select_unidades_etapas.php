<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call peri_dist_peri_libt_view(?)}";
		$params = array($_POST['peri_dist_cab_codi']);
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
				echo '<select name="pg_peri_dist_codi" id="pg_peri_dist_codi" style="width:75%; margin-top:10px;">';
				while($row_peri_dist_peri_nive_view= sqlsrv_fetch_array($stmt))
				{	
					echo '<option value="'.$row_peri_dist_peri_nive_view["peri_dist_codi"].'">'
					.$row_peri_dist_peri_nive_view["peri_dist_deta"].
					'</option>';
				}
				echo '</select>';
			}
			else
			{
				echo '<select id="pg_peri_dist_codi" name="pg_peri_dist_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
                echo '<option value="-1">Seleccione</option>';
                echo '</select>';
			}
		}
?>