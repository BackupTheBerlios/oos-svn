<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: german.php,v 1.116 2003/02/17 11:49:26 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/* ----------------------------------------------------------------------
   If you made a translation, please send to
      lang@oos-shop.de
   the translated file.
   ---------------------------------------------------------------------- */

 /**
  * look in your $PATH_LOCALE/locale directory for available locales..
  * on RedHat try 'pl_PL'
  * on FreeBSD try 'pl_PL.ISO_8859-2'
  * on Windows try 'pl', or 'Polski'
  */
  @setlocale(LC_TIME, 'pl_PL');
  define('DATE_FORMAT_SHORT', '%Y-%m-%d');  // this is used for strftime()
  define('DATE_FORMAT_LONG', '%d %B %Y'); // this is used for strftime()
  define('DATE_FORMAT', 'Y-m-d');  // this is used for strftime()
  define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
  define('DATE_TIME_FORMAT_SHORT', '%H:%M:%S');


 /**
  * Return date in raw format
  * $date should be in format mm/dd/yyyy
  * raw date is in format YYYYMMDD, or DDMMYYYY
  *
  * @param $date
  * @param $reverse
  * @return string
  */
  function oos_date_raw($date, $reverse = false) {
    if ($reverse) {
      return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
    } else {
      return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
    }
  }

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="pl"');
define('XML_PARAMS','xml:lang="pl" lang="pl"');

// charset for web pages and emails
define('CHARSET', 'iso-8859-2');

//text in oos_temp/templates/oos/system/user_navigation.html
$aLang['header_title_create_account'] = 'Utw?z Konto';
$aLang['header_title_my_account'] = 'Moje Konto';
$aLang['header_title_cart_contents'] = 'Zawarto?koszyka';
$aLang['header_title_checkout'] = 'Zam?ienie';
$aLang['header_title_top'] = 'Top';
$aLang['header_title_catalog'] = 'Katalog';
$aLang['header_title_logoff'] = 'Wyloguj si';
$aLang['header_title_login'] = 'Zaloguj si';
$aLang['header_title_whats_new'] = 'What\'s New?';

$aLang['block_heading_specials'] = 'Promocje';

// footer text in includes/oos_footer.php
$aLang['footer_text_requests_since'] = 'wywoa?od';

// text for gender
$aLang['male'] = 'M?zyzna';
$aLang['female'] = 'Kobieta';
$aLang['male_address'] = 'Pan';
$aLang['female_address'] = 'Pani';

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');
$aLang['dob_format_string'] = 'tt.mm.jjjj';

// search block text in tempalate/your theme/block/search.html
$aLang['block_search_text'] = 'Wpisz sowo aby wyszuka?produkt.';
$aLang['block_search_advanced_search'] = 'Wyszukiwanie zaawansowane';
$aLang['text_search'] = 'search...';

// reviews block text in tempalate/your theme/block/reviews.php
$aLang['block_reviews_write_review'] = 'Napisz recenzj?o tym produkcie!';
$aLang['block_reviews_no_reviews'] = 'Obecnie nie ma recenzji o produktach';
$aLang['block_reviews_text_of_5_stars'] = '%s z 5 Gwiazdek!';

// shopping_cart block text in tempalate/your theme/block/shopping_cart.html
$aLang['block_shopping_cart_empty'] = '...jest pusty';

// notifications block text in tempalate/your theme/block/products_notifications.php
$aLang['block_notifications_notify'] = 'Informuj mnie o aktualizacjach produktu <b>%s</b>';
$aLang['block_notifications_notify_remove'] = 'Nie informuj mnie o aktualizacjach produktu <b>%s</b>';

// wishlist block text in tempalate/your theme/block/wishlist.html
$aLang['block_wishlist_empty'] = 'Nie masz produkt? w swoim spisie';

// manufacturer box text
$aLang['block_manufacturer_info_homepage'] = '%s Homepage';
$aLang['block_manufacturer_info_other_products'] = 'Wi?ej produkt?';

$aLang['block_add_product_id_text'] = 'Wpisz numer produktu.';

