<?php 
 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	
	$curs_para_codi=$_POST['curs_para_codi'];
	
	$sql="{call curs_para_list_view(?)}";
    $params_opc= array($curs_para_codi);
    $stmt = sqlsrv_query($conn, $sql,$params_opc);
	if( $stmt === false )
    {
        echo "Error in executing statement .\n";
        die( print_r( sqlsrv_errors(), true));
    }
    $response .= "<select style='width: 100%' id='mate_prof' name='mate_prof' >";
    while($prof_mate_result= sqlsrv_fetch_array($stmt))
    {
        
        $response .= '<option value="'.$prof_mate_result["curs_para_mate_prof_codi"].'" >'.$prof_mate_result["mate_deta"].'-'.$prof_mate_result["prof_apel"].' '.$prof_mate_result["prof_nomb"].'</option>';
    }
    $response .= '</select>';
    echo $response;

?>
