<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call curs_para_peri_dist_cab(?)}";
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
				echo '<input 
            	type="radio" 
                name="radio_op" 
                id="radio_op3" 
                value="3"
                style="margin-left: 15px; margin-right:10px; margin-top:10px;">';	
				echo '<select id="pg_curs_para_codi" name="pg_curs_para_codi" style="width:75%; margin-top:10px;">';
				while($row_curs_para_view= sqlsrv_fetch_array($stmt))
				{	
					echo '<option value="'.$row_curs_para_view["curs_para_codi"].'">'
					.$row_curs_para_view["curs_deta"].'-'.$row_curs_para_view["para_deta"].
					'</option>';
				}
				echo '</select>';
			}
			else
			{
				echo '<input 
            	type="radio" 
                name="radio_op" 
                id="radio_op3" 
                value="3"
                style="margin-left: 15px; margin-right:10px; margin-top:10px;">';
				echo '<select id="pg_curs_para_codi" name="pg_curs_para_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
                echo '<option value="-1">Seleccione</option>';
                echo '</select>';
			}
		}
?>