// information block text in tempalate/your theme/block/information.html
$aLang['block_information_imprint'] = 'Informacje';
$aLang['block_information_privacy'] = 'Bezpiecze?two';
$aLang['block_information_conditions'] = 'Korzystanie z&nbsp;Serwisu';
$aLang['block_information_shipping'] = 'Wysyka i Zwroty';
$aLang['block_information_contact'] = 'Kontakt';
$aLang['block_information_v_card'] = 'vCard';
$aLang['block_information_mapquest'] = 'Map This Location';
$aLang['block_skype_me'] = 'Skype Me';
$aLang['block_information_gv'] = 'Gift Voucher FAQ';
$aLang['block_information_gallery'] = 'Gallery';


//service
$aLang['block_service_links'] = 'Web Links';
$aLang['block_service_newsfeed'] = 'RDS/RSS Newsfeed';
$aLang['block_service_gv'] = 'Gutschein einl&ouml;sen';
$aLang['block_service_sitemap'] = 'Mapa strony';

//login
$aLang['entry_email_address'] = 'eMail:';
$aLang['entry_password'] = 'Haso:';
$aLang['text_password_info'] = 'Zapomniaem hasa?';
$aLang['image_button_login'] = 'Zaloguj si?';
$aLang['login_block_new_customer'] = 'Nowy klient';
$aLang['login_block_account_edit'] = 'Zmie?dane';
$aLang['login_block_account_history'] = 'Historia zam?ie?';
$aLang['login_block_order_history'] = 'Order History';
$aLang['login_block_address_book'] = 'Ksika adresowa';
$aLang['login_block_product_notifications'] = 'Powiadmoienia';
$aLang['login_block_my_account'] = 'Dane osobiste';
$aLang['login_block_logoff'] = 'Wymelduj';
$aLang['login_entry_remember_me'] = 'Logowanie automatyczne';

// tell a friend block text in tempalate/your theme/block/tell_a_friend.html
$aLang['block_tell_a_friend_text'] = 'Powiedz o tym produkcie komu, kogo znasz.';

// checkout procedure text
$aLang['checkout_bar_delivery'] = 'Informacje o Dostawie';
$aLang['checkout_bar_payment'] = 'Informacje o patnoci';
$aLang['checkout_bar_confirmation'] = 'Potwierdzenie';
$aLang['checkout_bar_finished'] = 'Gotowe!';

// pull down default text
$aLang['pull_down_default'] = 'Prosz?wybra?';
$aLang['type_below'] = 'prosz?wybra?poniej';

//newsletter
$aLang['block_newsletters_subscribe'] = 'Wpisa?';
$aLang['block_newsletters_unsubscribe'] = 'Wypisa?';

//myworld
$aLang['text_date_account_created'] = 'Zugang erstellt am:';
$aLang['text_yourstore'] = 'Your Participation';
$aLang['edit_yourimage'] = 'Your Image';

// javascript messages
$aLang['js_error'] = 'Brak wanych danych!\nProsz?wpisac prawidowo.\n\n';

$aLang['js_review_text'] = '* Tekst musi mie?minimum ' . REVIEW_TEXT_MIN_LENGTH . ' literek.\n';
$aLang['js_review_rating'] = '* Prosz?wpisa?swoj recenzje.\n';

$aLang['js_gender'] = '* Anredeform festlegen.\n';
$aLang['js_first_name'] = '* Der \'Vornname\' muss mindestens aus ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['js_last_name'] = '* Der \'Nachname\' muss mindestens aus ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['js_dob'] = '* Die \'Geburtsdaten\' im Format xx.xx.xxxx (Tag.Monat.Jahr) eingeben.\n';
$aLang['js_email_address'] = '* Die \'eMail-Adresse\' muss mindestens aus ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['js_address'] = '* Die \'Strasse/Nr.\' muss mindestens aus ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['js_post_code'] = '* Die \'Postleitzahl\' muss mindestens aus ' . ENTRY_POSTCODE_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['js_city'] = '* Die \'Stadt\' muss mindestens aus ' . ENTRY_CITY_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['js_state'] = '* Das \'Bundesland\' muss ausgew?lt werden.\n';
$aLang['js_country'] = '* Das \'Land\' muss ausgew?lt werden.\n';
$aLang['js_telephone'] = '* Die \'Telefonnummer\' muss mindestens aus ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zahlen bestehen.\n';
$aLang['js_password'] = '* Das \'Passwort\' und die \'Best?igung\' mssen bereinstimmen und mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Buchstaben enthalten.\n';

