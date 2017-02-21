<select class="form-control" size="5" id="fic_codigo" name="fic_codigo" onChange="carga_fichas_campos('campos_div','ajax_script/fichas.php',this.value)">
	<option value="" selected="selected">Seleccione...</option>
    <?php foreach($fichas->rows as $ficha ){
	?>
    	<option value="<?= $ficha['fic_codigo'];?>" <?= $ficha['fic_codigo']==$fichas->codigo? "selected='selected'":""; ?>><?= $ficha['fic_nombre'];?></option>
    <?php }
	?>
</select>