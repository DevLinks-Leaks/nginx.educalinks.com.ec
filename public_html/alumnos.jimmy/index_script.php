<?php
	session_start(); 
	include ('../framework/dbconf.php');
?>

<div class="zones alumnos">
    <div class="zone" >        
        <?php
        $params_mate = array($_SESSION['alum_codi'],$_SESSION['curs_para_codi']);
        $sql_mate="{call alum_curs_peri_mate_view(?,?)}";
        $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
        while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
			if ($row_curs_mate_view['curs_para_mate_agen']==1) 
			{?>
                        

        <div class="accordion" id="mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
            
            <div class="accordion-group">
            <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
                    
                        <div class="title">  
                           <span class="icons icon-arrow-down"></span>
                           <?= mb_strtoupper($row_curs_mate_view["mate_deta"]); ?>
                         </div>

                        <div class="opciones">


                          <span class="icons icon-calendar"></span>
                          Agendas: 
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
            </div>

            <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-body collapse in">
                <div  id="mate-inner_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-inner">
                            

                <div class="container"> 
                    <!-- PROFESOR -->
                    <table class="table_striped ">
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
                                        <td  class="no-padding">
                                          

                                        <div class="teacher">
                                            <div class="image">
                                                <img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;width:55px; height:55px;"/>
                                            </div>
                                            <div class="information">
                                                <div class="name">
                                                <?= $row_curs_mate_view["prof_nomb"]; ?>
                                                </div>
                                                <div class="email">
                                                <?= $row_curs_mate_view["prof_mail"]; ?>
                                             </div>
                                        </div>
                                     

                                        
                                      </td>
                                    </tr>
                                  </tbody>
                    </table>
                </div>

                <div class="container"> 
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



                </div>
            </div>
            </div>

        </div>
    <?php } 
	} ?>
    </div>


    










<div class="zone-last">
        

<div class="container">
        <table class="table_striped">
        <?php 
            $params_compa = array($_SESSION['curs_para_codi']);
            $sql_compa="{call curs_para_alums_view(?)}";
            $stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
            $colum=6;
            ?>
                          <thead>

                            <tr>
                              <th colspan="<?= $colum?>">
                                <span class="icons icon-users"></span>COMPAÑEROS DE CURSO:
                              </th>
                            </tr>
            </thead>
            <tbody>

                <tr>
                    <td>
                        <?php $cont=0; while($row_compas_view = sqlsrv_fetch_array($stmp_compa)){?>
                        
                        <?php
                        $cont++;
                        $ruta=$_SESSION['ruta_foto_alumno'];
                        $full_name = $ruta . $row_compas_view['alum_codi'].".jpg";
                        $file_exi=$full_name;
                        if (file_exists($file_exi)){
                            $pp=$file_exi;
                        } else {
                            $pp=$_SESSION['foto_default'];
                        }
                        ?>
                        <div id="div_foto_<?=$row_compas_view['alum_codi']?>" style="padding-left:5px;width:55px; height:55px;float:left">
                            <img src="<?php echo $pp;?>" title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb']?>"  border="0" style="border-color:#F0F0F0;"/>
                        </div> 
                        <?php if($cont==$colum){echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;}?>
                            
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
        </table>
</div>
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
<td>
  <form action="" enctype="multipart/form-data" method="post" id="frm_post" name="frm_post">
    <div >
        <textarea id="text_post" name="text_post" rows="3" placeholder="asdfasdf" ></textarea>
        <script>
            CKEDITOR.replace('text_post', {
             removePlugins:'elementspath,resize,toolbar',
             height:'100px',
         });
        </script>
        <input type="hidden" id="text_post_hd" name="text_post_hd" value="" />
        <input type="hidden" id="curs_para_mate_codi_hd" name="curs_para_mate_codi_hd" value="0" />
    </div>
    <div style="float:none; text-align:right; padding-top:10px;">
        <button type="button" class="btn btn-primary" onclick="post_add('posts_div','script_post.php');"><span class="icons icon-checkmark"></span>  Enviar Comentario</button>
    </div>
</form>
</td>
</tr>

<tr>
<td class="no-padding">

<div class="post_list" id="posts_div">                           
    <?php
    $params_post = array($_SESSION['curs_para_codi']);
    $sql_post="{call wall_curs_para_view(?)}";
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

          <a class="btn btn-info" href="posts_main.php">
            <span class="icons icon-add"></span>Ver Todos
          </a>
        </div>

      </td>
    </tr>
  </tbody>
    
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