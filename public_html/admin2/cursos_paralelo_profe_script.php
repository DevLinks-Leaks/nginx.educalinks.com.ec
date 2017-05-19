<?php 
	session_start();	 
	include ('../framework/dbconf.php');?>  
<div class="box-header with-border">
	<h3 class="box-title form-inline">
		<?php 
		$params = array ($_SESSION['peri_codi']);
        $sql="{call curs_para_view(?)}";
        $stmt = sqlsrv_query($conn, $sql, $params);
        if( $stmt === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}
		$a=0;?>
        <label>Elija un curso: </label> 
        
    </h3>
	<div class="pull-right">
	  	<a id="bt_mate_add"  class="btn btn-default"  href="javascript:getURL()">
							<span class="fa fa-print"></span>Imprimir Lista </a>
    </div>
</div>
<div class="box-body">    
    <script type="text/javascript">
	
	</script>
    
    <div class="row" id="div_curso_lista">
    
    </div>
</div>