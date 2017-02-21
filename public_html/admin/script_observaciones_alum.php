<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}

switch($opc){
	case 'obs_add':
		if(isset($_POST['alum_curs_para_codi'])){$alum_curs_para_codi=$_POST['alum_curs_para_codi'];}else{$alum_curs_para_codi="";}
		if(isset($_POST['tipo_obs'])){$tipo_obs=$_POST['tipo_obs'];}else{$tipo_obs="";}
		if(isset($_POST['obs_deta'])){$obs_deta=$_POST['obs_deta'];}else{$obs_deta="";}
		$usua_codi=$_SESSION['usua_codi'];
		
		$params_opc=array($alum_curs_para_codi,'K',$usua_codi,$tipo_obs,$obs_deta);
		$sql_opc="{call observacion_add(?,?,?,?,?)}";
		$stmp_opc = sqlsrv_query($conn, $sql_opc,$params_opc); 
		
		if( $stmp_opc === false){
            // echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));
            $result= json_encode(array ('state'=>'error',
                        'result'=>'Error al agregar la observación.',
                        'console'=> sqlsrv_errors() ));
        }else{
    		$veri=lastId($stmp_opc);
    		if ($veri>0)
    		{
                $result = json_encode(array ('state'=>'success',
                            'result'=>'Observación agregada con éxito.'));
    			//Para auditoría
                $detalle="Curso paralelo materia código: ".$curs_para_mate_codi;
                $detalle.=" Alumno curso paralelo código: ".$alum_curs_para_codi;
                $detalle.=" Tipo observación: ".$tipo_obs;
                $detalle.=" Observación detalle: ".$obs_deta;
                registrar_auditoria (41, $detalle);

                $params_opc2=array($alum_curs_para_codi);
                $sql_opc2="{call obs_alum_repr_info(?)}";
                $stmp_opc2 = sqlsrv_query($conn, $sql_opc2,$params_opc2); 
                if( $stmp_opc2 === false){
                    // echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));
                    $result= json_encode(array ('state'=>'warning',
                            'result'=>'<b>Error al enviar mail de notificación.</b>',
                            'console'=> sqlsrv_errors() ));
                    echo $result;
                    exit(1);
                }
                $row_obs_view2=sqlsrv_fetch_array($stmp_opc2);
                
                if($row_obs_view2['repr_mail']==''){
                    $result =json_encode(array ('state'=>'warning',
                            'result'=>'Error al enviar mail de notificación. <b>Representante no tiene mail registrado.</b>'));
                    echo $result;
                    exit(1);
                }


                require_once('../framework/includes/class.phpmailer.php');
                $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
                $mail->isSMTP(); // telling the class to use SMTP transport
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = para_sist(303);            // SMTP username
                $mail->Password = para_sist(304);                         // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;

                $params_opc2=array($usua_codi);
                $sql_opc2="{call usua_info(?)}";
                $usua_info = sqlsrv_query($conn, $sql_opc2,$params_opc2);
                $row_usua_info=sqlsrv_fetch_array($usua_info);

                try {
                        $mail->AddReplyTo(para_sist(303), 'Educalinks'); 
                        $nombre_parti="";
                        $nombre_parti=$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_apel'];
                        $mail->AddAddress($row_obs_view2['repr_mail'], $nombre_parti);
                        $mail->SetFrom(para_sist(303), 'Educalinks');
                        //$mail->AddReplyTo('sistemas@redlinks.com.ec', 'Sistemas Redlinks');
                        $mail->Subject = 'Observación creada desde Educalinks ';
                        $mail->AltBody = 'Para ver este correo, por favor use un visualizador de email compatible con HTML.'; 
                        $body="<html><head><meta charset='UTF-8'><title></title></head><body>";
                        $body .="<p>Estimado $nombre_parti,</p>";
                        $body .="<p>Se ha creado una observaci&oacute;n a su representado <b>".$row_obs_view2['alum_nomb']." ".$row_obs_view2['alum_apel']."</b> desde Educalinks por parte del usuario administrativo <b> ".$row_usua_info['usua_nomb']." ".$row_usua_info['usua_apel']."</b></p>";
                        $body .="<p>Observaci&oacute;n ingresada:</p>";
                        $body .="<p style='color: #000011 ;font-style: italic;'>".$obs_deta."</p>";
                        $body.="<p>Para mayor informaci&oacute;n ingrese con su usuario y contrase&ntilde;a al sistema Educalinks</p></body></html>";
                        $mail->MsgHTML($body); // optional - MsgHTML will create an alternate automatically
                        //$mail->AddAttachment('images/phpmailer.gif');      // attachment
                        //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->CharSet = 'UTF-8';
                        $mail->Send(); 

                } catch (phpmailerException $e) {
                        //echo $e->errorMessage(); //Pretty error messages from PHPMailer
                    $result = json_encode(array ('state'=>'warning',
                            'result'=>'Error al enviar mail de notificación. <b>Verificar el formato de mail del Representante.</b>'));
                    
                    //exit(1);
                }
                
    		}
    		else
    		{
    			$result = json_encode(array ('state'=>'error',
                            'result'=>'Error al agregar la observación.'));
    		}
        }
        echo $result;
	break;
	case 'obs_view':
		if(isset($_POST['alum_curs_para_codi'])){$alum_curs_para_codi=$_POST['alum_curs_para_codi'];}else{$alum_curs_para_codi="";}
		$params_opc=array($alum_curs_para_codi);
		$sql_opc="{call observacion_alum_info(?)}";
		$stmp_opc = sqlsrv_query($conn, $sql_opc,$params_opc); 
		if( $stmp_opc === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}?>
		<div>&nbsp;</div>
        <table class="table_striped">
            <thead>
                <tr>
                	<th width="15%">Tipo de Observaci&oacute;n</th>
					<th width="40%">Observaci&oacute;n</th>
					<th width="15%">Ingresado por</th>
					<th width="15%">Rol</th>
					<th width="15%">Fecha de Ingreso</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row_obs_view=sqlsrv_fetch_array($stmp_opc)){?>
            	<tr>
                	<td><?=$row_obs_view['obse_tipo_deta'];?></td>
					<td><?=$row_obs_view['obse_deta'];?></td>
					<td><?=$row_obs_view['usua_deta'];?></td>
					<td><?=$row_obs_view['usua_tipo'];?></td>
					<td><?=date_format($row_obs_view['obse_fech'],"d/m/Y");?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>	
        <div>&nbsp;</div>
		<?php 
	break;
	
}
?>