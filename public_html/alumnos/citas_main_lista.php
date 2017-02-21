<?php
session_start();
if(isset($_POST['prof_codi'])){$prof_codi=$_POST['prof_codi'];}else{$prof_codi=$row_curs_mate_view['prof_codi'];}
if(isset($_POST['fecha_cita'])){$fecha_cita=$_POST['fecha_cita'];}else{$fecha_cita=date("d/m/Y");}
if(isset($_POST['alum_curs_para_mate_codi'])){$alum_curs_para_mate_codi=$_POST['alum_curs_para_mate_codi'];}else{$alum_curs_para_mate_codi=$row_curs_mate_view['alum_curs_para_mate_codi'];}
?>

<!-- Horarios -->
<div class="panel panel-default" >
    <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-time"></span> Horarios Disponibles para el profesor <?=$fecha_cita?></h3>
    </div>
    <div class="panel-body" style="max-height: 120px; overflow-x:hidden; overflow-y: scroll;">
        <table class="table table-hover">
            <tbody>
                <?php 
                if($conn==""){include("../framework/dbconf.php");include("../framework/funciones.php");};
                $fecha_cita_iso=substr($fecha_cita,6,4)."".substr($fecha_cita,3,2)."".substr($fecha_cita,0,2);
                $params_hora = array($prof_codi,$fecha_cita_iso,$_SESSION['peri_codi']);
                $sql_hora="{call hora_prof_fech_busq(?,?,?)}";
                $hora_prof_busq = sqlsrv_query($conn, $sql_hora, $params_hora); 
                if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));} 
                $cc = 0;
                while($row_hora_prof= sqlsrv_fetch_array($hora_prof_busq)){$cc++;?>
                <tr <?php if ($row_hora_prof['hora_aten_repr_codi']==''){?> onclick="citas_add('citas_alum_curs_para_mate_<?= $alum_curs_para_mate_codi;?>','script_citas.php','<?=$row_hora_prof['hora_codi'];?>','<?= $alum_curs_para_mate_codi;?>','<?=$prof_codi?>','<?=$row_hora_prof['hora_codi'];?>','<?=$fecha_cita?>')"<?php }?> style="cursor:pointer;">
                    <td  <?php if ($row_hora_prof['hora_aten_repr_codi']!=''){?>class="citas-disabled"<?php }?>><?=$row_hora_prof['hora_ini'];?> - <?=$row_hora_prof['hora_fin'];?>: <?php if ($row_hora_prof['hora_aten_repr_codi']==''){echo "El horario est&aacute; libre para realizar una cita.";}else{echo "El horario se encuentra reservado para una cita.";}?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        Total de Horarios ( <?=$cc;?> )
    </div>
</div>
