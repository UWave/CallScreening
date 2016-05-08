<?php
/*
	GNU Public License
	Version: GPL 3
*/
require_once "root.php";
require_once "resources/require.php";
require_once "resources/check_auth.php";

$vars = array('caller_id_number', 'caller_id_name');

$fp = event_socket_create($_SESSION['event_socket_ip_address'], $_SESSION['event_socket_port'], $_SESSION['event_socket_password']);

if (!$fp) {
	die("ERROR");
}

function uuid_getvar($uuid, $var) {
	global $fp;
	return trim(event_socket_request($fp, "api uuid_getvar ".$uuid." ".$var));
}

$xml = trim(event_socket_request($fp, "api valet_info"));
$valet_info = new SimpleXMLElement($xml);
$out = array();
foreach($valet_info as $lot) {
	$lot_name = (string)$lot['name'];
	$out[$lot_name] = array();
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
		$out[$lot_name][] = $call;
	}
}

echo json_encode($out);
