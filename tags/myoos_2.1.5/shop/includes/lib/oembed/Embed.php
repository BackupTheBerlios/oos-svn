<?
/*
 * PHP OEmbed provider/proxy - for details, visit
 *
 * http://code.google.com/p/php-oembed/
 *
 * Copyright(C) by Adam Nemeth. Licensed under New BSD license.
 *
 * I would love to hear every feedback on aadaam at googlesmailservice
 *
 */
require_once("config.php");
$format = $_REQUEST['format'] ? $_REQUEST['format'] : 'json';
$url = $_REQUEST['url'];
$manager = ProviderManager::getInstance();
if ($format=="xml"){
header('Content-type: application/xml');
} else if ($format=="serialized"){
} else {
header('Content-type: application/json');
}
try{
echo $manager->provide($url,$format);
 } catch (Exception $e){
 header("HTTP/1.0 404 Not Found");
}