$aLang['js_error_no_payment_module_selected'] = '* Bitte w?len Sie eine Zahlungsweise fr Ihre Bestellung.\n';
$aLang['js_error_submitted'] = 'Diese Seite wurde bereits best?igt. Bet?igen Sie bitte OK und warten bis der Prozess durchgefhrt wurde.';

$aLang['error_no_payment_module_selected'] = 'Bitte w?len Sie eine Zahlungsweise fr Ihre Bestellung.';
$aLang['error_conditions_not_accepted'] = 'Sofern Sie unsere AGB\'s nicht akzeptieren, k?nen wir Ihre Bestellung bedauerlicherweise nicht entgegen nehmen!';

$aLang['category_company'] = 'Firmendaten';
$aLang['category_personal'] = 'Ihre pers&ouml;nlichen Daten';
$aLang['category_address'] = 'Ihre Adresse';
$aLang['category_contact'] = 'Ihre Kontaktinformationen';
$aLang['category_options'] = 'Optionen';
$aLang['category_password'] = 'Ihr Passwort';
$aLang['entry_company'] = 'Firmenname:';
$aLang['entry_company_error'] = '';
$aLang['entry_company_text'] = '';
$aLang['entry_owner'] = 'Inhaber';
$aLang['entry_owner_error'] = '';
$aLang['entry_owner_text'] = '';
$aLang['entry_vat_id'] = 'VAT ID';
$aLang['entry_vat_id_error'] = 'The chosen VatID is not valid or not proofable at this moment! Please fill in a valid ID or leave the field empty.';
$aLang['entry_vat_id_text'] = '* for Germany and EU-Countries only';
$aLang['entry_number'] = 'Kundennummer';
$aLang['entry_number_error'] = '';
$aLang['entry_number_text'] = '';
$aLang['entry_gender'] = 'Anrede:';

$aLang['entry_first_name'] = 'Vorname:';
$aLang['entry_first_name_error'] = 'mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Buchstaben';
$aLang['entry_last_name'] = 'Nachname:';
$aLang['entry_last_name_error'] = 'mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Buchstaben';
$aLang['entry_date_of_birth'] = 'Geburtsdatum:';
$aLang['entry_date_of_birth_text'] = '(z.B. 21.05.1970)';
$aLang['entry_email_address'] = 'eMail-Adresse:';
$aLang['entry_email_address_error'] = 'mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Buchstaben';
$aLang['entry_email_address_check_error'] = 'ungltige eMail-Adresse!';
$aLang['entry_email_address_error_exists'] = 'Diese eMail-Adresse existiert schon!';
$aLang['entry_street_address'] = 'Strasse/Nr.:';
$aLang['entry_street_address_error'] = 'mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Buchstaben';

$aLang['entry_suburb'] = 'Stadtteil:';
$aLang['entry_suburb_error'] = '';
$aLang['entry_suburb_text'] = '';
$aLang['entry_post_code'] = 'Postleitzahl:';
$aLang['entry_post_code_error'] = 'mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zahlen';
$aLang['entry_city'] = 'Ort:';
$aLang['entry_city_error'] = 'mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Buchstaben';
$aLang['entry_state'] = 'Bundesland:';
$aLang['entry_country'] = 'Land:';
$aLang['entry_country_error'] = '';
$aLang['entry_telephone_number'] = 'Telefonnummer:';
$aLang['entry_telephone_number_error'] = 'mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zahlen';
$aLang['entry_fax_number'] = 'Telefaxnummer:';
$aLang['entry_fax_number_error'] = '';
$aLang['entry_fax_number_text'] = '';
$aLang['entry_newsletter'] = 'Newsletter:';
$aLang['entry_newsletter_text'] = '';
$aLang['entry_newsletter_yes'] = 'abonniert';
$aLang['entry_newsletter_no'] = 'nicht abonniert';
$aLang['entry_newsletter_error'] = '';
$aLang['entry_password'] = 'Passwort:';
$aLang['entry_password_confirmation'] = 'Best&auml;tigung:';
$aLang['entry_password_error'] = 'mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen';
$aLang['password_hidden'] = '--VERSTECKT--';
$aLang['entry_info_text'] = 'notwendige Eingabe';


