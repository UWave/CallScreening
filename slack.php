<?php
require_once "root.php";
require_once "resources/require.php";
require_once "vendor/autoload.php";
$settings = json_decode(file_get_contents(__DIR__."/settings.json"), true);

if(!isset($_POST['token']) || $_POST['token'] != $settings['slack']['token']) {
	error_log("Invalid token ".$_POST['token']);
	die("Invalid token");
}

$fp = event_socket_create($_SESSION['event_socket_ip_address'], $_SESSION['event_socket_port'], $_SESSION['event_socket_password']);

if (!$fp) {
	die("Failed to connect");
}

if(isset($_POST['text'])) {
	$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
	$number = $phoneUtil->parse($_POST['text'], "US");

	$number_str = $phoneUtil->format($number, \libphonenumber\PhoneNumberFormat::E164);

	event_socket_request($fp, "api originate sofia/gateway/".$settings['origination']['gateway']."/".$settings['origination']['prefix'].$number_str." '&bridge(user/".$settings['on_air_user']."@".$settings['on_air_domain'].")'");
}
