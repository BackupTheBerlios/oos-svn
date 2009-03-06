<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File:: chp.php,v 1.01 2003/02/18 03:25:00 harley_vb 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
/********************************************************************
*	Copyright (C) 2002 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers
*       http://www.themedia.at & http://www.oscommerce.at
*
*                    All rights reserved.
*
* This program is free software licensed under the GNU General Public License (GPL).
*
*    This program is free software; you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program; if not, write to the Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
*    USA
*
*********************************************************************/
/* ----------------------------------------------------------------------
   If you made a translation, please send to 
      lang@oos-shop.de 
   the translated file. 
   ---------------------------------------------------------------------- */

define('MODULE_SHIPPING_CHP_STATUS_TITLE', 'Schweizerische Post');
define('MODULE_SHIPPING_CHP_STATUS_DESC', 'Wollen Sie den Versand über die schweizerische Post anbieten?');

define('MODULE_SHIPPING_CHP_HANDLING_TITLE', 'Handling Fee');
define('MODULE_SHIPPING_CHP_HANDLING_DESC', 'Bearbeitungsgebühr für diese Versandart in CHF');

define('MODULE_SHIPPING_CHP_TAX_CLASS_TITLE', 'Steuersatz');
define('MODULE_SHIPPING_CHP_TAX_CLASS_DESC', 'Wählen Sie den MwSt.-Satz für diese Versandart aus.');

define('MODULE_SHIPPING_CHP_ZONE_TITLE', 'Versand Zone');
define('MODULE_SHIPPING_CHP_ZONE_DESC', 'Wenn Sie eine Zone auswählen, wird diese Versandart nur in dieser Zone angeboten.');

define('MODULE_SHIPPING_CHP_SORT_ORDER_TITLE', 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_CHP_SORT_ORDER_DESC', 'Niedrigste wird zuerst angezeigt.');

define('MODULE_SHIPPING_CHP_COUNTRIES_1_TITLE', 'Tarifzone 0 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_1_DESC', 'Inlandszone');

define('MODULE_SHIPPING_CHP_COST_ECO_1_TITLE', 'Tariftabelle für Zone 0 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_1_DESC', 'Tarif Tabelle für die Inlandszone, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_1_TITLE', 'Tariftabelle für Zone 0 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_1_DESC', 'Tarif Tabelle für die Inlandszone, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_1_TITLE', 'Tariftabelle für Zone 0 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_1_DESC', 'Tarif Tabelle für die Zone 0, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COUNTRIES_2_TITLE', 'Tarifzone 1 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_2_DESC', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 1 sind.');

define('MODULE_SHIPPING_CHP_COST_ECO_2_TITLE', 'Tariftabelle für Zone 1 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_2_DESC', 'Tarif Tabelle für die Zone 1, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_2_TITLE', 'Tariftabelle für Zone 1 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_2_DESC', 'Tarif Tabelle für die Zone 1, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_2_TITLE', 'Tariftabelle für Zone 1 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_2_DESC', 'Tarif Tabelle für die Zone 1, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COUNTRIES_3_TITLE', 'Tarifzone 2 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_3_DESC', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 2 sind.');

define('MODULE_SHIPPING_CHP_COST_ECO_3_TITLE', 'Tariftabelle für Zone 2 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_3_DESC', 'Tarif Tabelle für die Zone 2, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_3_TITLE', 'Tariftabelle für Zone 2 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_3_DESC', 'Tarif Tabelle für die Zone 2, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_3_TITLE', 'Tariftabelle für Zone 2 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_3_DESC', 'Tarif Tabelle für die Zone 2, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COUNTRIES_4_TITLE', 'Tarifzone 3 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_4_DESC', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 3 sind.');

define('MODULE_SHIPPING_CHP_COST_ECO_4_TITLE', 'Tariftabelle für Zone 3 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_4_DESC', 'Tarif Tabelle für die Zone 3, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_4_TITLE', 'Tariftabelle für Zone 3 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_4_DESC', 'Tarif Tabelle für die Zone 3, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_4_TITLE', 'Tariftabelle für Zone 3 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_4_DESC', 'Tarif Tabelle für die Zone 3, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COUNTRIES_5_TITLE', 'Tarifzone 4 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_5_DESC', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 4 sind.');

define('MODULE_SHIPPING_CHP_COST_ECO_5_TITLE', 'Tariftabelle für Zone 4 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_5_DESC', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_5_TITLE', 'Tariftabelle für Zone 4 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_5_DESC', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_5_TITLE', 'Tariftabelle für Zone 4 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_5_DESC', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COUNTRIES_6_TITLE', 'Tarifzone 5 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_6_DESC', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 5 sind.');

define('MODULE_SHIPPING_CHP_COST_ECO_6_TITLE', 'Tariftabelle für Zone 5 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_6_DESC', 'Tarif Tabelle für die Zone 5, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_6_TITLE', 'Tariftabelle für Zone 5 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_6_DESC', 'Tarif Tabelle für die Zone 5, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_6_TITLE', 'Tariftabelle für Zone 5 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_6_DESC', 'Tarif Tabelle für die Zone 5, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COUNTRIES_7_TITLE', 'Tarifzone 6 Länder');
define('MODULE_SHIPPING_CHP_COUNTRIES_7_DESC', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 6 sind.');

define('MODULE_SHIPPING_CHP_COST_ECO_7_TITLE', 'Tariftabelle für Zone 6 bis 30 kg ECO');
define('MODULE_SHIPPING_CHP_COST_ECO_7_DESC', 'Tarif Tabelle für die Zone 6, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_PRI_7_TITLE', 'Tariftabelle für Zone 6 bis 30 kg PRI');
define('MODULE_SHIPPING_CHP_COST_PRI_7_DESC', 'Tarif Tabelle für die Zone 6, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.');

define('MODULE_SHIPPING_CHP_COST_URG_7_TITLE', 'Tariftabelle für Zone 6 bis 30 kg URG');
define('MODULE_SHIPPING_CHP_COST_URG_7_DESC', 'Tarif Tabelle für die Zone 6, basiered auf <b>\'URG\'</b> bis 30 kg Versandgewicht.');


$aLang['module_shipping_chp_text_title'] = 'Poste suisse';
$aLang['module_shipping_chp_text_description'] = 'La poste suisse';
$aLang['module_shipping_chp_text_way'] = 'Expédition pour';
$aLang['module_shipping_chp_text_units'] = 'kg';
$aLang['module_shipping_chp_invalid_zone'] = 'Une expédition dans ce pays n\’est malheureusement pas possible';
$aLang['module_shipping_chp_undefined_rate'] = 'Les frais d\'expéditions ne peuvent actuellement pas être calculés';
?>
