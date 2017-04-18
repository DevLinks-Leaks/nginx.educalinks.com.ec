<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call curs_para_mate_prof_dist_view(?)}";
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
                id="radio_op4" 
                value="4"
                style="margin-left: 15px; margin-right:10px; margin-top:10px;">';	
				echo '<select id="pg_prof_codi" name="pg_prof_codi" style="width:75%; margin-top:10px;">';
				while($row_prof_view= sqlsrv_fetch_array($stmt))
				{	
					echo '<option value="'.$row_prof_view["prof_codi"].'">'
					.$row_prof_view["prof_apel"].' '.$row_prof_view["prof_nomb"].
					'</option>';
				}
				echo '</select>';
			}
			else
			{
				echo '<input 
            	type="radio" 
                name="radio_op" 
                id="radio_op4" 
                value="4"
                style="margin-left: 15px; margin-right:10px; margin-top:10px;">';
				echo '<select id="pg_prof_codi" name="pg_prof_codi" style="width:75%; margin-top:10px;" disabled="disabled">';
                echo '<option value="-1">Seleccione</option>';
                echo '</select>';
			}
		}
?>