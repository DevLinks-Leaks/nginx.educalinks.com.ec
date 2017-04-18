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
	
	//Variables globales
	$materias_cuantitativas_count=0;
	
	//Consulta de calificaciones
	$sql="{call acta_nota_curs_final (?,?)}";
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
	{	if($row['peri_dist_nota_tipo']!='EQ')
		{	$aux_col[$i][0] = $row['curs_para_mate_codi'];
			$aux_col[$i][1] = $row['mate_deta'];
			$aux_col[$i][2] = $row['mate_tipo'];
			$aux_col[$i][3] = $row['mate_padr'];
			
			$aux_sub_col[$i][0] = $row['peri_dist_codi'];
			$aux_sub_col[$i][1] = $row['peri_dist_deta'];
			
			$aux_fil[$i][0] = $row['alum_codi'];
			$aux_fil[$i][1] = $row['alum_apel'];
			$aux_fil[$i][2] = $row['alum_nomb'];
			
			$datos[]=$row;
			$i++;
		}
	}
	
	$sql="{call acta_nota_curs (?,?)}";
	$params = array($curs_para_codi, $peri_dist_codi);
	$stmt1 = sqlsrv_query($conn, $sql, $params);
	//Columnas y filas
	$row=array();
	while ($row = sqlsrv_fetch_array($stmt1))
	{	if($row['peri_dist_nota_tipo']!='EQ')
		{	$aux_col[$i][0] = $row['curs_para_mate_codi'];
			$aux_col[$i][1] = $row['mate_deta'];
			$aux_col[$i][2] = $row['mate_tipo'];
			$aux_col[$i][3] = $row['mate_padr'];
			$aux_col[$i][4] = $row['mate_orde'];
			
			$aux_sub_col[$i][0] = $row['peri_dist_codi'];
			$aux_sub_col[$i][1] = $row['peri_dist_deta'];
			
			$aux_fil[$i][0] = $row['alum_codi'];
			$aux_fil[$i][1] = $row['alum_apel'];
			$aux_fil[$i][2] = $row['alum_nomb'];
			
			$datos[]=$row;
			$i++;
		}
	}
	
	//Columnas finales
	$columnas = arrayUnique ($aux_col);
	
	//Subcolumnas finales
	$subcolumnas =arrayUnique ($aux_sub_col);
	
	//Filas finales
	$filas = arrayUnique ($aux_fil);
	
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);  
	$cab_row=sqlsrv_fetch_array($cab_view);
	
	//Datos del curso
	$params = array($curs_para_codi);
	$sql="{call curs_para_info(?)}";
	$curs_info = sqlsrv_query($conn, $sql, $params);
	$row_curs_info = sqlsrv_fetch_array($curs_info);
	
