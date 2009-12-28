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
$x = new YouTubeProvider();
print_r($x->provide(""));
