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
define("PROVIDER_XML","providers.xml");
define("TEMPLATE_PATH","templates/");
function __autoload($classname){

  if(file_exists($x=$classname.".class.php")) {
    require_once($x);
  }
/*
  if(file_exists($x="meta/".$classname.".php")) {
    require_once($x);
  } else if (file_exists($x="exceptions/".$classname.".php")){
    require_once($x);
  } else if (file_exists($x="services/".$classname.".php")){
    require_once($x);
  } else if (file_exists($x="entities/".$classname.".php")){
    require_once($x);
  }
  */
}
?>
