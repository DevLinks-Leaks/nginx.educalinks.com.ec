<div class="representantes_add_script">
<?php  
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{if(isset($_GET['alum_codi'])){$alum_codi=$_GET['alum_codi'];}else{$alum_codi=0;}}
if(isset($_POST['repr_codi'])){$repr_codi=$_POST['repr_codi'];}else{if(isset($_GET['repr_codi'])){$repr_codi=$_GET['repr_codi'];}else{$repr_codi=0;}}
$params = array($alum_codi);
$sql="{call alum_info(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
if( $stmt === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
$alum_view= sqlsrv_fetch_array($stmt);

$params_repr = array($repr_codi);

$sql_repr="{call repr_info(?)}";
$stmt_repr = sqlsrv_query($conn, $sql_repr, $params_repr);
if( $stmt_repr === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
$repr_view= sqlsrv_fetch_array($stmt_repr);?>
<div id="div_blacklist_warning_repr" style=""></div>
<form id="frm_repr" name="frm_repr" action="" enctype="multipart/form-data" method="post">
<input id="alum_codi" name="alum_codi" type="hidden" value="<?=$alum_view['alum_codi'];?>">
<div class="full">

<div class="picture">
    <div class="buttons">
        <h3><?= $repr_codi!=0?"":"";?> <?= $alum_view['alum_nomb']." ".$alum_view['alum_apel'];?></h3>
        <ul>
            <li>
            <? if ($repr_codi==0){?>
                <button id="btn_guardar" name="btn_guardar" type="button" onClick="load_ajax_add_repr('div_repr_list','script_repr.php');">Guardar</button>
            <? }else{?>
                <button id="btn_guardar" name="btn_guardar" type="button" onClick="load_ajax_upd_repr('div_repr_list','script_repr.php','<?= $repr_codi?>');">Grabar cambios</button>
            <? }?>
            </li>
            <li>
                <button id="btn_cancelar" name="btn_cancelar" type="reset">Cancelar</button>
            </li>
            <li>
                <button id="btn_regresar" name="btn_regresar" type="button" onclick="window.history.back();">Regresar</button>
            </li>
        </ul>
    </div>

</div>
<div class="data">
    
	<div class="form_element">
    	<label id="lbl_repr_cedula" for="repr_cedula">N&uacute;mero de Identificaci&oacute;n:</label>
    	<input id="repr_cedula" name="repr_cedula" type="text" placeholder="Ingrese la c&eacute;dula del representante..." value="<?= $repr_codi>0? $repr_view['repr_cedula']:"";?>" onchange="load_ajax_blacklist_warning_repr('div_blacklist_warning_repr','script_alumnos_blacklist.php','warning_blacklist' );valida_repre(this.value,'div_precargar','script_repr.php');" onkeyup="valida_repre(this.value,'div_precargar','script_repr.php');">
    </div>
    <div class="form_element">
        <label for="repr_tipo_iden">Tipo de Identificaci&oacute;n:</label>

        <?php 
            include ('../framework/dbconf.php');        
            $sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y'";
            $stmt = sqlsrv_query($conn, $sql);
    
            if( $stmt === false )
            {
                echo "Error in executing statement .\n";
                die( print_r( sqlsrv_errors(), true));
            }
            echo "<select id='repr_tipo_iden' name='repr_tipo_iden' onchange=valida_repre(document.getElementById('repr_cedula').value,'div_precargar','script_repr.php'); >";
            while($tipo_iden_result= sqlsrv_fetch_array($stmt))
            {
                $seleccionado="";
                if ($tipo_iden_result["tipo_iden_codi"]==trim($repr_view['REPR_TIPOIDFACTURA']," "))
                            $seleccionado="selected";
                echo '<option value="'.$tipo_iden_result["tipo_iden_codi"].'" '.$seleccionado.'>'.$tipo_iden_result["tipo_iden_deta"].'</option>';
            }
            echo '</select>';
        ?> 
    </div>
    <div id="div_precargar"></div>
    <? if($repr_codi!=0){?>
	<script>
    var tipo_iden = document.getElementById("repr_tipo_iden");
    carga_data_repre('<?= $repr_view['repr_cedula']?>', tipo_iden.options[tipo_iden.selectedIndex].value,'script_repr.php','div_precargar');</script>
	<? }?>
    



<br> 
<br>
<br>
<br>

    <div id="div_repr_list" class="section">
    </div>
    <? if ($repr_codi!=0){?>
        <div id="div_alum_repr_list" class="section">
        <table class="table_full">
        <tr>
        <td>Alumno</td>
        <td>Parentesco</td>
        <td>Curso</td>
        <td>Opciones</td>
        </tr>
        <?  $params = array($repr_codi);
            $sql="{call alum_repr_info(?)}";
            $alum_busq = sqlsrv_query($conn, $sql, $params);
            $c=0;
            while($row_alum_busq = sqlsrv_fetch_array($alum_busq)){?>
                <tr>
                <td><?=$row_alum_busq['alum_apel']." ".$row_alum_busq['alum_nomb']?></td>
                <td><?=$row_alum_busq['repr_parentesco']?></td>
                <td><?=$row_alum_busq['curs_deta']." ".$row_alum_busq['para_deta']?></td>
                <td> <div class="menu_options"><ul><li><a class="option" href="javascript:quitar_representado('script_repr.php','<?=$row_alum_busq['alum_codi']?>','<?=$repr_codi?>');"><span class="icon-remove icon"></span>Quitar</a></li></ul></div>
                </td>
                </tr>
                <? $c++;
            }?>
        </table>
        </div>
    <? }else{?>

        <script>load_list_repr('div_repr_list','script_repr.php','opc=repr_list&alum_codi='+document.getElementById('alum_codi').value);</script>
    
    <? }?>
    </div>



</div>
</form>


</div>