// constants for use in oos_prev_next_display function
$aLang['text_result_page'] = 'Seiten:';
$aLang['text_display_number_of_products'] = 'angezeigte Produkte: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)';
$aLang['text_display_number_of_orders'] = 'angezeigte Bestellungen: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)';
$aLang['text_display_number_of_reviews'] = 'angezeigte Meinungen: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)';
$aLang['text_display_number_of_products_new'] = 'angezeigte neue Produkte: <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)';
$aLang['text_display_number_of_specials'] = 'angezeigte Angebote <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)';
$aLang['text_display_number_of_wishlist'] = 'angezeigt Wunschprodukte <b>%d</b> bis <b>%d</b> (von <b>%d</b> insgesamt)';

$aLang['prevnext_title_first_page'] = 'erste Seite';
$aLang['prevnext_title_previous_page'] = 'vorherige Seite';
$aLang['prevnext_title_next_page'] = 'n&auml;chste Seite';
$aLang['prevnext_title_last_page'] = 'letzte Seite';
$aLang['prevnext_title_page_no'] = 'Seite %d';
$aLang['prevnext_title_prev_set_of_no_page'] = 'Vorhergehende %d Seiten';
$aLang['prevnext_title_next_set_of_no_page'] = 'N&auml;chste %d Seiten';
$aLang['prevnext_button_first'] = '&lt;&lt;ERSTE';
$aLang['prevnext_button_prev'] = '&lt;&lt;&nbsp;vorherige';
$aLang['prevnext_button_next'] = 'n&auml;chste&nbsp;&gt;&gt;';
$aLang['prevnext_button_last'] = 'LETZTE&gt;&gt;';

$aLang['image_button_add_address'] = 'Neue Adresse';
$aLang['image_button_address_book'] = 'Adressbuch';
$aLang['image_button_back'] = 'Zurck';
$aLang['image_button_change_address'] = 'Adresse ?dern';
$aLang['image_button_checkout'] = 'Kasse';
$aLang['image_button_confirm_order'] = 'Bestellung best?igen';
$aLang['image_button_continue'] = 'Weiter';
$aLang['image_button_continue_shopping'] = 'Einkauf fortsetzen';
$aLang['image_button_delete'] = 'L?chen';
$aLang['image_button_edit_account'] = 'Daten ?dern';
$aLang['image_button_history'] = 'Bestellbersicht';
$aLang['image_button_login'] = 'Anmelden';
$aLang['image_button_in_cart'] = 'In den Warenkorb';
$aLang['image_button_notifications'] = 'Benachrichtigungen';
$aLang['image_button_quick_find'] = 'Schnellsuche';
$aLang['image_button_remove_notifications'] = 'Benachrichtigungen l?chen';
$aLang['image_button_reviews'] = 'Bewertungen';
$aLang['image_button_search'] = 'Suchen';
$aLang['image_button_tell_a_friend'] = 'Weiterempfehlen';
$aLang['image_button_update'] = 'Aktualisieren';
$aLang['image_button_update_cart'] = 'Warenkorb aktualisieren';
$aLang['image_button_write_review'] = 'Bewertung schreiben';
$aLang['image_button_add_quick'] = 'Schnellkauf!';
$aLang['image_wishlist_delete'] = 'l&ouml;schen';
$aLang['image_button_in_wishlist'] = 'Wunschliste';
$aLang['image_button_add_wishlist'] = 'Wunschliste';
$aLang['image_button_redeem_voucher'] = 'Gutschein einl�en';

$aLang['image_button_hp_buy'] = 'In den Warenkorb';
$aLang['image_button_hp_more'] = 'Zeige mehr';

$aLang['icon_button_mail'] = 'E-mail';
$aLang['icon_button_movie'] = 'Movie';
$aLang['icon_button_pdf'] = 'PDF';
$aLang['icon_button_print'] = 'Print';
$aLang['icon_button_zoom'] = 'Zoom';


$aLang['icon_arrow_right'] = 'Zeige mehr';
$aLang['icon_cart'] = 'In den Warenkorb';
$aLang['icon_warning'] = 'Warnung';

