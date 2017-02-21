<?php
session_start();
include("../framework/dbconf.php");
include("../framework/funciones.php");
?>
<?php
	if (para_sist(402))
	{
		$params_mate = array($_SESSION['alum_codi'],$_SESSION['curs_para_codi']);
		$sql_mate="{call alum_curs_peri_mate_view(?,?)}";
		$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
		while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
?>

<div class="zones">

<div class="alumnos_citas">

    <div class="accordion" id="mate_h<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>">
      <div class="accordion-group">
        <div class="accordion-heading">

<a class="accordion-toggle" data-toggle="collapse" data-parent="#mate_h<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>">   
    <div class="title">  
        <span class="icons icon-arrow-down"></span>
        <?= $row_curs_mate_view["mate_deta"]; ?>
    </div>
    
</a>


        </div>

        <div id="mate_b_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" class="accordion-body collapse in">
          <div  id="mate-inner_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" class="accordion-inner">
            <!-- Inicio de region de interior del acordeon-->





<div class="zone"> 
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
                    Fecha a Reservar: <input name="fecha_cita_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" id="fecha_cita_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" value="<?= date("d/m/Y");?>" />
                    <script type="text/javascript" charset="utf-8">
                        $("#fecha_cita_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>").datepicker({onSelect: function(date){citas_free_view ('citas_alum_curs_para_mate_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>','citas_main_lista.php','<?=$row_curs_mate_view['prof_codi']?>','','<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>',date);}});
                    </script>
            </div> 
            </div>

            </td>
            </tr>
        </tbody>
        </table>
</div>


                <div class="zone-last"  id="citas_alum_curs_para_mate_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>">
					<?php include("citas_main_lista.php");?>
            	</div>
            </div>
            <!-- Fin de region de interior del acordeon-->
          </div>
        </div>
      </div>
       
    </div>
<?php }
?>
</div>
</div>
<?
}
else
{
?>
	<h3>Las citas están desactivadas.</h3>
<?
}
?> 