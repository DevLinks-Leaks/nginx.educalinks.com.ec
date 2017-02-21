<?php
//Función que genera un array único con varias columnas
function arrayUnique($array, $preserveKeys = false)  
{  
	// Unique Array for return  
	$arrayRewrite = array();  
	// Array with the md5 hashes  
	$arrayHashes = array();  
	foreach($array as $key => $item) {  
		// Serialize the current element and create a md5 hash  
		$hash = md5(serialize($item));  
		// If the md5 didn't come up yet, add the element to  
		// to arrayRewrite, otherwise drop it  
		if (!isset($arrayHashes[$hash])) {  
			// Save the current element hash  
			$arrayHashes[$hash] = $hash;  
			// Add element to the unique Array  
			if ($preserveKeys) {  
				$arrayRewrite[$key] = $item;  
			} else {  
				$arrayRewrite[] = $item;  
			}  
		}  
	}  
	return $arrayRewrite;  
}
	
	
//Permite buscar la nota en una matriz de calificaciones
/*function buscar_nota ($matriz, $alum_curs_para_mate_codi, $peri_dist_codi)
{	
	foreach ($matriz as $r)
	{
		if (($r['alum_curs_para_mate_codi']==$alum_curs_para_mate_codi) && ($r['peri_dist_codi']==$peri_dist_codi))
		{
			return $r['nota'];
		}
	}
}*/

function buscar_nota ($matriz, $valor_fila, $valor_columna, $fila, $columna)
{	
	foreach ($matriz as $r)
	{
		if (($r[$fila]==$valor_fila) && ($r[$columna]==$valor_columna))
		{
			return $r['nota'];
		}
	}
}

function buscar_nota_3d ($matriz, $valor_fila, $valor_columna, $valor_extra, $fila, $columna, $extra)
{	
	foreach ($matriz as $r)
	{
		if (($r[$fila]==$valor_fila) && ($r[$columna]==$valor_columna) && ($r[$extra]==$valor_extra))
		{
			return $r['nota'];
		}
	}
}


function contar_notas_num ($notas, $inferior, $superior)
{	
	$cont=0;
	foreach ($notas as $nota)
	{
		if (($nota>=$inferior) && ($nota<=$superior))
		{
			$cont++;
		}
	}
	return $cont;
}

function contar_notas_porc ($notas, $inferior, $superior)
{	
	$cont=0;
	$total_notas=count($notas);
	foreach ($notas as $nota)
	{
		if (($nota>=$inferior) && ($nota<=$superior))
		{
			$cont++;
		}
	}
	return ($cont/$total_notas)*100;
}
	
?>