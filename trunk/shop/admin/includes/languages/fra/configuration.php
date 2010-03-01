<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: configuration.php,v 1.8 2002/01/04 03:51:40 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Name');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');


define('STORE_NAME_TITLE', 'Shop Name');
define('STORE_NAME_DESC', 'Der Name meines Shops');

define('STORE_OWNER_TITLE', 'Shop Inhaber');
define('STORE_OWNER_DESC', 'Der Name des Shop-Betreibers');

define('STORE_OWNER_EMAIL_ADDRESS_TITLE', 'E-Mail Adresse');
define('STORE_OWNER_EMAIL_ADDRESS_DESC', 'Die E-Mail Adresse des Shop-Betreibers');

define('EMAIL_FROM_TITLE', 'E-Mail Absender');
define('EMAIL_FROM_DESC', 'Die E-Mail Adresse die als Absender verwendet wird');

define('STORE_COUNTRY_TITLE', 'Land');
define('STORE_COUNTRY_DESC', 'In welchem Land wird der Shop betrieben <br><br><b>Hinweis: Bitte vergessen Sie nicht, das Bundesland zu aktualisieren</b>');

define('STORE_ZONE_TITLE', 'Bundesland');
define('STORE_ZONE_DESC', 'In welchem Bundesland wird der Shop betrieben?');

define('EXPECTED_PRODUCTS_SORT_TITLE', 'Sortierreihenfolge erwartete Produkte');
define('EXPECTED_PRODUCTS_SORT_DESC', 'Sortierreihenfolge, die im \'erwartete Produkte\'-Block verwendet wird.');

define('EXPECTED_PRODUCTS_FIELD_TITLE', 'Sortierspalte erwartete Produkte');
define('EXPECTED_PRODUCTS_FIELD_DESC', 'Die Spalte, nach der im \'erwartete Produkte\'-Block sortiert wird.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE', 'W&auml;hrung automatisch wechseln');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC', 'Wechselt automatisch die W&auml;hrung anhand der eingestellten Sprache');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE', 'Zus&auml;tzliche Bestellbest&auml;tigung per Mail senden');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC', 'Sendet zus&auml;tzliche Bestellbenachrichtigungen an folgende E-Mail Adresse, in diesem Format: Name 1 &lt;email@adresse1&gt;');

define('SEND_BANKINFO_TO_ADMIN_TITLE', 'Bankinfo per Mail');
define('SEND_BANKINFO_TO_ADMIN_DESC', 'M&ouml;chten Sie die Bankdaten aus dem Lastschriftverfahren mit der E-Mail erhalten?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE', 'Standardoperator f&uuml;r Suchfunktionen');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC', 'Die Standardverkn&uuml;pfung, mit der mehrere Suchbegriffe verkn&uuml;pft werden');

define('STORE_NAME_ADDRESS_TITLE', 'Adressinformationen des Shops');
define('STORE_NAME_ADDRESS_DESC', 'Die Kontaktinformationen des Shops, welche sowohl in Dokumenten als auch Online ausgegeben werden');

define('TAX_DECIMAL_PLACES_TITLE', 'Dezimalstellen der Steuer');
define('TAX_DECIMAL_PLACES_DESC', 'Anzahl der Dezimalstellen der Steuer');

define('DISPLAY_PRICE_WITH_TAX_TITLE', 'Preise inkl. Steuer');
define('DISPLAY_PRICE_WITH_TAX_DESC', 'Preise incl. Steuer anzeigen (true) oder die Steuer dem Gesamtbetrag hinzurechnen (false)');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE', 'AGB anzeigen');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC', 'Im Kassenbereich Ihre Allgemeine Gesch&auml;fts- und Lieferbedingungen anzeigen, bevor fortgefahren werden kann.');

define('PRODUCTS_OPTIONS_SORT_BY_PRICE_TITLE', 'Sortierung Produktoptionen');
define('PRODUCTS_OPTIONS_SORT_BY_PRICE_DESC', 'M&ouml;chten Sie die Produktopionen nach Preisen sortieren?');

define('WEB_SEARCH_GOOGLE_KEY_TITLE', 'Google API Lizenzschl&uuml;ssel');
define('WEB_SEARCH_GOOGLE_KEY_DESC', 'Google API Lizenzschl&uuml;ssel (kostenlos!) <A HREF=\"http://www.google.com/apis\" TARGET=\"_blank\">http://www.google.com/apis</A>.');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE', 'Vorname');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Vornames');

define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE', 'Nachname');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Nachnames');

define('ENTRY_DOB_MIN_LENGTH_TITLE', 'Geburtsdatum');
define('ENTRY_DOB_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Geburtsdatums');

define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE', 'E-Mail Adresse');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC', 'Mindestl&auml;nge der E-Mail Adresse');

define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE', 'Strasse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Strassennamens');

define('ENTRY_COMPANY_LENGTH_TITLE', 'Firma');
define('ENTRY_COMPANY_LENGTH_DESC', 'Mindestl&auml;nge des Firmennames');

define('ENTRY_POSTCODE_MIN_LENGTH_TITLE', 'Postleitzahl');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC', 'Mindestl&auml;nge der Postleitzahl');

define('ENTRY_CITY_MIN_LENGTH_TITLE', 'Stadt');
define('ENTRY_CITY_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Namens der Stadt');

define('ENTRY_STATE_MIN_LENGTH_TITLE', 'Bundesland');
define('ENTRY_STATE_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Namens des Bundeslandes');

define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE', 'Telefonnummer');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC', 'Mindestl&auml;nge der Telefonnummer');

define('ENTRY_PASSWORD_MIN_LENGTH_TITLE', 'Passwort');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Passworts');

define('CC_OWNER_MIN_LENGTH_TITLE', 'Name Kreditkarteneigent&uuml;mer');
define('CC_OWNER_MIN_LENGTH_DESC', 'Mindestl&auml;nge des Names vom Kreditkarteneigent&uuml;mer');

define('CC_NUMBER_MIN_LENGTH_TITLE', 'Kreditkartennummer');
define('CC_NUMBER_MIN_LENGTH_DESC', 'Mindestl&auml;nge der Kreditkartennummer');

define('MIN_DISPLAY_BESTSELLERS_TITLE', 'Verkaufsschlager');
define('MIN_DISPLAY_BESTSELLERS_DESC', 'Minimale Anzahl der Verkaufsschlager, die angezeigt werden.');

define('MIN_DISPLAY_ALSO_PURCHASED_TITLE', 'Kunden kauften auch');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC', 'Minimale Anzahl von Produkten, die im \'Kunden kauften auch\'-Block angezeigt werden.');

define('MIN_DISPLAY_XSELL_PRODUCTS_TITLE', 'Produkt-Empfehlungen');
define('MIN_DISPLAY_XSELL_PRODUCTS_DESC', 'Minimale Anzahl von Produkten, die im \'Produkt-Empfehlungen\'-Block angezeigt werden.');

define('MIN_DISPLAY_PRODUCTS_NEWSFEED_TITLE', 'Neue Produkte im Newsfeed');
define('MIN_DISPLAY_PRODUCTS_NEWSFEED_DESC', 'Minimale Anzahl von Produkten, die im \'Newsfeed\'-Block angezeigt werden.');

define('MIN_DISPLAY_NEW_NEWS_TITLE', 'News Meldungen');
define('MIN_DISPLAY_NEW_NEWS_DESC', 'Minimale Anzahl von Meldungen, die auf der \'Startseite\' angezeigt werden.');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE', 'Anzahl Adressbucheintr&auml;ge');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC', 'Maximale Anzahl von Adressbucheintr&auml;gen, die ein Kunde besitzen darf.');

