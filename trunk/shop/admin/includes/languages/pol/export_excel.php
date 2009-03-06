<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: backup.php,v 1.16 2002/03/16 21:30:02 hpdl
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


define('HEADING_TITLE', 'Administracja archiwami bazy danych');

define('TABLE_HEADING_TITLE', 'Nazwa');
define('TABLE_HEADING_FILE_DATE', 'Data');
define('TABLE_HEADING_FILE_SIZE', 'Rozmiar');
define('TABLE_HEADING_ACTION', 'Dziaanie');

define('TEXT_INFO_HEADING_NEW_BACKUP', 'Nowe Archiwum');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Przywracanie Danych');
define('TEXT_INFO_NEW_BACKUP', 'Nie przerywaj procesu archiwizacji - moe potrwa�kilka minut.');
define('TEXT_INFO_UNPACK', '<br><br>(po rozpakowaniu pliku z archiwum)');
define('TEXT_INFO_DATE', 'Data:');
define('TEXT_INFO_SIZE', 'Rozmiar:');
define('TEXT_INFO_COMPRESSION', 'Kompresja:');
define('TEXT_INFO_USE_GZIP', 'Uyj GZIP');
define('TEXT_INFO_USE_ZIP', 'Uyj ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Bez kompresji (czysty SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Tylko cignanie pliku (nie przechowuj go na serwerze)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Najlepiej z poczeniem HTTPS');
define('TEXT_DELETE_INTRO', 'Czy na pewno chcesz usun�to archiwum?');
define('TEXT_NO_EXTENSION', 'Brak');
define('TEXT_EXPORT_DIRECTORY', 'Katalog archiwum:');
define('TEXT_FORGET', '(<u>zapomnij</u>)');

define('ERROR_EXPORT_DIRECTORY_DOES_NOT_EXIST', 'Bd: Katalog archiwizacji nie istnieje. Ustaw go w pliku configure.php.');
define('ERROR_EXPORT_DIRECTORY_NOT_WRITEABLE', 'Bd: Nie mona zapisywa�do katalogu archiwizacji.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Bd: Problem z linkiem do cigni�ia pliku.');

define('SUCCESS_DATABASE_SAVED', 'Powiodo si� Baza zostaa zachowana.');
define('SUCCESS_DATABASE_RESTORED', 'Powiodo si� Baza zostaa przywr�ona.');
define('SUCCESS_EXPORT_DELETED', 'Powiodo si� archiwum zostao usuni�e.');
?>
