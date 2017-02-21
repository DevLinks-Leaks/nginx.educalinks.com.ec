<?php
	//Importando librerías necesarias
	require_once ('funciones.php');
	require_once ('../../framework/dbconf.php');	
	require_once ('../../framework/funciones.php');	
	
	//Iniciando sesión
	session_start();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="estilos.css" />
	<title>Educalinks | <?php echo para_sist(2); ?></title>
</head>
<body>
<?php
	//Obteniendo parámetros
	$curs_para_codi=$_GET['curs_para_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	
	
	//Consulta de calificaciones
	$sql="{call acta_nota_curs (?,?)}";
	$params = array($curs_para_codi, $peri_dist_codi);
	$stmt = sqlsrv_query($conn, $sql, $params);

	if( $stmt === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}

	
	//Columnas y filas
	$row=array();
	$i=0;
	while ($row = sqlsrv_fetch_array($stmt))
	{
		$aux_col[$i][0] = $row['curs_para_mate_codi'];
		$aux_col[$i][1] = $row['mate_deta'];//Encabezado
		$aux_col[$i][2] = $row['mate_tipo'];
		$aux_col[$i][3] = $row['mate_padr'];
		$aux_col[$i][4] = $row['mate_orde'];
		$aux_fil[$i][0] = $row['alum_codi'];
		$aux_fil[$i][1] = $row['alum_apel'];
		$aux_fil[$i][2] = $row['alum_nomb'];
		$datos[]=$row;
		$i++;
	}
	
	//Columnas finales
	$columnas = arrayUnique ($aux_col);
	//Columnas finales

		foreach ($columnas as $key => $row) 
		{     $aux[$key] = $row[4]; 
		}
		array_multisort($aux, SORT_ASC, $columnas);
		
	//Filas finales
	$filas = arrayUnique ($aux_fil);
	
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);  
	$cab_row=sqlsrv_fetch_array($cab_view);
	
	//Datos del profesor
	$params = array($curs_para_mate_codi);
	$sql="{call prof_curs_para_mate_cons (?)}";
	$dat_profesor = sqlsrv_query($conn, $sql, $params);  
	$prof_row=sqlsrv_fetch_array($dat_profesor);
	
	//Datos del curso
	$params = array($curs_para_codi);
	$sql="{call curs_para_info(?)}";
	$curs_info = sqlsrv_query($conn, $sql, $params);
	$row_curs_info = sqlsrv_fetch_array($curs_info);
	
	//Tipos de falta
	$params=array();
	$sql="{call falt_tipo_view()}";
	$falt_view = sqlsrv_query($conn, $sql, $params);
	
