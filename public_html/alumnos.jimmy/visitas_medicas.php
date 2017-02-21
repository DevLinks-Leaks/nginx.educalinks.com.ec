
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->
    <?php include ('head.php');?>

    <body class="general admin">
                                <!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=7; ?>
                                <!-- InstanceEndEditable -->
        <div class="pageContainer"> 
            
            <?php include ('menu.php');?>

            <div  id="mainPanel"  class="section_main">
                
                <?php include ('header.php');?>

                <div class="main sectionBorder">
                    <div id="information">
                        <div class="titleBar">
                            <div class="title"><h3> <span class="icon-clock icon"></span>Visitas Médicas</h3></div> 
                        </div>

                        <table class="table_striped" id="table_visitas" data-page-length='10'>
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Motivo</th>
                                    <th style="text-align: center;">Fecha - Hora</th>
                                    <th style="text-align: center;">Tratamiento</th>
                                    <th style="text-align: center;">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    include ('../framework/dbconf.php');        
                                    $sql="{call med_alum_atenciones(?)}";
                                    $params_opc= array($_SESSION['alum_codi']);
                                    $stmt = sqlsrv_query($conn, $sql,$params_opc);
                            
                                    if( $stmt === false )
                                    {
                                        echo 'Error in executing statement .\n';
                                        die( print_r( sqlsrv_errors(), true));
                                    }
                                    
                                    while($atencion_result= sqlsrv_fetch_array($stmt))
                                    {
                                        echo "<tr>";
                                        echo '<td class="text-center">'.$atencion_result['enfe_descripcion'].'</td>';
                                        echo '<td class="text-center">'.date_format($atencion_result['aten_fechaCreacion'],"d/m/Y H:i:s").'</td>';
                                        echo '<td class="text-center"><ul>';
                                        $sql2="{call med_atenciones_detalle_info(?)}";
                                        $params_opc2= array($atencion_result['aten_codigo']);
                                        $stmt2 = sqlsrv_query($conn, $sql2,$params_opc2);
                                        while($detalle_result= sqlsrv_fetch_array($stmt2)){
                                            echo "<li>Medicamento: ".$detalle_result['med_descripcion']." Cant: ".$detalle_result['aten_deta_med_cantidad']."</li>";
                                        }
                                        echo '</ul></td>';
                                        echo '<td class="text-center"><a href="../medic/comprobante_atencion/'.$atencion_result['aten_codigo'].'" target="_blank"><span class="icon icon-print"></span> Comprobante Atención</a></td>';
                                        echo "</tr>";
                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <input name="mens_de"       type="hidden" id="mens_de"      value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
    <input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

</html>
