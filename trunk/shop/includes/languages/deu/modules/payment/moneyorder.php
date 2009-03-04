<?php
/* ----------------------------------------------------------------------
   $Id: moneyorder.php,v 1.12 2008/08/12 09:07:27 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: moneyorder.php,v 1.8 2003/02/16 01:12:22 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE', 'Scheck/Vorkasse Modul aktivieren');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC', 'M&ouml;chten Sie die Bezahlung per Scheck/Vorkasse akzeptieren?');

define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE', 'Zahlbar an:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC', 'An wen sollen Zahlungen erfolgen?');

define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');

define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');

define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC', 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen.');

$aLang['module_payment_moneyorder_text_title'] = 'Scheck/Vorkasse';
$aLang['module_payment_moneyorder_text_description'] = 'Zahlbar an:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br />Adressat:<br /><br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . 'Die Ware wird ausgeliefert wenn der Betrag auf unserem Konto eingegangen ist.';
$aLang['module_payment_moneyorder_text_email_footer'] = "Zahlbar an: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nAdressat:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Die Ware wird ausgeliefert wenn der Betrag auf unserem Konto eingegangen ist.';

?>
