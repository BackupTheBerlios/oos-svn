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
abstract class OEmbed extends LazyTemplateEngine{
  public $type;
  public $version;
  public $title;
  public $author_name;
  public $author_url;
  public $provider_name;
  public $provider_url;
  public $cache_age;
  public $description; // added by me, not part of OEmbed
  public $resource_url; // added by me, not part of OEmbed
  public $thumbnail_url;
  public $thumbnail_width;
  public $thumbnail_height;
  public function renderClass(){
    try{
      return $this->render(get_class($this).".template.php");
    } catch (TemplateNotFoundException $e){
      return $this->render(get_parent_class($this).".template.php");//TODO: infinite level
    }
  }
  public function cloneObj($object){
  foreach($object as $key=>$value){
    $this->$key=(string)$value;
  }
  }
}
