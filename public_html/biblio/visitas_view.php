 
<?php


    include("clases/PHP/Lib_Visitas.php");
    
	
	
	
	if(isset($_POST['visi_fech_ini'])){$visi_fech_ini=$_POST['visi_fech_ini'];$visi_fech_ini=substr($_POST['visi_fech_ini'], 6,4).substr($_POST['visi_fech_ini'], 3,2).substr($_POST['visi_fech_ini'], 0,2);}else{$visi_fech_ini="";}
	if(isset($_POST['visi_fech_fin'])){$visi_fech_fin=$_POST['visi_fech_fin'];$visi_fech_fin=substr($_POST['visi_fech_fin'], 6,4).substr($_POST['visi_fech_fin'], 3,2).substr($_POST['visi_fech_fin'], 0,2);}else{$visi_fech_fin="";}
	
	if(isset($_POST['usua_codi'])){	$usua_codi=$_POST['usua_codi'];}	else{$usua_codi="";}
	if(isset($_POST['usua_tipo_codi'])){	$usua_tipo_codi=$_POST['usua_tipo_codi'];}	else{$usua_tipo_codi="";}
	
	
		
	
    $Visitas = new Visitas();
    $Visitas->visi_view_busq($visi_fech_ini,$visi_fech_fin,$usua_codi,$usua_tipo_codi);   
	
	 
    $i=0;
	 
?>
  
 
<table class="table table-striped table-hover table-responsive" id="table_cons_Visitas" data-page-length='20'>
  <thead>
      <tr>                       
          <th width="15%">Fecha</th>
          <th >Usuario</th>
          <th >Nombre</th>
        
          <th >Tipo Vis.</th>
          <th >Observacion</th>
      </tr>
  </thead>
  <tbody>
      <?php
   
      foreach($Visitas->rows as $Visita){$i++;?>
      <tr class="cursor_link" onClick="">
          
          <td><?= date_format($Visita['visi_fech'], 'd/M/Y' ); ?></td>
          <td><?= $Visita['usua_codi'];?></td>
          <td><?= $Visita['usua_nomb'];?> (<?= $Visita['usua_tipo_deta'];?>)</td>
         
          <td><?= $Visita['visi_tipo_deta'];?></td>
          <td><?= $Visita['visi_obse'];?></td>
      </tr>
      <?php }?>
  </tbody>
</table>
 