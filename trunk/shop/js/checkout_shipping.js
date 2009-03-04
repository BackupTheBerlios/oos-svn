// ----------------------------------------------------------------------
// $Id: checkout_shipping.js,v 1.2 2005/04/29 02:14:09 r23 Exp $
//
// OOS [OSIS Online Shop]
// http://www.oos-shop.de/
// 
// 
// Copyright (c) 2003 - 2005 by the OOS Development Team.
// ----------------------------------------------------------------------
// Based on:
//
// File: checkout_shipping.php,v 1.9 2003/02/22 17:34:00 wilt 
// orig:  checkout_shipping.php,v 1.14 2003/02/14 20:28:47 dgw_ 
// ----------------------------------------------------------------------
// osCommerce, Open Source E-Commerce Solutions
// http://www.oscommerce.com
//
// Copyright (c) 2003 osCommerce
// ----------------------------------------------------------------------
// Released under the GNU General Public License
// ----------------------------------------------------------------------


var selected;

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;
  buttonSelect = buttonSelect -1;

// one button is not an array
  if (document.checkout_address.shipping[0]) {
    document.checkout_address.shipping[buttonSelect].checked=true;
  } else {
    document.checkout_address.shipping.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

