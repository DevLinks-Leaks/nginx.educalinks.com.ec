<html>
	<head>
		<meta charset="ISO-8859-1"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="script_notas.js"></script>
	</head>
	<body>
	<?
	include ('framework/dbconf.php');
	include ('framework/funciones.php');
	/*Pregunto si hicieron click en GRABAR*/
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if (isset($_POST['peri_dist_codi']))
			$peri_dist_codi=$_POST['peri_dist_codi'];
		
		if (isset($_POST['curs_para_mate_codi']))
			$curs_para_mate_codi=$_POST['curs_para_mate_codi'];
		
		if (isset($_POST['num_filas']))
			$cc=$_POST['num_filas'];
		
		if (isset($_POST['num_columnas']))
			$cc_index=$_POST['num_columnas'];
		
		
		//Inicia en 1
		$i=1;
		
		$xml='<?xml version="1.0" encoding="utf-8"?>';
		//Lista de Alumnos		  
		$xml.='<ns u="'.$_SESSION['usua_codi'].'" t="A">';
		while ($i<=$cc)
		{
			//Lista las columnnas de ingreso		
			$alum_curs_para_mate_codi= $_POST['alum_curs_para_mate_codi_'.$i];
			$i2=0;
			$xml.='<a c="'.$alum_curs_para_mate_codi.'">';
			
			//Detalle de auditoría
			$detalle ="<b>alum_curs_para_mate_codi </b>".$alum_curs_para_mate_codi;
			
			while ($i2<$cc_index)
			{
				$peri_dist_codi=$_POST['peri_dist_codi_'.($i2+ 1)];
				$nota=$_POST['nota_'.$i.'_'.$i2];
				$i2+=1;
				$xml.='<n p="'.$peri_dist_codi.'" v="'.$nota.'" />';
					
				//Actualiza las materias agrupadas
				//$params = array($alum_curs_para_mate_codi,$peri_dist_codi);
				//$sql="{call nota_padr_upd(?,?)}";
				//sqlsrv_query($conn, $sql, $params); 
				
				//Detalle de auditoría de notas
				$detalle.=", <b>peri_dist_codi </b>".$peri_dist_codi;
				$detalle.=" <b>nota </b>".$nota;
			}
			$i+=1;
			$xml.='</a>';
			
			//Registro de la auditoría
			//registrar_auditoria(19,$detalle);
		}
		$xml.='</ns>';
		
		echo htmlentities($xml);
		//Plan A
		$params=array($xml);
		$sql="{call notas_xml_add(?)}";
		$stmt=sqlsrv_query($conn,$sql,$params);
		if ($stmt===false)
		{
			echo '<div style="bg-color: green">Error</div>';
			die( print_r( sqlsrv_errors(), true));
		}
		else
		{
			echo '<div style="bg-color: red">Guardado</div>';
		}
	}
	?>
	<form method="POST">
		<table>
		<thead>
		<tr>
		<th align="left">#</th>
		<th align="left">Alumnos</th>
		
		<th class="left">TAREAS
		<input type="hidden" value="640" name="peri_dist_codi_1"/>
		</th>
		
		<th class="left">LECCIO.	
		<input type="hidden" value="641" name="peri_dist_codi_2"/>	
		</th>
		
		<th class="left">TRAGRU	
		<input type="hidden" value="642" name="peri_dist_codi_3"/>	
		</th>
		
		<th class="left">TRAIND	
		<input type="hidden" value="643" name="peri_dist_codi_4"/>	
		</th>
		
		<th class="left">PRUEBA	
		<input type="hidden" value="644" name="peri_dist_codi_5"/>	
		</th>
		
		<th class="left">PROMED	
		<input type="hidden" value="639" name="peri_dist_codi_6"/>
		</th>	
		
		<th align="left">&nbsp;&nbsp;&nbsp;
		</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td class='center'>1</td><td>2014010195 - <input 
							type='hidden'value='87943'name='alum_curs_para_mate_codi_1'id='alum_curs_para_mate_codi_1'/>CAMACHO CAÑARTE NICOLÁS </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_1_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="1"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_1_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="21"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_1_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="41"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_1_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="61"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_1_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="81"/>
                                </td><td id="1" align="right" ></td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>2</td><td>2014010247 - <input 
							type='hidden'value='87945'name='alum_curs_para_mate_codi_2'id='alum_curs_para_mate_codi_2'/>DE REISET ESQUIVEL CHLÓÉ </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_2_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="2"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_2_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="22"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_2_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="42"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_2_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="62"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_2_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="82"/>
                                </td><td id="2" align="right" ></td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>3</td><td>2013010168 - <input 
							type='hidden'value='87939'name='alum_curs_para_mate_codi_3'id='alum_curs_para_mate_codi_3'/>DEFRANC AVILÉS LILA IVETTE</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_3_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="3"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_3_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="23"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_3_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="43"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_3_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="63"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_3_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="83"/>
                                </td><td align="right" id="3">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>4</td><td>2014010252 - <input 
							type='hidden'value='87946'name='alum_curs_para_mate_codi_4'id='alum_curs_para_mate_codi_4'/>ENDERICA ASTUDILLO MARÍA EMILIA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_4_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="4"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_4_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="24"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_4_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="44"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_4_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="64"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_4_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="84"/>
                                </td><td align="right" id="4">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>5</td><td>2015070084 - <input 
							type='hidden'value='87954'name='alum_curs_para_mate_codi_5'id='alum_curs_para_mate_codi_5'/>FLORES GÓMEZ JASON </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_5_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="5"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_5_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="25"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_5_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="45"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_5_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="65"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_5_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="85"/>
                                </td><td align="right" id="5">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>6</td><td>2014010175 - <input 
							type='hidden'value='87942'name='alum_curs_para_mate_codi_6'id='alum_curs_para_mate_codi_6'/>HERRERA PALADINES FLAVIA CAMILIE</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_6_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="6"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_6_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="26"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_6_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="46"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_6_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="66"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_6_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="86"/>
                                </td><td align="right" id="6">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>7</td><td>2014010108 - <input 
							type='hidden'value='87940'name='alum_curs_para_mate_codi_7'id='alum_curs_para_mate_codi_7'/>IZQUIERDO GUZMÁN JOSÉ ANTONIO</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_7_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="7"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_7_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="27"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_7_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="47"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_7_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="67"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_7_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="87"/>
                                </td><td align="right" id="7">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>8</td><td>2012020133 - <input 
							type='hidden'value='87938'name='alum_curs_para_mate_codi_8'id='alum_curs_para_mate_codi_8'/>JARAMILLO ERAZO CAMILA ELIZABETH</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_8_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="8"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_8_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="28"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_8_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="48"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_8_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="68"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_8_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="88"/>
                                </td><td align="right" id="8">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>9</td><td>2012020110 - <input 
							type='hidden'value='87936'name='alum_curs_para_mate_codi_9'id='alum_curs_para_mate_codi_9'/>KUSIJANOVIC LOOR MILENA MARÍA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_9_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="9"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_9_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="29"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_9_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="49"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_9_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="69"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_9_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="89"/>
                                </td><td align="right" id="9">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>10</td><td>2014020011 - <input 
							type='hidden'value='87948'name='alum_curs_para_mate_codi_10'id='alum_curs_para_mate_codi_10'/>MACÍAS IGLESIAS LEONARDO CARLOS</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_10_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="10"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_10_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="30"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_10_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="50"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_10_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="70"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_10_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="90"/>
                                </td><td align="right" id="10">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>11</td><td>2014050019 - <input 
							type='hidden'value='87951'name='alum_curs_para_mate_codi_11'id='alum_curs_para_mate_codi_11'/>MARAZITA ROMÁN JOSÉ JAVIER</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_11_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="11"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_11_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="31"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_11_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="51"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_11_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="71"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_11_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="91"/>
                                </td><td align="right" id="11">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>12</td><td>2014030029 - <input 
							type='hidden'value='87950'name='alum_curs_para_mate_codi_12'id='alum_curs_para_mate_codi_12'/>MEDINA CASTILLO TAHIZ ARIANNA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_12_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="12"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_12_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="32"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_12_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="52"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_12_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="72"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_12_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="92"/>
                                </td><td align="right" id="12">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>13</td><td>2014020025 - <input 
							type='hidden'value='87949'name='alum_curs_para_mate_codi_13'id='alum_curs_para_mate_codi_13'/>MORA CEDEÑO ANDREA VALENTINA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_13_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="13"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_13_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="33"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_13_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="53"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_13_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="73"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_13_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="93"/>
                                </td><td align="right" id="13">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>14</td><td>2012020116 - <input 
							type='hidden'value='87937'name='alum_curs_para_mate_codi_14'id='alum_curs_para_mate_codi_14'/>MOSQUERA WONG MELISSA ALEJANDRA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_14_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="14"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_14_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="34"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_14_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="54"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_14_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="74"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_14_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="94"/>
                                </td><td align="right" id="14">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>15</td><td>2014070047 - <input 
							type='hidden'value='87952'name='alum_curs_para_mate_codi_15'id='alum_curs_para_mate_codi_15'/>ORDOÑEZ ANDRADE JUAN FERNANDO</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_15_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="15"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_15_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="35"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_15_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="55"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_15_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="75"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_15_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="95"/>
                                </td><td align="right" id="15">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>16</td><td>2014020003 - <input 
							type='hidden'value='87947'name='alum_curs_para_mate_codi_16'id='alum_curs_para_mate_codi_16'/>PEZO ACOSTA VICTORIA EULALIA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_16_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="16"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_16_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="36"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_16_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="56"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_16_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="76"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_16_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="96"/>
                                </td><td align="right" id="16">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>17</td><td>2014010124 - <input 
							type='hidden'value='87941'name='alum_curs_para_mate_codi_17'id='alum_curs_para_mate_codi_17'/>SAAVEDRA SOLIS CAMILA ANDREA</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_17_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="17"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_17_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="37"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_17_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="57"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_17_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="77"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_17_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="97"/>
                                </td><td align="right" id="17">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>18</td><td>2014070058 - <input 
							type='hidden'value='87953'name='alum_curs_para_mate_codi_18'id='alum_curs_para_mate_codi_18'/>TRIANA NUÑEZ ISABELLA BEATRIZ</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_18_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="18"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_18_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="38"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_18_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="58"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_18_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="78"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_18_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="98"/>
                                </td><td align="right" id="18">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>19</td><td>2015080116 - <input 
							type='hidden'value='87955'name='alum_curs_para_mate_codi_19'id='alum_curs_para_mate_codi_19'/>UEYAMA GUEVARA JUN SEBASTIÁN</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_19_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="19"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_19_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="39"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_19_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="59"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_19_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="79"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_19_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="99"/>
                                </td><td align="right" id="19">								</td>	<td>&nbsp;</td>
						</tr><tr><td class='center'>20</td><td>2014010238 - <input 
							type='hidden'value='87944'name='alum_curs_para_mate_codi_20'id='alum_curs_para_mate_codi_20'/>VIZUETA AGUIRRE JUAN JOSÉ</td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_20_0"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="20"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_20_1"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="40"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_20_2"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="60"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_20_3"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="80"/>
                                </td><td align="right" >								<input 
									type="number" 
									class="cls_validar"  
									value="0.00"
									name="nota_20_4"    
									style="width:70px" 
									placeholder='0.00'
									onChange="TEXTVALI(this,.0000,10)" 
									pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" 
									step="0.01"
									placeholder="00.00" max="10"
									tabindex="100"/>
                                </td><td align="right" id="20">								</td>	<td>&nbsp;</td>
						</tr>
	</tbody>
</table>
<input type="submit" value="Grabar notas" />
<input name="num_filas" type="hidden" value="20" />
<input name="num_columnas" type="hidden" value="5" />
<input name="peri_dist_main" type="hidden" value="639"/>
</form>
	</body>
</html>

