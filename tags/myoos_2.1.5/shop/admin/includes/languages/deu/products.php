<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: categories.php,v 1.22 2002/08/17 09:43:33 project3000
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('TEXT_NEW_PRODUCT', 'Neuer Artikel in &quot;%s&quot;');
define('TEXT_PRODUCTS', 'Artikel:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Preis:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Steuerklasse:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'durchschnittl. Bewertung:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Anzahl:');
define('TEXT_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_IMAGE_NONEXISTENT', 'BILD EXISTIERT NICHT');
define('TEXT_PRODUCT_MORE_INFORMATION', 'F&uuml;r weitere Informationen, besuchen Sie bitte die <a href="http://%s" target="blank"><u>Homepage</u></a> des Herstellers.');
define('TEXT_PRODUCT_DATE_ADDED', 'Diesen Artikel haben wir am %s in unseren Katalog aufgenommen.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Dieser Artikel ist erh&auml;ltlich ab %s.');

define('TEXT_TAX_INFO', 'Netto:');
define('TEXT_PRODUCTS_LIST_PRICE', 'empf VK:');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED', 'Discountmaximum:');

define('TEXT_PRODUCTS_BASE_PRICE', 'Grundpreis ');
define('TEXT_PRODUCTS_BASE_UNIT', 'Grundgr&ouml;&szlig;e:');
define('TEXT_PRODUCTS_BASE_PRICE_FACTOR', 'Faktor zum Berechnen des Grundpreis:');
define('TEXT_PRODUCTS_BASE_QUANTITY', 'Basismenge:');
define('TEXT_PRODUCTS_PRODUCT_QUANTITY', 'Artikelmenge:');
define('TEXT_PRODUCTS_DECIMAL_QUANTITY', 'Bestellmengen in Dezimalzahlen');
define('TEXT_PRODUCTS_UNIT', 'Verpackungseinheit');

define('TEXT_PRODUCTS_IMAGE_REMOVE', '<b>Entfernen</b> des Bildes vom Artikel?');
define('TEXT_PRODUCTS_IMAGE_DELETE', '<b>L&ouml;schen</b> des Bildes vom Server?');
define('TEXT_PRODUCTS_ZOOMIFY', 'Zoomify');

define('TEXT_PRODUCTS_STATUS', 'Produktstatus:');
define('TEXT_CATEGORIES', 'Kategorien:');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Erscheinungsdatum:');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'nicht lieferbar');
define('TEXT_PRODUCTS_MANUFACTURER', 'Artikel-Hersteller:');
define('TEXT_PRODUCTS_NAME', 'Artikelname:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Artikelbeschreibung:');
define('TEXT_PRODUCTS_DESCRIPTION_META', 'Artikelbeschreibung f&uuml;r Description Tag (max. 250 Zeichen)');
define('TEXT_PRODUCTS_KEYWORDS_META', 'Artikel Suchworte f&uuml;r Keyword Tag (Stichworte durch Komma getrennt - max. 250 Zeichen)');
define('TEXT_PRODUCTS_QUANTITY', 'Artikelanzahl:');
define('TEXT_PRODUCTS_REORDER_LEVEL', 'Mindestlagerbestand:');
define('TEXT_PRODUCTS_MODEL', 'Artikel-Nr.:');
define('TEXT_PRODUCTS_EAN', 'EAN :');
define('TEXT_PRODUCTS_IMAGE', 'Artikelbild:');
define('TEXT_PRODUCTS_URL', 'Herstellerlink:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '<small>(ohne f&uuml;hrendes http://)</small>');
define('TEXT_PRODUCTS_PRICE', 'Artikelpreis:');
define('TEXT_PRODUCTS_WEIGHT', 'Artikelgewicht:');
define('TEXT_PRODUCTS_SORT_ORDER', 'Sort Order:');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Fehler: Produkte k&ouml;nnen nicht in der gleichen Kategorie verlinkt werden.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Verzeichnis \'images\' im Katalogverzeichnis ist schreibgesch&uuml;tzt: ' . OOS_ABSOLUTE_PATH . OOS_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Verzeichnis \'images\' im Katalogverzeichnis ist nicht vorhanden: ' . OOS_ABSOLUTE_PATH . OOS_IMAGES);
?>
