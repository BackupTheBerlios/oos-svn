<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: coupon_restrict.php,v 1.1.2.1 2003/05/10 16:10:21 wilt 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com
 
   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('TOP_BAR_TITLE', 'Statistiek');
define('HEADING_TITLE', 'Tegoedbonnen');
define('HEADING_TITLE_STATUS', 'Status : ');
define('TEXT_CUSTOMER', 'Klant:');
define('TEXT_COUPON', 'Tegoedbon naam');
define('TEXT_COUPON_ALL', 'Alle tegoedbonnen');
define('TEXT_COUPON_ACTIVE', 'Actieve tegoedbonnen');
define('TEXT_COUPON_INACTIVE', 'Inactieve tegoedbonnen');
define('TEXT_SUBJECT', 'Onderwerp:');
define('TEXT_FROM', 'Van:');
define('TEXT_FREE_SHIPPING', 'Franco verzending');
define('TEXT_MESSAGE', 'Mededeling:');
define('TEXT_SELECT_CUSTOMER', 'Selecteer klant');
define('TEXT_ALL_CUSTOMERS', 'Alle klanten');
define('TEXT_NEWSLETTER_CUSTOMERS', 'Aan alle nieuwsbriefabonnees');
define('TEXT_CONFIRM_DELETE', 'Weet u zeker dat u deze tegoedbon wilt verwijderen?');
define('TEXT_TO_REDEEM', 'U kan deze tegoedbon inwisselen bij de het afrekenen aan de kassa. Voer de tegoedboncode in in het veld en klik op de inwisselknop.');
define('TEXT_IN_CASE', ' in het geval dat u problemen hebt. ');
define('TEXT_VOUCHER_IS', 'De tegoedboncode is ');
define('TEXT_REMEMBER', 'Raak de tegoedboncode niet kwijt, verzeker u van een veilige bewaarplaats anders kan u geen gebruik maken van deze speciala aanbieding.');
define('TEXT_VISIT', 'als u ' . OOS_HTTP_SERVER . OOS_SHOP . ' bezoekt.');
define('TEXT_ENTER_CODE', ' en voer de code in ');

define('TABLE_HEADING_ACTION', 'Actie');

define('NOTICE_EMAIL_SENT_TO', 'ATTENTIE: Er werd een email verstuurd aan: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'FOUT: U hebt geen klant geselecteerd.');
define('COUPON_NAME', 'Tegoedbon naam');
//define('COUPON_VALUE', 'Coupon Value');
define('COUPON_AMOUNT', 'Tegoedbon bedrag');
define('COUPON_CODE', 'Tegoedbon code');
define('COUPON_STARTDATE', 'Startdatum');
define('COUPON_FINISHDATE', 'Einddatum');
define('COUPON_FREE_SHIP', 'Franco');
define('COUPON_DESC', 'Tegoedbon beschrijving');
define('COUPON_MIN_ORDER', 'Tegoedbon minimaal  bestelbedrag');
define('COUPON_USES_COUPON', 'Tegoegbon hoe vaak inwisselbaar?');
define('COUPON_USES_USER', 'Tegoedbon per klant?');
define('COUPON_PRODUCTS', 'Geaccepteerde producten');
define('COUPON_CATEGORIES', 'Geaccepteerde categori&euml;en');
define('VOUCHER_NUMBER_USED', 'Te gebruiken nummers');
define('DATE_CREATED', 'Afgiftedatum');
define('DATE_MODIFIED', 'Veranderdatum');
define('TEXT_HEADING_NEW_COUPON', 'Geeft nieuwe tegoedbon uit');
define('TEXT_NEW_INTRO', 'Geef a.u.b. de navolgende informatie in, om een nieuwe tegoedbon uit te geven.<br />');


define('COUPON_NAME_HELP', 'Een korte benaming voor de tegoedbon.');
define('COUPON_AMOUNT_HELP', 'Geef het bedrag van de tegoedbon aan. Danwel een bepaald bedrag of een procenteken (%) aan het eind voor een procentuele korting.');
define('COUPON_CODE_HELP', 'U kan hier een tegoedboncode ingeven, of het veld leeg laten. Er wordt dan een automatisch gegenereerde tegoedboncode gebruikt.');
define('COUPON_STARTDATE_HELP', 'Vanaf wanneer is de tegoedbon geldig? ');
define('COUPON_FINISHDATE_HELP', 'Tot wanneer is de tegoedbon geldig? ');
define('COUPON_FREE_SHIP_HELP', 'Voor deze tegoedbon kan de klant franco bestellen! Let er a.u.b. op: De keuze overschrijft het tegoedbedrag, houdt echter rekening met het minimale bestelbedrag!');
define('COUPON_DESC_HELP', 'Een tegoedbon beschrijving voor de klant');
define('COUPON_MIN_ORDER_HELP', 'Een minimaal bestelbedrag ingeven. Onder dit bedrag wordt de tegoedbon niet ingewisselt!');
define('COUPON_USES_COUPON_HELP', 'Hoe vaak kan de tegoedbon gebruikt worden? Mag het aantal ongelimiteerd zijn, laat dan het veld leeg.');
define('COUPON_USES_USER_HELP', 'Hoe vaak kan een klant een tegoedbon gebruiken? Mag het aantal ongelimiteerd zijn, laat dan het veld leeg.');
define('COUPON_PRODUCTS_HELP', 'Een lijst van toegestane product-IDs (door een komma gescheiden). Laat het veld leeg, als u geen beperkingen instellen wil.');
define('COUPON_CATEGORIES_HELP', 'Een lijst van toegestane categori&euml;en (door een komma gescheiden). Laat het veld leeg, als u geen beperkingen instellen wil.');
?>
