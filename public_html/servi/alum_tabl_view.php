<?

	include ('../framework/dbconf.php'); 
	
	
	$curs_para_codi=$_GET['tabl_codi'];
	 
 
	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	 

 
	$posts = array();
 	while($post = sqlsrv_fetch_array($alum_curs_para_view,SQLSRV_FETCH_ASSOC)) {
			$posts[] = array('alumno'=>$post);
	}
	 
 
	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('alumno'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<alumnos>';
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
		echo '</alumnos>';
	} 

?>