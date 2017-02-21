<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->

  <?php include ('head.php');?>

	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=2; ?>
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 

			<?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
        <?php include ('header.php');?>
				
				<div class="main sectionBorder">
					<div id="information">
          
            <div class="titleBar">
                 <div class="title"><h3><span class="icon-calendar icon"></span>Agendas</h3></div> 
                 <div class="options">
                    <ul>
                      <li class="titleBar_select">
                        <div class="button_text">
                          Seleccione la materia: 
                              <select id="agen" name="agen" onChange="carga_agenda('agen_div','script_agen.php',this.value)">
                                <option value="0">Agendas activas...</option>
                                <?php
                                  $params_mate = array($_SESSION['alum_codi'],$_SESSION['curs_para_codi']);
                  								$sql_mate="{call alum_curs_peri_mate_view(?,?)}";
                  								$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
                  								while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
                  									if ($row_curs_mate_view['curs_para_mate_agen']==1)
                  									{ ?>
                                <option value="<?=$row_curs_mate_view['curs_para_mate_prof_codi']?>"><?=$row_curs_mate_view['mate_deta']?></option>
                                <?php }
  							                }?>
                              </select>
                         </div>
                      </li>
                    </ul>
                  </div>
            </div><!-- Title Bar -->
            
            <div class="zones">                  
              <div id="agen_div_all" class="alumnos_agendas">
                  <div class="agenda_list  " id="agen_div">
      								<?php 								
      								$alum_codi=$_SESSION['alum_codi'];
      								$peri_codi=$_SESSION['peri_codi'];
      								$params_agen = array($alum_codi,$peri_codi);
      								$sql_agen="{call agen_curs_para_mate_view_all(?,?)}";
                      $stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
                      while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
                      <div class="container">
                          <table class="table_striped">
                              <thead>
                              	<tr>
                                      <th><?="(".$row_agen_curs_view['mate_deta'].") - ".$row_agen_curs_view['agen_titu']?></th>
                                  </tr>
                                  
                              </thead>
                              <tbody>
                              <table class="table_basic ">
                                	<tr>
                                      <td width="60%"><strong>Detalle</strong></td>
                                      <td width="20%"><strong>Fecha Ingreso</strong></td>
                                      <td width="20%"><strong>Fecha de Entrega</strong></td>
                                  </tr>
                              	<tr>
                                      <td><?=$row_agen_curs_view['agen_deta']?>
                                      </td>
                                      <td><?=date_format($row_agen_curs_view['agen_fech_ini'], 'd/m/Y')?>
                                      </td>
                                      <td><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?>
                                      </td>
                                  </tr>
                              </table>
                              </tbody>
                          </table>
                      </div>
                      <?php } ?>
                  </div>
              </div>
            </div><!-- zones -->
						
          </div><!-- Information -->
				</div><!-- Section Border -->
			</div><!-- Section Main -->

	
	</div><!-- Page Container --> 
    
  <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
</body>
</html>