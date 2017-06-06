<?php
include("../framework/dbconf.php");
include("../framework/funciones.php");

if(isset($_POST['repr_codi'])){$repr_codi=$_POST['repr_codi'];}else{$repr_codi=0;}
if(isset($_POST['flag'])){$flag=$_POST['flag'];} //Para saber en que pantalla se usa
$sql_opc = "{call repr_info(?)}";
$params_opc= array($_POST['repr_codi']);
$repr_info = sqlsrv_query( $conn, $sql_opc,$params_opc);

$row_repr_info = sqlsrv_fetch_array($repr_info);

if($repr_codi>0){
	$label='Editar';
	$f="repre_exist_edit('alert_repr','script_repr.php');";
	$disabled='';
}else{
	$label='Nuevo';
	$disabled='disabled';
	$f="";
}
?>
<input id="hd_repr_cedula" name="hd_repr_cedula" type="hidden" value="<?=$row_repr_info['repr_cedula'];?>">
<input id="hd_repr_codi" name="hd_repr_codi" type="hidden" value="<?=$repr_codi;?>">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="title_repr"><?=$label;?> Representante: <?=$row_repr_info['repr_apel'].' '.$row_repr_info['repr_nomb']?></h4>
</div>
<div id="modal_repr" class="modal-body" >
	<div class="row">
		<div id="div_blacklist_warning_repr" class="col-md-12"></div>
		<div class="form-group <?= ($repr_codi>0) ? 'col-md-6' : 'col-md-5'?>">
			<label for="repr_cedula">Número de identificación<span style="color:red;">*</span>:</label>
			<input class="form-control input-sm" id="repr_cedula" name="repr_cedula" type="text" placeholder="Ingresar el número de identificación" value="<?=$row_repr_info['repr_cedula'];?>" onchange="<?=$f;?>" onkeyup="">
		</div>
		<div class="form-group <?= ($repr_codi>0) ? 'col-md-6' : 'col-md-5'?>">
			<label for="repr_tipo_iden">Tipo de identificación<span style="color:red;">*</span>:</label>
			<?php 
			include ('../framework/dbconf.php');        
			$sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y'";
			$stmt = sqlsrv_query($conn, $sql);

			if( $stmt === false )
			{
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}
			echo "<select id='repr_tipo_iden' class='form-control input-sm' name='repr_tipo_iden' >";
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
		<? if ($repr_codi<=0){?>
		<div class="col-md-1 form-group">
			<label></label>
			<button id="btn_buscar_repr" type='button' class='btn btn-success form-control' data-loading="Buscando..." onclick="valida_repre($('#repr_cedula').val(),'repr-tab-content','script_repr.php');"><span class="fa fa-search fa-lg"></span></button>
		</div>
		<div class="col-md-1 form-group">
			<label></label>
			<button id="btn_reset_repr" type='button' onmouseover="$(this).tooltip('show');" title="Presione para limpiar formulario" class='btn btn-info form-control' data-loading="Buscando..." onclick="reset();" disabled><span class="fa fa-refresh fa-lg"></span></button>
		</div>
		<?}?>
		<div id="alert_repr">
			
		</div>
	</div>
	<div class="row">
		<div id="tabs" name="tabs" class="col-md-12 nav-tabs-custom">
			<ul class="nav nav-tabs">    
				<li class="active"><a href="#tab1" data-toggle="tab" onClick=""><span class="fa fa-clipboard"></span> Datos Personales</a></li>
				<li><a href="#tab2" data-toggle="tab" onClick="" ><span class="fa fa-phone"></span> Datos Contacto</a></li>
				<li><a href="#tab3" data-toggle="tab" onClick=""><span class="fa fa-graduation-cap"></span> Trabajo y Estudio</a></li>
				<li><a href="#tab4" data-toggle="tab" onClick=""><span class="fa fa-archive"></span> Otros Datos</a></li>
			</ul>
			<div id="repr-tab-content" class="tab-content">
				<?include("representantes_add_modal_content.php");?>
			</div>
		</div>

	</div>
	
</div>
<div id='repr_footer' class="modal-footer">
	<button id="btn_guardar_repr" type='button' class='btn btn-success' data-loading="Guardando..."  onclick="load_ajax_upd_repr('script_repr.php',<?=$flag?>);" <?=$disabled?> >Guardar</button>
	<button type='button' class='btn btn-default' data-dismiss='modal' >Cerrar</button>
</div>