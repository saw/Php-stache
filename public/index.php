<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('apc.write_lock', 'false');
ini_set('apc.slam_defense', 'false');
// apc.write_lock = 1 and apc.slam_defense = 0 in php.ini
$start = microtime(true);

require_once('../lib/includes.php');

$app = App::getInstance();



$app->get('/', 'Controller_Index');

$app->get('/test', 'Controller_Test');

$app->listen();
$now = microtime(true) - $start;
$timeStr = round(($now * 1000), 2) . 'ms';
if(isset($_REQUEST['time'])){
    echo("<p style=\"width: 100%; background: red; color:#fff; font-size:20px; clear:both\">$timeStr</h1>");
}
// echo("<!--$timeStr-->");
?>