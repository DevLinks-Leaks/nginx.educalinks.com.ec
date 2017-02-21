<?php
session_start();
include("framework/dbconf_main.php");
$params = array($domain);

$sql="{call dbo.clie_info_domain(?)}";
$resu_login = sqlsrv_query($conn, $sql, $params);  
$row = sqlsrv_fetch_array($resu_login);
$_SESSION['host']=$row['clie_instancia_db'];
$_SESSION['user']=$row['clie_user_db'];
$_SESSION['pass']=$row['clie_pass_db'];
$_SESSION['dbname']=$row['clie_base'];
$_SESSION['IN']= (isset($_SESSION['usua_codi']))?'OK':'KO';
$_SESSION['usua_codigo']=$_SESSION['usua_codi'];
$_SESSION['usua_pass']=$_SESSION['usua_pass'];
$_SESSION['modulo']='finan';
//$_SESSION['modulo']='acad';
//$_SESSION['modulo']='biblio';
//$_SESSION['modulo']='medic';
//header ("location: http://".$domain."/finan/general/");<html><body><div style='text-align:center'><img src='mfanf.jpg'/><br><img src='imagenes/logo_educalinks.png'/></div></body></html>
//echo $_SESSION['peri_codi'];
?>
<form id="frm" name="frm" action="/finan/general/" method="post">
<input type="hidden" name="usua_codigo" id="usua_codigo" value="<?php echo $_SESSION['usua_codi']?>"  />
<input type="hidden" name="usua_clave" id="usua_clave" value="<?php echo $_SESSION['usua_pass']?>"  />
<input id="event" name="event" type="hidden" value="login" />
</form>
<script>
document.frm.submit();
</script>