define('MAX_DISPLAY_SEARCH_RESULTS_TITLE', 'Anzahl Suchergebnisse');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC', 'Maximal Anzahl der Artikel, die als Suchergebnis angezeigt werden.');

define('MAX_DISPLAY_PAGE_LINKS_TITLE', 'Seiten-Links');
define('MAX_DISPLAY_PAGE_LINKS_DESC', 'Number of \'number\' links use for page-sets');

define('MAX_DISPLAY_NEW_PRODUCTS_TITLE', 'Neue Produkte');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC', 'Maximale Anzahl von neuen Produkten, die in jeder Kategorie angezeigt werden.');

define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE', 'Erwartete Produkte');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC', 'Maximale Anzahl der erwarteten Produkte, die angezeigt werden.');

define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE', 'Anzahl Hersteller');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC', 'Wird im Hersteller-Block benutzt. Maximale Anzahl von Herstellern, die in einer Liste angezeigt werden. Wird diese Zahl von Herstellern &uuml;berschritten, erscheint eine Auswahlbox anstelle der Standard-Liste');

define('MAX_MANUFACTURERS_LIST_TITLE', 'Anzahl Zeilen Herstellerauswahlbox');
define('MAX_MANUFACTURERS_LIST_DESC', 'Wird im Hersteller-Block benutzt. Ist dieser Wert \'1\' so wird die normale Auswahlbox angezeigt. Anderenfalls wird eine Liste mit der angegebenen Anzahl von Zeilen angezeigt');

define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE', 'L&auml;nge des Herstellernamens');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC', 'Wird im Hersteller-Block benutzt. Maximale Anzahl anzuzeigender Zeichen des Herstellernamens');

define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE', 'Anzahl Kategorien pro Zeile');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', 'Anzahl der Kategorien, die pro Zeile maximal angezeigt werden');

define('MAX_DISPLAY_PRODUCTS_NEW_TITLE', 'Anzahl neue Produkte');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', 'Anzahl der neuen Produkte, die in der &Uuml;bersicht der neuen Produkte maximal angezeigt werden');

define('MAX_DISPLAY_BESTSELLERS_TITLE', 'Verkaufsschlager');
define('MAX_DISPLAY_BESTSELLERS_DESC', 'Maximale Anzahl der anzuzeigenden Verkaufsschlager');

define('MAX_DISPLAY_ALSO_PURCHASED_TITLE', 'Kunden kauften auch');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', 'Maximale Anzahl von Produkten die im \'Kunden kauften auch\'-Block angezeigt werden');

define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE', 'Produktanzahl Bestell&uuml;bersicht-Block');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC', 'Maximale Anzahl von Produkten, die im Bestell&uuml;bersichts-Block angezeigt werden');

define('MAX_DISPLAY_ORDER_HISTORY_TITLE', 'Anzahl Bestellungen im Bestell&uuml;bersicht-Block');
define('MAX_DISPLAY_ORDER_HISTORY_DESC', 'Maximale Anzahl von Bestellungen im Bestell&uuml;bersichts-Block');

define('MAX_DISPLAY_XSELL_PRODUCTS_TITLE', 'Produkt-Empfehlungen');
define('MAX_DISPLAY_XSELL_PRODUCTS_DESC', 'Maximale Anzahl von Produkten, die im \'Produkt-Empfehlungen\'-Block angezeigt werden');

define('MAX_DISPLAY_WISHLIST_PRODUCTS_TITLE', 'Wunschzettel');
define('MAX_DISPLAY_WISHLIST_PRODUCTS_DESC', 'Maximale Anzahl von Produkten auf der Wunschzettel-Seite');

define('MAX_DISPLAY_WISHLIST_BOX_TITLE', 'Wunschzettel-Infobox');
define('MAX_DISPLAY_WISHLIST_BOX_DESC', 'Maximale Anzahl von Produkten, die im \'Wunschzettel\'-Block angezeigt werden');

define('MAX_DISPLAY_PRODUCTS_NEWSFEED_TITLE', 'Neue Produkte im Newsfeed');
define('MAX_DISPLAY_PRODUCTS_NEWSFEED_DESC', 'Maximale Anzahl von Produkten, die im \'Newsfeed\' angezeigt werden');

define('MAX_RANDOM_SELECT_NEWSFEED_TITLE', 'Newsfeed');
define('MAX_RANDOM_SELECT_NEWSFEED_DESC', 'Die Menge der Newsfeeds, aus denen per Zufall ein Newsfeed angezeigt wird');

define('MAX_RANDOM_SELECT_NEW_TITLE', 'Zuf&auml;llige Produktanzeigen');
define('MAX_RANDOM_SELECT_NEW_DESC', 'Die Menge der neuen Produkte, aus denen per Zufall ein Produkt angezeigt wird');

define('MAX_RANDOM_SELECT_REVIEWS_TITLE', 'Zuf&auml;llige Produktbewertungen');
define('MAX_RANDOM_SELECT_REVIEWS_DESC', 'Die Menge der Produktbewertungen, aus denen per Zufall eine Produktbewertungen angezeigt wird');

define('MAX_DISPLAY_NEW_NEWS_TITLE', 'Anzahl der News Meldungen');
define('MAX_DISPLAY_NEW_NEWS_DESC', 'Maximale Anzahl von Meldungen, die auf der Startseite angezeigt werden');

define('MAX_DISPLAY_PRODUCTS_IN_PRODUCTS_HISTORY_BOX_TITLE', 'Anzahl der k&uuml;rzlich besuchten Produkte');
define('MAX_DISPLAY_PRODUCTS_IN_PRODUCTS_HISTORY_BOX_DESC', 'Maximale Anzahl von Produkten, die im \'Products History\'-Block angezeigt werden. Dies sind die Produkte, die sich der Shopbesucher k&uuml;rzlich angesehen hat.');

define('SMALL_IMAGE_WIDTH_TITLE', 'Breite kleine Bilder');
define('SMALL_IMAGE_WIDTH_DESC', 'Die Breite von kleinen Bildern in Pixeln');

define('SMALL_IMAGE_HEIGHT_TITLE', 'H&ouml;he kleine Bilder');
define('SMALL_IMAGE_HEIGHT_DESC', 'Die H&ouml;he von kleinen Bildern in Pixeln');

define('HEADING_IMAGE_WIDTH_TITLE', 'Breite &Uuml;berschrift-Bilder');
define('HEADING_IMAGE_WIDTH_DESC', 'Die Breite von Bildern, die als &Uuml;berschrift verwendet werden, in Pixeln');

define('HEADING_IMAGE_HEIGHT_TITLE', 'H&ouml;he &Uuml;berschrift-Bilder');
define('HEADING_IMAGE_HEIGHT_DESC', 'Die H&ouml;he von Bildern, die als &Uuml;berschrift verwendet werden, in Pixeln');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE', 'Breite Unterkategorie-Bilder');
define('SUBCATEGORY_IMAGE_WIDTH_DESC', 'Die Breite von Unterkategorie-Bildern in Pixeln');

define('SUBCATEGORY_IMAGE_HEIGHT_TITLE', 'H&ouml;he Unterkategorie-Bilder');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC', 'Die H&ouml;he von Unterkategorie-Bildern in Pixeln');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE', 'Berechnen der Bildgr&ouml;sse');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC', 'Soll die Bildgr&ouml;sse berechnet werden?');

define('IMAGE_REQUIRED_TITLE', 'Bild erforderlich');
define('IMAGE_REQUIRED_DESC', 'Einschalten, um tote Links zu Bildern darzustellen. Hilfreich bei der Entwicklung.');

