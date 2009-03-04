<?php
/* ----------------------------------------------------------------------
   $Id: gv_redeem.php,v 1.15 2007/12/17 11:42:12 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: gv_redeem.php,v 1.1.2.1 2003/05/15 23:04:32 wilt
   ----------------------------------------------------------------------
   The Exchange Project - Community Made Shopping!
   http://www.theexchangeproject.org

   Gift Voucher System v1.0
   Copyright (c) 2001,2002 Ian C Wilson
   http://www.phesis.org
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
/* ----------------------------------------------------------------------
   If you made a translation, please send to
      lang@oos-shop.de
   the translated file.
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = 'Gutschein benutzen';
$aLang['heading_title'] = 'Gutschein benutzen';

$aLang['text_information'] = 'F&uuml;r weitere Informationen zu Gutscheinen, lesen Sie bitte unsere <a href="' . oos_href_link($aModules['gv'], $aFilename['gv_faq']).'">Gutscheine, Fragen und Antworten</a>';
$aLang['text_invalid_gv'] = 'Der Gutscheincode kann ung&uuml;ltig sein oder ist schon benutzt worden. Sollten Fragen bestehen, wenden Sie sich an unseren <a href="' . oos_href_link($aModules['main'], $aFilename['contact_us']) . '">Vertrieb &uuml;ber unsere Kontaktseite</a>.';
$aLang['text_valid_gv'] = 'Herzlichen Gl&uuml;ckwunsch, Sie haben einen Gutschein im Wert von %s eingel&ouml;st.';
?>