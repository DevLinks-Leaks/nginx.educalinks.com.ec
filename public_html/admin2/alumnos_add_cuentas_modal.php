<?php  
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['alum_cuen_codi']))
{	$alum_cuen_codi=$_POST['alum_cuen_codi'];
}else
{
	$alum_cuen_codi = 0;	
}
if(isset($_POST['alum_codi']))
{	$alum_codi=$_POST['alum_codi'];
}else
{
	$alum_codi = 0;	
}
/*
	Cuando se inscribe, recién obtiene un alum_curs_para_codi, si es nuevo, no permitir sacar Documentos, o indicarle al usuario que debe matricularlo primero.
*/

$params = array($alum_cuen_codi);
$sql="{call alum_cuentas_show(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
if( $stmt === false ){
	echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
} 
$alum_cuentas_show= sqlsrv_fetch_array($stmt);
/*descencriptar numero tarjeta*/
if($alum_cuentas_show['alum_cuen_nume']!=null and !is_numeric($alum_cuentas_show['alum_cuen_nume'])){
	$alum_cuen_nume_dec=base64_decode($alum_cuentas_show['alum_cuen_nume']);
	$iv = base64_decode($_SESSION['clie_iv']);
	$alum_cuen_nume = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_cuen_nume_dec, MCRYPT_MODE_CBC, $iv );
	// $alum_cuen_nume=rtrim($alum_cuen_nume,"\0");
	$alum_cuen_nume=preg_replace('/[^A-Za-z0-9\-]/', '',$alum_cuen_nume);
	$alum_cuen_nume =  creditCardMask($alum_cuen_nume,4,8);
}else{
	$alum_cuen_nume=$alum_cuentas_show['alum_cuen_nume'];
}

