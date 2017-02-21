<?php
	$array_user = array ();
	$array_users = array ();
	for ($i=1;$i<=10;$i++)
	{
		$array_user[] = array ("id"=>$i, "username"=>$_POST["inicial"].$i,"password"=>rand (1111, 9999)); 
	}
	$array_users = array ("result"=>$array_user);
	echo json_encode($array_users);
?>