<?php
/* ----------------------------------------------------------------------
   $Id: user_create_account_process.php,v 1.22 2007/11/04 17:41:57 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account_process.php,v 1.15 2003/02/16 00:42:03 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title_1'] = 'Konto erstellen';
$aLang['navbar_title_2'] = 'Bearbeitung';
$aLang['heading_title'] = 'Informationen zu Ihrem Kundenkonto';

$aLang['email_subject'] = 'Willkommen zu ' . STORE_NAME;
$aLang['email_greet_mr'] = 'Sehr geehrter Herr ' . stripslashes($lastname) . ',' . "\n\n";
$aLang['email_greet_ms'] = 'Sehr geehrte Frau ' . stripslashes($lastname) . ',' . "\n\n";
$aLang['email_greet_none'] = 'Sehr geehrte ' . stripslashes($firstname) . ',' . "\n\n";
$aLang['email_welcome'] = 'willkommen zu <b>' . STORE_NAME . '</b>.' . "\n\n";
$aLang['email_text'] = 'Sie k�nnen jetzt unseren <b>Online-Service</b> nutzen. Der Service bietet unter anderem:' . "\n\n" . '<li><b>Kundenwarenkorb</b> - Jeder Artikel bleibt registriert bis Sie zur Kasse gehen, oder die Produkte aus dem Warenkorb entfernen.' . "\n" . '<li><b>Adressbuch</b> - Wir k�nnen jetzt die Produkte zu der von Ihnen ausgesuchten Adresse senden. Der perfekte Weg ein Geburtstagsgeschenk zu versenden.' . "\n" . '<li><b>Vorherige Bestellungen</b> - Sie k�nnen jederzeit Ihre vorherigen Bestellungen �berpr�fen.' . "\n" . '<li><b>Meinungen �ber Produkte</b> - Teilen Sie Ihre Meinung zu unseren Produkten mit anderen Kunden.' . "\n\n";
$aLang['email_contact'] = 'Falls Sie Fragen zu unserem Kunden-Service haben, wenden Sie sich bitte an den Vertrieb: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n";
$aLang['email_warning'] = '<b>Achtung:</b> Diese eMail-Adresse wurde uns von einem Kunden bekannt gegeben. Falls Sie sich nicht angemeldet haben, senden Sie bitte eine eMail an ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n";

$aLang['email_gv_incentive_header'] = 'Um Sie als Neukunden zu begr��en, haben wir Ihnen einen Gutschein �ber %s gesendet.';
$aLang['email_gv_redeem'] = 'Der Gutscheincode lautet: %s. Sie k�nnen diesen, beim Abschlu� Ihrer Bestellung eingeben';
$aLang['email_gv_link'] = 'Oder Sie benutzen den folgenden Link: ';
$aLang['email_coupon_incentive_header'] = 'Herzlichen Gl�ckwunsch! Um den ersten Besuch in unserm Shop attraktiver zu machen erhalten Sie diesen Gutschein!' . "\n" .
                                         'Es folgen weitere Details �ber Ihren pers�nlichen Einkaufsgutschein.' . "\n\n";
$aLang['email_coupon_redeem'] = 'Um den Einkaufsgutschein zu nutzen geben Sie bitte den Gutscheincode %s ' . "\n" .
                               'beim Beenden Ihrer Bestellung ein!';

$aLang['email_welcome_points'] = '<li><b>Reward Point Program</b> - As part of our Welcome to new customers, we have credited your %s with a total of %s Shopping Points.' . "\n" . 'Please refer to the %s as conditions may apply.';
$aLang['email_points_account'] = 'Shopping Points Accout';
$aLang['email_points_faq'] = 'Reward Point Program FAQ';

$aLang['email_password'] = 'Ihr Passwort f�r \'' . STORE_NAME . '\' lautet:' . "\n\n" . '   %s' . "\n\n";


$aLang['email_disclaimer'] = '--- Disclaimer ------------------------------------------------------------ ' . "\n\n" .
                            'Ihre Privatsph�re:' . "\n\n" .
                            'Wir verpflichten uns Ihre Daten (Name, E-Mail etc.) in keinem Fall an' . "\n" .
                            'dritte Parteien weitergegeben, sofern dieses nicht rechtlich erzwungen' . "\n" .
                            'wird. Ausser dass diese Weitergabe illegal w�re, sehen wir darin keine' . "\n" .
                            'Bereicherung f�r Sie oder f�r uns. Ihr Name und E-Mail-Adresse sind aber' . "\n" .
                            'nat�rlich f�r alle sichtbar, die Ihre Beitr�ge auf ' . oos_server_get_base_url() . ' lesen.' . "\n" .
                            'Da die Kommunikation und Anmeldung im World Wide Web in vielen F�llen' . "\n" .
                            'unverschl�sselt erfolgt, so dass auch Ihr Benutzername und Ihr Passwort' . "\n" .
                            'f�r andere lesbar �bertragen werden, benutzen Sie f�r den Zugang' . "\n" .
                            'zu ' . oos_server_get_base_url() . ' sicherheitshalber eine andere' . "\n" .
                            'Benutzername/Passwort-Kombination als die, die z.B. Zugriff zu Ihrem' . "\n" .
                            'pers�nlichen Computer gestattet.' . "\n\n" .
                            'Sie haben diese E-Mail nicht angefordert?' . "\n\n" .
                            'Diese E-Mail wurde am ' . strftime(DATE_FORMAT_LONG) . ' von der IP ' . oos_server_get_remote() . ' ' . oos_server_get_var('REMOTE_HOST') . ' ' . "\n" .
                            'initiiert. Falls das nicht Ihre (auch tempor�re) IP Adresse ist, l�schen' . "\n" .
                            'Sie diese E-Mail nicht, und wenden sich bitte freundlich an den' . "\n" .
                            'verantwortlichen Webmaster unter ' . STORE_OWNER_EMAIL_ADDRESS . '. Dieser kann Ihnen' . "\n" .
                            'in dem meisten F�llen weiterhelfen. Sollte Ihnen diese Hilfe nicht' . "\n" .
                            'ausreichend erscheinen, wenden Sie sich bitte direkt an den Provider' . "\n" .
                            'von ' . oos_server_get_var('REMOTE_HOST') . "\n\n" .
                            'Wichtig: Der Betreiber von ' . oos_server_get_base_url() . ' ist nur bedingt in der Lage' . "\n" .
                            'solchen Missbrauch zu kontrollieren, und ist i.d.R. nicht verantwortlich' . "\n" .
                            'f�r diese E-Mail.';


$aLang['owner_email_subject'] = 'Neuer Kunde';
$aLang['owner_email_date'] = 'Datum:';
$aLang['owner_email_company_info'] = 'Firmendaten';
$aLang['owner_email_contact'] = 'Kontaktinformationen';
$aLang['owner_email_options'] = 'Optionen';
$aLang['owner_email_company'] = 'Firmenname:';
$aLang['owner_email_owner'] = 'Inhaber:';
$aLang['owner_email_number'] = 'Kundennummer:';
$aLang['owner_email_gender'] = 'Anrede:';
$aLang['owner_email_first_name'] = 'Vorname:';
$aLang['owner_email_last_name'] = 'Nachname:';
$aLang['owner_email_date_of_birth'] = 'Geburtsdatum:';
$aLang['owner_email_address'] = 'eMail-Adresse:';
$aLang['owner_email_street'] = 'Strasse/Nr.:';
$aLang['owner_email_suburb'] = 'Stadtteil:';
$aLang['owner_email_post_code'] = 'Postleitzahl:';
$aLang['owner_email_city'] = 'Ort:';
$aLang['owner_email_state'] = 'Bundesland:';
$aLang['owner_email_country'] = 'Land:';
$aLang['owner_email_telephone_number'] = 'Telefonnummer:';
$aLang['owner_email_fax_number'] = 'Telefaxnummer:';
$aLang['owner_email_newsletter'] = 'Newsletter:';
$aLang['owner_email_newsletter_yes'] = 'abonniert';
$aLang['owner_email_newsletter_no'] = 'nicht abonniert';
$aLang['email_separator'] = '------------------------------------------------------';

?>