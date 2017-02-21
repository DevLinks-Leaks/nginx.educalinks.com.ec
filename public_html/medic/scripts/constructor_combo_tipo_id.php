<?php
	function constructor_combo_tipo_id( $nombre, $completo, $tipo = "" )
	{	$selected = array();
		if ( $tipo == "CI" )
		{ 	$selected[0] = ' selected="selected" ';
		}
		else if ( $tipo == "RUC" )
		{ 	$selected[1] = ' selected="selected" ';
		}
		else if ( $tipo == "PAS" )
		{ 	$selected[2] = ' selected="selected" ';
		}
		else if ( $tipo == "CF" )
		{ 	$selected[3] = ' selected="selected" ';
		}
		else if ( $tipo == "IDE" )
		{ 	$selected[4] = ' selected="selected" ';
		}
		else if ( $tipo == "PLC" )
		{ 	$selected[5] = ' selected="selected" ';
		}
		if ( $completo == 1 )
			$whole_set = '
					<option '.$selected[1].' value="RUC">RUC</option>
					<option '.$selected[3].' value="CF">Consumidor final</option>
					<option '.$selected[4].' value="IDE">Exterior</option>
					<option '.$selected[5].' value="PLC">Placa</option>';
		
		return '<select id="'.$nombre.'" name="'.$nombre.'" class="form-control">
					<option value="">Tipo de identificaci&oacute;n</option>
					<option '.$selected[0].' value="CI">Cédula</option>
					<option '.$selected[2].' value="PAS">Pasaporte</option>'
					.$whole_set.'
				</select>';
	}
?>