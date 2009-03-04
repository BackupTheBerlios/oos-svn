<?php
/* ----------------------------------------------------------------------
   $Id: user_create_account_process.php,v 1.15 2007/11/04 17:41:57 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account_process.php,v 1.13 2002/11/19 01:48:08 dgw_
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title_1'] = 'Create an Account';
$aLang['navbar_title_2'] = 'Process';
$aLang['heading_title'] = 'My Account Information';

$aLang['email_subject'] = 'Welcome to ' . STORE_NAME;
$aLang['email_greet_mr'] = 'Dear Mr. ' . stripslashes($lastname) . ',' . "\n\n";
$aLang['email_greet_ms'] = 'Dear Ms. ' . stripslashes($lastname) . ',' . "\n\n";
$aLang['email_greet_none'] = 'Dear ' . stripslashes($firstname) . ',' . "\n\n";
$aLang['email_welcome'] = 'We welcome you to <b>' . STORE_NAME . '</b>.' . "\n\n";
$aLang['email_text'] = 'You can now take part in the <b>various services</b> we have to offer you. Some of these services include:' . "\n\n" . '<li><b>Permanent Cart</b> - Any products added to your online cart remain there until you remove them, or check them out.' . "\n" . '<li><b>Address Book</b> - We can now deliver your products to another address other than yours! This is perfect to send birthday gifts direct to the birthday-person themselves.' . "\n" . '<li><b>Order History</b> - View your history of purchases that you have made with us.' . "\n" . '<li><b>Products Reviews</b> - Share your opinions on products with our other customers.' . "\n\n";
$aLang['email_contact'] = 'For help with any of our online services, please email the store-owner: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n";
$aLang['email_warning'] = '<b>Note:</b> This email address was given to us by one of our customers. If you did not signup to be a member, please send a email to ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n";

$aLang['email_gv_incentive_header'] = 'As part of our welcome to new customers, we have sent you an e-Gift Voucher worth %s';
$aLang['email_gv_redeem'] = 'The redeem code for is %s, you can enter the redeem code when checking out, after making a purchase';
$aLang['email_gv_link'] = 'or by following this link ';
$aLang['email_coupon_incentive_header'] = 'Congratulation, to make your first visit to our online shop a more rewarding experience' . "\n" . 
                                        '  below are details of a Discount Coupon created just for you' . "\n\n";
$aLang['email_coupon_redeem'] = 'To use the coupon enter the redeem code which is %s during checkout, ' . "\n" . 
                               'after making a purchase';

$aLang['email_welcome_points'] = '<li><b>Reward Point Program</b> - As part of our Welcome to new customers, we have credited your %s with a total of %s Shopping Points.' . "\n" . 'Please refer to the %s as conditions may apply.';
$aLang['email_points_account'] = 'Shopping Points Accout';
$aLang['email_points_faq'] = 'Reward Point Program FAQ';

$aLang['email_password'] = 'Your password to \'' . STORE_NAME . '\' is:' . "\n\n" . '   %s' . "\n\n";

$aLang['email_disclaimer'] = '--- Disclaimer ------------------------------------------------------------' . "\n\n" .
                            'Your privacy:' . "\n\n" .
                            'We will never sell or trade your personal information. We will not' . "\n" .
                            'reveal your personal information to anyone except if required by lawful' . "\n" .
                            'authority. The only exception to the privacy of your information is' . "\n" .
                            'your name and email being visible to all readers that access your' . "\n" .
                            'contributions on ' . oos_server_get_base_url() . '.' . "\n\n" .
                            'Please note that your connection to ' . oos_server_get_base_url() . ', like your connection' . "\n" .
                            'to many other websites, is not encrypted. Your login and password are' . "\n" .
                            'transmitted in plain text over your internet connection and may be' . "\n" .
                            'readable by malicious users. For this reason, you must not use' . "\n" .
                            'credentials that are identical to any other service you subscribe to.' . "\n" .
                            'To be safe, make a unique password for each of your internet services.' . "\n\n" .
                            'Unsolicited Email:' . "\n\n" .
                            'This email was initiated on ' . strftime(DATE_FORMAT_LONG) . ' by the IP ' . oos_server_get_remote() . "\n" .
                            '(' . oos_server_get_var('REMOTE_HOST') . '). If this IP address was not yours at that time, and' . "\n" .
                            'you wish to persue the abuse, please do not delete this email.' . "\n" .
                            'Instead, kindly ask the responsible webmaster at ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n" .
                            'They can help you in most cases, but if you still feel unsatisfied then,' . "\n" .
                            'you may contact the ISP of the originating network of ' . oos_server_get_var('REMOTE_HOST') . '.' . "\n\n" .
                            'Important: The webmaster of ' . oos_server_get_base_url() . ' is contingently able to control' . "\n" .
                            'any abuses and is generally not resposible for this email.' . "\n\n" .
                            'If you do not wish to subscribe, simply do nothing. Thank you.';

                               
$aLang['owner_email_subject'] = 'New Customer';
$aLang['owner_email_date'] = 'Date:';
$aLang['owner_email_company_info'] = 'Company Details';
$aLang['owner_email_contact'] = 'Contact Information';
$aLang['owner_email_options'] = 'Options';
$aLang['owner_email_company'] = 'Company Name:';
$aLang['owner_email_owner'] = 'Owner';
$aLang['owner_email_number'] = 'Customer number';
$aLang['owner_email_gender'] = 'Gender:';
$aLang['owner_email_first_name'] = 'First Name:';
$aLang['owner_email_last_name'] = 'Last Name:';
$aLang['owner_email_date_of_birth'] = 'Date of Birth:';
$aLang['owner_email_address'] = 'E-Mail Address:';
$aLang['owner_email_street'] = 'Street Address:';
$aLang['owner_email_suburb'] = 'Suburb:';
$aLang['owner_email_post_code'] = 'Post Code:';
$aLang['owner_email_city'] = 'City:';
$aLang['owner_email_state'] = 'State/Province:';
$aLang['owner_email_country'] = 'Country:';
$aLang['owner_email_telephone_number'] = 'Telephone Number:';
$aLang['owner_email_fax_number'] = 'Fax Number:';
$aLang['owner_email_newsletter'] = 'Newsletter:';
$aLang['owner_email_newsletter_yes'] = 'Subscribed';
$aLang['owner_email_newsletter_no'] = 'Unsubscribed';
$aLang['email_separator'] = '------------------------------------------------------';

?>
