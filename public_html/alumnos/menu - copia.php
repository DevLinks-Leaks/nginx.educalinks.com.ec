<div class="section_side" id="sidePanel">
	<section class="main">
		<div class="ingenium">
			<img src="../theme/images/logo_ingenium.png">
		</div>
		<div class="logo"> 
			<img src="<?= $_SESSION['ruta_foto_logo_web'];?>" alt="">
		</div>
		<h5>Unidad Educativa</h5>
		<h4><?php echo para_sist(2); ?></h4>
	</section>
	
	<? session_start();include ('../framework/dbconf.php');?>
	<ul class="menu_main">
		<li>
			<a href="index.php"  <? if ($Menu==0) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="active"  alt="Ir al inicio"> 
				<span class="icon-home icon"></span>
				<div class="text"><h4>Inicio</h4></div>
			</a>
		</li>
		
		<li>
			<a href="agen_main.php"  <?  if ($Menu==2) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las agendas">
				<span class="icon-calendar icon"></span>
				<div class="text"><h4>Agenda</h4></div>
			</a>
		</li>
		
		<li>
			<a href="clases.php"  <?  if ($Menu==3) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las clases">
				<span class="icon-book icon"></span>
				<div class="text"><h4>Clases</h4></div>
			</a>
		</li>

		<li>
			<a href="notas.php"  <?  if ($Menu==4) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
				<span class="icon-briefcase icon"></span>
				<div class="text"><h4>Notas</h4></div>
			</a>
		</li>
		<?php
			require_once ('../framework/dbconf_main.php');
			$params = array($_SESSION['codi'],6); //Opción Módulo Médico
			$sql="{call clie_opci_cons(?,?)}";
			$result = sqlsrv_query($conn, $sql, $params);  
			$row = sqlsrv_fetch_array($result);
			if($row['opci_valo']=='A'){

		?>
		<li>
			<a href="visitas_medicas.php"  <?  if ($Menu==7) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las visitas médicas">
				<span class="icon icon-briefcase"></span>
				<div class="text"><h4>Visitas Médicas</h4></div>
			</a>
		</li>
		<?php
			}
		?>
		<?php 
			include ('../framework/dbconf.php');
			if($_SESSION['USUA_TIPO']=='R'){
				if (para_sist(402))
				{?>
		<li>
			
			<a href="citas.php"  <?  if ($Menu==5) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las citas">
				<span class="icon-clock icon"></span>
				<div class="text"><h4>Citas</h4></div>
			</a>
		</li>
		<?php 
				}
			}?>
		<?php if($_SESSION['USUA_TIPO']=='R'){?>
		<li>
			<a href="observaciones_main.php"  <?  if ($Menu==6) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las observaciones">
				<span class="icon-eye icon"></span>
				<div class="text"><h4>Observaciones</h4></div>
			</a>
		</li>
		<li>
			<a href="#" onclick="js_menu_pagos();"
				<?  if ($Menu==8) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las pagos">
				<span class="icon-envelope icon"></span>
				<div class="text"><h4>Pagos</h4></div>
			</a>
		</li>
		<?php }?>
		<li>
            <a href="mensajes.php" class='section_califications link_menu <? if ($Menu==700) echo 'active'; ?>' >
              <span class="icon-envelope  icon"></span>
              <div class="text"><h4>Mensajes</h4></div>  
            </a>
        </li> 
		<li>
			<a href="../help/MANUAL_REPR.pdf" class="section_califications link_menu" alt="Ver la Ayuda">
				<span class="icon-signup  icon"></span>
				<div class="text"><h4>Ayuda</h4></div> 
			</a>
		</li>
	  
	</ul>
</div>