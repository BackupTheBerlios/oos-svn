<?php
/* ----------------------------------------------------------------------
   $Id: checkout_success.php,v 1.5 2007/05/07 09:16:12 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/


   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_success.php,v 1.17 2003/02/16 00:42:03 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title_1'] = 'Kasa';
$aLang['navbar_title_2'] = 'Sukces';

$aLang['heading_title'] = 'Dzi�ujemy!';

$aLang['text_success'] = 'Twoje zamowienie zostao przyj�e i jest opracowywane! Wysyka w cigu 2-5 dni roboczych.';
$aLang['text_notify_products'] = 'Prosz�mnie poinformowa�o aktualnociach do podanych produkt�:';
$aLang['text_see_orders'] = 'Moesz zawsze zobaczy�swoje zam�ienie(a) na stronie <a href="' . oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL') . '"><u>\'Moje konto\'</a></u>  i te zestawienie swoich <a href="' . oos_href_link($aModules['account'], $aFilename['account_history'], '', 'SSL') . '"><u>\'zam�ie�'</u></a> .';
$aLang['text_contact_store_owner'] = 'Jak masz pytania w sprawie swoich zam�ie� prosimy o kontakt z naszym <a href="' . oos_href_link($aModules['main'], $aFilename['contact_us']) . '"><u>dziaem zbytu</u></a>.';
$aLang['text_thanks_for_shopping'] = 'Dzi�ujemy za Twoje zam�ienie!';

$aLang['table_heading_download_date'] = 'Mona cign�do:';
$aLang['table_heading_download_count'] = 'max. ilo�cigni�';
$aLang['heading_download'] = 'cignij produkty:';
$aLang['footer_download'] = 'Moesz te p�iej cign�swoje produkty pod \'%s\' ';
?>
