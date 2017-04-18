<?php
if(isset($_POST['DO'])){
		if ($_POST['DO']=='ADD'){
			
				session_start();
				include ('../framework/dbconf.php');  
				include ('../framework/funciones.php');
				
				$mens_de = $_POST['mens_de'];
				$mens_de_tipo = $_POST['mens_de_tipo'];
				//$mens_para = $_POST['mens_para'];
				//$mens_para_tipo = $_POST['mens_para_tipo'];
				$mens_dest = $_POST['mens_dest'];
				$mens_titu = reemplazarTilde($_POST['mens_titu']);
				$mens_deta = str_replace("**","&",$_POST['mens_deta']);
			 	$mens_dest_array = json_decode($mens_dest);
			 	
			 	//echo print_r($mens_dest_array[0]->mens_para);
			 	
				$xml = new DOMDocument("1.0","UTF-8");
				//Curso
				$mens_cab = $xml->createElement("mens_cab");
				$mens_cab->setAttribute("mens_de",$mens_de);
				$mens_cab->setAttribute("mens_de_tipo",$mens_de_tipo);
				$mens_cab->setAttribute("mens_titu",$mens_titu);

				foreach($mens_dest_array as $dest){
			        $mens_dest = $xml->createElement("mens_dest");
			        $mens_para_tipo = $dest->mens_para_tipo;
			        if($mens_para_tipo=='R'){
			        	$mens_dest->setAttribute("mens_para",$dest->mens_para);
						$mens_dest->setAttribute("mens_para_tipo",$dest->mens_para_tipo);
						$mens_dest->setAttribute("mens_alum_codi",$dest->mens_alum_codi);
			        }else if ($mens_de_tipo=='R'){
			        	$mens_dest->setAttribute("mens_para",$dest->mens_para);
						$mens_dest->setAttribute("mens_para_tipo",$dest->mens_para_tipo);
						$mens_dest->setAttribute("mens_alum_codi",$_SESSION['alum_codi']);
			        }else{
						$mens_dest->setAttribute("mens_para",$dest->mens_para);
						$mens_dest->setAttribute("mens_para_tipo",$dest->mens_para_tipo);
					}
					$mens_cab->appendChild($mens_dest);
					$info_auditoria_receptor .= $dest->mens_para.'('.$dest->mens_para_tipo.') ';
				}
				$xml->appendChild($mens_cab);
				$result=array();
				try
				{	$params = array($xml->saveXML(),$mens_deta);
					$sql	= "{call mens_xml_add (?,?)}";
					$stmt 	= sqlsrv_query($conn,$sql,$params);

					if ($stmt === false)
					{	$result = array ("tipo"=>"error",
						 				"mensaje"=>'Los mensajes no pudieron ser enviados.');
						echo json_encode($result);
						die( print_r( sqlsrv_errors(), true));
					}
					foreach($mens_dest_array as $dest2){
				        
						if($dest2->mens_para_tipo=='R'){
							$params_opc2=array($dest2->mens_para);
				            $sql_opc2="{call repr_info(?)}";
				            $stmp_opc2 = sqlsrv_query($conn, $sql_opc2,$params_opc2); 
				            if( $stmp_opc2 === false){echo "Error in executing statement \n";die( print_r( sqlsrv_errors(), true));}
				            $row_obs_view2=sqlsrv_fetch_array($stmp_opc2);
				            if($row_obs_view2['repr_email']==''){
				                $warning = array ("tipo"=>"warning",
								 				"repr"=>$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_apel']);
				                $result[]=$warning;
				                //exit(1);
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
				            try {
				                    $mail->AddReplyTo(para_sist(303), 'Educalinks'); 
				                    $nombre_parti="";
				                    $nombre_parti=$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_apel'];
				                    $mail->AddAddress($row_obs_view2['repr_email'], $nombre_parti);
				                    $mail->SetFrom(para_sist(303), 'Educalinks');
				                    //$mail->AddReplyTo('sistemas@redlinks.com.ec', 'Sistemas Redlinks');
				                    $mail->Subject = 'Mensaje recibido desde Educalinks ';
				                    $mail->AltBody = 'Para ver este correo, por favor use un visualizador de email compatible con HTML.'; 
				                    $body="<html><head><meta charset='UTF-8'><title></title></head><body>";
				                    $body .="<p>Estimado $nombre_parti,</p>";
				                    $body .="<p>Se ha recibido un mensaje del docente <b>".$_SESSION['prof_nomb']." ".$_SESSION['prof_apel']."</b> desde Educalinks</p>";
				                    $body .="<p>Mensaje recibido:</p>";
				                    $body .="<p style='color: #000011 ;font-style: italic;'>".$mens_deta."</p>";
				                    $body.="<p>Para mayor informaci&oacute;n ingrese con su usuario y contrase&ntilde;a al sistema Educalinks</p></body></html>";
				                    $mail->MsgHTML($body); // optional - MsgHTML will create an alternate automatically
				                    //$mail->AddAttachment('images/phpmailer.gif');      // attachment
				                    //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
				                    $mail->isHTML(true); // Set email format to HTML
				                    $mail->CharSet = 'UTF-8';
				                    $mail->Send(); 

				            } catch (phpmailerException $e) {
				                    //echo $e->errorMessage(); //Pretty error messages from PHPMailer
				                $warning = array ("tipo"=>"warning",
								 				"repr"=>$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_apel']);
				                $result[]=$warning;
				                //exit(1);
				            }
			        	}
			            
					}

					
				}catch (Exception $e)
				{	$result = array ("tipo"=>"error",
									 "mensaje"=>$e->getMessage());
					echo json_encode($result);
					exit(1);
				}

				$detalle.=" Emisor_código: ".$mens_de;
				$detalle.=" Receptores: ".$info_auditoria_receptor;
				$detalle.=" Título: ".$mens_titu;
				$detalle.=" Detalle: " . $mens_deta;
				
				/*Auditorias codigo: Admin: 59, D:60, R:61, A:62	*/
				if($mens_de_tipo=='R'){
					registrar_auditoria (61, $detalle);
				}else{
					registrar_auditoria (62, $detalle);
				}
				
				
				$success = array ("tipo"=>"success",
				 				"repr"=>"");
				$result[]=$success;
				echo json_encode($result);
			
		}
		if ($_POST['DO']=='RESP'){
			
				session_start();
				include ('../framework/dbconf.php');  
				include ('../framework/funciones.php');
				
				$mens_de = $_POST['mens_de'];
				$mens_de_tipo = $_POST['mens_de_tipo'];
				$mens_para = $_POST['mens_para'];
				$mens_para_tipo = $_POST['mens_para_tipo'];
				$mens_dest = $_POST['mens_dest'];
				$mens_titu = $_POST['mens_titu'];
				$mens_deta = str_replace("**","&",$_POST['mens_deta']);
				
				if($mens_de_tipo=='R'){
					$mens_alum_codi=$_SESSION['alum_codi'];
					
				}else
					$mens_alum_codi=null;

				$params = array($mens_de,$mens_de_tipo,$mens_para,$mens_para_tipo,$mens_titu,$mens_deta,$mens_alum_codi);
				$sql="{call mens_add(?,?,?,?,?,?,?)}";
				$stmt = sqlsrv_query($conn, $sql, $params); 
				
				if ($stmt === false)
				{	$result = array ("tipo"=>"error",
					 				"mensaje"=>'El mensaje no pudo ser enviado.');
					echo json_encode($result);
					die( print_r( sqlsrv_errors(), true));
				}else{
					if($mens_para_tipo=='R'){
						$params_opc2=array($mens_para);
			            $sql_opc2="{call repr_info(?)}";
			            $stmp_opc2 = sqlsrv_query($conn, $sql_opc2,$params_opc2); 
			            if( $stmp_opc2 === false){echo "Error in executing statement \n";die( print_r( sqlsrv_errors(), true));}
			            $row_obs_view2=sqlsrv_fetch_array($stmp_opc2);
			            if($row_obs_view2['repr_email']==''){
			                $warning = array ("tipo"=>"warning",
							 				"repr"=>$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_apel']);
			                $result[]=$warning;
			                //exit(1);
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
			            try {
			                    $mail->AddReplyTo(para_sist(303), 'Educalinks'); 
			                    $nombre_parti="";
			                    $nombre_parti=$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_apel'];
			                    $mail->AddAddress($row_obs_view2['repr_email'], $nombre_parti);
			                    $mail->SetFrom(para_sist(303), 'Educalinks');
			                    //$mail->AddReplyTo('sistemas@redlinks.com.ec', 'Sistemas Redlinks');
			                    $mail->Subject = 'Mensaje recibido desde Educalinks ';
			                    $mail->AltBody = 'Para ver este correo, por favor use un visualizador de email compatible con HTML.'; 
			                    $body="<html><head><meta charset='UTF-8'><title></title></head><body>";
			                    $body .="<p>Estimado $nombre_parti,</p>";
			                    $body .="<p>Se ha recibido un mensaje desde Educalinks</p>";
			                    $body .="<p>Mensaje recibido:</p>";
			                    $body .="<p style='color: #000011 ;font-style: italic;'>".$mens_deta."</p>";
			                    $body.="<p>Para mayor informaci&oacute;n ingrese con su usuario y contrase&ntilde;a al sistema Educalinks</p></body></html>";
			                    $mail->MsgHTML($body); // optional - MsgHTML will create an alternate automatically
			                    //$mail->AddAttachment('images/phpmailer.gif');      // attachment
			                    //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
			                    $mail->isHTML(true); // Set email format to HTML
			                    $mail->CharSet = 'UTF-8';
			                    $mail->Send(); 

			            } catch (phpmailerException $e) {
			                    //echo $e->errorMessage(); //Pretty error messages from PHPMailer
			                $warning = array ("tipo"=>"warning",
							 				"repr"=>$row_obs_view2['repr_nomb']." ".$row_obs_view2['repr_email']);
			                $result[]=$warning;
			                //exit(1);
			            }
			        }
				}
				

				$detalle.=" Emisor_código: ".$mens_de;
				$detalle.=" Emisor_tipo: ".$mens_de_tipo;
				$detalle.=" Receptor_código: ".$mens_para;
				$detalle.=" Receptor_tipo: ".$mens_para_tipo;
				$detalle.=" Título: ".$mens_titu;
				$detalle.=" Detalle: " . $mens_deta;
				
				/*Auditorias codigo: Admin: 59, D:60, R:61, A:62	*/
				if($mens_de_tipo=='R'){
					registrar_auditoria (61, $detalle);
				}else{
					registrar_auditoria (62, $detalle);
				}
				
				$success = array ("tipo"=>"success",
				 				"mensaje"=>"Mensaje enviado con éxito");
				$result[]=$success;
				echo json_encode($result);
			
		}
		if ($_POST['DO']=='DEL'){
			
				session_start();
				include ('../framework/dbconf.php');  
			
			
			
				$mens_codi = $_POST['mens_codi'];
			 	$op = $_POST['op'];
			 	
			 	if($op==1 or $op==2){
			 		$mens_who='P';
			 	}else if($op==3){
			 		$mens_who='D';
			 	}
			 
				$params = array($mens_codi,$mens_who);
				$sql="{call mens_del(?,?)}";
				sqlsrv_query($conn, $sql, $params);  
			
		}
	}
?>