define('CUSTOMER_NOT_LOGIN_TITLE', 'Zugangsberechtigung');
define('CUSTOMER_NOT_LOGIN_DESC', 'Die Zugangsberechtigung wird durch den Administrator nach Pr&uuml;fung der Kundendaten erteilt');

define('SEND_CUSTOMER_EDIT_EMAILS_TITLE', 'Kundendaten per Mail');
define('SEND_CUSTOMER_EDIT_EMAILS_DESC', 'Die Kundendaten werden per E-Mail an den Shopbetreiber versandt');

define('DEFAULT_MAX_ORDER_TITLE', 'Kundenkredit');
define('DEFAULT_MAX_ORDER_DESC', 'Maximaler Wert einer Bestellung');

define('ACCOUNT_GENDER_TITLE', 'Anrede');
define('ACCOUNT_GENDER_DESC', 'Die Anrede wird angezeigt und als Eingabe zwingend gefordert, wenn auf \'true\' gesetzt wird. Sonst wird es als nicht als Eingabem&ouml;glichkeit angezeigt.');

define('ACCOUNT_DOB_TITLE', 'Geburtsdatum');
define('ACCOUNT_DOB_DESC', 'Das Gebutsdatum wird als Eingabe zwingend gefordert, wenn auf \'true\' gesetzt wird. Sonst wird es als nicht als Eingabem&ouml;glichkeit angezeigt.');

define('ACCOUNT_NUMBER_TITLE', 'Kundennummer');
define('ACCOUNT_NUMBER_DESC', 'Verwaltung von eigenen Kundenummern, wenn auf \'true\' gesetzt wird. Sonst wird es als nicht als Eingabem&ouml;glichkeit angezeigt. Die Eingabe ist nicht zwingend notwendig.');

define('ACCOUNT_COMPANY_TITLE', 'Firmenname');
define('ACCOUNT_COMPANY_DESC', 'Ein Firmenname f&uuml;r gewerbliche Kunden kann eingegeben werden. Die Eingabe ist nicht zwingend notwendig.');

define('ACCOUNT_OWNER_TITLE', 'Inhaber');
define('ACCOUNT_OWNER_DESC', 'Der Inhaber der Firmen bei gewerblichen Kunden kann eingegeben werden. Die Eingabe ist nicht zwingend notwendig.');

define('ACCOUNT_SUBURB_TITLE', 'Stadtteil');
define('ACCOUNT_SUBURB_DESC', 'Stadtteil wird angezeigt und kann eingegeben werden. Eine Eingabe ist nicht zwingend notwendig.');

define('ACCOUNT_STATE_TITLE', 'Bundesland');
define('ACCOUNT_STATE_DESC', 'Die Anzeige und Eingabe des Bundeslandes wird erm&ouml;glicht. Die Eingabe ist bei Anzeige zwingend notwendig.');

define('STORE_ORIGIN_COUNTRY_TITLE', 'L&auml;ndercode');
define('STORE_ORIGIN_COUNTRY_DESC', 'Eingabe des &quot;ISO 3166&quot;-L&auml;ndercodes des Shops, der im Versandbereich benutzt werden soll. Zum Finden Ihres L&auml;ndercodes besuchen Sie die <A HREF=\"http://www.din.de/gremien/nas/nabd/iso3166ma/codlstp1/index.html\" TARGET=\"_blank\">ISO 3166');

define('STORE_ORIGIN_ZIP_TITLE', 'Postleitzahl');
define('STORE_ORIGIN_ZIP_DESC', 'Eingabe der Postleitzahl des Shops, die im Versandbereich benutzt werden soll.');

define('SHIPPING_MAX_WEIGHT_TITLE', 'Maximales Gewicht einer Bestellung');
define('SHIPPING_MAX_WEIGHT_DESC', 'Versandunternehmen haben ein H&ouml;chstgewicht f&uuml;r einzelne Pakete. Dies hier ist ein Wert, der f&uuml;r alle Unternehmen gleicherma&szlig;en gilt.');

define('SHIPPING_BOX_WEIGHT_TITLE', 'Gewicht der Verpackung.');
define('SHIPPING_BOX_WEIGHT_DESC', 'Wie hoch ist im Schnitt das Gewicht der Verpackung eines kleinen bis mittleren Paketes?');

define('SHIPPING_BOX_PADDING_TITLE', 'Prozentuale Mehrkosten f&uuml;r schwerere Pakete.');
define('SHIPPING_BOX_PADDING_DESC', 'Prozentuale Mehrkosten f&uuml;r schwerere Pakete. F&uuml;r 10% einfach 10 eingeben.');

define('PRODUCT_LIST_IMAGE_TITLE', 'Artikelbild anzeigen');
define('PRODUCT_LIST_IMAGE_DESC', 'M&ouml;chten Sie ein Artikelbild anzeigen?');

define('PRODUCT_LIST_MANUFACTURER_TITLE', 'Artikelhersteller anzeigen');
define('PRODUCT_LIST_MANUFACTURER_DESC', 'M&ouml;chten Sie den Hersteller des Artikels anzeigen?');

define('PRODUCT_LIST_MODEL_TITLE', 'Artikelmodell anzeigen');
define('PRODUCT_LIST_MODEL_DESC', 'M&ouml;chten Sie das Artikelmodell anzeigen?');

define('PRODUCT_LIST_NAME_TITLE', 'Artikelname anzeigen');
define('PRODUCT_LIST_NAME_DESC', 'M&ouml;chten Sie den Artikelnamen anzeigen?');

define('PRODUCT_LIST_PRICE_TITLE', 'Artikelpreis anzeigen');
define('PRODUCT_LIST_PRICE_DESC', 'M&ouml;chten Sie den Artikelpreis anzeigen?');

define('PRODUCT_LIST_QUANTITY_TITLE', 'Artikelanzahl anzeigen');
define('PRODUCT_LIST_QUANTITY_DESC', 'M&ouml;chten Sie die Anzahl der vorhandenen Artikel anzeigen?');

define('PRODUCT_LIST_WEIGHT_TITLE', 'Artikelgewicht anzeigen');
define('PRODUCT_LIST_WEIGHT_DESC', 'M&ouml;chten Sie das Artikelgewicht anzeigen?');

define('PRODUCT_LIST_BUY_NOW_TITLE', 'Jetzt Kaufen anzeigen');
define('PRODUCT_LIST_BUY_NOW_DESC', 'M&ouml;chten Sie den \'Jetzt Kaufen\' Button anzeigen?');

define('PRODUCT_LIST_FILTER_TITLE', 'Kategorie/Hersteller Filter anzeigen');
define('PRODUCT_LIST_FILTER_DESC', 'M&ouml;chten Sie den Kategorie/Hersteller Filter anzeigen (0:aus,1:an)?');

define('PRODUCT_LIST_SORT_ORDER_TITLE', 'Display Product Sort Order');
define('PRODUCT_LIST_SORT_ORDER_DESC', 'Do you want to display the Product Sort Order column?');

define('PREV_NEXT_BAR_LOCATION_TITLE', 'Position der Zur&uuml;ck/Vor Navigation');
define('PREV_NEXT_BAR_LOCATION_DESC', 'Legt die Position der Zur&uuml;ck/Vor Navigation fest (1:oben, 2:unten, 3:beides)');

define('STOCK_CHECK_TITLE', 'Bestandspr&uuml;fung');
define('STOCK_CHECK_DESC', 'Soll der Shop eine Bestandspr&uuml;fung durchf&uuml;hren?');

define('STOCK_LIMITED_TITLE', 'Lagerbestand aktualisieren');
define('STOCK_LIMITED_DESC', 'Soll der Shop nach einem Kauf den Artikel vom Bestand abziehen?');

