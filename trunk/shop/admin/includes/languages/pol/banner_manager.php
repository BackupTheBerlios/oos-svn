<?php
/* ----------------------------------------------------------------------
   $Id: banner_manager.php,v 1.3 2006/01/24 17:52:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: banner_manager.php,v 1.17 2002/08/18 18:54:47 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('HEADING_TITLE', 'Zarzdzanie banerami');

define('TABLE_HEADING_BANNERS', 'Baner');
define('TABLE_HEADING_GROUPS', 'Grupa');
define('TABLE_HEADING_STATISTICS', 'Wywietle�/ Klikni�');
define('TABLE_HEADING_STATUS', 'Status');
define('TABLE_HEADING_ACTION', 'Dziaanie');

define('TEXT_BANNERS_TITLE', 'Nazwa banera:');
define('TEXT_BANNERS_URL', 'Adres URL banera:');
define('TEXT_BANNERS_GROUP', 'Grupa:');
define('TEXT_BANNERS_NEW_GROUP', ', lub wprowad now grup�baner� poniej');
define('TEXT_BANNERS_IMAGE', 'Obrazek:');
define('TEXT_BANNERS_IMAGE_LOCAL', ', lub podaj ciek�do pliku lokalnego');
define('TEXT_BANNERS_IMAGE_TARGET', 'Zapisz obrazek w (link obrazka):');
define('TEXT_BANNERS_HTML_TEXT', 'Tekst HTML:');
define('TEXT_BANNERS_EXPIRES_ON', 'Wygasa dnia:');
define('TEXT_BANNERS_OR_AT', ', lub po');
define('TEXT_BANNERS_IMPRESSIONS', 'wywietleniach.');
define('TEXT_BANNERS_SCHEDULED_AT', 'Rozpocznij dnia:');
define('TEXT_BANNERS_BANNER_NOTE', '<b>Informacje o banerze:</b><ul><li>Uyj obrazka lub tekstu HTML jako banera - nie obu na raz.</li><li>Tekst HTML ma wyszy priorytet ni obrazek.</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<b>Informacje o obrazku:</b><ul><li>Musisz miec prawo do zapisu w katalogach w kt�ych chcesz umieci�obrazki</li><li>Nie wypeniaj pola \'Zapisz obrazek w\' jeeli wgrywasz obrazka na serwer (np., jeeli uywasz lokalnego obrazka - znajdujcego si�na dysku serwera).</li><li>Pole \'Zapisz obrazek w\' musi wskazywa�na istniejcy katalog i ko�zy�si�slashem (np. banners/).</li></ul>');
define('TEXT_BANNERS_EXPIRCY_NOTE', '<b>Informacje o wygani�iu:</b><ul><li>Tylko jedno z dw�h p� powinno by�wypenione</li><li>Jeeli nie chcesz aby baner wygas automatycznie pozostaw to pole puste</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<b>Informacje o rozpocz�iu:</b><ul><li>Jeeli pole \'Rozpocz�ie Dnia\' jest ustawione emisja banera rozpocznie si�w tym dniu.</li><li>Wszystkie banery z ustawion dat startu emisji zaznaczone s jako wyczone. Wcz si�w dniu ustawionym przez pole \'Rozpocznij dnia\' .</li></ul>');

define('TEXT_BANNERS_DATE_ADDED', 'Data dodania:');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', 'Rozpocznij dnia: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', 'Wygasa dnia: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', 'Wygasa po: <b>%s</b> wywietl.');
define('TEXT_BANNERS_STATUS_CHANGE', 'Zmiana stanu: %s');

define('TEXT_BANNERS_DATA', 'D<br>A<br>N<br>E');
define('TEXT_BANNERS_LAST_3_DAYS', 'Ostatnie 3 dni');
define('TEXT_BANNERS_BANNER_VIEWS', 'Wywietlenia');
define('TEXT_BANNERS_BANNER_CLICKS', 'Klikni�ia');

define('TEXT_INFO_DELETE_INTRO', 'Czy na pewno chcesz usun�ten baner?');
define('TEXT_INFO_DELETE_IMAGE', 'Usu�r�nie obrazek');

define('SUCCESS_BANNER_INSERTED', 'Powiodo si� Baner zosta dodany.');
define('SUCCESS_BANNER_UPDATED', 'Powiodo si� Baner zosta zaktualizowany.');
define('SUCCESS_BANNER_REMOVED', 'Powiodo si� Baner zosta usuni�y.');
define('SUCCESS_BANNER_STATUS_UPDATED', 'Powiodo si� Status banera zosta zaktualizowany.');

define('ERROR_BANNER_TITLE_REQUIRED', 'Bd: Wymagana nazwa banera.');
define('ERROR_BANNER_GROUP_REQUIRED', 'Bd: Wymagana grupa banera.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Bd: Katalog nie istnieje: %s');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Bd: Nie mona zapisywa�do katalogu: %s');
define('ERROR_IMAGE_DOES_NOT_EXIST', 'Bd: Obrazek nie istnieje.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', 'Bd: Obrazek nie moe zosta�usuni�y.');
define('ERROR_UNKNOWN_STATUS_FLAG', 'Bd: Nieznany status.');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Bd: Katalog wykres� nie istnieje. Prosz�utworzy�katalog \'graphs\' w katalogu \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Bd: Nie mona zapisywa�do katalogu wykres�.');
?>
