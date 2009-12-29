<?php
// RSS to PDF
// Author: Keyvan Minoukadeh
// License: AGPLv3
// Date: 2009-06-08
// How to use: request this file passing it your feed in the querystring: makepdf.php?feed=http://mysite.org
// To include images in the PDF, add images=true to the querystring: makepdf.php?feed=http://mysite.org&images=true

/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


if(file_exists('bootstrap.php'))
{
	require_once 'bootstrap.php';
}

error_reporting(E_ALL & ~E_STRICT);

@set_time_limit(120);

define('OOS_VALID_MOD', 'yes');

// MyOOS requires PHP 5.2+
version_compare(PHP_VERSION, '5.2', '<') and exit('MyOOS requires PHP 5.2 or newer.');
define('MYOOS_DOCUMENT_ROOT', dirname(__FILE__)=='/'?'':dirname(__FILE__));

if (!defined('MYOOS_INCLUDE_PATH'))
{
  define('MYOOS_INCLUDE_PATH', MYOOS_DOCUMENT_ROOT);
}


require_once MYOOS_INCLUDE_PATH . '/includes/oos_main.php';


// Include OPML parser for OPML support
require_once MYOOS_INCLUDE_PATH . '/includes/lib/opml/iam_opml_parser.php';
// Include SimplePie for RSS/Atom support
require_once MYOOS_INCLUDE_PATH . '/includes/lib/simplepie/simplepie.php';
require_once MYOOS_INCLUDE_PATH . '/includes/lib/pdf-newspaper/SimplePie_Chronological.php';
// Include HTML Purifier to clean up and filter HTML input
require_once MYOOS_INCLUDE_PATH . '/includes/htmlpurifier/library/HTMLPurifier.auto.php';
// Include SmartyPants to make pretty, curly quotes
require_once MYOOS_INCLUDE_PATH . '/includes/lib/smartypants/smartypants.php';
// Include TCPDF to turn all this into a PDF
require_once MYOOS_INCLUDE_PATH . '/includes/lib/tcpdf/config/lang/eng.php';
require_once MYOOS_INCLUDE_PATH . '/includes/lib/tcpdf/tcpdf.php';
// Include NewspaperPDF to let us add stories to our PDF easily
require_once MYOOS_INCLUDE_PATH . '/includes/lib/pdf-newspaper/NewspaperPDF.php';

////////////////////////////////
// Check for feed URL
////////////////////////////////

$url = BLOG_HTTP_SERVER . '/feed/';

if (!preg_match('!^https?://.+!i', $url)) {
	$url = 'http://'.$url;
}
$valid_url = filter_var($url, FILTER_VALIDATE_URL);
if ($valid_url !== false && $valid_url !== null && preg_match('!^https?://!', $valid_url)) {
	$url = filter_var($url, FILTER_SANITIZE_URL);
} else {
	die('Invalid URL supplied');
}

////////////////////////////////
// Check item ordering
////////////////////////////////
if (isset($_GET['order']) && $_GET['order'] == 'asc') {
	$order = 'asc';
} else {
	$order = 'desc';
}

////////////////////////////////
// Check for date range
////////////////////////////////
if (isset($_GET['date_start'])) {
	$date_start = strtotime($_GET['date_start']);
}
if (isset($_GET['date_end'])) {
	$date_end = strtotime($_GET['date_end']);
}

////////////////////////////////
// Check if images should be downloaded
////////////////////////////////
if (isset($_GET['images']) && $_GET['images'] == 'true') {
	$get_images = true;
} else {
	$get_images = false;
}

//////////////////////////////////
// Max string length (total feed)
//////////////////////////////////
if ($get_images) {
	$max_strlen = 20000;
} else {
	$max_strlen = 100000;
}

//////////////////////////////////
// Check for cached copy
//////////////////////////////////
if ($get_images || isset($date_start) || isset($date_end)) {
	$query_md5 = md5($get_images . @$date_start . @$date_end);
	$cache_file = 'cache/'.md5($url.$order).'_'.$query_md5.'.pdf';
	unset($query_md5);
} else {
	$cache_file = 'cache/'.md5($url.$order).'.pdf';
}
if (file_exists($cache_file)) {
	$cache_mtime = filemtime($cache_file);
	$diff = time() - $cache_mtime;
	$diff = $diff / 60;
	if ($diff < 20) { // cache created less than 20 minutes ago
		header('Content-Type: application/pdf');
		if (headers_sent()) die('Some data has already been output to browser, can\'t send PDF file');
		$cached_pdf = file_get_contents($cache_file);
		header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', $cache_mtime).' GMT');
		header('Content-Length: '.strlen($cached_pdf));
		header('Content-Disposition: inline; filename="news.pdf";');
		echo $cached_pdf;
		exit;
	}
}

