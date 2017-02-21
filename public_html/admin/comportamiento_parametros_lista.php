
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	
?> 
<table width="100%"   class="table_striped">
 <thead>
  <tr>
    <th width="75%"><strong>Listado de parámetros</strong></th>
    <th><strong>Opciones</strong></th>
  </tr>
  </thead>


  <tbody>
  <tr >
    <td height="29">VALORES</td>
    <td width="60%">
    
			<div class="menu_options" style="text-align:left;">
			  <ul>
			<?php if (permiso_activo(73)){?>
			    <li>
				    <a class="option" href="valores_main.php">
				    <span class="icon-users icon"></span> Ir
				    </a>
			    </li>
                 <?php }?>
                </ul>
             </div>
    </td>
    </tr>
    
    <tr>
    <td height="29">INDICADORES</td>
    <td width="60%">
    
			<div class="menu_options" style="text-align:left;">
			  <ul>
			<?php if (permiso_activo(74)){?>
			    <li>
				    <a class="option" href="indicadores_main.php">
				    <span class="icon-users icon"></span> Ir
				    </a>
			    </li>
                 <?php }?>
                </ul>
             </div>
    </td>
    </tr>
    
    <tr>
    <td height="29">EVALUACION PARCIAL</td>
    <td width="60%">
    
			<div class="menu_options" style="text-align:left;">
			  <ul>
			<?php if (permiso_activo(75)){?>
			    <li>
				    <a class="option" href="evaluacion_comportamiento_main.php">
				    <span class="icon-users icon"></span> Ir
				    </a>
			    </li>
                 <?php }?>
                </ul>
             </div>
    </td>
    </tr>

</tbody>
</table>

 
      
