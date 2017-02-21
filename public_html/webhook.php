<?php
/*$botToken="329232236:AAHMeacaBRPAiGuWpl2ekqw8ZZqG7huKa2U";
$website="https://api.telegram.org/bot".$botToken;
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];

switch($message){
	case "/test":
		sendMessage($chatId,"test");
		break;
	case "/hi":
		sendMessage($chatId,"Hi there!");
		break;
	default:
		sendMessage($chatId,"default");
		break;
}
function sendMessage ($chatId,$message){
	$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
	file_get_contents($url);
}*/


$botToken = "329232236:AAHMeacaBRPAiGuWpl2ekqw8ZZqG7huKa2U";
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);


$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];


switch($message) {
	
	case "/test":
		sendMessage($chatId, "test");
		
		break;
	case "/hi":
		sendMessage($chatId, "hi there!");
		break;
	default: 
		sendMessage($chatId, "ok");
}

function sendMessage ($chatId, $message) {
	
	$url = $GLOBALS['website']."/sendMessage?chat_id=".$chatId."&text=".urlencode($message);
	file_get_contents($url);
	
}
 




?>