$aLang['text_greeting_personal'] = 'Sch&ouml;n, dass Sie wieder da sind <span class="greetUser">%s!</span> M&ouml;chten Sie die <a href="%s"><u>neuen Produkte</u></a> ansehen?';
$aLang['text_greeting_guest'] = 'Herzlich Willkommen <span class="greetUser">Gast!</span> M&ouml;chten Sie sich <a href="%s"><u>anmelden</u></a>? Oder wollen Sie ein <a href="%s"><u>Kundenkonto</u></a> er&ouml;ffnen?';

$aLang['text_sort_products'] = 'Sortierung der Artikel ist ';
$aLang['text_descendingly'] = 'absteigend';
$aLang['text_ascendingly'] = 'aufsteigend';
$aLang['text_by'] = ' nach ';

$aLang['text_review_by'] = 'von %s';
$aLang['text_review_word_count'] = '%s Worte';
$aLang['text_review_rating'] = 'Bewertung:';
$aLang['text_review_date_added'] = 'Datum hinzugef&uuml;gt: ';
$aLang['text_no_reviews'] = 'Es liegen noch keine Bewertungen vor.';
$aLang['text_no_new_products'] = 'Zur Zeit gibt es keine neuen Produkte.';
$aLang['text_unknown_tax_rate'] = 'Unbekannter Steuersatz';
$aLang['text_required'] = 'erforderlich';
$aLang['error_oos_mail'] = '<small>Fehler:</small> Die eMail kann nicht &uuml;ber den angegebenen SMTP-Server verschickt werden. Bitte kontrollieren Sie die Einstellungen in der php.ini Datei und f&uuml;hren Sie notwendige Korrekturen durch!';

$aLang['warning_install_directory_exists'] = 'Warnung: Das Installationverzeichnis ist noch vorhanden auf: ' . dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/install. Bitte l&ouml;schen Sie das Verzeichnis aus Gr&uuml;nden der Sicherheit!';
$aLang['warning_config_file_writeable'] = 'Warnung: OOS [OSIS Online Shop] kann in die Konfigurationsdatei schreiben: ' . dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/includes/configure.php. Das stellt ein m&ouml;gliches Sicherheitsrisiko dar - bitte korrigieren Sie die Benutzerberechtigungen zu dieser Datei!';
$aLang['warning_session_auto_start'] = 'Warnung: session.auto_start ist enabled - Bitte disablen Sie dieses PHP Feature in der php.ini und starten Sie den WEB-Server neu!';
$aLang['warning_download_directory_non_existent'] = 'Warnung: Das Verzeichnis fr den Artikel Download existiert nicht: ' . OOS_DOWNLOAD_PATH . '. Diese Funktion wird nicht funktionieren bis das Verzeichnis erstellt wurde!';
$aLang['warning_session_directory_non_existent'] = 'Warnung: Das Verzeichnis f&uuml;r die Sessions existiert nicht: ' . oos_session_save_path() . '. Die Sessions werden nicht funktionieren bis das Verzeichnis erstellt wurde!';
$aLang['warning_session_directory_not_writeable'] = 'Warnung: OOS [OSIS Online Shop] kann nicht in das Sessions Verzeichnis schreiben: ' . oos_session_save_path() . '. Die Sessions werden nicht funktionieren bis die richtigen Benutzerberechtigungen gesetzt wurden!';

$aLang['text_ccval_error_invalid_date'] = 'Das "G&uuml;ltig bis" Datum ist ung&uuml;ltig.<br>Bitte korrigieren Sie Ihre Angaben.';
$aLang['text_ccval_error_invalid_number'] = 'Die "KreditkarteNummer", die Sie angegeben haben, ist ung&uuml;ltig.<br>Bitte korrigieren Sie Ihre Angaben.';
$aLang['text_ccval_error_unknown_card'] = 'Die ersten 4 Ziffern Ihrer Kreditkarte sind: %s<br>Wenn diese Angaben stimmen, wird dieser Kartentyp leider nicht akzeptiert.<br>Bitte korrigieren Sie Ihre Angaben gegebenfalls.';

