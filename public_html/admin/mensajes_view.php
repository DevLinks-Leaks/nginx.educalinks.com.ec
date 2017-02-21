
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
 	$op=2;
	if(isset($_POST['OP'])) 
		$op=$_POST['OP'];
	
	 
	$mens_usua=$_SESSION['USUA_DE'];
	$mens_usua_tipo=$_SESSION['USUA_TIPO'];

	 
	
	$params = array($op,$mens_usua,$mens_usua_tipo,$rowcount);
	$sql="{call mens_view_op(?,?,?,?)}";
	$mens_view_op = sqlsrv_query($conn, $sql, $params);  
 
	 
	
	$page=0; 		/* Contador pagina */
	$cc_page=0;  	/* Contador division */
	$cc=0;  		/* Contador General */
	$page_div = 10;	/* Numero por pagina */
  
?> 

<div class="lista">
<table id="mensajes_table" class="table_striped">
        <thead>
            <tr>
                <?php switch($op) {
                    case 1: ?>
                        <th width="20%" >Título</th>
                        <th width="25%" class="sort"><span class="icon-sort icon"></span>Enviado por</th>
                        <th width="15%" class="center"></span>Fecha Recibido</th>
                        <th width="7%" >Opciones</th>
                    <?  break;
                    case 2: ?>
                        <th width="20%" >Título</th>
                        <th width="25%" class="sort"><span class="icon-sort icon"></span>Enviado por</th>
                        <th width="15%" class="center"></span>Fecha Recibido</th>
                        <th width="7%" >Opciones</th>
                    <?  break;
                    case 3: ?>
                        <th width="20%" >Título</th>
                        <th width="25%" class="sort"><span class="icon-sort icon"></span>Enviado a</th>
                        <th width="15%" class="center"></span>Fecha Enviado</th>
                        <th width="15%" class="center">Fecha Lectura</th>
                        <th width="7%" >Opciones</th>
                    <?  break;
                    case 4: ?>
                        <th width="20%" >Título</th>
                        <th width="20%" >Detalle</th>
                        <th width="15%" class="center"></span>Enviado a</th>
                        <th width="15%" class="center">Enviado por</th>
                        <th width="5%" >Opciones</th>
                    <?  break;
                } ?>
            </tr>
        </thead>
        <tbody>
    <?php  
    while ($row_mens_view_op = sqlsrv_fetch_array($mens_view_op)) 
    { 
      $cc +=1; 
    ?>
        <tr>
            <td class="titulares">
              <strong>
                <?= $row_mens_view_op["mens_titu"]; ?>
              </strong>
            </td>
            <?php if($op==4){ ?>
              <td align="left">
                <strong>
                  <?= substr($row_mens_view_op["mens_deta"],0,40) ?>...
                </strong>
              </td>
            <?php }else{?> 
              <td align="left">
                <strong>
                  <?= $row_mens_view_op["mens_nomb"]; ?>
                </strong>
              </td>
            <?php } ?>
            <?php if($op==4){ ?>
              <td align="left">
                <strong>
                  <?= $row_mens_view_op["mens_de_nomb"]; ?>
                </strong>
              </td>
              <td align="left">
                <strong>
                  <?= $row_mens_view_op["mens_para_nomb"]; ?>
                </strong>
              </td>

            <?php }else{?>
              <td align="center">
                <strong>
                  <?=  date_format( $row_mens_view_op["mens_fech_envi"], 'd/M/Y  h:m:s' ); ?>
                </strong>
              </td>
              <?php if($op==1 or $op==2){ ?>
              <?php }else{?> 
                <td align="center">
                  <strong>
                    <?=  date_format( $row_mens_view_op["mens_fech_lect"], 'd/M/Y  h:m:s' ); ?>
                  </strong>
                </td>
              <?php } ?> 
              
            <?php } ?>
            
            
            <td align="left" >
                <div class="menu_options" style="text-align:left;">
                  <ul>
                    <li>
                      <a 
                          class="option" 
                          data-toggle="modal" 
                          data-target="#modal_leer_ext"
                          onclick="load_ajax('modal_main_ext','mensajes_info.php','mens_codi=<?= $row_mens_view_op["mens_codi"]; ?>&op=<?= $op?>');mens_alert_upda();">
                            <span class="icon-envelope icon"></span>Leer
                      </a>
                    </li>
                    <li>
                      <?php if($op==1 or $op==2 or $op==3){
                       ?>
                         <a 
                            class="option" 
                            onclick="elimina_mensaje(<?= $row_mens_view_op["mens_codi"]; ?>,<?= $op?>);" >
                            <span class="icon-remove icon"></span>
                              Eliminar
                          </a>
                       <?php }
                       ?>
                        
                    </li>
                  </ul>
                </div>
            </td>
        </tr>
 
 <?php  }?>
  
 </tbody>
<tfoot>
   <tr class="pager_table" >
    <td><span class="icon-users icon"></span>Total de Mensajes 
        <?php if($op==1 or $op==2){ ?>
          Recibidos
        <?php }else if($op==4){?> 
          Eliminados
        <?php }else{?> 
          Enviados
        <?php } ?> 
        ( <?php echo $cc;?> )
    </td>
    <td colspan="2" class="right"><div class="paging"></div></td>
  </tr>
 </tfoot>
</table>
</div>

<script type="text/javascript" charset="utf-8">
 
      $('#mensajes_table').datatable({
        pageSize: 8,
        sort: [false,true, false],
        filters: [true,true, false],
        filterText: 'Buscar... '
      }) ;
</script>