?>
<page>
	<h1 class="titulo_1">UNIDAD EDUCATIVA <?= $_SESSION['cliente']; ?></h1> 
    <h2 class="titulo_2">CUADRO DE CALIFICACIONES DEL <? echo $cab_row['nivel_2']; ?> - <? echo $cab_row['nivel_1']; ?></h2>
    <h2 class="titulo_2">AÑO LECTIVO <? echo $_SESSION['peri_deta']; ?></h2>
    <h3 class="titulo_3"><? echo $row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].', PARALELO: '.$row_curs_info['para_deta'].' JORNADA: MATUTINA'; ?></h3>
    <table id="matriz">
        
        
        
        
        <thead>
        <tr>
            <th>#</th>
            <th width="20%">NÓMINA</th>
            <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]=='COMPORTAMIENTO')
                {
            ?>
                    <th class="rotate">
                        <div>
                            <span>
                                <? echo substr($columnas[$i][1],0,20); ?>
                            </span>
                        </div>
                    </th>
            <?
                }
            }
            
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]!='COMPORTAMIENTO')
                {
            ?>
                    <th class="rotate">
                        <div>
                            <span>
                                <? 
								$palabras=explode(" ",$columnas[$i][1]);
								foreach ($palabras as $word)
								echo substr($word,0,20)."<br/>"; 
								?>
                            </span>
                        </div>
                    </th>
            <?
                }
            }
			
			//Tipos de faltas
			while ($falt_view_row=sqlsrv_fetch_array($falt_view))
			{
			?>
            	<th class="rotate">
                        <div>
                            <span>
                                <? 
								$palabras=explode(" ",$falt_view_row['falt_tipo_deta']);
								$iniciales="";
								foreach ($palabras as $word)
									$iniciales=$iniciales.substr($word,0,1);
								echo $iniciales; 
								?>
                            </span>
                        </div>
                    </th> 
            <?
			}
            ?>
            <th class="rotate" width="3%">
                <div>
                    <span>PROMEDIO<br/>RENDIMIENTO</span>
                </div>
            </th>
        </tr>
         </thead>

        
        
         <? 
         //Acumulador para el promedio de rendimiento
         $acum_rendimiento=0;
         //Recorre cada estudiante
         for ($i=0;$i<count($filas);$i++) 
         {
             $cont_materias=0;
             $acum_materias=0;
         ?>
         <tr>
            <td class="centrar"><? echo $i+1; ?></td>
            <td><? echo $filas[$i][1].' '.$filas[$i][2]; ?></td>
            <? 
            for ($j=0;$j<count($columnas);$j++) 
            {
				//Datos de la materia
				$params = array($columnas[$j][0]);
				$sql="{call curs_para_mate_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
				$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				
                if ($columnas[$j][1]=='COMPORTAMIENTO')
                {
                    $nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
                    if ($columnas[$j][2]=='C')
                    {
                        echo '<td class="centrar">'.number_format($nota,2,'.',',').'</td>';
                    }
                    else
                    {
                        if ($nota==0)
                        {
                            echo '<td class="centrar">--</td>';
                        }
                        else
                        {
                            echo '<td class="centrar">'.notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota).'</td>';
                        }
                    }
                }
            }
             
            for ($j=0;$j<count($columnas);$j++) 
            {
				//Datos de la materia
				$params = array($columnas[$j][0]);
				$sql="{call curs_para_mate_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
				$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				
                if ($columnas[$j][1]!='COMPORTAMIENTO')
                {
                    $nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
					//Si la calificación es numérica
                    if ($columnas[$j][2]=='C')
                    {
                        echo '<td class="centrar">'.number_format($nota,2,'.',',').'</td>';
						
						//Para sacar el promedio de las materias principales
						if ($columnas[$j][3]==-1)
						{
							$cont_materias++;
							$acum_materias=$acum_materias+$nota;
						}
                    }
					//Si la calificación es cualitativa
                    else
                    {
                        if ($nota==0)
                        {
                            echo '<td class="centrar">--</td>';
                        }
                        else
                        {
                            echo '<td class="centrar">'.notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota).'</td>';
                        }
                    }
                }
            }
			
			//Tipos de falta
			$params=array();
			$sql="{call falt_tipo_view()}";
			$falt_view = sqlsrv_query($conn, $sql, $params);
			while ($falt_view_row=sqlsrv_fetch_array($falt_view))
			{
				//Consulta las faltas
				$params=array($_SESSION['peri_codi'], $peri_dist_codi, $curs_para_codi,$filas[$i][0],$falt_view_row['falt_tipo_codi']);
				$sql="{call falt_tipo_alum_view(?,?,?,?,?)}";
				$falt_alum_view = sqlsrv_query($conn, $sql, $params);
				$falt_alum_view_row=sqlsrv_fetch_array($falt_alum_view);
				 echo '<td class="centrar">'.$falt_alum_view_row['num_faltas'].'</td>';
			}
			$nota_rendimiento=$acum_materias/$cont_materias;
			$acum_rendimiento=$acum_rendimiento+$nota_rendimiento;
            echo '<td class="centrar">'.number_format($nota_rendimiento,2,'.',',').'</td>';

            ?>
         </tr>
         <?
         }
         ?>




         <tr>
         	<td></td>
            <td><strong>Promedio Global:</strong></td>
            <?
			for ($j=0;$j<count($columnas);$j++) 
			{
                if ($columnas[$j][1]=='COMPORTAMIENTO')
                {
                    $acum_global=0;
                    $prom_global=0;
                    
                    for ($i=0;$i<count($filas);$i++)
                    {
                        $acum_global=$acum_global+buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
                    }
                    $prom_global=$acum_global/count($filas);

                    if ($columnas[$j][2]=='C')
                    {
                        echo '<td class="centrar">'.number_format($prom_global,2,'.',',').'</td>';
                    }
                    else
                    {
                        if ($prom_global==0)
                        {
                            echo '<td class="centrar">--</td>';
                        }
                        else
                        {
                            echo '<td class="centrar">'.notas_prom_quali($_SESSION['peri_codi'],'Q',$prom_global).'</td>';
                        }
                    }
                }
			}


            for ($j=0;$j<count($columnas);$j++) 
			{
                if ($columnas[$j][1]!='COMPORTAMIENTO')
                {
                    $acum_global=0;
                    $prom_global=0;
                    $cont_global=0;
                    
                    for ($i=0;$i<count($filas);$i++)
                    {
						$nota=buscar_nota($datos,$filas[$i][0],$columnas[$j][0], 'alum_codi', 'curs_para_mate_codi');
						if ($nota!=0)
						{
                        	$acum_global=$acum_global+$nota;
                            $cont_global++;
						}
                    }
                    $prom_global=$acum_global/$cont_global;

                    if ($columnas[$j][2]=='C')
                    {
                        echo '<td class="centrar">'.number_format($prom_global,2,'.',',').'</td>';
                    }
                    else
                    {
                        if ($prom_global==0)
                        {
                            echo '<td class="centrar">--</td>';
                        }
                        else
                        {
                            echo '<td class="centrar">'.notas_prom_quali($_SESSION['peri_codi'],'Q',$prom_global).'</td>';
                        }
                    }
                }
			}
			
			
			//Tipos de falta
			$params=array();
			$sql="{call falt_tipo_view()}";
			$falt_view = sqlsrv_query($conn, $sql, $params);
			while ($falt_view_row=sqlsrv_fetch_array($falt_view))
			{
				//Para sumar las faltas
				$acum_faltas=0;
				for ($i=0;$i<count($filas);$i++)
                {
					//Consulta las faltas
					$params=array($_SESSION['peri_codi'], $peri_dist_codi, $curs_para_codi,$filas[$i][0],$falt_view_row['falt_tipo_codi']);
					$sql="{call falt_tipo_alum_view(?,?,?,?,?)}";
					$falt_alum_view = sqlsrv_query($conn, $sql, $params);
					$falt_alum_view_row=sqlsrv_fetch_array($falt_alum_view);
					$acum_faltas=$acum_faltas+$falt_alum_view_row['num_faltas'];
                }
				echo '<td class="centrar">'.$acum_faltas.'</td>';
			}
			
			?>
            <td class="centrar"><? echo number_format($acum_rendimiento/count($filas),2,'.',','); ?></td>
         </tr>
    </table>
       <table id="info_footer" class="informacion">
        <tr>
	        <td>
            	<strong>Profesor:</strong>
                ........................................................
			</td>
            <td>
            	<strong>Fecha:</strong>
                ........................................................
			</td>
		</tr>
		</table>
</page>
<div class="page-break"></div>
</body>
</html>