<?

	include ('../framework/dbconf.php'); 
	
	
	$alum_codi=$_GET['alum_codi'];
	$params = array($alum_codi);
	$sql="{call alum_info(?)}";
	$alum_info = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 

 
	$posts = array();
 	while($post = sqlsrv_fetch_array($alum_info,SQLSRV_FETCH_ASSOC)) {
			$posts[] = array('alumno'=>$post);
	}
	 
 
	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('posts'=>$posts));
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
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</alumnos>';
	} 

?>