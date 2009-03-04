<?php
/* ----------------------------------------------------------------------
   $Id: search_advanced.php,v 1.5 2006/05/10 12:49:31 alf_alive Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: advanced_search.php,v 1.18 2003/02/16 00:42:02 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = '����������� �����';
$aLang['heading_title'] = '������� �������� ������';

$aLang['heading_search_criteria'] = '������� �����';

$aLang['text_search_in_description'] = '������ � ���������';
$aLang['entry_categories'] = '���������:';
$aLang['entry_include_subcategories'] = '������ � �������������';
$aLang['entry_manufacturers'] = '�������������:';
$aLang['entry_price_from'] = '�� ���� ��:';
$aLang['entry_price_to'] = '�� ���� ��:';
$aLang['entry_date_from'] = '�������� �:';
$aLang['entry_date_to'] = '�������� ��:';

$aLang['text_search_help_link'] = '<u>������ ��� ������������ ������</u> [?]';

$aLang['text_all_categories'] = '��� ���������';
$aLang['text_all_manufacturers'] = '��� �������������';

$aLang['heading_search_help'] = '������ ��� ������������ ������';
$aLang['text_search_help'] = '������� ������������ ������ ������ ��������� ����� � ������������� ��������� � �� ��������� � �������������� � �� ������ ��������.<br /><br />�� ������ ������������ ���������� ��������� "AND" ("�") ��� "OR" ("���")<br /><br />� �������:<u>Microsoft AND Maus</u>.<br /><br />��� �� ���� ����������� ������������� ������� ������:<br /><br /><u>Microsoft AND (Maus OR Tastatur OR "Visual Basic")</u>.<br /><br />��������� �������� �� ���������� ������ ����� � ���� �������.';
$aLang['text_close_window'] = '<u>������� ����</u> [x]';

$aLang['js_at_least_one_input'] = '* ���� �� ��������� ����� ������ ���� ���������:\n    ������� �����\n    �������� �\n    �������� ��\n    �� ���� ��\n    �� ���� ��\n';
$aLang['js_invalid_from_date'] = '* ������������ �������� �\n';
$aLang['js_invalid_to_date'] = '* ������������ �������� ��\n';
$aLang['js_to_date_less_than_from_date'] = '* ���� � ������ ���� ������ ��� ����� ������������ ���\n';
$aLang['js_price_from_must_be_num'] = '* �� ���� ��, ������ ���� ������\n';
$aLang['js_price_to_must_be_num'] = '* �� ���� ��, ������ ���� ������\n';
$aLang['js_price_to_less_than_price_from'] = '* �� ���� �� ������ ���� ������ ��� ����� �� ���� ��.\n';
$aLang['js_invalid_keywords'] = '* ������� ����� �����������!\n';
?>