define('STOCK_ALLOW_CHECKOUT_TITLE', 'Kaufen erlauben');
define('STOCK_ALLOW_CHECKOUT_DESC', 'Darf ein Kunde die Kaufabwicklung auch abschliessen, wenn er Artikel gekauft hat, die nicht mehr vorr&auml;tig sind?');

define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE', 'Produktmarkierung, wenn nicht auf Lager');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC', 'Kennzeichnung f&uuml;r Produkte, die nicht mehr vorr&auml;tig sind');

define('STOCK_REORDER_LEVEL_TITLE', 'Unterschrittene Mengen im Lagerbestand');
define('STOCK_REORDER_LEVEL_DESC', 'Ab diesem Bestand erfolgt eine Meldung an den Administrator');

define('USE_CACHE_TITLE', 'Benutze Cache');
define('USE_CACHE_DESC', 'Soll die Seite zwischengespeichert werden?');

define('EMAIL_TRANSPORT_TITLE', 'E-Mail Versandmethode');
define('EMAIL_TRANSPORT_DESC', 'Definiert, ob dieser Server eine lokale Verbindung zu sendmail oder eine SMTP-Verbindung &uuml;ber TCP/IP benutzt. Bei Servern, die unter Windows oder MacOS laufen sollte SMTP eingetragen werden.');

define('EMAIL_LINEFEED_TITLE', 'E-Mail Linefeeds');
define('EMAIL_LINEFEED_DESC', 'Defines the character sequence used to separate mail headers.');

define('EMAIL_USE_HTML_TITLE', 'Benutze MIME HTML beim Versand von E-Mails');
define('EMAIL_USE_HTML_DESC', 'Sende E-Mails im HTML-Format');

define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE', 'Pr&uuml;fe E-Mail Adressen &uuml;ber DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC', 'E-Mail Adressen werden durch einen DNS-Server &uuml;berpr&uuml;ft.');

define('SEND_EMAILS_TITLE', 'Sende E-Mails');
define('SEND_EMAILS_DESC', 'Verschicke E-Mails');

define('DOWNLOAD_ENABLED_TITLE', 'Erm&ouml;gliche Download');
define('DOWNLOAD_ENABLED_DESC', 'Aktiviert die Shop-Funktionen, die es erm&ouml;glichen Datei herunterzuladen.');

define('DOWNLOAD_BY_REDIRECT_TITLE', 'Download by redirect');
define('DOWNLOAD_BY_REDIRECT_DESC', 'Use browser redirection for download. Disable on non-Unix systems.');

define('DOWNLOAD_MAX_DAYS_TITLE', 'Ablaufzeit (Tage)');
define('DOWNLOAD_MAX_DAYS_DESC', 'Setzt die Anzahl der Tage, nach denen der Link ung&uuml;ltig wird. 0 hei&szlig;t immer g&uuml;tig.');

define('DOWNLOAD_MAX_COUNT_TITLE', 'Maximale Anzahl der Downloads');
define('DOWNLOAD_MAX_COUNT_DESC', 'Setzt die maximal m&ouml;gliche Anzahl der Downloads, 0 hei&szlig;t dass kein Download erlaubt ist.');

define('DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE_TITLE', 'Downloads Controller Update Status Value');
define('DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE_DESC', 'What orders_status resets the Download days and Max Downloads - Default is 4');

define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG_TITLE', 'Downloads Controller Download on hold message');
define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG_DESC', 'Downloads Controller Download on hold message');

define('DOWNLOADS_CONTROLLER_ORDERS_STATUS_TITLE', 'Downloads Controller Order Status Value');
define('DOWNLOADS_CONTROLLER_ORDERS_STATUS_DESC', 'Downloads Controller Order Status Value - Default=2');

define('WEB_PRINTER_TITLE', 'WebPrinter');
define('WEB_PRINTER_DESC', 'M&ouml;chten Sie Ihre Versandetiketten &uuml;ber Toshiba Tec WebPrinter drucken?');

define('WEB_PRINTER_EMAIL_TITLE', 'per E-Mail');
define('WEB_PRINTER_EMAIL_DESC', 'Soll die Druckdatei per E-Mail versendet werden?');

define('WEB_PRINTER_FTP_TITLE', 'per FTP');
define('WEB_PRINTER_FTP_DESC', 'Soll die Druckdatei per FTP an den WebPrinter &uuml;bertragen werden?');

define('WEB_PRINTER_XML_TITLE', 'per XML');
define('WEB_PRINTER_XML_DESC', 'Soll die Druckdatei per XML an den WebPrinter &uuml;bertragen werden?');

define('PRINTER_EMAIL_TITLE', 'WebPrinter E-Mail Adresse');
define('PRINTER_EMAIL_DESC', 'Die e-Mail Adresse von Ihrem Toshiba Tec WebPrinter');

define('OOS_PRINTER_TEMP_TITLE', 'Temp-Verzeichnis');
define('OOS_PRINTER_TEMP_DESC', 'Temp Verzeichnis f&uuml;r Ihre WebPrinter Dateien');

define('PRINTER_DELETE_FILE_TITLE', 'L&ouml;schen der Temp-Dateien');
define('PRINTER_DELETE_FILE_DESC', 'Soll die Druckdatei nach der &Uuml;bertragung an den WebPrinter gel&ouml;scht werden?');

define('PRINTER_STORE_NAME_TITLE', 'Absender Name');
define('PRINTER_STORE_NAME_DESC', 'Der Name des Absenders');

define('PRINTER_STORE_STREET_ADDRESS_TITLE', 'Strasse und Hausnummer');
define('PRINTER_STORE_STREET_ADDRESS_DESC', 'Strasse und Hausnummer der Absender-Adresse');

define('PRINTER_STORE_STREET_POSTCODE_TITLE', 'Postleitzahl');
define('PRINTER_STORE_STREET_POSTCODE_DESC', 'Die Postleitzahl der Absender-Adresse');

define('PRINTER_STORE_STREET_CITY_TITLE', 'Stadt');
define('PRINTER_STORE_STREET_CITY_DESC', 'Die Stadt der Absender-Adresse');

define('PRINTER_STORE_COUNTRY_TITLE', 'Land');
define('PRINTER_STORE_COUNTRY_DESC', 'Das Land der Absender-Adresse');

define('PDF_DATA_SHEET_TITLE', 'Erm&ouml;gliche PDF-Prospekt');
define('PDF_DATA_SHEET_DESC', 'M&ouml;chten Sie die Produktinformationen als PDF-Datei zum download anbieten?');

define('HEADER_COLOR_TABLE_TITLE', 'Farbe: Prospektkopf-Tabelle');
define('HEADER_COLOR_TABLE_DESC', 'Farbe in R, G, B, Werten (Beispiel: 230,230,230)');

define('PRODUCT_NAME_COLOR_TABLE_TITLE', 'Farbe: Produkname-Tabelle');
define('PRODUCT_NAME_COLOR_TABLE_DESC', 'Farbe in R, G, B, Werten (Beispiel: 230,230,230)');

define('FOOTER_CELL_BG_COLOR_TITLE', 'Hintergundfarbe: Prospektfuss');
define('FOOTER_CELL_BG_COLOR_DESC', 'Farbe in R, G, B, Werten (Beispiel: 210,210,210)');

define('SHOW_BACKGROUND_TITLE', 'Hintergrund');
define('SHOW_BACKGROUND_DESC', 'M&ouml;chten Sie die Hintergrundfarbe angezeigen?');

define('PAGE_BG_COLOR_TITLE', 'Hintergundfarbe: Prospekt');
define('PAGE_BG_COLOR_DESC', 'Farbe in R, G, B, Werten (Beispiel: 250,250,250)');

