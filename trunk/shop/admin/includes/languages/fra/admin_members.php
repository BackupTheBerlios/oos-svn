<?php
/* ----------------------------------------------------------------------
   $Id: admin_members.php,v 1.1 2005/10/14 15:04:01 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: admin_members.php,v 1.13 2002/08/19 01:45:58 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

if ($_GET['gID']) {
  define('HEADING_TITLE', 'redaktionelle Gruppen');
} elseif ($_GET['gPath']) {
  define('HEADING_TITLE', 'Gruppe anlegen');
} else {
  define('HEADING_TITLE', 'Redaktionsmitglieder');
}

define('TEXT_COUNT_GROUPS', 'Gruppen: ');

define('TABLE_HEADING_NAME', 'Name');
define('TABLE_HEADING_EMAIL', 'Email-Adresse');
define('TABLE_HEADING_PASSWORD', 'Passwort');
define('TABLE_HEADING_CONFIRM', 'Passwort best&auml;tigen');
define('TABLE_HEADING_GROUPS', 'Gruppenstufe');
define('TABLE_HEADING_CREATED', 'Konto angelegt');
define('TABLE_HEADING_MODIFIED', 'Konto angelegt');
define('TABLE_HEADING_LOGDATE', 'Letzter Zugriff');
define('TABLE_HEADING_LOGNUM', 'Anmeldenr');
define('TABLE_HEADING_LOG_NUM', 'Anmeldenummer');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TABLE_HEADING_GROUPS_NAME', 'Gruppenname');
define('TABLE_HEADING_GROUPS_DEFINE', 'Bereichs- und Dateiauswahl');
define('TABLE_HEADING_GROUPS_GROUP', 'Stufe');
define('TABLE_HEADING_GROUPS_CATEGORIES', 'Kategorie Erlaubnis');


define('TEXT_INFO_HEADING_DEFAULT', 'Redaktionsmitglieder ');
define('TEXT_INFO_HEADING_DELETE', ' Genehmigung zum l&ouml;schen');
define('TEXT_INFO_HEADING_EDIT', 'Editiere Kategorie / ');
define('TEXT_INFO_HEADING_NEW', 'Neues Redaktionsmitglied ');

define('TEXT_INFO_DEFAULT_INTRO', 'Mitarbeitergruppe');
define('TEXT_INFO_DELETE_INTRO', 'Soll <nobr><b>%s</b></nobr> jetzt als <nobr>Redaktionsmitglied<br /> gel&ouml;scht werden?</nobr>');
define('TEXT_INFO_DELETE_INTRO_NOT', 'Sie k&ouml;nnen <nobr>%s Gruppe nicht l&ouml;schen !</nobr>');
define('TEXT_INFO_EDIT_INTRO', 'Legen Sie hier die Erlaubnisstufe an: ');

define('TEXT_INFO_FULLNAME', 'Name: ');
define('TEXT_INFO_FIRSTNAME', 'Vorname: ');
define('TEXT_INFO_LASTNAME', 'Nachname: ');
define('TEXT_INFO_EMAIL', 'Email Adresse: ');
define('TEXT_INFO_PASSWORD', 'Passwort: ');
define('TEXT_INFO_CONFIRM', 'Passwort best&auml;igen: ');
define('TEXT_INFO_CREATED', 'Konto angelegt: ');
define('TEXT_INFO_MODIFIED', 'Konto ver&auml;ndert: ');
define('TEXT_INFO_LOGDATE', 'Letzter Zugriff: ');
define('TEXT_INFO_LOGNUM', 'Zugriffs-Nummer: ');
define('TEXT_INFO_GROUP', 'Gruppenstufe: ');
define('TEXT_INFO_ERROR', '<font color="red">Email Adresse wird schon verwendet! Versuchen Sie es erneut.</font>');

define('JS_ALERT_FIRSTNAME', '- Ben&ouml;tigt: Vorname \n');
define('JS_ALERT_LASTNAME', '- Ben&ouml;tigt: Lastname \n');
define('JS_ALERT_EMAIL', '- Ben&ouml;tigt: Email Adresse \n');
define('JS_ALERT_EMAIL_FORMAT', '- Email Adressenformat ist ung&uuml;ltig! \n');
define('JS_ALERT_EMAIL_USED', '- Email Adresse wird schon verwendet! \n');
define('JS_ALERT_LEVEL', '- Ben&ouml;tigt: Gruppenmitglied \n');

define('ADMIN_EMAIL_SUBJECT', 'Neues Redaktionsmitglied');
define('ADMIN_EMAIL_TEXT', 'Hallo %s,' . "\n\n" . 'Sie k&ouml;nnen auf den Redaktionsbereich mit dem folgenden Passwort ' . "\n" . 'zugreifen. Wenn Sie einmal auf den Redaktionsbereich zugegriffen haben,' . "\n" . ' &auml;ndern Sie bitte Ihr Passwort!' . "\n\n" . 'Website : %s' . "\n" . 'Benutzername: %s' . "\n" . 'Passwort: %s' . "\n\n" . 'Danke!' . "\n" . '%s' . "\n\n" . 'Bitte nicht auf diese Nachricht antworten, da sie automatisch generiert wurde und nur Ihrer Information dient.'); 

define('TEXT_INFO_HEADING_DEFAULT_GROUPS', 'Redaktionsgruppe ');
define('TEXT_INFO_HEADING_DELETE_GROUPS', 'L&ouml;sche Gruppe ');

define('TEXT_INFO_DEFAULT_GROUPS_INTRO', '<b>HINWEIS:</b><li><b>bearbeiten:</b> bearbeite Gruppenname.</li><li><b>l&ouml;schen:</b> Gruppe l&ouml;schen.</li><li><b>Definieren:</b> Definieren Sie die Gruppenzugriffsrechte.</li>');
define('TEXT_INFO_DELETE_GROUPS_INTRO', 'Es wird auch s&auml;mtliche Mitglieder dieser Gruppe l&ouml;schen. Sind Sie sicher das Sie diese <nobr><b>%s</b> Gruppe l&ouml;schen wollen?</nobr>');
define('TEXT_INFO_DELETE_GROUPS_INTRO_NOT', 'Sie k&ouml;nnen diese Gruppe nicht l&ouml;schen!');
define('TEXT_INFO_GROUPS_INTRO', 'Vergeben Sie einen einmaligen Gruppennamen. Klicken Sie weiter zur &Uuml;bertragung.');

define('TEXT_INFO_HEADING_GROUPS', 'Neue Gruppe');
define('TEXT_INFO_HEADING_EDIT_GROUP', 'Gruppenname &auml;ndern');
define('TEXT_INFO_EDIT_GROUP_INTRO', 'Geben Sie den neuen Gruppennamen ein.');
define('TEXT_INFO_GROUPS_NAME', ' <b>Gruppenname:</b><br />Vergeben Sie einen einmaligen Gruppennamen. Dann klicken Sie N&auml;chster zur &Uuml;bermittlung.<br />');
define('TEXT_INFO_GROUPS_NAME_FALSE', '<font color="red"><b>FEHLER:</b> Der Gruppenname muss aus mindestens 5 Buchstaben bestehen!</font>');
define('TEXT_INFO_GROUPS_NAME_USED', '<font color="red"><b>FEHLER:</b> Gruppenname wird schon verwendet!</font>');
define('TEXT_INFO_GROUPS_LEVEL', 'Gruppenstufe: ');
define('TEXT_INFO_GROUPS_BOXES', '<b>Bereichserlaubnis:</b><br />Zugriff auf die ausgew&auml;hlten Bereiche vergeben.');
define('TEXT_INFO_GROUPS_BOXES_INCLUDE', 'Beinhaltet gespeicherte Daten in: ');

define('TEXT_INFO_HEADING_DEFINE', 'Definiere Gruppe');
if ($_GET['gPath'] == 1) {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br />Sie k&ouml;nnen nicht die Zugriffsberechtigungen f&uuml;r diese Gruppe vergeben.<br /><br />');
} else {
  define('TEXT_INFO_DEFINE_INTRO', '<b>%s :</b><br />&Auml;ndern Sie die Zugriffsberechtigungen f&uuml;r diese Gruppe und die darin befindlichen Dateien, indem Sie die Bereiche ausw&auml;hlen/abw&auml;hlen. Klicken Sie <b>speichern</b> um die &Auml;nderungen zu sichern.<br /><br />');
}
?>