?>
<page>
	<h1 class="titulo_1">UNIDAD EDUCATIVA <?= $_SESSION['cliente']; ?></h1> 
    <h2 class="titulo_2">CUADRO DE CALIFICACIONES FINALES DEL <? echo $cab_row['nivel_2']; ?> - <? echo $cab_row['nivel_1']; ?></h2>
    <h2 class="titulo_2">AÑO LECTIVO <? echo $_SESSION['peri_deta']; ?></h2>
    <h3 class="titulo_3"><? echo $row_curs_info['curs_deta'].' '.$row_curs_info['nive_deta'].', PARALELO: '.$row_curs_info['para_deta'].' JORNADA: MATUTINA'; ?></h3>
    <table id="matriz">
        
        
        
        
        <thead>
        <tr>
            <th rowspan="2">#</th>
            <th rowspan="2" width="20%">NÓMINA</th>
            <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]=='COMPORTAMIENTO')
                {
            ?>
                    <th colspan="<?= count($subcolumnas); ?>">
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
                    <th colspan="<?= count($subcolumnas); ?>">
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
					if ($columnas[$i][2]=='C')
					{
						$materias_cuantitativas_count++;
					}
                }
            }
            ?>
            <th rowspan="1" width="3%" colspan="<?= count($subcolumnas); ?>">
                <div>
                    <span>PROMEDIO<br/>RENDIMIENTO</span>
                </div>
            </th>
        </tr>
        <tr>
        
        <? 
		$promedio_rendimiento=array();
		for ($i=0;$i<count($columnas);$i++)
         {
			 foreach ($subcolumnas as $subcol)
			 {
                if ($columnas[$i][1]=='COMPORTAMIENTO')
                {
            ?>
                    <th class="rotate">
                        <div>
                            <span>
                                <? echo $subcol[1]; ?>
                            </span>
                        </div>
                    </th>
            <?
                }
			 }
           }
		   
		 for ($i=0;$i<count($columnas);$i++)
         {
 			 foreach ($subcolumnas as $subcol)
			 {
                if ($columnas[$i][1]!='COMPORTAMIENTO')
                {
            ?>
                    <th class="rotate">
                        <div>
                            <span>
                                <? echo $subcol[1]; ?>
                            </span>
                        </div>
                    </th>
            <?
                }
			 }
           }
		   
		 foreach ($subcolumnas as $subcol)
		{	if ($columnas[$i][1]!='COMPORTAMIENTO')
			{	
				?>
                    <th class="rotate">
                        <div>
                            <span>
                                <? echo $subcol[1]; ?>
                            </span>
                        </div>
                    </th>
            <?
			}
		}
			?>
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
				foreach ($subcolumnas as $subcol)
				{	$params = array($columnas[$j][0]);
					$sql="{call curs_para_mate_info(?)}";
					$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
					$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
					if ($columnas[$j][1]=='COMPORTAMIENTO')
					{
						$nota=buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
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
								$nota_prom_quali= notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota);
								echo '<td class="centrar">'.$nota_prom_quali.'</td>';
							}
						}
					}
                }
            }
             
            for ($j=0;$j<count($columnas);$j++) 
            {	$aux=0;
				foreach ($subcolumnas as $subcol)
				{	$params = array($columnas[$j][0]);
					$sql="{call curs_para_mate_info(?)}";
					$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
					$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
					if ($columnas[$j][1]!='COMPORTAMIENTO')
					{
						$nota=buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
						//Si la calificación es numérica
						if ($columnas[$j][2]=='C')
						{
							echo '<td class="centrar">'.number_format($nota,2,'.',',').'</td>';
							$promedio_rendimiento[$j][$aux]=$nota;
							$aux++;
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
							{	$nota_prom_quali= notas_prom_quali($_SESSION['peri_codi'],$row_curs_peri_info['nota_refe_cab_tipo'],$nota);
								echo '<td class="centrar">'.$nota_prom_quali.'</td>';
							}
						}
					}
                }
            }

            ?>
         
         <?
			//PROMEDIO RENDIMIENTO
			$p_r_total=array();
			$x=$y=0;
			for ($y=0;$y<count($columnas);$y++)
			{	for ($x=0;$x<count($subcolumnas);$x++)
				{
					$p_r_total[$x]=$p_r_total[$x]+$promedio_rendimiento[$y][$x];
				}
			}
			for ($z=0;$z<count($subcolumnas);$z++)
				{
					$p_r_total[$z]=$p_r_total[$z]/$materias_cuantitativas_count;
				}
			foreach ($p_r_total as $notaRP)
			{	
				echo '<td class="centrar">'.number_format($notaRP,2,'.',',').'</td>';
			}
         }
		 ?>
		</tr>
         <tr>
            <td></td>
            <td>FIRMAS</td>
            <? 
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]=='COMPORTAMIENTO')
                {
            ?>
                    <td colspan="<?= count($subcolumnas); ?>">
						<? 
							//Datos del profesor
							$curs_para_mate_codi=$columnas[$i][0];
							$params = array($curs_para_mate_codi);
							$sql="{call prof_curs_para_mate_cons (?)}";
							$dat_profesor = sqlsrv_query($conn, $sql, $params);  
							$prof_row=sqlsrv_fetch_array($dat_profesor);
							echo $prof_row['prof_apel'].' '.$prof_row['prof_nomb'];
						 ?>
                    </td>
            <?
                }
            }
            
            for ($i=0;$i<count($columnas);$i++)
            {
                if ($columnas[$i][1]!='COMPORTAMIENTO')
                {
            ?>
                    <td colspan="<?= count($subcolumnas); ?>">
                       <? 
							//Datos del profesor
							$curs_para_mate_codi=$columnas[$i][0];
							$params = array($curs_para_mate_codi);
							$sql="{call prof_curs_para_mate_cons (?)}";
							$dat_profesor = sqlsrv_query($conn, $sql, $params);  
							$prof_row=sqlsrv_fetch_array($dat_profesor);
							echo $prof_row['prof_apel'].' '.$prof_row['prof_nomb'];
						 ?>
                    </td>
            <?
                }
            }
            ?>
            <td class="rotate" width="3%" colspan="<?= count($subcolumnas); ?>">
                <div>
                    <span>PROMEDIO<br/>RENDIMIENTO</span>
                </div>
            </td>
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