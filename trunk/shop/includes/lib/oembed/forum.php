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
/** getFeedURL - "AutoDiscovery emulator"
    @param url URL of an album or collection
    @return String Atom feed URL, or false if none found
  */
function getFeedURL($url){
  // PHP5 befigyel!!!
  $doc = new DOMDocument();
    $opts = array(
        'http' => array(
            'max_redirects' => 100,
            ));
  $resource= stream_context_get_default($opts);
  $context = stream_context_create( $opts );
  libxml_set_streams_context($context);

  // Pattogna kulonben a cookie miatt, kenytelenek vagyunk curl-t hasznalni
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_COOKIEFILE, "cookiefile");
  curl_setopt($curl, CURLOPT_COOKIEJAR, "cookiefile"); # SAME cookiefile

  if (@$doc->loadHTML(curl_exec($curl))){
    $datas=array();
    $xpath = new DOMXPath($doc);
    $items=$xpath->query('//link[@type="application/atom+xml"]/@href');
    foreach ($items as $item){
      return $item->nodeValue;
    }
    return false;
  } else return false;
}

function embedImageURL($url){

  $url.="/details/xs";
  // PHP5 befigyel!!!
  $doc = new DOMDocument();
    $opts = array(
        'http' => array(
            'max_redirects' => 100,
            ));
  $resource= stream_context_get_default($opts);
  $context = stream_context_create( $opts );
  libxml_set_streams_context($context);

  // Pattogna kulonben a cookie miatt, kenytelenek vagyunk curl-t hasznalni
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_COOKIEFILE, "cookiefile");
  curl_setopt($curl, CURLOPT_COOKIEJAR, "cookiefile"); # SAME cookiefile
  if (@$doc->loadHTML(curl_exec($curl))){
    if($retnode=$doc->getElementById("textfield-url")){
      echo "megy";
      return "<img src=\"$retnode->nodeValue\">";
      } else {
      return false;
    }
  } else return false;
}

/** parsePost - searches for URL occurencies in given text
  * @param text forumtext
  * @returns Array an Array of successfully recognized embedcodes 
  */
function parsePost($text){
        $arr = array();
        $ret = array();
        $x= preg_match_all("(http://[^/]*indafoto.hu\/[^\s]*)",$text,$arr);
        if($x>0){
          foreach($arr as $item){
                  if (strpos($item[0],"/image/")){ // NOT RegExp!
                          // kep beszurasa
                          $ret[]=embedImageURL($item[0]);
                  } else {
                          if($embedcode=embedFeedURL(getFeedURL($item[0]))){
                          $ret[]=$embedcode;
                          }
                  }
          }
        }
        return $ret;
}
/** addPost - dummy function for database saving. Currently uses an XML file.*/
function addPost($author,$text){
  if (!isset($author) || $author==null || $author=='') $author="Anonymous";
   $xml = simplexml_load_file("hello.xml");
   $post=$xml->addChild("post");
   $post->addChild("author",$author);
   $post->addChild("text",$text);
   $xml->asXML("hello.xml"); // save;
}
  function embedFeedURL($url){
  return '<script type="text/javascript" src="http://static.indafoto.hu/js/slideshow.js"></script>
  <script type="text/javascript">
   INDAFOTO.slideshow.run({ "feedUrl":"'.$url.'", "width":"300", "height":"90", "orientation":"horizontal", "size":"xs", "bgcolor":"#000000", "textcolor":"#FFFFFF", "number":"3", "target":"blank", "staticUrl":"http://static.indafoto.hu" });
   </script>
   '; 
  }
/** parsedText - adds embedcodes at the end of the post */
function parsedText($text){
  foreach (parsePost($_POST["szoveg"]) as $item){
      $text.= "<br/>".$item;
    }
    return $text;
}
  if(isset($_POST["szoveg"])){
    addPost($_POST["author"],parsedText($_POST["szoveg"]));
  }
   $xml = simplexml_load_file("hello.xml");
   foreach($xml as $item){
  ?>

  <div style="width:50%;margin:1em;padding:2px;background-color:#ccc;">
  <div style="background-color:#ccc">
  <?=$item->author." - ".date("Y / m / j")?>
  </div>
  <div style="background-color:white;padding:0.5em;">
  <?=$item->text?>
  </div>
  </div>
  <?
  }
  ?>
  <form method="POST">
  From: <input type="text" name="author"><br/>
  <textarea name="szoveg" cols=50 rows=10></textarea>
  <input type="submit">
  </form>
</body>
</html>
