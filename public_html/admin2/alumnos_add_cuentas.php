<?php 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['alum_codi']))
{	$alum_codi=$_POST['alum_codi'];
}else
{
	if(isset($_GET['alum_codi']))
	{	$alum_codi = $_GET['alum_codi'];
	}
	else
	{	$alum_curs_para_codi = 0;
		$alum_codi=0;
	}
}
$params = array($alum_codi);
$sql="{call alum_cuentas_view(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
if( $stmt === false ){
	echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
} 

/*FIN*/
?>
<div class="col-md-12">
	<table id="tbl_metodo_pago" class="table table-striped hover">
		<thead><tr>
			<th class="text-center">Orden</th>
			<th>Forma de Débito</th>
			<th>Cuenta / Tarjeta</th>
			<th>Propietario</th>
			<th>Número</th>
			<th>Opciones</th>
		</tr></thead>
		<tbody>
		<?php 
			while ($row_alum_cuentas_view= sqlsrv_fetch_array($stmt)){
				/*descencriptar numero tarjeta*/
				if($row_alum_cuentas_view['alum_cuen_nume']!=null and !is_numeric($row_alum_cuentas_view['alum_cuen_nume'])){
					$alum_cuen_nume_dec=base64_decode($row_alum_cuentas_view['alum_cuen_nume']);
					$iv = base64_decode($_SESSION['clie_iv']);
					$alum_cuen_nume = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_cuen_nume_dec, MCRYPT_MODE_CBC, $iv );
					// $alum_cuen_nume=rtrim($alum_cuen_nume,"\0");
					$alum_cuen_nume=preg_replace('/[^A-Za-z0-9\-]/', '',$alum_cuen_nume);
					$alum_cuen_nume =  creditCardMask($alum_cuen_nume,4,8);
				}else{
					$alum_cuen_nume=$row_alum_cuentas_view['alum_cuen_nume'];
				}
		?>
		<tr>
			<td class="roworder text-center" style="cursor: move;"><?=$row_alum_cuentas_view['alum_cuen_orde']+1;?></td>
			<td class="roworder" style="cursor: move;"><?=$row_alum_cuentas_view['form_pago'];?></td>
			<td class="roworder" style="cursor: move;"><?=$row_alum_cuentas_view['banc_tarj'];?></td>
			<td class="roworder" style="cursor: move;"><?=$row_alum_cuentas_view['alum_cuen_nomb'];?></td>
			<td class="roworder" style="cursor: move;"><?=$alum_cuen_nume?></td>
			<td>
				<div class="btn-group btn-group-sm" role="group">
                    <a class="btn btn-default" data-toggle="modal" onmouseover="$(this).tooltip('show')" title="Editar Método de Pago" data-target="#modal_metodo_pago" onclick="load_modal_cuentas('modal_body_metodo_pago','alumnos_add_cuentas_modal.php','alum_cuen_codi=<?=$row_alum_cuentas_view['alum_cuen_codi']?>&alum_codi=<?=$alum_codi?>');"  >
                        <span class="fa fa-pencil btn_opc_lista_editar"></span>
                    </a>
                    <a id="btn_cuenta_del" class="btn btn-danger" onmouseover="$(this).tooltip('show')" title="Eliminar Método de Pago" href="javascript:cuentas_del('script_cuentas.php','opc=alum_cuen_del&alum_cuen_codi=<?=$row_alum_cuentas_view['alum_cuen_codi'];?>&alum_codi=<?=$row_alum_cuentas_view['alum_codi'];?>&alum_cuen_banc_tarj=<?=$row_alum_cuentas_view['banc_tarj'];?>','<?=$alum_codi?>');" >
                        <span class="fa fa-trash "></span>
                    </a> 
                </div>
			</td>
		</tr>
		<?}?>
		</tbody>
	</table>
</div>
