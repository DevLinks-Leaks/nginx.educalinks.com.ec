<!-- Modal  MATERIA MODIFICACION-->
<input id="m_mate_codi" name="m_mate_codi" type="hidden" value="">
<input id="m_peri_codi" name="m_peri_codi" type="hidden" value="<?= $peri_codi;?>">
<div class="modal fade" id="mate_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Materia <label id="m_top_matemodal" ></label></h4>
      </div>
      <div class="modal-body">
      <div id="div_mate_edi"> 
       	<table width="100%">
		<tr>
            <td width="15%">
            	Nombre: 
			</td>
            <td width="85%">
            	<input 
                	id="m_mate_deta" 
                    name="m_mate_deta" 
                    type="text" 
                    value="" 
                    style="width: 100%; margin-top: 10px;">
			</td>
		</tr>
        <tr>
	        <td>
            	Abreviatura: 
			</td>
    	    <td>
				<input 
                	id="m_mate_abre" 
                    name="m_mate_abre" 
                    type="text" 
                    value=""
                    style="width: 50%; margin-top: 10px;">
			</td>
        </tr>
        <tr>
            <td>
                Área: 
            </td>
            <td>
            <?php 
                $params = array($peri_codi);
                $sql="{call area_view(?)}";
                $area_view = sqlsrv_query($conn, $sql, $params);  
            ?>
        
                <select id="a_area_sele" name="a_area_sele" style="width: 100%; margin-top: 10px;">
            <?php 
                    while($row_area_view= sqlsrv_fetch_array($area_view))
                    {
            ?>
                    <option value="<?= $row_area_view['area_codi'];?>">
                        <?= $row_area_view['area_deta'];?>
                    </option>
            
            <?php 
                    }
            ?>
                </select>
            </td>
        </tr>    
        <tr>
            <td>
            	Agrupada: 
			</td>
            <td>
			<?php 
				$params = array($peri_codi);
				$sql="{call mate_peri_view(?)}";
				$mate_peri_view = sqlsrv_query($conn, $sql, $params);  
            ?>
        
            	<select id="m_mate_padr" name="m_mate_padr" style="width: 100%; margin-top: 10px;">
            		<option value="-1">Ninguno...</option>
            <?php 
					while($row_mate_peri_view= sqlsrv_fetch_array($mate_peri_view))
					{
			?>
            		<option value="<?= $row_mate_peri_view['mate_codi'];?>">
						<?= $row_mate_peri_view['mate_deta'];?> -  <?= $row_mate_peri_view['mate_codi'];?>
					</option>
            
            <?php 
					}
			?>
				</select>
            </td>
        </tr>
        <tr>
            <td>
            	Promediada
			</td>
            <td>
				<input id="ch_mate_prom" name="ch_mate_prom" type="checkbox" value="" style="margin-top: 10px;"/>
			</td>
        </tr>
        <!--<tr>
        	<td height="35">
            	Tipo: 
			</td>
        	<td>
            
                
                <?php 
				$params = array();
				$sql="{call mate_tipo_view()}";
				$mate_tipo_view = sqlsrv_query($conn, $sql, $params);  
            ?>
        
            	<select id="m_mate_tipo" name="m_mate_tipo" style="width: 100%; margin-top: 10px;">
            		 
            <?php 
					while($row_mate_tipo_view= sqlsrv_fetch_array($mate_tipo_view))
					{
			?>
            		<option value="<?= $row_mate_tipo_view['mate_tipo'];?>">
						<?= $row_mate_tipo_view['mate_tipo_deta'];?> 					</option>
            
            <?php 
					}
			?>
				</select>
			</td>
        </tr>-->
		</table>
      </div>
	  <div class="form_element">&nbsp;</div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"  onClick="mate_peri_upd()">
        	Aceptar
        </button>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" class="btn btn-default" data-dismiss="modal">
        	Cerrar
		</button>
      </div>
    </div>
  </div>
</div>