define('SHOW_WATERMARK_TITLE', 'Wasserzeichen');
define('SHOW_WATERMARK_DESC', 'M&ouml;chten Sie Ihren Firmenname als Wasserzeichen angezeigen?');

define('PAGE_WATERMARK_COLOR_TITLE', 'Wasserzeichenfarbe');
define('PAGE_WATERMARK_COLOR_DESC', 'Farbe in R, G, B, Werten (Beispiel: 236,245,255)');

define('PDF_IMAGE_KEEP_PROPORTIONS_TITLE', 'Produktbilder');
define('PDF_IMAGE_KEEP_PROPORTIONS_DESC', 'M&ouml;chten Sie die maximale bzw. minimale Produktgr&ouml;sse verwenden?');

define('MAX_IMAGE_WIDTH_TITLE', 'Breite der Produktbilder');
define('MAX_IMAGE_WIDTH_DESC', 'max. Breite in mm der Produktbilder');

define('MAX_IMAGE_HEIGHT_TITLE', 'H&ouml;he der Produktbilder');
define('MAX_IMAGE_HEIGHT_DESC', 'max. H&ouml;he in mm der Produktbilder');

define('PDF_TO_MM_FACTOR_TITLE', 'Faktor');
define('PDF_TO_MM_FACTOR_DESC', 'Produktbilder');

define('SHOW_PATH_TITLE', 'Kategoriename');
define('SHOW_PATH_DESC', 'M&ouml;chten Sie den Kategorienamen anzeigen?');

define('SHOW_IMAGES_TITLE', 'Produktbild');
define('SHOW_IMAGES_DESC', 'M&ouml;chten Sie das Produktbild anzeigen?');

define('SHOW_NAME_TITLE', 'Produktname');
define('SHOW_NAME_DESC', 'M&ouml;chten Sie den Produktnamen in der Beschreibung anzeigen?');

define('SHOW_MODEL_TITLE', 'Bestellnummer');
define('SHOW_MODEL_DESC', 'M&ouml;chten Sie die Bestellnummer anzeigen?');

define('SHOW_DESCRIPTION_TITLE', 'Produktbeschreibung');
define('SHOW_DESCRIPTION_DESC', 'M&ouml;chten Sie die Produktbeschreibung anzeigen?');

define('SHOW_MANUFACTURER_TITLE', 'Hersteller');
define('SHOW_MANUFACTURER_DESC', 'M&ouml;chten Sie den Hersteller anzeigen?');

define('SHOW_PRICE_TITLE', 'Produktpreis');
define('SHOW_PRICE_DESC', 'M&ouml;chten Sie den Produktpreis anzeigen?');

define('SHOW_SPECIALS_PRICE_TITLE', 'Sonderangebote');
define('SHOW_SPECIALS_PRICE_DESC', 'M&ouml;chten Sie den Angebotspreis anzeigen?');

define('SHOW_SPECIALS_PRICE_EXPIRES_TITLE', 'Datum Sonderangebote');
define('SHOW_SPECIALS_PRICE_EXPIRES_DESC', 'M&ouml;chten Sie das G&uuml;ltigkeitsdatum der Angebotspreise anzeigen?');

define('SHOW_TAX_CLASS_ID_TITLE', 'Steuersatz');
define('SHOW_TAX_CLASS_ID_DESC', 'M&ouml;chten Sie den Steuersatz anzeigen?');

define('SHOW_OPTIONS_TITLE', 'Produktoptionen');
define('SHOW_OPTIONS_DESC', 'M&ouml;chten Sie die Produktoptionen anzeigen?');

define('SHOW_OPTIONS_PRICE_TITLE', 'Preis der Produktoptionen');
define('SHOW_OPTIONS_PRICE_DESC', 'M&ouml;chten Sie die Preise der Produktoptionen anzeigen?');

define('SECURITY_CODE_LENGTH_TITLE', 'Einl&ouml;sungscode');
define('SECURITY_CODE_LENGTH_DESC', 'Setzt die L&auml;nge des Einl&ouml;ngscodes, je l&auml;nger dieser ist, desto sicherer ist er.');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Neukunden Gutschein');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Setzt die H&ouml;he des Gutscheines, den ein Neukunde geschenkt bekommt fest. Feld leer lassen, wenn Neukunden kein \'Begr&uuml;&szlig;ungsgeschenk\' bekommen sollen.');

define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Coupon-ID');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Dies ist die Coupon-ID, die ein Neukunde per E-Mail erh&auml;lt. Ist keine ID gesetzt, wird keine E-Mail verschickt.');

define('STORE_TEMPLATES_TITLE', 'Layout Vorlage');
define('STORE_TEMPLATES_DESC', 'Shop Templates');

define('SHOW_DATE_ADDED_AVAILABLE_TITLE', 'Produkt - Datum');
define('SHOW_DATE_ADDED_AVAILABLE_DESC', 'M&ouml;chten Sie im Shop das Datum von der Aufnahme des Produktes zeigen?');

define('SHOW_COUNTS_TITLE', 'Artikelanzahl in den jeweiligen Kategorien');
define('SHOW_COUNTS_DESC', 'Anzeigen, wieviele Produkte in jeder Kategorie vorhanden sind');

define('CATEGORIES_BOX_SCROLL_LIST_ON_TITLE', 'Kategorien-Auswahlliste');
define('CATEGORIES_BOX_SCROLL_LIST_ON_DESC', 'M&ouml;chten Sie die Kategorien als Auswahlliste anzeigen?');

define('CATEGORIES_SCROLL_BOX_LEN_TITLE', 'Kategorie-Menge');
define('CATEGORIES_SCROLL_BOX_LEN_DESC', 'Wenn Sie die Kategorien als Auswahlliste anzeigen wollen, legen Sie hier die L&auml;nge fest');

define('SHOPPING_CART_IMAGE_ON_TITLE', 'Bild im Warenkorbinhalt');
define('SHOPPING_CART_IMAGE_ON_DESC', 'M&ouml;chten Sie in der Detailansicht vom Warenkorb das Porduktbild anzeigen?');

define('SHOPPING_CART_MINI_IMAGE_TITLE', 'Bildverkleinerung');
define('SHOPPING_CART_MINI_IMAGE_DESC', 'Wert f&uuml;r die Verkleinerung in der Detailansicht vom Warenkorb');

define('DISPLAY_CART_TITLE', 'Warenkorb anzeigen');
define('DISPLAY_CART_DESC', 'Zeigt den Warenkorb an, nachdem diesem ein Produkt hinzugef&uuml;gt wurde');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE', 'Empfehlen auch f&uuml;r G&auml;ste');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC', 'G&auml;sten erlauben, ein Produkt zu empfehlen');

define('ALLOW_CATEGORY_DESCRIPTIONS_TITLE', 'Erlaube Kategorienbeschreibung');
define('ALLOW_CATEGORY_DESCRIPTIONS_DESC', 'Erlaubt eine ausf&uuml;hrliche Beschreibung der einzelnen Kategorien');

define('ALLOW_NEWS_CATEGORY_DESCRIPTIONS_TITLE', 'Erlaube News-Kategorienbeschreibung');
define('ALLOW_NEWS_CATEGORY_DESCRIPTIONS_DESC', 'Erlaubt eine ausf&uuml;hrliche Beschreibung der einzelnen News-Kategorien');

define('SHOW_PRODUCTS_MODEL_TITLE', 'Navigation mit Bestellnummer');
define('SHOW_PRODUCTS_MODEL_DESC', 'M&ouml;chten Sie die auf der Produkt-Informations-Seite die Bestellnummer in der Navation anzeigen?');

