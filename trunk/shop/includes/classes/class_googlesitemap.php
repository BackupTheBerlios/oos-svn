<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Google XML Sitemap Feed
 *
 * The Google sitemap service was announced on 2 June 2005 and represents
 * a huge development in terms of crawler technology.  This contribution is
 * designed to create the sitemap XML feed per the specification delineated
 * by Google.
 *
 * Optimized for use with OOS by r23 (info@r23.de)
 *
 * @package Google-XML-Sitemap-Feed
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 2.0
 * @link http://www.oscommerce-freelancers.com/ osCommerce-Freelancers
 * @link http://www.google.com/webmasters/sitemaps/docs/en/about.html About Google Sitemap
 * @copyright Copyright 2005, Bobby Easland
 * @author Bobby Easland
 */
class GoogleSitemap
{

    /**
     * $filename is the base name of the feeds (i.e. - 'sitemap')
     *
     * @var string
     */
     var $filename;

    /**
     * $savepath is the path where the feeds will be saved - store root
     *
     * @var string
     */
     var $savepath;

    /**
     * $base_url is the URL for the catalog
     *
     * @var string
     */
     var $base_url;

    /**
     * $debug holds all the debug data
     *
     * @var array
     */
     var $debug;


    /**
     * GoogleSitemap class constructor
     */
     function GoogleSitemap()
     {

         $this->filename = "sitemap";
         $this->savepath = OOS_ABSOLUTE_PATH;
         $this->base_url = OOS_HTTP_SERVER . OOS_SHOP;
         $this->debug = array();
     }


    /**
     * Function to save the sitemap data to file as either XML or XML.GZ format
     *
     * @param string $data XML data
     * @param string $type Feed type (index, products, categories)
     * @return boolean
     */
     function SaveFile($data, $type)
     {
         $filename = $this->savepath . $this->filename . $type;
         $compress = defined('GOOGLE_SITEMAP_COMPRESS') ? GOOGLE_SITEMAP_COMPRESS : '0';
         if ($type == 'index') $compress = '0';
             switch($compress){
                 case '1':
                   $filename .= '.xml.gz';
                   if ($gz = gzopen($filename,'wb9')){
                       gzwrite($gz, $data);
                       gzclose($gz);
                       $this->debug['SAVE_FILE_COMPRESS'][] = array('file' => $filename, 'status' => 'success', 'file_exists' => '1');
                       return true;
                   } else {
                       $file_check = file_exists($filename) ? '1' : '0';
                       $this->debug['SAVE_FILE_COMPRESS'][] = array('file' => $filename, 'status' => 'failure', 'file_exists' => $file_check);
                       return false;
                   }
                   break;

                 default:
                   $filename .= '.xml';
                   if ($fp = fopen($filename, 'w+')){
                       fwrite($fp, $data);
                       fclose($fp);
                       $this->debug['SAVE_FILE_XML'][] = array('file' => $filename, 'status' => 'success', 'file_exists' => '1');
                       return true;
                   } else {
                       $file_check = file_exists($filename) ? '1' : '0';
                       $this->debug['SAVE_FILE_XML'][] = array('file' => $filename, 'status' => 'failure', 'file_exists' => $file_check);
                       return false;
                   }
                   break;

         }
     }


    /**
     * Function to compress a normal file
     *
     * @param string $file
     * @return boolean
     */
     function CompressFile($file)
     {
         $source = $this->savepath . $file . '.xml';
         $filename = $this->savepath . $file . '.xml.gz';
         $error_encountered = false;
         if ( $gz_out = gzopen($filename, 'wb9') ){
             if ($fp_in = fopen($source,'rb')){
                 while (!feof($fp_in)) gzwrite($gz_out, fread($fp_in, 1024*512));
                     fclose($fp_in);
             } else {
                 $error_encountered = true;
             }
             gzclose($gz_out);
         } else {
             $error_encountered = true;
         }
         if ($error_encountered){
             return false;
         } else {
             return true;
         }
     }


