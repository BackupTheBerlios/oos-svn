<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_confirmation.php,v 1.6.2.1 2003/05/03 23:41:23 wilt
   orig: checkout_confirmation.php,v 1.135 2003/02/14 20:28:46 dgw_
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

require 'includes/languages/' . $sLanguage . '/checkout_confirmation.php';
require 'includes/functions/function_address.php';

// if the customer is not logged on, redirect them to the login page
if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL',  'page' =>$aPages['checkout_payment']));
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['shopping_cart']));
}

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset($_SESSION['cart']->cartID) && isset($_SESSION['cartID'])) {
    if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
        MyOOS_CoreApi::redirect(oos_href_link($aPages['checkout_shipping'], '', 'SSL'));
    }
}


if ( isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid']) ) {
    if (isset($_POST['payment'])) $_SESSION['payment'] = oos_db_prepare_input($_POST['payment']);

    if ( (isset($_POST['comments'])) && (empty($_POST['comments'])) ) {
        $_SESSION['comments'] = '';
    } elseif (isset($_POST['comments'])) {
        $_SESSION['comments'] = oos_db_prepare_input($_POST['comments']);
    }

    if (isset($_POST['campaign_id']) && is_numeric($_POST['campaign_id'])) {
        $_SESSION['campaigns_id'] = intval($_POST['campaign_id']);
    }

    // if no shipping method has been selected, redirect the customer to the shipping method selection page
    if (!isset($_SESSION['shipping'])) {
      MyOOS_CoreApi::redirect(oos_href_link($aPages['checkout_shipping'], '', 'SSL'));
    }


    // if conditions are not accepted, redirect the customer to the payment method selection page
    if ( (DISPLAY_CONDITIONS_ON_CHECKOUT == '1') && (empty($_POST['gv_redeem_code'])) ) {
        if ($_POST['conditions'] == false) {
            $_SESSION['navigation']->remove_current_page();
            $_SESSION['navigation']->remove_last_page();

            $_SESSION['error_message'] = $aLang['error_conditions_not_accepted'];
            MyOOS_CoreApi::redirect(oos_href_link($aPages['checkout_payment'], '', 'SSL', true, false));
        }
    }


    // load the selected payment module
    require 'includes/classes/class_payment.php';

    if ($credit_covers) $_SESSION['payment'] = '';

    $oPaymentModules = new payment($_SESSION['payment']);
    require 'includes/classes/class_order_total.php';

    require 'includes/classes/class_order.php';
    $oOrder = new order;


    if ( (isset($_SESSION['shipping'])) && ($_SESSION['shipping']['id'] == 'free_free')) {
        if ( ($oOrder->info['total'] - $oOrder->info['shipping_cost']) < MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER ) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['checkout_shipping'], '', 'SSL'));
        }
    }

    $oPaymentModules->update_status();
    $oOrderTotalModules = new order_total;
    $oOrderTotalModules->collect_posts();


    if (isset($_SESSION['cot_gv'])) {
        $credit_covers = $oOrderTotalModules->pre_confirmation_check();
    }


    if ( (is_array($oPaymentModules->modules)) && (count($oPaymentModules->modules) > 1) && (!is_object($$_SESSION['payment'])) && (!$credit_covers) ) {
      $_SESSION['error_message'] = $aLang['error_no_payment_module_selected'];
      MyOOS_CoreApi::redirect(oos_href_link($aPages['checkout_payment'], '', 'SSL'));
    }

    if (is_array($oPaymentModules->modules)) {
      $oPaymentModules->pre_confirmation_check();
    }

    // load the selected shipping module
    require 'includes/classes/class_shipping.php';
    $shipping_modules = new shipping($_SESSION['shipping']);


    // Stock Check
    $any_out_of_stock = false;
    if (STOCK_CHECK == '1') {
        for ($i=0, $n=count($oOrder->products); $i<$n; $i++) {
            if (oos_check_stock($oOrder->products[$i]['id'], $oOrder->products[$i]['qty'])) {
                $any_out_of_stock = true;
            }
        }
        // Out of Stock
        if ( (STOCK_ALLOW_CHECKOUT != '1') && ($any_out_of_stock == true) ) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['shopping_cart']));
        }
    }

    // links breadcrumb
    $oBreadcrumb->add(decode($aLang['navbar_title_1']), oos_href_link($aPages['checkout_shipping'], '', 'SSL'));
    $oBreadcrumb->add(decode($aLang['navbar_title_2']));

    $aOption['template_main'] = $sTheme . '/modules/checkout_confirmation.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
    $aOption['breadcrumb'] = 'default/system/breadcrumb.html';

    $nPageType = OOS_PAGE_TYPE_CHECKOUT;

    require 'includes/oos_system.php';
    if (!isset($option)) {
      require 'includes/info_message.php';
      require 'includes/oos_blocks.php';
    }

    $oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
    $oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'pagetitle'         => htmlspecialchars($oos_pagetitle),
            'meta_description'  => htmlspecialchars($oos_meta_description),
            'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'confirmation.gif'
        )
    );

    if (MODULE_ORDER_TOTAL_INSTALLED) {
      $oOrderTotalModules->process();
      $order_total_output = $oOrderTotalModules->output();
      $oSmarty->assign('order_total_output', $order_total_output);
    }

    if (is_array($oPaymentModules->modules)) {
        if ($confirmation = $oPaymentModules->confirmation()) {
            $oSmarty->assign('confirmation', $confirmation);
        }
    }

    if (is_array($oPaymentModules->modules)) {
      $oPaymentModules_process_button =  $oPaymentModules->process_button();
    }

    $oSmarty->assign('payment_modules_process_button', $oPaymentModules_process_button);


    if (isset($$_SESSION['payment']->form_action_url)) {
        $form_action_url = $$_SESSION['payment']->form_action_url;
    } else {
        $form_action_url = oos_href_link($aPages['checkout_process'], '', 'SSL');
    }
    $oSmarty->assign('form_action_url', $form_action_url);
    $oSmarty->assign('order', $oOrder);

    $oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';

} else {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['checkout_shipping'], '', 'SSL'));

}