define('BREADCRUMB_SEPARATOR_TITLE', 'Trenner f&uuml;r Men&uuml;ebenenanzeige');
define('BREADCRUMB_SEPARATOR_DESC', 'Trenner f&uuml;r die Anzeige der Men&uuml;ebene, in der sich der Kunde gerade aufh&auml;lt.');

define('BLOCK_BEST_SELLERS_IMAGE_TITLE', 'Bild im Block Verkaufschlager');
define('BLOCK_BEST_SELLERS_IMAGE_DESC', 'Bild im Content-Block Verkaufschlager anzeigen?');

define('BLOCK_PRODUCTS_HISTORY_IMAGE_TITLE', 'Bild im Block besuchte Produkte');
define('BLOCK_PRODUCTS_HISTORY_IMAGE_DESC', 'Bild im Content-Block gekaufte Produkte anzeigen?');

define('BLOCK_WISHLIST_IMAGE_TITLE', 'Bild im Block Wunschliste');
define('BLOCK_WISHLIST_IMAGE_DESC', 'Bild im Content-Block Wunschliste anzeigen?');

define('BLOCK_XSELL_PRODUCTS_IMAGE_TITLE', 'Bild im Block &auml;hnliche Produkte');
define('BLOCK_XSELL_PRODUCTS_IMAGE_DESC', 'Bild im Content-Block &auml;hnliche Produkte anzeigen?');

define('OOS_GD_LIB_VERSION_TITLE', 'GD-Bibliothek');
define('OOS_GD_LIB_VERSION_DESC', '1 f&uuml;r alte GD-Lib Version (1.x)<br> 2 f&uuml;r aktuelle GD-Lib Version (2.x)');

define('OOS_SMALLIMAGE_WAY_OF_RESIZE_TITLE', 'Bildbearbeitung kleines Bild');
define('OOS_SMALLIMAGE_WAY_OF_RESIZE_DESC', '0: proportionale Verkleinerung; Breite oder H&ouml;he ist die maximale Gr&ouml;&szlig;e<br> 1: Bild wird proportional in das neue Bild kopiert. Die Hintergrundfarbe wird  ber&uuml;cksichtigt.<br> 2: ein Ausschnitt wird in das neue Bild kopiert');

define('OOS_IMAGE_BGCOLOUR_R_TITLE', 'Hintergrund kleines Bild R');
define('OOS_IMAGE_BGCOLOUR_R_DESC', 'Rotwert f&uuml;r kleines Produktbild');

define('OOS_IMAGE_BGCOLOUR_G_TITLE', 'Hintergrund kleines Bild G');
define('OOS_IMAGE_BGCOLOUR_G_DESC', 'Gr&uuml;nwert f&uuml;r kleines Produktbild');

define('OOS_IMAGE_BGCOLOUR_B_TITLE', 'Hintergrund kleines Bild B');
define('OOS_IMAGE_BGCOLOUR_B_DESC', 'Blauwert f&uuml;r kleines Produktbild');

define('OOS_BIGIMAGE_WAY_OF_RESIZE_TITLE', 'Bildbearbeitung grosses Bild');
define('OOS_BIGIMAGE_WAY_OF_RESIZE_DESC', '0: proportionale Verkleinerung; Breite oder H&ouml;he ist die maximale Gr&ouml;&szlig;e<br> 1: Bild wird proportional in das neue Bild kopiert. Die Hintergrundfarbe wird  ber&uuml;cksichtigt.<br> 2: ein Ausschnitt wird in das neue Bild kopiert');

define('OOS_BIGIMAGE_WIDTH_TITLE', 'Breite grosses Bild');
define('OOS_BIGIMAGE_WIDTH_DESC', 'Breite vom grossen Bild in Pixel');

define('OOS_BIGIMAGE_HEIGHT_TITLE', 'H&ouml;he grosses Bild');
define('OOS_BIGIMAGE_HEIGHT_DESC', 'H&ouml;he vom grossen Bild in Pixel');

define('OOS_WATERMARK_TITLE', 'Wasserzeichen');
define('OOS_WATERMARK_DESC', 'M&ouml;chten Sie im grossen Bild ein Wasserzeichen einf&uuml;gen?');

define('OOS_WATERMARK_QUALITY_TITLE', 'Qualit&auml;t vom Wasserzeichen');
define('OOS_WATERMARK_QUALITY_DESC', 'Hier legen Sie die Qualit&auml;t vom Wasserzeichen fest');

define('OOS_IMAGE_SWF_TITLE', 'Ming');
define('OOS_IMAGE_SWF_DESC', 'Ist Ming installiert?');

define('OOS_SWF_MOVIECLIP_TITLE', 'Flash-Film');
define('OOS_SWF_MOVIECLIP_DESC', 'M&ouml;chten Sie das kleine Produktbild in einen Flash-Film umwandeln?');

define('OOS_SWF_BGCOLOUR_R_TITLE', 'Hintergrund vom Flashfilm R');
define('OOS_SWF_BGCOLOUR_R_DESC', 'Rotwert f&uuml;r kleines Produktbild im Flashfilm');

define('OOS_SWF_BGCOLOUR_G_TITLE', 'Hintergrund vom Flashfilm G');
define('OOS_SWF_BGCOLOUR_G_DESC', 'Gr&uuml;nwert f&uuml;r kleines Produktbild im Flashfilm');

define('OOS_SWF_BGCOLOUR_B_TITLE', 'Hintergrund vom Flashfilm B');
define('OOS_SWF_BGCOLOUR_B_DESC', 'Blauwert f&uuml;r kleines Produktbild im Flashfilm');

define('OOS_RANDOM_PICTURE_NAME_TITLE', 'Dateiname');
define('OOS_RANDOM_PICTURE_NAME_DESC', 'Zuf&auml;llig erzeugter Dateiname f&uuml;r die Grafik');

define('OOS_MO_PIC_TITLE', 'Mehr Produktbilder');
define('OOS_MO_PIC_DESC', 'Weitere Produktbilder auf der Produktinfoseite zeigen?');

define('PSM_TITLE', 'Preissuchmaschine');
define('PSM_DESC', 'M&ouml;chten Sie Die Schnittstelle zur Preissuchmaschine verwenden? Hierf&uuml;r ist eine Anmeldung bei <A HREF=\"http://www.preissuchmaschine.de/psm_frontend/main.asp?content=mitmachenreissuchmaschine\" TARGET=\"_blank\">http://www.preissuchmaschine.de</A> n');

define('OOS_PSM_DIR_TITLE', 'Verzeichnis Preissuchmaschine');
define('OOS_PSM_DIR_DESC', 'Die Datei f&uuml;r die Preissuchmaschine soll in diesem Shop-Verzeichnis gespeichert werden.');

define('OOS_PSM_FILE_TITLE', 'Dateiname');
define('OOS_PSM_FILE_DESC', 'Die Datei f&uuml;r die Preissuchmaschine');

define('OOS_META_TITLE_TITLE', 'Shop Titel');
define('OOS_META_TITLE_DESC', 'Der Titel');

define('OOS_META_DESCRIPTION_TITLE', 'Beschreibung');
define('OOS_META_DESCRIPTION_DESC', 'Die Beschreibung Ihres Shop(max. 250 Zeichen)');

define('OOS_META_KEYWORDS_TITLE', 'Suchworte');
define('OOS_META_KEYWORDS_DESC', 'Geben Sie hier Ihre Schl&uuml;sselw&ouml;rter(durch Komma getrennt) ein(max. 250 Zeichen)');

