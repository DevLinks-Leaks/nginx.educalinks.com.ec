<?
	header("Content-Type: application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=cuadro_calificaciones".$_GET['curs_para_codi'].".xls");
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
	<title>Educalinks | <?php echo get_parametro($_SESSION['codi'], 4); ?></title>
    <style type="text/css">
	@media all 
	{
		.page-break	
		{ 
			display: none; 
		}
	}
	
	@media print 
	{
		.page-break	
		{ 
			display: block; 
			page-break-before: always; 
		}
		
		@page 
		{  
			size: A4 landscape;  
			border: 1px solid black;
		} 
	}
	
	body
	{
		font-family: "Times New Roman";
		font-size: 10px;
	}
	
	th.rotate 
	{
		height: 80px;
		white-space: normal;
		width: 0%;
	}
	
	th.rotate div 
	{
		transform: rotate(-90deg);
	}
	
	/*th .rotate div span 
	{
	  border-bottom: 1px solid #ccc;
	  padding: 2px 2px;
	}*/
	
	.centrar
	{
		text-align: center;
	}
	
	.informacion
	{
		font-size: 8px;
		margin-top: 10px;
		text-align:left;
	}
	
	.titulo_1
	{
		font-size: 14px;
		margin: 0;
		text-align:center;
	}
	
	.titulo_2
	{
		font-size: 12px;
		margin: 0;
		text-align:center;
	}
	
	.titulo_3
	{
		font-size: 10px;
		margin: 10px 0 0 0;
		text-align: left;
	}
	
	.sombreado
	{
		background: #CFCFCF;
	}
	
	#equi_cuali
	{
		border: 1px solid #000;
		border-collapse: collapse;
		font-size: 8px;
		margin-top: 5px;
		width: 50%;
	}
	
	#equi_cuali tr td, #equi_cuali thead tr th
	{
		border: 1px solid #000;
	}
	
	#info_header, #info_footer
	{
		width: 100%;
	}
	
	#matriz
	{
		border: 1px solid black;
		border-collapse: collapse;
		width: 100%;
	}
	
	#matriz thead
	{
		background: #CFCFCF !important;
		font-size: 5px;
	}
	
	#matriz thead th
	{
		border: 1px solid black;
	}
	
	#matriz tr td
	{
		border: 1px solid black;
		font-size: 7px;
	}
	</style>
</head>
<body>
<?php
	//Obteniendo parámetros
	$curs_para_codi=$_GET['curs_para_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	
	
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
	{
		$aux_col[$i][0] = $row['curs_para_mate_codi'];
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
	
	//Datos de la materia
	$params = array($curs_para_mate_codi);
	$sql="{call curs_para_mate_info(?)}";
	$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
	$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
	
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
                }
            }
            ?>
            <th rowspan="2" class="rotate" width="3%">
                <div>
                    <span>PROMEDIO<br/>RENDIMIENTO</span>
                </div>
            </th>
        </tr>
        <tr>
        
        <? 
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
				{
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
								echo '<td class="centrar">'.notas_prom_quali(1,'Q',$nota).'</td>';
							}
						}
					}
                }
            }
             
            for ($j=0;$j<count($columnas);$j++) 
            {
				foreach ($subcolumnas as $subcol)
				{
					if ($columnas[$j][1]!='COMPORTAMIENTO')
					{
						$nota=buscar_nota_3d($datos,$filas[$i][0],$columnas[$j][0], $subcol[0], 'alum_codi', 'curs_para_mate_codi', 'peri_dist_codi');
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
								echo '<td class="centrar">'.notas_prom_quali(1,'Q',$nota).'</td>';
							}
						}
					}
                }
            }

            ?>
         </tr>
         <?
         }
		 ?>
         
         
         
         
         
         
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
            <td class="rotate" width="3%">
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