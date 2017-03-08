<?
		session_start();
        include ('../framework/dbconf.php');		
		$sql="{call cata_hijo_view(?)}";
		$params = array($_GET['idpadre']);
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
				echo '<label for="alum_resp_form_banc_tarj" id="lbl_banco_tarjeta">Banco/Tarjeta:</label><select class="form-control" id="alum_resp_form_banc_tarj" name="alum_resp_form_banc_tarj">';
				echo '<option value="">SELECCIONE</option>';
				while($banc_tarj_view= sqlsrv_fetch_array($stmt))
				{
					echo '<option value="'.$banc_tarj_view["codigo"].'">'.$banc_tarj_view["descripcion"].'</option>';
				}
				echo '</select>';
			}
			else
			{
				echo '<label for="lbl_banco_tarjeta" id="lbl_banco_tarjeta">Banco/Tarjeta:</label><select class="form-control" id="alum_resp_form_banc_tarj" name="alum_resp_form_banc_tarj"  disabled="disabled">';
                echo '<option value="0">SELECCIONE</option>';
                echo '</select>';
			}
		}
?>