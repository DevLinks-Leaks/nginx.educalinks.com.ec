<?

	include ('../framework/dbconf.php'); 
	
	
	$curs_acti_codi=$_GET['curs_acti_codi'];
	$cont_tipo_codi=$_GET['cont_tipo_codi'];
	 
 
	$params = array($curs_acti_codi,$cont_tipo_codi);
	$sql="{call curs_cont_view_tipo(?,?)}";
	$curs_cont_view = sqlsrv_query($conn, $sql, $params);  
	 

 
	$posts = array();
 	while($post = sqlsrv_fetch_array($curs_cont_view,SQLSRV_FETCH_ASSOC)) {
			$posts[] = array('contenido'=>$post);
	}
	 
 
	/* output in necessary format */
	if($format == 'json') {
		header('Content-type: application/json');
		echo json_encode(array('contenido'=>$posts));
	}
	else {
		header('Content-type: text/xml');
		echo '<contenidos>';
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
		echo '</contenidos>';
	} 

?>