    /**
     * Function to generate sitemap file from data
     *
     * @param array $data
     * @param string $file
     */
     function GenerateSitemap($data, $file)
     {
         $content = '<?xml version="1.0" encoding="UTF-8"' . "\n";
         $content .= '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">' . "\n";
         foreach ($data as $url){
             $content .= "\t" . '<url>' . "\n";
             $content .= "\t\t" . '<loc>'.$url['loc'].'</loc>' . "\n";
             $content .= "\t\t" . '<lastmod>'.$url['lastmod'].'</lastmod>' . "\n";
             $content .= "\t\t" . '<changefreq>'.$url['changefreq'].'</changefreq>' . "\n";
             $content .= "\t\t" . '<priority>'.$url['priority'].'</priority>' . "\n";
             $content .= "\t" . '</url>' . "\n";
         }
         $content .= '</urlset>';
         return $this->SaveFile($content, $file);
    }


    /**
     * Function to generate sitemap index file
     *
     * @return boolean
     */
     function GenerateSitemapIndex()
     {
         $content = '<?xml version="1.0" encoding="UTF-8"' . "\n";
         $content .= '<sitemapindex xmlns="http://www.google.com/schemas/sitemap/0.84">' . "\n";
         $pattern = defined('GOOGLE_SITEMAP_COMPRESS')
                    ? GOOGLE_SITEMAP_COMPRESS == '1'
                    ? "{sitemap*.xml.gz}"
                      : "{sitemap*.xml}"
                      : "{sitemap*.xml}";
         foreach ( glob($this->savepath . $pattern, GLOB_BRACE) as $filename ) {
             if ( eregi('index', $filename) ) continue;
             $content .= "\t" . '<sitemap>' . "\n";
             $content .= "\t\t" . '<loc>'.$this->base_url . basename($filename).'</loc>' . "\n";
             $content .= "\t\t" . '<lastmod>'.date ("Y-m-d", filemtime($filename)).'</lastmod>' . "\n";
             $content .= "\t" . '</sitemap>' . "\n";
         }
         $content .= '</sitemapindex>';
         return $this->SaveFile($content, 'index');
    }


    /**
     * Function to generate product sitemap data
     *
     * @return boolean
     */
     function GenerateProductSitemap()
     {

         $dbconn =& oosDBGetConn();
         $oostable =& oosDBGetTables();

         $aPages = oos_get_pages();

         $productstable  = $oostable['products'];
         $sql = "SELECT products_id as pID, products_date_added as date_added,
                        products_last_modified as last_mod, products_ordered
                 FROM $productstable
                 WHERE products_status >= '1'
                   AND products_access = '0'
                 ORDER BY products_ordered DESC";

         if ( $products_query = $dbconn->Execute($sql) ){
             $this->debug['QUERY']['PRODUCTS']['STATUS'] = 'success';
             $this->debug['QUERY']['PRODUCTS']['NUM_ROWS'] = $products_query->RecordCount();
             $container = array();
             $number = 0;
             $top = 0;
             while ( $result = $products_query->fields )
             {

                 $top = max($top, $result['products_ordered']);
                 $location = oos_href_link($aPages['product_info'], 'products_id=' . $result['pID'], 'NONSSL', false, true);
                 $lastmod = !empty($result['last_mod']) ? $result['last_mod'] : $result['date_added'];
                 $changefreq = GOOGLE_SITEMAP_PROD_CHANGE_FREQ;
                 $ratio = $top > 0 ? $result['products_ordered']/$top : 0;
                 $priority = $ratio < .1 ? .1 : number_format($ratio, 1, '.', '');

                 $container[] = array('loc' => htmlspecialchars(utf8_encode($location)),
                                      'lastmod' => date ("Y-m-d", strtotime($lastmod)),
                                      'changefreq' => $changefreq,
                                      'priority' => $priority);
                 if ( count($container) >= 50000 ){
                     $type = $number == 0 ? 'products' : 'products' . $number;
                     $this->GenerateSitemap($container, $type);
                     $container = array();
                     $number++;
                 }

                 // Move that ADOdb pointer!
                 $products_query->MoveNext();
             }
             if ( count($container) > 1 ) {
                 $type = $number == 0 ? 'products' : 'products' . $number;
                 return $this->GenerateSitemap($container, $type);
             }
         } else {
             $this->debug['QUERY']['PRODUCTS']['STATUS'] = '0';
             $this->debug['QUERY']['PRODUCTS']['NUM_ROWS'] = '0';
         }
    }


