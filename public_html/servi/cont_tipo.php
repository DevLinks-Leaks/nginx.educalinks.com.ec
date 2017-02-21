<?

	include ('../framework/dbconf.php'); 
	
	 
	 
 
	$params = array();
	$sql="{call cont_tipo()}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	 

 
	$posts = array();
 	while($post = sqlsrv_fetch_array($alum_curs_para_view,SQLSRV_FETCH_ASSOC)) {
			$posts[] = array('contenidos_tipo'=>$post);
	}
	 
 
	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('contenidos_tipo'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<contenidos_tipos>';
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
		echo '</contenidos_tipos>';
	} 

?>