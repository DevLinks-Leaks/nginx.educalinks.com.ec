<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->

  <?php include ('head.php');?>
		
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=4;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 
			
      <?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
        <?php include ('header.php');?>			

				<div class="main sectionBorder">
					<div id="information">
            <div class="titleBar">
              <div class="title">
                  <h3>
                      <span class="icon-briefcase icon"></span>
                      Notas
                  </h3>
              </div>
            </div>       
          	<?
              $peri_codi = $_SESSION['peri_codi'];
              //ETAPA PARA ALUMNOS Y REPRESENTANTES 
              $peri_etap_codi = 'U';
              $params = array($peri_codi, $_SESSION['peri_dist_cab_tipo'],$peri_etap_codi);
              $sql="{call peri_dist_peri_view_Lb_etapa(?,?,?)}";
              $peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);  
            ?>
            <table class="table_striped">
              <thead>
                <tr>
                	<th colspan="2">
                    Lista de Notas disponibles
                    </th>
                </tr>
              </thead>
              <? while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view)){ ?>
                <tr>
                  <td width="87%"><?= $row_peri_dist_peri_view['peri_dist_deta'];?> </td>
                  <td width="13%">  
            			  <div class="menu_options" style="text-align:left;">
              				<ul>
                        <li>
                        	<a  
                            	class="option"
                                href="notas_view.php?peri_dist_codi=<?= $row_peri_dist_peri_view['peri_dist_codi'];?> ">
    								            <span class="icon-tree icon"></span>Ver
    	                    </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
               <?php 	} ?>
            </table>        		 
          </div>
				</div>
			</div>
      
      
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
   	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />  
  <!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
  </body>

</html>