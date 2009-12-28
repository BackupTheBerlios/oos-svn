<?php
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
$x=new LazyTemplateEngine();
$x->setScriptPath("templates/");
$y= new LinkEmbed();
$y->version="bumm";
//$y->setScriptPath("templates/");
//echo $y->getClassName();
var_dump($y);
$x->hello = "szia";
$x->content=$y->renderClass();
echo $x->render("Main.template.php");

