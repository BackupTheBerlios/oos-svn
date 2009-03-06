<?php
/* ----------------------------------------------------------------------
   $Id$

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

define('HEADING_TITLE', 'Comptes de rédaction');

define('TABLE_HEADING_ACCOUNT', 'Mon compte');

define('TEXT_INFO_FULLNAME', '<b>Nom: </b>');
define('TEXT_INFO_FIRSTNAME', '<b>Prénom: </b>');
define('TEXT_INFO_LASTNAME', '<b>Nom de famille: </b>');
define('TEXT_INFO_EMAIL', '<b>Adresse email: </b>');
define('TEXT_INFO_PASSWORD', '<b>Mot de passe: </b>');
define('TEXT_INFO_PASSWORD_HIDDEN', '-Caché-');
define('TEXT_INFO_PASSWORD_CONFIRM', '<b>Confirmez le mot de passe: </b>');
define('TEXT_INFO_CREATED', '<b>compte créé: </b>');
define('TEXT_INFO_LOGDATE', '<b>Dernier accès: </b>');
define('TEXT_INFO_LOGNUM', '<b>Numéro d\'accès: </b>');
define('TEXT_INFO_GROUP', '<b>Niveau du goupe: </b>');
define('TEXT_INFO_ERROR', '<font color="red">Adresse e-mail est déjà utilisée! Essayez le de nouveau.</font>');
define('TEXT_INFO_MODIFIED', 'Modifié: ');

define('TEXT_INFO_HEADING_DEFAULT', 'Traiter mon compt');
define('TEXT_INFO_HEADING_CONFIRM_PASSWORD', 'Confirmation du mot de passe');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD', 'Mot de passe:');
define('TEXT_INFO_INTRO_CONFIRM_PASSWORD_ERROR', '<font color="red"><b>FEHLER:</b>Mot de passe est faux!</font>');
define('TEXT_INFO_INTRO_DEFAULT', 'Cliquez le<b>bouton traiter</b> en bas pour editer le compte.');
define('TEXT_INFO_INTRO_DEFAULT_FIRST_TIME', '<br /><b>ATTENTION:</b><br />Bonjour<b>%s</b>, vous vous êtes inscrit pour la premier fois. Nous vous recommendons de changer votre mot de passe!');
define('TEXT_INFO_INTRO_DEFAULT_FIRST', '<br /><b>ATTENTION:</b><br />Bonjour<b>%s</b>, nous vous recommendons de changer votre adresse e-mail(<font color="red">admin@localhost</font>) et votre mot de passe!');
define('TEXT_INFO_INTRO_EDIT_PROCESS', 'Tous les champs seront utilisé. Cliquez AFFIRMER pour retransmettre les données.');

define('JS_ALERT_FIRSTNAME',        '- Besoin de: Prénom \n');
define('JS_ALERT_LASTNAME',         '- Besoin de: Nom de famille \n');
define('JS_ALERT_EMAIL',            '- Besoin de: Adresse e-mail \n');
define('JS_ALERT_PASSWORD',         '- Besoin de: Mot de passe\n');
define('JS_ALERT_FIRSTNAME_LENGTH', '- La longueur du prénom par');
define('JS_ALERT_LASTNAME_LENGTH',  '- La longueur du nom de famille par');
define('JS_ALERT_PASSWORD_LENGTH',  '- La longueur du mot de passe par');
define('JS_ALERT_EMAIL_FORMAT',     '- Ce format d\'adresse email est non valide! \n');
define('JS_ALERT_EMAIL_USED',       '- Cette adresse e-mail est déjà utilisée! \n');
define('JS_ALERT_PASSWORD_CONFIRM', '- Dans le secteur d\'activité pour le mot de passe il n\'y a pas un entérinement effectué! \n');

?>
