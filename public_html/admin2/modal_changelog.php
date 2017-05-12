<?php

$params = array($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO_CODI'],'C');
$sql="{call visi_usua_view(?,?,?)}";
$visi_usua_view = sqlsrv_query($conn, $sql, $params); 

$array_chan = array();

while($array_chan[] = sqlsrv_fetch_array($visi_usua_view)['chan_codi']);
// var_dump($array_chan);
require_once ('../framework/dbconf_main.php');

$modulo = 'ACAD';
$params = array($modulo);
$sql="{call changelog_view(?)}";
$changelog_view = sqlsrv_query($conn, $sql, $params);  
$chan_flag = 0;
// 
?> 
<!-- Modal CHANGELOG -->
<div class="modal fade" id="modal_changelog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Cambios en Educalinks</h4>
        </div>
        <div class="modal-body">
            <div class="carousel" style="padding: 10px;">
                <?php while($row_changelog_view = sqlsrv_fetch_array($changelog_view)){
                    setlocale(LC_ALL, "esp");
                    $fecha_hoy=strftime("%B %d ,%Y", strtotime($row_changelog_view['chan_fech_regi']));
                    // var_dump(in_array($row_changelog_view['chan_codi'],$array_chan));
                    if(!in_array($row_changelog_view['chan_codi'],$array_chan)){
                        $chan_flag ++;
                ?>
                    <div id="<?=$row_changelog_view['chan_codi']?>" class="changelog_div" >
                        <table style="width:100%;">
                            <?php if($row_changelog_view['chan_img']!=null){ ?>
                            <tr>
                                <td><img class="img-responsive" style="" src="../imagenes/changelog/<?=$row_changelog_view['chan_img']?>" /></td>
                            </tr>
                            <?}?>
                            <tr>
                                <td><b><h3 style="text-align: center; padding-bottom: 0px;"><?=$row_changelog_view['chan_titu']?></h3></b></td>
                            </tr>
                            <tr>
                                <td>
                                    <b><i>Cambios en Educalinks- <span style="text-transform: capitalize;"> <?=$fecha_hoy?></span></i></b>
                                </td>
                            </tr>
                            <tr>
                                <td><p><?=$row_changelog_view['chan_desc']?></p></td>
                            </tr>
                        </table>
                    </div>
                <? } }  ?>
            </div>
        </div>

        <div class="modal-footer">
            <label style="padding-right: 5%;" for="chk_mostrar">
            <input type="checkbox" id="chk_mostrar" name="chk_mostrar" /> <strong>No, volver a mostrar esto</strong>
            </label>
            <button id="btn_aceptar" type="button" class="btn btn-success" onclick="cerrar_changelog();">Entendido!</button>
        </div>
    </div>
</div>
</div>

<?php if($chan_flag>0){?>
<script>
    $(document).ready(function(){
        $('#modal_changelog').modal('show');

        $('#modal_changelog').on('shown.bs.modal',function(){
            $('.carousel').slick({
                dots: true,
                fade: true,
                speed: 500,
                autoplay: true,
                adaptiveHeight: true,
                prevArrow:'<span style="left: -15px;width: 20px;height: 18px;transform: translate(0, -50%);cursor: pointer;position: absolute;top: 50%;" class="fa fa-chevron-left fa-2x"></span>',
                nextArrow:'<span style="right: -15px;width: 20px;height: 18px;transform: translate(0, -50%);cursor: pointer;position: absolute;top: 50%;" class="fa fa-chevron-right fa-2x"></span>'
            });

        });
    });
</script>
<?}?>