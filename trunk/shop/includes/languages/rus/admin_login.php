<?php
/* ----------------------------------------------------------------------
   $Id: admin_login.php,v 1.6 2006/11/25 22:03:17 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: login.php,v 1.11 2002/06/03 13:19:42 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = 'Вход';
$aLang['heading_title'] = 'Администратор, Войдите';
$aLang['entry_key'] = 'Секретный Ключ'; // should be empty
$aLang['heading_admin_login'] = 'Вход с правами Покупателя';

$aLang['entry_email_address'] = 'E-Mail Адрес:';
$aLang['text_login_error'] = '<font color="#ff0000"><b>ОШИБКА:</b></font> Неправильный \'E-Mail Адрес\' и/или \'Пароль\'.';
$aLang['text_login_error2'] = '<font color="#ff0000"><b>NO ACCESS GRANTED: В связи с предшествующими чарджбэками или другим мошенничеством, Ваш пользователь заблокирован на нашем сайте.<br /><br /> Мы более не принимаем интернет заказов от Вашего пользователя.<br /><br />Если Вы хотите оформить заказ, Вы должны связаться с нами по телефону и выполнить предоплату заказа наличными или денежным переводом.<br /><br />Заказ будет скомплектован после получения подтверждения об оплате.<br /><br /> Пришлите нам копию платёжного свидетельства по почте или факсу.<br /><br />Заказ может быть доставлен только на проверенный адрес.</b></font><br /><br />';

$aLang['text_visitors_cart'] = '<font color="#ff0000"><b>ВНИМАНИЕ:</b></font> Содержимое Вашей &quot;Корзины&quot;, сформированое до входа, будет перемещено в Вашу &quot;Клиентскую Корзину&quot; как только Вы войдёте. <a href="javascript:session_win();">[Подробнее]</a>';

?>