////////////////////////////////
// Get RSS/Atom feed
////////////////////////////////
if ($order == 'asc') {
	$feed = new SimplePie_Chronological();
} else {
	$feed = new SimplePie();
}
$feed->set_feed_url($url);
//$feed->set_feed_url('http://localhost/fivefilters/apps/newspaper/rss2.xml');
//$feed->set_feed_url('http://occupations.org.uk/feed/');
//$feed->set_feed_url('http://feeds.gawker.com/lifehacker/full');
//$feed->set_feed_url('http://www.medialens.org/forum/rss.php');
$feed->set_timeout(20);
$feed->enable_cache(false);
$feed->set_stupidly_fast(true);
$feed->enable_order_by_date(true);
$feed->set_url_replacements(array());
$result = $feed->init();
//$feed->handle_content_type();
//$feed->get_title();
if ($result && (!is_array($feed->data) || count($feed->data) == 0)) {
	die('Sorry, no feed items found');
}

//////////////////////////////////////////
// Get feeds from OPML (if URL is not feed)
//////////////////////////////////////////
if (!$result) {
	$opml = new IAM_OPML_Parser();
	$feeds_array = $opml->getFeeds($url);
	if (!is_array($feeds_array) || count($feeds_array) == 0) {
		die('URL must point to a feed or OPML of feeds');
	}
	$feed_urls = array();
	foreach($feeds_array as $feed_item) {
		if (trim($feed_item['feeds']) != '') {
			$feed_urls[] = trim($feed_item['feeds']);
		}
		// limit to 10 URLs in OPML
		if (count($feed_urls) >= 10) break;
	}
	// setup SimplePie again
	if ($order == 'asc') {
		$feed = new SimplePie_Chronological();
	} else {
		$feed = new SimplePie();
	}
	$feed->set_feed_url($feed_urls);
	//$feed->force_feed(true);
	$feed->set_timeout(120);
	$feed->enable_cache(false);
	$feed->set_stupidly_fast(true);
	$feed->enable_order_by_date(true);
	$feed->set_url_replacements(array());
	$result = $feed->init();
	//$feed->handle_content_type();
	//if ($feed->error()) echo $feed->error();exit;
	if (!$result) {
		die('Sorry, no feed items found');
	}
}

/////////////////////////////////////////////////
// Create new PDF document (LETTER/A4)
/////////////////////////////////////////////////
$pdf = new NewspaperPDF('P', 'mm', 'A4', true, 'UTF-8', false);
//$pdf = new NewspaperPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('http://fivefilters.org/pdf-newspaper/ (free software using TCPDF)');
$pdf->SetAuthor('fivefilters.org');
$pdf->SetTitle('Five Filters News');
$pdf->SetSubject('Non-corporate news');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

//$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);

// set default header data
// $pdf->SetHeaderData('../../../images/five_filters.jpg', 85, '', '');
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array('helveticab', 'B', 9));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//set margins
$pdf->SetMargins(13, PDF_MARGIN_TOP, 13);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(16);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(15);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setCellHeightRatio(1.5);

$pdf->SetFont('dejavuserifcondensed');

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
//$pdf->setImageScale(2);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  // 4

$pdf->SetDisplayMode('default', 'continuous');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// Black links with no underlining
$pdf->setHtmlLinksStyle(array(0, 0, 0), '');

// Define vertical spacing for various HTML elements
$tagvs = array(
			'blockquote' => array(0 => array('h' => '', 'n' => 1), 1 => array('h' => '', 'n' => 1)),
			'img' => array(0 => array('h' => '', 'n' => 0), 1 => array('h' => '', 'n' => 0)),
			'p' => array(0 => array('h' => '', 'n' => 1.6), 1 => array('h' => '', 'n' => 1.6)),
			'h1' => array(0 => array('h' => '', 'n' => 1), 1 => array('h' => '', 'n' => 1.5)),
			'h2' => array(0 => array('h' => '', 'n' => 2), 1 => array('h' => '', 'n' => 1)),
			'h3' => array(0 => array('h' => '', 'n' => 1), 1 => array('h' => '', 'n' => 1)),
			'h4' => array(0 => array('h' => '', 'n' => 1), 1 => array('h' => '', 'n' => 1)),
			'h5' => array(0 => array('h' => '', 'n' => 1), 1 => array('h' => '', 'n' => 1)),
			'h6' => array(0 => array('h' => '', 'n' => 1), 1 => array('h' => '', 'n' => 1)),
			'ul' => array(0 => array('h' => '', 'n' => 0), 1 => array('h' => '', 'n' => 1.5)),
			'li' => array(0 => array('h' => '', 'n' => 1.4))
			);
$pdf->setHtmlVSpace($tagvs);

$pdf->addPage();


///////////////////////////////////////
// Set up HTML Purifier, HTML Tidy
///////////////////////////////////////
$purifier = new HTMLPurifier();

// do tidy stuff, see http://tidy.sourceforge.net/docs/quickref.html
$tidy_config = array(
	 'clean' => true,
	 'output-xhtml' => true,
	 'logical-emphasis' => true,
	 'show-body-only' => true,
	 'wrap' => 0,
	 'drop-empty-paras' => true,
	 'drop-proprietary-attributes' => true,
	 'enclose-text' => true,
	 'enclose-block-text' => true,
	 'merge-divs' => true,
	 'merge-spans' => true,
	 'char-encoding' => 'utf8'
);

