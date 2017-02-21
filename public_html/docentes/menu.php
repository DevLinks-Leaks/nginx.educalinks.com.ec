<div class="section_side" id="sidePanel">
            
       <section class="main">
        
            <div class="ingenium">
              <img src="../theme/images/logo_ingenium.png">
            </div>

            <div class="contenedor">
                <div class="logo"> 
                  <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" alt="">
                </div>
                <h5>Unidad Educativa</h5>
                <h4><?php echo para_sist(3); ?></h4>
            </div> 
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
                <a href="agenda.php"  <?  if ($Menu==2) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las agendas">
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
            <?
            if ($_SESSION['es_tutor'])
			{
            ?>
             <li>
                <a href="tutor.php"  <?  if ($Menu==7) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                    <span class="icon-briefcase icon"></span>
                    <div class="text"><h4>Tutor</h4></div>
                </a>
            </li>
            <?
			}
			?>
            <li>
                <a href="hora_aten_repr_listas_main.php"  <?  if ($Menu==5) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                    <span class="icon-clock icon"></span>
                    <?php
                        $params = array($_SESSION['prof_codi']);
                        $sql="{call citas_prof_cont(?)}";
                        $citas_prof_info = sqlsrv_query($conn, $sql, $params);  
                        $row_citas_prof_info = sqlsrv_fetch_array($citas_prof_info);
                    ?>
                    <div class="text"><h4>Citas ( <?=$row_citas_prof_info['cant'];?> )</h4></div>
                </a>
            </li>
            
            <li>
                <a href="observaciones.php"  <?  if ($Menu==6) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                    <span class="icon-eye icon"></span>
                    <div class="text"><h4>Observaciones</h4></div>
                </a>
            </li>
        
            <li>
            <a href="mensajes.php" class='section_califications link_menu <? if ($Menu==700) echo 'active'; ?>' >
              <span class="icon-envelope  icon"></span>
              <div class="text"><h4>Mensajes</h4></div>  
            </a>
          </li> 
            <li>
                <a href="../help/MANUAL_DOCENTE.pdf" target="_blank" class="section_califications link_menu" alt="Ver Calificaciones">
                    <span class="icon-signup  icon"></span>
                    <div class="text"><h4>Ayuda</h4></div> 
                </a>
            </li>
          
        </ul>

</div> 