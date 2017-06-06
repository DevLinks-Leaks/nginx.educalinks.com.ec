<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'alum_cuen_add':
		$alum_cuen_nume = $_POST['alum_cuen_nume'];
		if($alum_cuen_nume==''){
			$alum_cuen_nume_encrypt='';
		
		}else{
			/*Codigo de encriptado de Número de tarjeta de crédito*/
			$iv = base64_decode($_SESSION['clie_iv']);
			$alum_cuen_nume_encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_cuen_nume, MCRYPT_MODE_CBC, $iv);
			$alum_cuen_nume_encrypt =base64_encode($alum_cuen_nume_encrypt);
			/*FIN*/
		}
		$alum_codi = ($_POST['alum_codi']==0 ? null : $_POST['alum_codi']);
		$alum_cuen_fech_venc = ($_POST['alum_cuen_fech_venc']=='' ? null : substr($_POST['alum_cuen_fech_venc'],6,4)."".substr($_POST['alum_cuen_fech_venc'],3,2)."".substr($_POST['alum_cuen_fech_venc'],0,2) );
		$sql_opc = "{call alum_cuentas_add(?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array($alum_codi,
							$_POST['alum_cuen_form_pago'],
							$_POST['alum_cuen_banc_tarj'],
							$_POST['alum_cuen_banc_emis'],
							$alum_cuen_fech_venc,
							$alum_cuen_nume_encrypt,
							$_POST['alum_cuen_tipo'],
							$_POST['alum_cuen_nomb'],
							$_POST['alum_cuen_cedu'],
							$_POST['alum_cuen_tipo_iden']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al agregar la cuenta de pago.',
						'console'=> sqlsrv_errors() ));
		}else{
			//Para auditoría
			$detalle="Código alumno: ".$_POST['alum_codi'];
			$detalle.=" Banco/Tarjeta: ".$_POST['alum_cuen_banc_tarj'];
			$detalle.=" alum_cuen_codi: ".$_POST['alum_cuen_codi'];
			// iNFO NUMERO CUENTA
			if(strpos($alum_cuen_nume, 'X') ===true)
				$detalle.=" # Banco/Tarjeta: ".$_POST['alum_cuen_nume'];
			else{ 
				if (is_numeric($_POST['alum_cuen_nume']))
					$detalle.=" # Banco/Tarjeta: ".$alum_cuen_nume_encrypt;
				else
					$detalle.=" # Banco/Tarjeta: ".$_POST['alum_cuen_nume'];
			}
			registrar_auditoria (121, $detalle);
			$result= json_encode(array ('state'=>'success',
					'result'=>'Cuenta de pago agregada con éxito.' ));
		}
		echo $result;
	break;
	case 'alum_cuen_del':
		$alum_cuen_codi=$_POST['alum_cuen_codi'];		
		$sql_opc = "{call alum_cuentas_del(?)}";
		$params_opc= array($alum_cuen_codi);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al eliminar la cuenta de pago.',
						'console'=> sqlsrv_errors() ));
		}else{
			//Para auditoría
			$detalle="Código alumno: ".$_POST['alum_codi'];
			$detalle.=" Banco/Tarjeta: ".$_POST['alum_cuen_banc_tarj'];
			$detalle.=" alum_cuen_codi: ".$_POST['alum_cuen_codi'];
			registrar_auditoria (123, $detalle);
			$result= json_encode(array ('state'=>'success',
					'result'=>'Cuenta de pago eliminada con éxito.' ));
		}
		echo $result;
	break;
	case 'alum_cuen_edit':
		$alum_resp_form_banc_tarj_nume = $_POST['alum_cuen_nume'];
		if($alum_resp_form_banc_tarj_nume==''){
			$alum_cuen_nume_encrypt='';
		
		}else{
			/*Codigo de encriptado de Número de tarjeta de crédito*/
			$iv = base64_decode($_SESSION['clie_iv']);
			$alum_cuen_nume_encrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume, MCRYPT_MODE_CBC, $iv);
			$alum_cuen_nume_encrypt =base64_encode($alum_cuen_nume_encrypt);
			/*FIN*/
		}
		$alum_cuen_fech_venc = ($_POST['alum_cuen_fech_venc']=='' ? null : $_POST['alum_cuen_fech_venc']);
		$sql_opc = "{call alum_cuentas_edit(?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array($_POST['alum_cuen_codi'],
							$_POST['alum_cuen_form_pago'],
							$_POST['alum_cuen_banc_tarj'],
							$_POST['alum_cuen_banc_emis'],
							$_POST['alum_cuen_fech_venc'],
							$alum_cuen_nume_encrypt,
							$_POST['alum_cuen_tipo'],
							$_POST['alum_cuen_nomb'],
							$_POST['alum_cuen_cedu'],
							$_POST['alum_cuen_tipo_iden']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){
			$result= json_encode(array ('state'=>'error',
						'result'=>'Error al actualizar la cuenta de pago.',
						'console'=> sqlsrv_errors() ));
		}else{
			//Para auditoría
			$detalle="Código alumno: ".$_POST['alum_codi'];
			$detalle.=" Banco/Tarjeta: ".$_POST['alum_cuen_banc_tarj'];
			$detalle.=" alum_cuen_codi: ".$_POST['alum_cuen_codi'];
			// iNFO NUMERO CUENTA
			if(strpos($alum_cuen_nume, 'X') ===true)
				$detalle.=" # Banco/Tarjeta: ".$_POST['alum_cuen_nume'];
			else{ 
				if (is_numeric($_POST['alum_cuen_nume']))
					$detalle.=" # Banco/Tarjeta: ".$alum_cuen_nume_encrypt;
				else
					$detalle.=" # Banco/Tarjeta: ".$_POST['alum_cuen_nume'];
			}
			registrar_auditoria (122, $detalle);
			$result= json_encode(array ('state'=>'success',
					'result'=>'Cuenta de pago actualizada con éxito.' ));
		}
		echo $result;
	break;
}
?>