define('OOS_META_PAGE_TOPIC_TITLE', 'Thema');
define('OOS_META_PAGE_TOPIC_DESC', 'Das Thema Ihres Shop');

define('OOS_META_LANGUAGE_TITLE', 'Sprache');
define('OOS_META_LANGUAGE_DESC', 'Geben Sie hier Ihre Sprache ein');

define('OOS_META_AUDIENCE_TITLE', 'Zielgruppe');
define('OOS_META_AUDIENCE_DESC', 'Ihre Zielgruppe');

define('OOS_META_AUTHOR_TITLE', 'Autor');
define('OOS_META_AUTHOR_DESC', 'Der Autor des Shop');

define('OOS_META_COPYRIGHT_TITLE', 'Copyright');
define('OOS_META_COPYRIGHT_DESC', 'Der Entwickler des Shop');

define('OOS_META_PAGE_TYPE_TITLE', 'Seitentyp');
define('OOS_META_PAGE_TYPE_DESC', 'Typ der Internetpr&auml;senz');

define('OOS_META_PUBLISHER_TITLE', 'Herausgeber');
define('OOS_META_PUBLISHER_DESC', 'Der Herausgeber');

define('OOS_META_ROBOTS_TITLE', 'Indizierung');
define('OOS_META_ROBOTS_DESC', 'Typ der Indizierung');

define('OOS_META_EXPIRES_TITLE', 'G&uuml;ltigkeitsdauer');
define('OOS_META_EXPIRES_DESC', 'Angebot verf&auml;llt am:( 0 f&uuml;r h&auml;ufig ge&auml;nderte Sites)');

define('OOS_META_PAGE_PRAGMA_TITLE', 'Proxy Caching');
define('OOS_META_PAGE_PRAGMA_DESC', 'Ihr Shop soll von Proxys zwischengespeichert werden?');

define('OOS_META_REVISIT_AFTER_TITLE', 'Wiederbesuchen nach');
define('OOS_META_REVISIT_AFTER_DESC', 'Wann soll die Suchmaschine Ihre Seite wiederbesuchen?');

define('OOS_META_DETAILS_TITLE', 'Details im Title-Tag');
define('OOS_META_DETAILS_DESC', '1 f&uuml;r Produktbezeichnung und Pfad <br> 2 f&uuml;r nur Produktbezeichnung');

define('OOS_META_PRODUKT_TITLE', 'Pflege im Artikel');
define('OOS_META_PRODUKT_DESC', 'M&ouml;chten Sie Keywords und Description f&uuml;r jeden Artikel pflegen?');

define('OOS_META_KATEGORIEN_TITLE', 'Pflege in Kategorien');
define('OOS_META_KATEGORIEN_DESC', 'M&ouml;chten Sie Keywords und Description f&uuml;r jede Kategorie pflegen');

define('OOS_META_INDEX_PAGE_TITLE', 'Index Seite erzeugen');
define('OOS_META_INDEX_PAGE_DESC', 'M&ouml;chten Sie eine Index-Seite mit allen Artikeln f&uuml;r Suchmaschinen erzeugen?');

define('OOS_META_INDEX_PATH_TITLE', 'Pfad f&uuml;r IndexSeite');
define('OOS_META_INDEX_PATH_DESC', 'Die Datei f&uuml;r die Suchmaschinen soll in diesem Shop-Verzeichnis gespeichert werden.');

define('ADMIN_CONFIG_KEYWORD_SHOW_TITLE', 'Keyword Show (ADMIN)');
define('ADMIN_CONFIG_KEYWORD_SHOW_DESC', 'Check searches from your own IP address ? (each search will be displayed)');

define('OOS_CONFIG_KEYWORD_SHOW_TITLE', 'Keyword Show Visitors');
define('OOS_CONFIG_KEYWORD_SHOW_DESC', 'Check the Customers/Guests searches ? (each search will be displayed)');

define('CONFIG_KEYWORD_SHOW_EXCLUDED_TITLE', 'Keyword Show (exclude this IP-Address)');
define('CONFIG_KEYWORD_SHOW_EXCLUDED_DESC', 'Your own IP Address, can be excluded through ADMIN<br>(like webmaster/owners/Beta-testers)');

define('KEYWORD_SHOW_LOG_PATH_TITLE', 'Keyword Show (absolute path to your logfile)');
define('KEYWORD_SHOW_LOG_PATH_DESC', 'Put here absolute path to your logfile, include the name of logfile<br>(non-compressed or compressed,.gz logfile)');

define('ENABLE_LINKS_COUNT_TITLE', 'Z&auml;hler');
define('ENABLE_LINKS_COUNT_DESC', 'Die Klicks auf Weblinks sollen gez&auml;hlt werden.');

define('ENABLE_SPIDER_FRIENDLY_LINKS_TITLE', 'Spider-frundliche Links');
define('ENABLE_SPIDER_FRIENDLY_LINKS_DESC', 'Erm&ouml;gliche Spider-freundliche Links (empfohlen). ACHTUNG: Es sind ggf. &Auml;nderungen in der Konfiguration des Webservers notwendig!');

define('LINKS_IMAGE_WIDTH_TITLE', 'Breite des Link-Bildes');
define('LINKS_IMAGE_WIDTH_DESC', 'Maximale Breite eines Bildes zu einem Link in Pixeln.');

define('LINKS_IMAGE_HEIGHT_TITLE', 'H&ouml;he des Link-Bildes');
define('LINKS_IMAGE_HEIGHT_DESC', 'Maximale H&ouml;he eines Bildes zu einem Link in Pixeln.');

define('LINK_LIST_IMAGE_TITLE', 'Anzeige des Link-Bildes');
define('LINK_LIST_IMAGE_DESC', 'Soll das Bild zum Link angezeigt werden?');

define('LINK_LIST_URL_TITLE', 'Anzeige der Link-URL');
define('LINK_LIST_URL_DESC', 'Soll die Link-URL angezeigt werden?');

define('LINK_LIST_TITLE_TITLE', 'Anzeige des Link-Titels');
define('LINK_LIST_TITLE_DESC', 'Soll der Linktitel angezeigt werden?');

define('LINK_LIST_DESCRIPTION_TITLE', 'Anzeige der Link-Beschreibung');
define('LINK_LIST_DESCRIPTION_DESC', 'Soll die Beschreibung des Links angezeigt werden?');

define('LINK_LIST_COUNT_TITLE', 'Anzeige der Link-Z&auml;hler');
define('LINK_LIST_COUNT_DESC', 'Sollen der Z&auml;hler f&uuml;r die Linkbesuche angezeigt werden?');

define('ENTRY_LINKS_TITLE_MIN_LENGTH_TITLE', 'Minimale L&auml;nge des Link-Titels');
define('ENTRY_LINKS_TITLE_MIN_LENGTH_DESC', 'Minimale L&auml;nge des Link-Titels');

define('ENTRY_LINKS_URL_MIN_LENGTH_TITLE', 'Minimale L&auml;nge der Link-URL');
define('ENTRY_LINKS_URL_MIN_LENGTH_DESC', 'Minimale L&auml;nge der Link-URL');

define('ENTRY_LINKS_DESCRIPTION_MIN_LENGTH_TITLE', 'Minimale L&auml;nge der Link-Beschreibung');
define('ENTRY_LINKS_DESCRIPTION_MIN_LENGTH_DESC', 'Minimale L&auml;nge der Link-Beschreibung');

define('ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH_TITLE', 'Minimale L&auml;nge des Kontaktnamens zum Link');
define('ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH_DESC', 'Minimale L&auml;nge des Kontaktnamens zum Link');

