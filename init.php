<?php
require_once('config.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!file_exists('config.php')) {
	$msg = 'Создайте файл config.php на основе config.sample.php ';
	trigger_error($msg,E_USER_ERROR);
}

$con = mysqli_connect($db_host, $db_username, $db_password, $db_database);
mysqli_set_charset($con, $db_charset);
