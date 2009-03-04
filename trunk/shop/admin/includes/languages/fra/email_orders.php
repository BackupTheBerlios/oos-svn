<?php
/* ----------------------------------------------------------------------
   $Id: email_orders.php,v 1.1 2005/10/14 15:04:01 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: orders.php,v 1.27 2003/02/16 02:09:20 harley_vb 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Modification d\'�tat de votre commande');
define('EMAIL_TEXT_ORDER_NUMBER', 'Num�ro de commande:');
define('EMAIL_TEXT_INVOICE_URL', 'Votre commande peut �tre compuls� sous l\'adresse:');
define('EMAIL_TEXT_DATE_ORDERED', 'Date de commande:');
define('EMAIL_TEXT_STATUS_UPDATE', 'L\'�tat de votre commande a �t� chang�.' . "\n\n" . 'Nouveau �tat: <b>%s</b>' . "\n\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Remarque et commentaire � votre commande: %s');
define('EMAIL_TEXT_THANKS', 'Si vous avez des questions concernant votre commande r�pondez s.v.p. � cet e-mail.' . "\n\n" . 'Meilleures salutations' . "\n" . 'Team Lensvision' . "\n");

?>
