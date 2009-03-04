<?php
/* ----------------------------------------------------------------------
   $Id: ticket_view.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ticket_view.php,v 1.3 2003/04/25 21:37:12 hook 
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


$aLang['heading_title'] = 'Voir ticket de soutien';
$aLang['navbar_title'] = 'Voir ticket de soutien';

$aLang['table_heading_nr'] = 'No du ticket';
$aLang['table_heading_subject'] = 'Concerne';
$aLang['table_heading_status'] = 'Statut';
$aLang['table_heading_department'] = 'D�partement';
$aLang['table_heading_priority'] = 'Priorit�';
$aLang['table_heading_created'] = 'Ouvert';
$aLang['table_heading_last_modified'] = 'Derni�re modification';

$aLang['text_ticket_by'] = 'de';
$aLang['text_comment'] = 'R�ponse:';
$aLang['text_date'] = 'Date:';
$aLang['text_department'] = 'D�partement:';
$aLang['text_priority'] = 'Priorit�:';
$aLang['text_opened'] = 'Ouvert le:';
$aLang['text_status'] = 'Statut:';
$aLang['text_ticket_nr'] = 'No du ticket:';
$aLang['text_customers_orders_id'] = 'No de commande:';
$aLang['text_view_ticket_nr'] = 'Veuillez indiquer le no du ticket:';

$aLang['ticket_warning_enquiry_too_short'] = 'Erreur: Les donn�es ne correspondent pas � la quantit� minimum de commande de ' . TICKET_ENTRIES_MIN_LENGTH . ' Lettres';
$aLang['ticket_message_updated'] = 'Votre ticket a �t� actualis�';

aLang['text_view_ticket_login'] = '<a href="%s">Vous devez d\'abord vous enregistrer ci-joint, afin de consulter le ticket de soutien</a>';
?>
