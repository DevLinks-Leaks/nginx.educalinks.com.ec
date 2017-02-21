<?php

	session_start();	 
	include ('../framework/dbconf.php');
	 
	$mens_de = $_SESSION['USUA_DE'];
	$mens_de_tipo = $_SESSION['USUA_TIPO'];
	 
 	$params = array($mens_de,$mens_de_tipo);
	$sql="{call mens_view_para_new(?,?)}";
	
	$mens_view_para_new = sqlsrv_query($conn, $sql, $params); 
	
	$row_mens_view_para_new = sqlsrv_fetch_array($mens_view_para_new);
	$row_count = $row_mens_view_para_new['row_count'];
	
	sqlsrv_next_result($mens_view_para_new);
	
?>
 
<?php if ($row_mens_view_para_new = sqlsrv_fetch_array($mens_view_para_new)) {?>
	<a  id="link_mens" class="button" href="#" data-toggle="dropdown">
		<img src="../theme/images/icons/ico_notifications.png" border="0" title="Mensajes">
		<div  id="mens_counter" class="button_counter"><?= $row_count; ?></div>
	</a>
	<ul class="dropdown-menu" role="menu" aria-labelledby="notificaciones">
    
     <?php  do { $cc +=1; ?> 
		<?php if ($cc  <= 5) {?>
            <li> 
                <a data-toggle="modal" 
                          data-target="#modal_leer_ext" onclick="load_ajax('modal_main_ext','mensajes_info.php','mens_codi=<?= $row_mens_view_para_new['mens_codi'];?>&op=2');mens_alert_upda();" > 
                    <div class="message_container">
                        <div class="icon">
                            <img src="../theme/images/flag.png" alt="icon_message">
                        </div>
                        <div class="message">
                            <h5><?= $row_mens_view_para_new['mens_titu'];?></h5></br>
                            <b>Enviado por: <?=  $row_mens_view_para_new['mens_para_nomb'];?></b>
                        </div>
                    </div> 
                </a>
            </li>
         <?php  }?>
 	<?php  }while ($row_mens_view_para_new = sqlsrv_fetch_array($mens_view_para_new))?>
     
    
<?php  }else{?> 
	<a  id="link_mens" class="button" href="mensajes.php" >
		<img src="../theme/images/icons/ico_notifications.png">
		<div  id="mens_counter" class="button_counter" style="display:none;">0</div>
	</a>
<ul class="dropdown-menu" role="menu" aria-labelledby="notificaciones">
<?php  }?>										  
	<li  class="btn_more_message" ><a href="mensajes.php">Ver mas ..</a></li>
</ul>