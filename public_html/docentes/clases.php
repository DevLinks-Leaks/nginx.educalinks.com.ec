<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
        <!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=3; ?>
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
      <?php include ('menu.php');?>
			
			<div  id="mainPanel"  class="section_main">
            
				<?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title"><h3> <span class="icon-books icon"></span>Clases</h3></div> 
               
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->

<div class="docentes_clases">                        
    <table class="table_striped">
        <thead>
            <tr>
                <td>
                	<div class="title">
                    	<h4>MATERIAS:</h4>
					</div>
                </td>
            </tr>
        </thead>
    <tbody>
    <tr style="display:none;">
    	<td></td>
	</tr>
    <tr>
    <td>
    <?php
    $params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
    $sql_mate="{call prof_curs_para_mate_view(?,?)}";
    $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
    while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
		if ($row_curs_mate_view['curs_para_mate_agen']==1) 
			{?>
        <div class="accordion" id="mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
                <div style=" width:70%;float:left;" ><?= $row_curs_mate_view["mate_deta"]." / ".$row_curs_mate_view["curs_deta"]." ".$row_curs_mate_view["para_deta"]; ?></div>
                <div style=" text-align:right; margin-right: 10%;">
                    <span class="icons icon-book"></span>Agendas: 
                    <?php 
                    $tipo_usua="A";
                    $params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
                    $sql_agen="{call agen_curs_para_mate_view_cont(?,?)}";
                    $stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
                    while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
                        <?=$row_agen_curs_view['cont_agen']?>
                    <?php } ?>
                </div>
              </a>
              <a
              	class="link_extra"
                href="cursos_paralelos_materias_profesor_lista.php?curs_para_mate_prof_codi=<?= $row_curs_mate_view['curs_para_mate_prof_codi']?>">
                <span class="icons icon-list"></span>
                Listado
              </a>
            </div>
            <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-body collapse in">
              <div  id="mate-inner_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-inner">
                
    <div>
    <a class="btn btn-success btn-lg btn-block" href="clases_main.php?curs_para_mate_prof_codi=<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>&curs_para_mate_codi=<?= $row_curs_mate_view['curs_para_mate_codi'];?>&curs_para_codi=<?= $row_curs_mate_view['curs_para_codi'];?>" style="color:#FFF;">
    <span class="icons icon-search"></span> Ver Detalles del Curso
    </a>
    </div>
    <div class="zone">
     <table class="table_striped">
        <?php 
        $ruta=$_SESSION['ruta_foto_docente'];
        $full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
        $file_exi=$full_name;
        if (file_exists($file_exi)){
            $pp=$file_exi;
        } else {
            $pp=$_SESSION['foto_default'];
        }?>
     <thead>
      <tr>
        <th>
          <span class="icons icon-parent"></span>Profesor
        </th>
      </tr>
	</thead>
        <tbody>
          <tr>
            <td class="no-padding">
            <div class="teacher">
                <div class="image">
                <img 
                    src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  
                    border="0" 
                    style="border-color:#F0F0F0;width:55px; height:55px;"/>
                                
                </div>
                <div class="information">
                    <div class="name">
                        <?= $row_curs_mate_view["prof_nomb"]; ?>
                    </div>
                	<div class="email">
                    	<?= $row_curs_mate_view["prof_mail"]; ?>
                	</div>
            	</div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
<!-- AGENDA -->
<table class="table_striped ">
    <thead>
      <tr>
        <th>
          <span class="icons icon-list"></span>AGENDA
        </th>
      </tr>
    </thead>
<tbody>
  <tr>
    <td class="no-padding">
        <div class="agenda_list">
		<?php 
        $tipo_usua="A";
        $params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
        $sql_agen="{call agen_curs_para_mate_view(?,?)}";
        $stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
        while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
            <div class="agenda">
                <div style="width:70%;float:left;"><?=$row_agen_curs_view['agen_titu']?></div>
                <div style="width:30%;float:right;"><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?></div>
            </div>
        <?php } ?>
        </div>
</td>
  </tr>
</tbody>
</table>
</div>
<div class="zone-last">
<?
if (para_sist(401))
{
?>
<table class="table_striped">
  <thead>
    <tr>
      <th>
        <span class="icons icon-bubbles"></span>COMENTARIOS
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="no-padding">
		<div class="post_list">
<?php
$params_post = array($row_curs_mate_view['curs_para_mate_prof_codi']);
$sql_post="{call wall_curs_para_mate_view(?)}";
$stmp_post = sqlsrv_query($conn, $sql_post, $params_post); 
while($row_wall_curs_view= sqlsrv_fetch_array($stmp_post)){?>
<div class="post">
<div class="image">
<?php
if ($row_wall_curs_view['wall_curs_para_tipo_usua']=='A'){
$ruta=$_SESSION['ruta_foto_alumno'];
}elseif($row_wall_curs_view['wall_curs_para_tipo_usua']=='D'){
$ruta=$_SESSION['ruta_foto_docente'];
}elseif($row_wall_curs_view['wall_curs_para_tipo_usua']=='R'){
$ruta=$_SESSION['ruta_foto_repre'];
}
$full_name=$ruta.$row_wall_curs_view['usua_codi'].".jpg";
$file_exi=$full_name;
if (file_exists($file_exi)){
$pp=$file_exi;
} else {
$pp=$_SESSION['foto_default'];
}

?>
<img src="<?php echo $pp;?>" border="0" />
</div>
            
<div class="information">
<div class="user">
<strong><?=$row_wall_curs_view['wall_curs_para_nombre']?></strong> <span><?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?></span> 
</div>
<div class="text">
<?=$row_wall_curs_view['wall_curs_para_text']?>
</div>
</div>
</div>
<?php }?>
</div>
      </td>
    </tr>
    <tr>
      <td class="footer">
        <div class="details">

          <a class="btn btn-info" href="posts_main.php?curs_para_mate_prof_codi=<?=$row_curs_mate_view['curs_para_mate_prof_codi']?>&curs_para_mate_codi=<?=$row_curs_mate_view['curs_para_mate_codi']?>&curs_para_codi=<?=$row_curs_mate_view['curs_para_codi']?>">
            <span class="icons icon-add"></span>*Ver Todos*
          </a>
        </div>

      </td>
    </tr>
  </tbody>
</table>
<?
}
else
{
?>
	<h3>Los comentarios están desactivados.</h3>
<?
}
?>  
            </div>
           
          </div>
        </div>
      </div>
       

<?php }
}
?>
</td>
</tr>
</tbody>
</table>

</div>
						<!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>