<?php
/*
	GNU Public License
	Version: GPL 3
*/
require_once "root.php";
require_once "resources/require.php";
require_once "resources/check_auth.php";
$settings = json_decode(file_get_contents(__DIR__."/settings.json"), true);


$vars = array('caller_id_number', 'caller_id_name');

$fp = event_socket_create($_SESSION['event_socket_ip_address'], $_SESSION['event_socket_port'], $_SESSION['event_socket_password']);

if (!$fp) {
	die("ERROR");
}

function uuid_getvar($uuid, $var) {
	global $fp;
	return trim(event_socket_request($fp, "api uuid_getvar ".$uuid." ".$var));
}

$valet_info = new SimpleXMLElement(trim(event_socket_request($fp, "api valet_info")));
$out = array("parked"=>array());
foreach($valet_info as $lot) {
	foreach($lot as $spot) {
		$uuid = (string)$spot['uuid'];
		$spot = (int)$spot;
		$call = array(
			"call" => $uuid,
			"spot" => $spot
		);
		foreach($vars as $var) {
			$call[$var] = uuid_getvar($uuid, $var);
		}
		$out["parked"][] = $call;
	}
}
$out["current_call"] = NULL;
$channels = json_decode(trim(event_socket_request($fp, "api show channels as json")), true);
if(isset($channels["rows"])) {
	foreach($channels['rows'] as $channel) {
		if($channel['dest'] == $settings['on_air_user']) {
			$out["current_call"] = $channel;
		}
	}
}
echo json_encode($out);
