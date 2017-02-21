<?

	include ('../framework/dbconf.php'); 
	
	
	$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
	 
 
	$params = array($curs_para_mate_codi);
	$sql="{call curs_acti_view_on(?)}";
	$curs_acti_view_ = sqlsrv_query($conn, $sql, $params);  
	 

 
	$posts = array();
 	while($post = sqlsrv_fetch_array($curs_acti_view_,SQLSRV_FETCH_ASSOC)) {
			$posts[] = array('actividad'=>$post);
	}
	 
 
	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('actividad'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<actividades>';
		foreach($posts as $index => $post) {
			if(is_array($post)) {
				foreach($post as $key => $value) {
					echo '<',$key,'>';
					if(is_array($value)) {
						foreach($value as $tag => $val) {
							echo '<',$tag,'>',$val,'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</actividades>';
	} 

?>