////////////////////////////////////////////
// Loop through feed items
////////////////////////////////////////////
$items = $feed->get_items();
$strlen = 0;

foreach ($items as $item) {
	// skip items which fall outside date range
	if (isset($date_start) && (int)$item->get_date('U') < $date_start) continue;
	if (isset($date_end) && (int)$item->get_date('U') > $date_end) continue;

	$config = HTMLPurifier_Config::createDefault();
	// these are the HTML elements/attributes that will be preserved
	if ($get_images) {
		$config->set('HTML.Allowed', 'div,p,b,strong,em,a[href],i,ul,li,ol,blockquote,br,h1,h2,h3,h4,h5,h6,code,pre,sub,sup,del,img[src]');
	} else {
		$config->set('HTML.Allowed', 'div,p,b,strong,em,a[href],i,ul,li,ol,blockquote,br,h1,h2,h3,h4,h5,h6,code,pre,sub,sup,del');
	}
	// Attempt to autoparagraph when 2 linebreaks are detected -- we use feature after we run HTML through Tidy and replace double <br>s with linebreaks (\n\n)
	$config->set('AutoFormat.AutoParagraph', true);
	// Remove empty elements - TCPDF still applies padding/vertical spacing rules to empty elements
	$config->set('AutoFormat.RemoveEmpty', true);
	// disable cache
	$config->set('Cache.DefinitionImpl', null);
	//$config->set('Output.TidyFormat', false);
	//$config->set('HTML.TidyLevel', 'heavy');
	$config->set('URI.Base', $item->get_permalink());
	$config->set('URI.MakeAbsolute', true);
	$config->set('HTML.DefinitionID', 'extra-transforms');
	$config->set('HTML.DefinitionRev', 1);
	$def = $config->getHTMLDefinition(true);
	// Change <div> elements to <p> elements - We don't want <div><p>Bla bla bla</p></div> (makes it easier for TCPDF)
	$def->info_tag_transform['div'] = new HTMLPurifier_TagTransform_Simple('p');
	// <h1> elements are treated as story headlines so we downgrade any that appear to <h2>
	// <h2> to <h6> elements are treated the same (made bold but kept the same size)
	$def->info_tag_transform['h1'] = new HTMLPurifier_TagTransform_Simple('h2');
	$def->info_tag_transform['h3'] = new HTMLPurifier_TagTransform_Simple('h2');
	$def->info_tag_transform['h4'] = new HTMLPurifier_TagTransform_Simple('h2');
	$def->info_tag_transform['h5'] = new HTMLPurifier_TagTransform_Simple('h2');
	$def->info_tag_transform['h6'] = new HTMLPurifier_TagTransform_Simple('h2');
	//$def->info_tag_transform['i'] = new HTMLPurifier_TagTransform_Simple('em');

	$story = '';
	//$story .= '<h1><a href="'.$item->get_permalink().'">'.$item->get_title().'</a></h1>';
	//$story .= '<p>'.$item->get_date('j M Y').'</p>';
	$content = $item->get_content();
	// run content through Tidy
	$tidy = tidy_parse_string($content, $tidy_config, 'UTF8');
	$tidy->cleanRepair();
	$content = $tidy->value;
	// replace double <br>s to linebreaks
	$content = preg_replace('!<br[^>]+>\s*<br[^>]+>!m', "\n\n", $content);
	// end here if character count is about to exceed our maximum
	$strlen += strlen($content);
	if ($strlen > $max_strlen) {
		break;
	}
	// run content through HTML Purifier
	$content = $purifier->purify($content, $config);
	// run through Tidy one last time (TODO: check if this step can be avoided)
	$tidy = tidy_parse_string($content, $tidy_config, 'UTF8');
	$tidy->cleanRepair();
	$content = $tidy->value;
	// a little additional cleanup...
	$content = str_replace('<p><br /></p>', '<br />', $content);
	$content = preg_replace('!<br />\s*<(/?(h2|p))>!', '<$1>', $content);
	//$content = preg_replace('!<br />\s*</p>!', '</p>', $content);
	$content = preg_replace('!\s*<br />\s*!', '<br />', $content);
	$content = preg_replace('!</(p|blockquote)>\s*<br />\s*!', '</$1>', $content);
	$content = str_replace('<p>&nbsp;</p>', '', $content);
	//$content = preg_replace('/\s+/', ' ', $content);
	// run content through SmartyPants to make things pretty
	$content = SmartyPants($content);
	$title = SmartyPants($item->get_title());
	$story .= $content;
	// add enclosure link
	if ($enclosure = $item->get_enclosure()) {
		$story = '<p><a href="'.$enclosure->get_link().'">Click here to view or listen to the audio/video.</a></p>'.$story;
	}
	//die($story);
	//die($purifier->purify($item->get_content()));
	$pdf->addItem('<a href="'.$item->get_permalink().'">'.$title.'</a>', $story, (int)$item->get_date('U'));
}
// make PDF
$pdf->makePdf();
// output PDF
$pdf->Output($cache_file, 'F');
$pdf->Output('news.pdf', 'I');

