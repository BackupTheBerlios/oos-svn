<?php
/* ----------------------------------------------------------------------
   $Id: ticket_status.php,v 1.5 2006/01/24 17:52:15 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ticket_status.php,v 1.3 2003/04/25 21:37:11 hook
   ----------------------------------------------------------------------
   OSC-SupportTicketSystem
   Copyright (c) 2003 Henri Schmidhuber IN-Solution
  
   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */


define('HEADING_TITLE', 'Ticketstatus');

define('TABLE_HEADING_TEXT_STATUS', 'Ticketstatus');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_DEFAULT_REPLY','Standard Kunde-Antwort-Status');
define('TEXT_DISPLAY_NUMBER_OF_TEXT_STATUS','Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Ticketstatus)');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_INFO_TEXT_STATUS_NAME', 'Ticketstatus:');
define('TEXT_INFO_INSERT_INTRO', 'Bitte geben Sie den neuen Status mit allen relevanten Daten ein');
define('TEXT_INFO_DELETE_INTRO', 'Sind Sie sicher, dass Sie diesen Status l&ouml;schen m&ouml;chten?');
define('TEXT_INFO_HEADING_NEW_TEXT_STATUS', 'Neuer Ticketstatus');
define('TEXT_INFO_HEADING_EDIT_TEXT_STATUS', 'Ticketstatus bearbeiten');
define('TEXT_INFO_HEADING_DELETE_TEXT_STATUS', 'Ticketstatus l&ouml;schen');

define('TEXT_SET_DEFAULT_REPLY','Neuer Status des Tickets wenn der Kunde antwortet');

define('ERROR_REMOVE_DEFAULT_TEXT_STATUS', 'Fehler: Der Standard-Ticketstatus kann nicht gel&ouml;scht werden. Bitte definieren Sie einen neuen Standard-Bestellstatus und wiederholen Sie den Vorgang.');
define('ERROR_STATUS_USED_IN_TICKET', 'Fehler: Dieser Ticketstatus wird zur Zeit noch bei den Tickets verwendet.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Fehler: Dieser Ticketstatus wird zur Zeit noch in der Tickethistorie verwendet.');
?>