$aLang['voucher_balance'] = 'Gutschein - Guthaben';
$aLang['gv_faq'] = 'Gutschein FAQ';
$aLang['error_redeemed_amount'] = 'Prima: Der Einl&ouml;sewert wurde Ihrem Kundenkonto gutgeschrieben! ';
$aLang['error_no_redeem_code'] = 'Sie haben keinen Gutschein-Code eingegeben!';
$aLang['error_no_invalid_redeem_gv'] = 'Fehler: Sie haben keinen g&uuml;ltigen Gutschein-Code eingegeben!';
$aLang['table_heading_credit'] = 'Guthaben';
$aLang['gv_has_vouchera'] = 'Sie haben ein Gutschein - Guthaben auf Ihrem Kundenkonto. M&ouml;chten Sie einen Teil <br>
                         Ihres Guthabens per';
$aLang['gv_has_voucherb'] = 'versenden?';
$aLang['entry_amount_check_error'] = '&nbsp;<small><font color="#FF0000">Leider keine ausreichende Deckung auf Ihrem Kundenkonto!</font></smal>';
$aLang['gv_send_to_friend'] = 'Gutschein versenden';

$aLang['voucher_redeemed'] = 'Voucher Redeemed';
$aLang['cart_coupon'] = 'Coupon :';
$aLang['cart_coupon_info'] = 'more info';

$aLang['category_payment_details'] = 'Auszahlung kann erfolgen &uuml;ber';

$aLang['block_ticket_generate'] = 'Support Anfrage';
$aLang['block_ticket_view'] = 'Ticket einsehen';

$aLang['down_for_maintenance_text'] = 'Down for Maintenance ... Please try back later';
$aLang['down_for_maintenance_no_prices_display'] = 'Down for Maintenance';
$aLang['no_login_no_prices_display'] = 'Preise nur f&uuml;r H&auml;ndler';
$aLang['text_products_base_price'] = 'Grundpreis';

$aLang['products_see_qty_discounts'] = 'Staffelpreise';
$aLang['products_order_qty_text'] = 'Menge: ';
$aLang['products_order_qty_min_text'] = '<br />' . ' Mindestbestellmenge: ';
$aLang['products_order_qty_min_text_info'] = ' Die Mindestbestellmenge ist: ';
$aLang['products_order_qty_min_text_cart'] = ' Die Mindestbestellmenge ist: ';
$aLang['products_order_qty_min_text_cart_short'] = 'min. M.: ';

$aLang['products_order_qty_unit_text'] = ' Verpackungseinheit: ';
$aLang['products_order_qty_unit_text_info'] = 'bei der Verpackungseinheit von: ';
$aLang['products_order_qty_unit_text_cart'] = 'bei der Verpackungseinheit von: ';
$aLang['products_order_qty_unit_text_cart_short'] = ' Verpackungseinheit: ';

$aLang['error_products_quantity_order_min_text'] = '';
$aLang['error_products_quantity_invalid'] = 'Fehler: Menge: ';
$aLang['error_products_quantity_order_units_text'] = '';
$aLang['error_products_units_invalid'] = 'Fehler: Menge ';

$aLang['error_destination_does_not_exist'] = 'Error: Destination does not exist.';
$aLang['error_destination_not_writeable'] = 'Error: Destination not writeable.';
$aLang['error_file_not_saved'] = 'Error: File upload not saved.';
$aLang['error_filetype_not_allowed'] = 'Error: File upload type not allowed.';
$aLang['success_file_saved_successfully'] = 'Success: File upload saved successfully.';
$aLang['warning_no_file_uploaded'] = 'Warning: No file uploaded.';
$aLang['warning_file_uploads_disabled'] = 'Warning: File uploads are disabled in the php.ini configuration file.';


// 404 Email Error Report
$aLang['error404_email_subject'] = '404 Fehlerreport';
$aLang['error404_email_header'] = '404 Fehlermeldung';
$aLang['error404_email_text'] = 'Ein 404-Fehler trat auf';
$aLang['error404_email_date'] = 'Datum:';
$aLang['error404_email_uri'] = 'Die fehlerhafte URI:';
$aLang['error404_email_ref'] = 'Die Ausgangsseite:';

