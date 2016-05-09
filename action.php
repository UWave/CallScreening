<?php
require_once "root.php";
require_once "resources/require.php";
require_once "resources/check_auth.php";
$settings = json_decode(file_get_contents(__DIR__."/settings.json"), true);

$fp = event_socket_create($_SESSION['event_socket_ip_address'], $_SESSION['event_socket_port'], $_SESSION['event_socket_password']);

if (!$fp) {
	die("ERROR");
}

$out = array();

function sanatize_uuid($input) {
	$output_array;
	preg_match("/[a-z0-9-]*/", $input, $output_array);
	return $output_array[0];
}

$postdata = json_decode(file_get_contents('php://input'), true);
if(isset($postdata['action'])) {
  switch($postdata['action']) {
		case "park":
			event_socket_request($fp, "api uuid_broadcast ".sanatise_uuid($postdata['call'])." valet_park::parking_lot auto in 1500 1599");
		break;
    case "unpark":
      $slot = intval($postdata['spot']);
      event_socket_request($fp, "api originate sofia/internal/".$settings['on_air_user']."%".$settings['on_air_domain']." '&valet_park(parking_lot ".$slot.")'");
    break;
		case "hangup":
			event_socket_request($fp, "api uuid_kill ".sanatize_uuid($postdata['call']));
		break;
		case "describe":
			event_socket_request($fp, "api uuid_setvar ".sanatize_uuid($postdata['call'])." description ".$postdata['description']);
		break;
  }
} else {
  die(json_encode(array("error" => "Please send an action!")));
}
