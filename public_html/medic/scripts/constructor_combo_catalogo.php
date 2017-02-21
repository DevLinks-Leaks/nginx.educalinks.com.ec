<?php
	include("../clases/Catalogos.php");
	function constructor_combo_catalogo( $options = array(), $optional = array(), $valor_selected="")
	{	$estado_civil->get_Catalogo_by_idPadre($catalogo);
		$opt = "";
        foreach($optional as $key => $value){
            $opt .= $key . "=" . $value . " ";
        }	
        $select = "<select $opt>";	
		for($i=0;$i<count($options)-1;$i++){
			if(trim($options[$i][0])==trim($valor_selected)){
				$sel="selected='selected'";
			}else{
				$sel="";
			}
			$select .= "<option value='".$options[$i][0]."'". $sel." >".$options[$i][1]."</option>";
        }
        $select .= "</select>";
        return $select;
	}
?>