define('LINKS_CHECK_PHRASE_TITLE', 'Ausdruck f&uuml;r Linkpr&uuml;fung');
define('LINKS_CHECK_PHRASE_DESC', 'Ausdruck, nach dem gesucht wird, wenn eine Linkpr&uuml;fung ausgef&uuml;hrt wird.');

define('DISPLAY_NEWSFEED_TITLE', 'Newsfeed anbieten');
define('DISPLAY_NEWSFEED_DESC', 'M&ouml;chten Sie Ihren Kunden RDF/RSS Newsfeed anbieten?');

define('MULTIPLE_CATEGORIES_USE_TITLE', 'Multi-Kategorien nutzen');
define('MULTIPLE_CATEGORIES_USE_DESC', 'Auf true setzen, um das Hinzuf&uuml;gen eines Produkts zu mehreren Kategorien mit einem Klick zu erm&ouml;glichen.');

define('OOS_SPAW_TITLE', 'SPAW PHP WYSIWYG Editor');
define('OOS_SPAW_DESC', 'SPAW PHP WYSIWYG bei der Datenerfassung verwenden?');

define('SLAVE_LIST_IMAGE_TITLE', 'Anzeige des Slave-Bildes');
define('SLAVE_LIST_IMAGE_DESC', 'Soll das Produktbild gezeigt werden?');

define('SLAVE_LIST_MANUFACTURER_TITLE', 'Anzeige des Slave-Herstellers');
define('SLAVE_LIST_MANUFACTURER_DESC', 'Soll der Name des Produktherstellers angezeigt werden?');

define('SLAVE_LIST_MODEL_TITLE', 'Anzeige des Slave-Modells');
define('SLAVE_LIST_MODEL_DESC', 'Soll das Produktmodell angezeigt werden?');

define('SLAVE_LIST_NAME_TITLE', 'Anzeige des Slave-Names');
define('SLAVE_LIST_NAME_DESC', 'Soll der Produktname angezeigt werden?');

define('SLAVE_LIST_PRICE_TITLE', 'Anzeige des Slave-Preises');
define('SLAVE_LIST_PRICE_DESC', 'Soll der Produktpreis angezeigt werden?');

define('SLAVE_LIST_QUANTITY_TITLE', 'Anzeige der Slave-Anzahl');
define('SLAVE_LIST_QUANTITY_DESC', 'Soll die Anzahl der Produkte angezeigt werden?');

define('SLAVE_LIST_WEIGHT_TITLE', 'Anzeige des Slave-Gewichts');
define('SLAVE_LIST_WEIGHT_DESC', 'Soll das Produktgewicht angezeigt werden?');

define('SLAVE_LIST_BUY_NOW_TITLE', 'Jetzt kaufen');
define('SLAVE_LIST_BUY_NOW_DESC', 'Soll die \'Jetzt kaufen\'-Zeile angezeigt werden?');

define('RCS_BASE_DAYS_TITLE', 'Look back days');
define('RCS_BASE_DAYS_DESC', 'Number of days to look back from today for abandoned cards.');

define('RCS_REPORT_DAYS_TITLE', 'Sales Results Report days');
define('RCS_REPORT_DAYS_DESC', 'Number of days the sales results report takes into account. The more days the longer the SQL queries!.');

define('RCS_EMAIL_TTL_TITLE', 'E-Mail time to live');
define('RCS_EMAIL_TTL_DESC', 'Number of days to give for emails before they no longer show as being sent');

define('RCS_EMAIL_FRIENDLY_TITLE', 'Friendly E-Mails');
define('RCS_EMAIL_FRIENDLY_DESC', 'If <b>true</b> then the customer\'s name will be used in the greeting. If <b>false</b> then a generic greeting will be used.');

define('RCS_SHOW_ATTRIBUTES_TITLE', 'Show Attributes');
define('RCS_SHOW_ATTRIBUTES_DESC', 'Controls display of item attributes.<br><br>Some sites have attributes for their items.<br><br>Set this to <b>true</b> if yours does and you want to show them, otherwise set to <b>false</b>.');

define('RCS_CHECK_SESSIONS_TITLE', 'Ignore Customers with Sessions');
define('RCS_CHECK_SESSIONS_DESC', 'If you want the tool to ignore customers with an active session (ie, probably still shopping) set this to <b>true</b>.<br><br>Setting this to <b>false</b> will operate in the default manner of ignoring session data &amp; using less resources');

define('RCS_CURCUST_COLOR_TITLE', 'Current Customer Hilight');
define('RCS_CURCUST_COLOR_DESC', 'Color for the word/phrase used to notate a current customer<br><br>A current customer is someone who has purchased items from your store in the past.');

define('RCS_UNCONTACTED_COLOR_TITLE', 'Uncontacted hilight Hilight');
define('RCS_UNCONTACTED_COLOR_DESC', 'Row highlight color for uncontacted customers.<br><br>An uncontacted customer is one that you have <i>not</i> used this tool to send an email to before.');

define('RCS_CONTACTED_COLOR_TITLE', 'Contacted hilight Hilight');
define('RCS_CONTACTED_COLOR_DESC', 'Row highlight color for contacted customers.<br><br>An contacted customer is one that you <i>have</i> used this tool to send an email to before.');

define('RCS_MATCHED_ORDER_COLOR_TITLE', 'Matching Order Hilight');
define('RCS_MATCHED_ORDER_COLOR_DESC', 'Row highlight color for entrees that may have a matching order.<br><br>An entry will be marked with this color if an order contains one or more of an item in the abandoned cart <b>and</b> matches either the cart\'s customer email address or database ID.');

define('RCS_SKIP_MATCHED_CARTS_TITLE', 'Skip Carts w/Matched Orders');
define('RCS_SKIP_MATCHED_CARTS_DESC', 'To ignore carts with an a matching order set this to <b>true</b>.<br><br>Setting this to <b>false</b> will cause entries with a matching order to show, along with the matching order\'s status.<br><br>See documentation for details.');

define('RCS_PENDING_SALE_STATUS_TITLE', 'Lowest Pending sales status');
define('RCS_PENDING_SALE_STATUS_DESC', 'The highest value that an order can have and still be considered pending. Any value higher than this will be considered by RCS as sale which completed.<br><br>See documentation for details.');

define('RCS_REPORT_EVEN_STYLE_TITLE', 'Report Even Row Style');
define('RCS_REPORT_EVEN_STYLE_DESC', 'Style for even rows in results report. Typical options are <i>dataTableRow</i> and <i>attributes-even</i>.');

define('RCS_REPORT_ODD_STYLE_TITLE', 'Report Odd Row Style');
define('RCS_REPORT_ODD_STYLE_DESC', 'Style for odd rows in results report. Typical options are NULL (ie, no entry) and <i>attributes-odd</i>.');

define('RCS_EMAIL_COPIES_TO_TITLE', 'E-Mail Copies to');
define('RCS_EMAIL_COPIES_TO_DESC', 'If you want copies of emails that are sent to customers by this contribution, enter the email address here. If empty no copies are sent');

define('RCS_AUTO_CHECK_TITLE', 'Autocheck "safe" carts to email');
define('RCS_AUTO_CHECK_DESC', 'To check entries which are most likely safe to email (ie, not existing customers, not previously emailed, etc.) set this to <b>true</b>.<br><br>Setting this to <b>false</b> will leave all entries unchecked (you will have to check each entry you want to send an email for).');

define('RCS_CARTS_MATCH_ALL_DATES_TITLE', 'Match orders from any date');
define('RCS_CARTS_MATCH_ALL_DATES_DESC', 'If <b>true</b> then any order found with a matching item will be considered a matched order.<br><br>If <b>false</b> only orders placed after the abandoned cart are considered.');
?>
