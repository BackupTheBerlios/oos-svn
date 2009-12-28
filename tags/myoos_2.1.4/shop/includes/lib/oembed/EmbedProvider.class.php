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
abstract class EmbedProvider {
  public $url;
  public $endpoint;
  public abstract function match($url);
  public abstract function provide($url,$format="json");
//  public abstract function register();
  public function __construct($url,$endpoint){
    $this->url = $url;
    $this->endpoint = $endpoint;
  }
}