    /**
     * Funciton to generate category sitemap data
     *
     * @return boolean
     */
     function GenerateCategorySitemap()
     {

         $dbconn =& oosDBGetConn();
         $oostable =& oosDBGetTables();

         $aPages = oos_get_pages();

         $categoriestable = $oostable['categories'];
         $sql = "SELECT categories_id as cID, date_added, last_modified as last_mod
                 FROM $categoriestable
                 WHERE categories_status = '1'
                   AND access = '0'
                 ORDER BY parent_id ASC, sort_order ASC, categories_id ASC";

         if ( $categories_query = $dbconn->Execute($sql) ){
             $this->debug['QUERY']['CATEOGRY']['STATUS'] = 'success';
             $this->debug['QUERY']['CATEOGRY']['NUM_ROWS'] = $categories_query->RecordCount();
             $container = array();
             $number = 0;
             while( $result = $categories_query->fields )
             {
                 $location = oos_href_link($aPages['shop'], 'categories=' . $this->GetFullcategories($result['cID']), 'NONSSL', false, true);
                 $lastmod = !empty($result['last_mod']) ? $result['last_mod'] : $result['date_added'];

                 $changefreq = GOOGLE_SITEMAP_CAT_CHANGE_FREQ;
                 $priority = .5;

                 $container[] = array('loc' => htmlspecialchars(utf8_encode($location)),
                                      'lastmod' => date ("Y-m-d", strtotime($lastmod)),
                                      'changefreq' => $changefreq,
                                      'priority' => $priority);
                 if ( count($container) >= 50000 ){
                     $type = $number == 0 ? 'categories' : 'categories' . $number;
                     $this->GenerateSitemap($container, $type);
                     $container = array();
                     $number++;
                 }

                 // Move that ADOdb pointer!
                 $categories_query->MoveNext();
             }

             if ( count($container) > 1 ) {
                 $type = $number == 0 ? 'categories' : 'categories' . $number;
                 return $this->GenerateSitemap($container, $type);
             }
         } else {
             $this->debug['QUERY']['CATEOGRY']['STATUS'] = '0';
             $this->debug['QUERY']['CATEOGRY']['NUM_ROWS'] = '0';
         }
    }


    /**
     * Function to retrieve full categories from category ID
     *
     * @param mixed $cID Could contain categories or single category_id
     * @return string Full categories string
     */
     function GetFullcategories($cID)
     {
         if ( preg_match('/_/', $cID) ){
             return $cID;
         } else {
             $c = array();
             $this->GetParentCategories($c, $cID);
             $c = array_reverse($c);
             $c[] = $cID;
             $cID = count($c) > 1 ? implode('_', $c) : $cID;
             return $cID;
        }
    }


    /**
     * Recursion function to retrieve parent categories from category ID
     *
     * @param mixed $categories Passed by reference
     * @param integer $categories_id
     */
     function GetParentCategories(&$categories, $categories_id)
     {

         $dbconn =& oosDBGetConn();
         $oostable =& oosDBGetTables();

         $categoriestable = $oostable['categories'];
         $sql = "SELECT parent_id
                 FROM $categoriestable
                 WHERE categories_id='" . intval($categories_id) . "'";
         $parent_categories_query =  $dbconn->Execute($sql);

         while ($parent_categories = $parent_categories_query->fields)
         {
             if ($parent_categories['parent_id'] == 0) return true;
             $categories[count($categories)] = $parent_categories['parent_id'];
             if ($parent_categories['parent_id'] != $categories_id) {
                 $this->GetParentCategories($categories, $parent_categories['parent_id']);
             }

             // Move that ADOdb pointer!
             $parent_categories_query->MoveNext();
        }
    }


    /**
     * Utility function to read and return the contents of a GZ formatted file
     *
     * @param string $file File to open
     * @return string
     */
     function ReadGZ( $file )
     {
         $file = $this->savepath . $file;
         $lines = gzfile($file);
         return implode('', $lines);
    }


    /**
     * Utility function to generate the submit URL
     *
     * @return string
     */
     function GenerateSubmitURL()
     {
         $url = urlencode($this->base_url . 'sitemapindex.xml');
         return htmlspecialchars(utf8_encode('http://www.google.com/webmasters/sitemaps/ping?sitemap=' . $url));
     }

}

