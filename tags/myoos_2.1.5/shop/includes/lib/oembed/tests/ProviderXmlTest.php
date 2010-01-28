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
$xml = simplexml_load_file("providers.xml");

foreach($xml->provider as $provider){
echo $provider->url;
echo $provider->endpoint;
}

