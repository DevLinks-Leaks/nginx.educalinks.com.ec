<form id="frm_mensaje" action="http://<?php echo$_SERVER['HTTP_HOST'] ?>/finan/debitosAutomaticos/" name="frm_mensaje" enctype="multipart/form-data" method="post">
	<input type="hidden" id="event" name="event" value="<?php echo $_GET['event'] ?>"/>
	<input type="hidden" id="contador1" name="contador1" value="<?php echo $_GET['contador1'] ?>"/>
	<input type="hidden" id="contador2" name="contador2" value="<?php echo $_GET['contador2'] ?>"/>
	<input type="hidden" id="contador3" name="contador3" value="<?php echo $_GET['contador3'] ?>"/>
</form>
<script type="text/javascript" charset="utf-8">
	document.frm_mensaje.submit();
</script>