$aLang['err404'] = '404 Fehlermeldung';
$aLang['err404_page_not_found'] = 'Die angeforderte Seite wurde nicht gefunden bei';
$aLang['err404_sorry'] = 'Die angeforderte Seite';
$aLang['err404_doesntexist'] = 'existiert nicht bei';
$aLang['err404_mailed'] = '<b>Details zum Fehler wurden automatisch an den Webmaster gesendet.</b>';
$aLang['err404_commonm'] = '<b>Typische Fehler</b>';
$aLang['err404_commonh'] = 'Namenskonventionen nicht beachtet';
$aLang['err404_urlend'] = 'die angegebene URL endet mit';
$aLang['err404_allpages'] = 'alle Seiten bei';
$aLang['err404_endwith'] = 'enden mit';
$aLang['err404_uppercase'] = 'die Benutzung von GROSSBUCHSTABEN';
$aLang['err404_alllower'] = 'alle Namen werden kleingeschrieben';


$aLang['text_info_csname'] = 'Sie sind Mitglied der Kundengruppe : ';
$aLang['text_info_csdiscount'] = 'Sie bekommen je nach Produkt einen maximalen Rabatt bis zu : ';
$aLang['text_info_csotdiscount'] = 'Sie bekommen auf Ihre Gesamtbestellung einen Rabatt von : ';
$aLang['text_info_csstaff'] = 'Sie sind berechtigt zu Staffelpreisen einzukaufen.';
$aLang['text_info_cspay'] = 'Folgende Zahlungsarten k?nen Sie benutzen : ';
$aLang['text_info_show_price_no'] = 'Sie erhalten noch keine Preisinformationen. Bitte melden Sie sich an';
$aLang['text_info_show_price_with_tax_yes'] = 'Die Preise beinhalten die MwSt.';
$aLang['text_info_show_price_with_tax_no'] = 'Die Preise werden ohne MwSt. angezeigt.';
$aLang['text_info_receive_mail_mode'] = 'Infos h?te ich geren im Format : ';
$aLang['entry_receive_mail_text'] = 'Text only';
$aLang['entry_receive_mail_html'] = 'HTML';
$aLang['entry_receive_mail_pdf'] = 'PDF';

$aLang['table_heading_price_unit'] = 'pro Stk.Netto';
$aLang['table_heading_discount'] = 'Rabatt';
$aLang['table_heading_ot_discount'] = 'Pauschalrabatt';
$aLang['text_info_minimum_amount'] = 'Ab dem folgenden Bestellwert erhalten Sie den Pausschalrabatt.';
$aLang['sub_title_ot_discount'] = 'Pauschalrabatt:';
$aLang['text_new_customer_introduction_newsletter'] = 'By subscribing to newsletter from ' .  STORE_NAME . ' you will stay informed of all news info.';
$aLang['text_new_customer_ip'] = 'This account has been created by this computer IP : ';
$aLang['text_customer_account_password_security'] = 'For you\'r own security we are not able to know this password. If you forgot it, you can request a new one.';
$aLang['text_login_need_upgrade_csnewsletter'] = '<font color="#ff0000"><b>NOTE:</b></font>You have already subscribed to an account for &quot;Newsletter &quot;. You need to upgade this account to be able to buy.';

// use TimeBasedGreeting
$aLang['good_morning'] = 'Guten Morgen!';
$aLang['good_afternoon'] = 'Guten Tag!';
$aLang['good_evening'] = 'Guten Abend!';

$aLang['text_taxt_incl'] = 'incl. Tax';
$aLang['text_taxt_add'] = 'plus. Tax';
$aLang['tax_info_excl'] = 'exkl. Tax';
$aLang['text_shipping'] = 'excl. <a href="%s"><u>Shipping cost</u></a>.';

$aLang['price'] = 'Preis';
$aLang['price_from'] = 'from';
$aLang['price_info'] = 'Alle Preise pro St&uuml;ck in &euro; inkl. der gesetzlichen Mehrwertsteuer, zzgl. <a href="' . oos_href_link($aModules['info'], $aFilename['information'], 'information_id=1') . '">Versandkostenpauschale</a>.';
$aLang['support_info'] = 'Haben Sie noch Fragen? Sie erreichen uns &uuml;ber unser <a href="' . oos_href_link($aModules['ticket'], $aFilename['ticket_create']) . '">Kontaktformular</a>.';

?>