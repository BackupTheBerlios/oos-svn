<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: customers.php,v 1.13 2002/06/15 12:19:14 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
   
define('HEADING_TITLE', 'Kunden');
define('HEADING_TITLE_SEARCH', 'Suche:');

define('TABLE_HEADING_FIRSTNAME', 'Vorname');
define('TABLE_HEADING_LASTNAME', 'Nachname');
define('TABLE_HEADING_ACCOUNT_CREATED', 'Zugang erstellt am');
define('TABLE_HEADING_ACTION', 'Aktion');
define('HEADING_TITLE_STATUS', 'Status:');
define('TEXT_ALL_CUSTOMERS', 'Alle Kunden');
define('HEADING_TITLE_LOGIN', 'Zugang');

define('TEXT_INFO_HEADING_STATUS_CUSTOMER', 'Kundenstatus &auml;ndern');
define('TEXT_NO_CUSTOMER_HISTORY', 'Keine Kundenstatus History vorhanden');
define('TABLE_HEADING_NEW_VALUE', 'Neuer Status');
define('TABLE_HEADING_OLD_VALUE', 'Alter Status');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Kunde benachrichtigt');
define('TABLE_HEADING_DATE_ADDED', 'Hinzugef&uuml;gt am:');

define('CATEGORY_MAX_ORDER', 'Max. Bestellwert');
define('ENTRY_MAX_ORDER', 'Kundenkredit:');


define('TEXT_DATE_ACCOUNT_CREATED', 'Zugang erstellt am:');
define('TEXT_DATE_ACCOUNT_LAST_MODIFIED', 'letzte &Auml;nderung:');
define('TEXT_INFO_DATE_LAST_LOGON', 'letzte Anmeldung:');
define('TEXT_INFO_NUMBER_OF_LOGONS', 'Anzahl der Anmeldungen:');
define('TEXT_INFO_COUNTRY', 'Land:');
define('TEXT_INFO_NUMBER_OF_REVIEWS', 'Anzahl der Artikelbewertungen:');
define('TEXT_DELETE_INTRO', 'Wollen Sie diesen Kunden wirklich l&ouml;schen?');
define('TEXT_DELETE_REVIEWS', '%s Bewertung(en) l&ouml;schen');
define('TEXT_INFO_HEADING_DELETE_CUSTOMER', 'Kunden l&ouml;schen');
define('TYPE_BELOW', 'Bitte unten eingeben');
define('PLEASE_SELECT', 'Ausw&auml;hlen');

define('EMAIL_SUBJECT', 'Bienvenu chez' . STORE_NAME);
define('EMAIL_GREET_MR', 'Monsieur');
define('EMAIL_GREET_MS', 'Madame');
define('EMAIL_GREET_NONE', 'Madame, Monsieur,');
define('EMAIL_WELCOME', 'bienvenu chez<b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'Maintenant vous pouvez utiliser notre<b>Online-Service</b>Ce service vous offre entre autres:' . "\n\n" . '<li><b>Panier client pour les produits</b> - Chaque article reste enregistré  	jusqu\'au moment ou vous allez à là caisse, ou vous enlevez les produits dans le panier.' . "\n" . '<li><b>Répertoire d\'adresses</b> - Nous pouvons maintenant envoyer les produits à votre adresse indiquée. Une manière parfaite pour envoyer un  cadeau.' . "\n" . '<li><b>Commande précédemment</b> - Vous pouvez vérifier à tout moment votres commandes passées' . "\n" . '<li><b>Opinion sur produits</b> - Partagez votre opinion avec des autres clients sur notre produits.' . "\n\n");
define('EMAIL_CONTACT', 'Si vous avez des questions concernant notre service après-vente vous vous adressez s.v.p. à notre distribution: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Attention:</b> Cet adresse e-mail nous a été donné par un client. Si vous vous n\'avez pas inscrit, envoyez nous un message par e-mail à' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('EMAIL_PASSWORD_BODY', 'Votre mot de passe est:' . "\n\n" . '   %s' . "\n\n");

define('EMAIL_GV_INCENTIVE_HEADER', 'Um f&uuml;r Sie als Neukunden zu begr&uuml;ssen, haben wir Ihnen einen Gutschein &uuml;ber %s gesendet.');
define('EMAIL_GV_REDEEM', 'Der Gutscheincode lautet: %s. Sie k&ouml;nnen diesen, beim Abschluss Ihrer Bestellung eingeben');
define('EMAIL_GV_LINK', 'Oder Sie benutzen den folgenden Link: ');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Herzlichen Gl&uuml;ckwunsch! Um den ersten Besuch in unserm Shop attraktiver zu machen erhalten Sie diesen Gutschein!' . "\n" .
                                        'Es folgen weitere Details &uuml;ber Ihren pers&ouml;nlichen Einkaufsgutschein.' . "\n\n");
define('EMAIL_COUPON_REDEEM', 'Um den Einkaufsgutschein zu nutzen geben Sie bitte den Gutscheincode %s ' . "\n" .
                               'beim Beenden Ihrer Bestellung ein!');
?>