/*FIN*/
?>
<input type="hidden" id="alum_cuen_codi" name="alum_cuen_codi" value="<?=$alum_cuen_codi;?>" />
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Método de Pago</h4>
</div>
<div class="modal-body" id="modal_body_metodo_pago">
	<div class="row">
		<div class="form-group col-md-6">
			<label for="alum_form_pago">Forma de Pago:</label>
			<?php 
				include ('../framework/dbconf.php');		
				$params = array(21);
				$sql="{call cata_hijo_view(?)}";
				$stmt = sqlsrv_query($conn, $sql, $params);
		
				if( $stmt === false )
				{
					echo "Error in executing statement .\n";
					die( print_r( sqlsrv_errors(), true));
				}
				echo '<select class="form-control input-sm" id="sl_form_pago" name="sl_form_pago" onchange="CargarBancosTarjetas(this.value);mostrar_tarjeta(this.value);" >';
				echo '<option value="">SELECCIONE</option>';
				
				while($form_pago_view= sqlsrv_fetch_array($stmt))
				{
					$seleccionado="";
					if ($form_pago_view["codigo"]==$alum_cuentas_show["alum_cuen_form_pago"])
						$seleccionado="selected";
					echo '<option value="'.$form_pago_view["codigo"].'" '.$seleccionado.'>'.$form_pago_view["descripcion"].'</option>';
				}
				echo '</select>';
			?> 
		</div>
		<div class="form-group col-md-6">
			<label for="alum_cuen_banc_tarj" id="lbl_banco_tarjeta">Banco/Tarjeta:</label>
				<?php 
				include ('../framework/dbconf.php');        
				$params = array($alum_cuentas_show['alum_cuen_form_pago']);
				$sql="{call cata_hijo_view(?)}";
				$stmt = sqlsrv_query($conn, $sql, $params);
		
				if( $stmt === false )
				{
					echo "Error in executing statement .\n";
					die( print_r( sqlsrv_errors(), true));
				}
				$seleccionado="";
				$deshabilitado="";
				if (!isset($alum_cuentas_show['alum_cuen_banc_tarj']))
					$deshabilitado="disabled";
				echo '<select class="form-control" id="alum_cuen_banc_tarj" name="alum_cuen_banc_tarj[]" '.$deshabilitado.'>';
				// echo '<option value="">SELECCIONE</option>';
				while($banc_tarj_view= sqlsrv_fetch_array($stmt))
				{
					if($banc_tarj_view["codigo"]==$alum_cuentas_show['alum_cuen_banc_tarj'])
					{
						$seleccionado="selected";
					}
					else
					{
						$seleccionado="";
					}
					echo '<option '.$seleccionado.' value="'.$banc_tarj_view['codigo'].'">'.$banc_tarj_view["descripcion"].'</option>';
				}
				echo '</select>';
			?> 
			
		</div>
	</div>
	<div id="div_tarjeta" class="row collapse <?=($alum_cuentas_show["alum_cuen_form_pago"]==23 ? 'in' : '')?>" aria-expanded="">
		<div class="form-group col-md-6">
			<label for="alum_cuen_banc_emis">Banco emisor: (en caso de tarj. de crédito)</label>
			<?php 
				include ('../framework/dbconf.php');        
				$params = array(22);
				$sql="{call cata_hijo_view(?)}";
				$stmt = sqlsrv_query($conn, $sql, $params);
				if( $stmt === false )
				{	echo "Error in executing statement .\n";
					die( print_r( sqlsrv_errors(), true));
				}
				$seleccionado="";
				echo '<select class="form-control input-sm" id="alum_cuen_banc_emis" name="alum_cuen_banc_emis">';
				echo '<option value="">SELECCIONE</option>';
				while($row= sqlsrv_fetch_array($stmt))
				{	if($row["codigo"]==$alum_cuentas_show['alum_cuen_banc_emis'])
					{	$seleccionado="selected";
					}
					else
					{	$seleccionado="";
					}
					echo '<option '.$seleccionado.' value="'.$row['codigo'].'">'.$row["descripcion"].'</option>';
				}
				echo '</select>';
			?> 
		</div>
		<div class="form-group col-md-6">
			<label for="alum_cuen_fech_venc">Fecha de Vencimiento de Tarjeta:</label>
			<input id="alum_cuen_fech_venc" name="alum_cuen_fech_venc" type="text" class="form-control input-sm" placeholder="Ingrese la fecha de vencimiento de la tarjeta..." value="<?=date_format($alum_cuentas_show['alum_cuen_fech_venc'],"d/m/Y");?>">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<label for="alum_cuen_nomb">Nombres del Propietario de la  Cuenta:</label>
			<input id="alum_cuen_nomb" name="alum_cuen_nomb" type="text" class="form-control input-sm" placeholder="Ingrese nombres y apellidos ..." value="<?=$alum_cuentas_show['alum_cuen_nomb'];?>">
		</div>
		<div class="form-group col-md-6">
			<label for="lbl_tipo">Tipo de Cuenta:<br/><br/>
				<label>
				<input id="cta_corriente" type="radio" name="tipo_cuenta" value="CORRIENTE" <?=($alum_cuentas_show['alum_cuen_tipo']=="C"?"checked":"")?> />CUENTA CORRIENTE
				</label>
				<label>
				<input id="cta_ahorro" type="radio" name="tipo_cuenta" value="AHORROS" <?=($alum_cuentas_show['alum_cuen_tipo']=="A"?"checked":"")?> />CUENTA DE AHORROS
				</label>
			</label>
		</div>
		<div class="form-group col-md-6">
			<label for="alum_cuen_cedu">Número de Identificación del Propietario de la  Cuenta:</label>
			<input id="alum_cuen_cedu" name="alum_cuen_cedu" type="text" class="form-control input-sm" placeholder="Ingrese cédula..." value="<?=$alum_cuentas_show['alum_cuen_cedu'];?>">
		</div>
		<div class="form-group col-md-6">
			<label for="alum_cuen_tipo_iden">Tipo de Identificación del Propietario de la Cuenta:</label>
			<?php 
				include ('../framework/dbconf.php');        
				$sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y'";
				$stmt = sqlsrv_query($conn, $sql);
		
				if( $stmt === false )
				{
					echo "Error in executing statement .\n";
					die( print_r( sqlsrv_errors(), true));
				}
				echo "<select class='form-control input-sm' id='alum_cuen_tipo_iden' name='alum_cuen_tipo_iden' >";
				while($tipo_iden_result= sqlsrv_fetch_array($stmt))
				{
					$seleccionado="";
					if ($tipo_iden_result["tipo_iden_codi"]==$alum_cuentas_show['alum_cuen_tipo_iden'])
								$seleccionado="selected";
					echo '<option value="'.$tipo_iden_result["tipo_iden_codi"].'" '.$seleccionado.'>'.$tipo_iden_result["tipo_iden_deta"].'</option>';
				}
				echo '</select>';
			?> 
		</div>
		
		<div class="form-group col-md-6">
			<label for="alum_cuen_nume">Número Cuenta o Tarjeta<?=(para_sist(404)=='1'?'<span style="color:red;">*</span>':'')?>:</label>
			<input id="alum_cuen_nume" class="form-control input-sm <?=(para_sist(404)=='1'?'required':'')?>" name="alum_cuen_nume" type="text" placeholder="Ingrese numero de Cuenta o Tarjeta..." value="<?=$alum_cuen_nume;?>" >
		</div>
		<?php if( permiso_activo( 534 ) and $alum_cuen_codi!=0){?>
		<div class="form-group col-md-6">
			<label><br/>
			<input id="chk_visualizar" name="check" type="checkbox" data-alumcodi="<?=$alum_codi?>" />
			<label for="check">Check para ver número de cuenta/tarjeta sin máscara</label>
			</label>
		</div>
		<?}?>
	</div>
</div>
<div class="modal-footer">
	<button id="btn_guardar_cuen" type='button' class='btn btn-success' data-loading="Guardando..."  onclick="cuenta_add('script_cuentas.php',<?=$alum_codi?>);" >Guardar</button>
	<button 
		type="button" 
		class="btn btn-default" 
		data-dismiss="modal">
			Cerrar
	</button>
</div>