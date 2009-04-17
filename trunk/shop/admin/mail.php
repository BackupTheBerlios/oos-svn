<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: mail.php,v 1.30 2002/03/16 01:07:28 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if ( ($action == 'send_email_to_user') && isset($_POST['customers_email_address']) && !isset($_POST['back_x']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_result = $dbconn->Execute("SELECT customers_firstname, customers_lastname, customers_email_address FROM " . $oostable['customers']);
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;

      case '**D':
        $mail_result = $dbconn->Execute("SELECT customers_firstname, customers_lastname, customers_email_address FROM " . $oostable['customers'] . " WHERE customers_newsletter = '1'");
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;

      default:
        $customers_email_address = oos_db_prepare_input($_POST['customers_email_address']);

        $mail_result = $dbconn->Execute("SELECT customers_firstname, customers_lastname, customers_email_address FROM " . $oostable['customers'] . " WHERE customers_email_address = '" . oos_db_input($customers_email_address) . "'");
        $mail_sent_to = $_POST['customers_email_address'];
        break;
    }

    // Instantiate a new mail object
    $send_mail = new PHPMailer();

    $send_mail->PluginDir = OOS_ABSOLUTE_PATH . 'includes/lib/phpmailer/';

    $sLang = (isset($_SESSION['iso_639_1']) ? $_SESSION['iso_639_1'] : 'en');
    $send_mail->SetLanguage( $sLang, OOS_ABSOLUTE_PATH . 'includes/lib/phpmailer/language/' );

    $send_mail->CharSet = CHARSET;
    $send_mail->IsMail();

    $send_mail->From = $from_mail ? $from_mail : STORE_OWNER_EMAIL_ADDRESS;
    $send_mail->FromName = $from_name ? $from_name : STORE_OWNER;
    $send_mail->Mailer = EMAIL_TRANSPORT;

    // Add smtp values if needed
    if ( EMAIL_TRANSPORT == 'smtp' ) {
      $send_mail->IsSMTP(); // set mailer to use SMTP
      $send_mail->SMTPAuth = OOS_SMTPAUTH; // turn on SMTP authentication
      $send_mail->Username = OOS_SMTPUSER; // SMTP username
      $send_mail->Password = OOS_SMTPPASS; // SMTP password
      $send_mail->Host     = OOS_SMTPHOST; // specify main and backup server
    } else
      // Set sendmail path
      if ( EMAIL_TRANSPORT == 'sendmail' ) {
        if (!oos_empty(OOS_SENDMAIL)) {
          $send_mail->Sendmail = OOS_SENDMAIL;
          $send_mail->IsSendmail();
        }
    }

    $send_mail->Subject = $subject;

    while ($mail = $mail_result->fields) {
      $send_mail->Body = $message;
      $send_mail->AddAddress($mail['customers_email_address'], $mail['customers_firstname'] . ' ' . $mail['customers_lastname']);
      $send_mail->Send();
      $send_mail->ClearAddresses();
      $send_mail->ClearAttachments();

      // Move that ADOdb pointer!
      $mail_result->MoveNext();
    }
    oos_redirect_admin(oos_href_link_admin($aFilename['mail'], 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($action == 'preview') && !isset($_POST['customers_email_address']) ) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if (isset($_GET['mail_sent_to'])) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
  $no_js_general = true;
  require 'includes/oos_header.php';
?>
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<?php require 'includes/oos_blocks.php'; ?>
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ( ($action == 'preview') && isset($_POST['customers_email_address']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;

      case '**D':
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;

      default:
        $mail_sent_to = $_POST['customers_email_address'];
        break;
    }
?>
          <tr><?php echo oos_draw_form('mail', $aFilename['mail'], 'action=send_email_to_user'); ?>
            <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
              <tr>
                <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_CUSTOMER; ?></b><br /><?php echo $mail_sent_to; ?></td>
              </tr>
              <tr>
                <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM_NAME; ?></b><br /><?php echo htmlspecialchars(stripslashes($_POST['from_name'])); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM_MAIL; ?></b><br /><?php echo htmlspecialchars(stripslashes($_POST['from_mail'])); ?></td>
              </tr>
              <tr>
                <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b><br /><?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?></td>
              </tr>
              <tr>
                <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br /><?php echo nl2br(htmlspecialchars(stripslashes($_POST['message']))); ?></td>
              </tr>
              <tr>
                <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td>
<?php
/* Re-Post all POST'ed variables */
    reset($_POST);
    while (list($key, $value) = each($_POST)) {
      if (!is_array($_POST[$key])) {
        echo oos_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
      }
    }
?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><?php echo oos_image_swap_submits('back','back_off.gif', IMAGE_BACK, 'name="back"'); ?></td>
                    <td align="right"><?php echo '<a href="' . oos_href_link_admin($aFilename['mail']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a> ' . oos_image_swap_submits('send_mail','send_mail_off.gif', IMAGE_SEND_EMAIL); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  } else {
?>
          <tr><?php echo oos_draw_form('mail', $aFilename['mail'], 'action=preview'); ?>
            <td><table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
<?php
    $customers = array();
    $customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
    $customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
    $customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
    $mail_result = $dbconn->Execute("SELECT customers_email_address, customers_firstname, customers_lastname FROM " . $oostable['customers'] . " ORDER BY customers_lastname");
    while($customers_values = $mail_result->fields) {
      $customers[] = array('id' => $customers_values['customers_email_address'],
                           'text' => $customers_values['customers_lastname'] . ', ' . $customers_values['customers_firstname'] . ' (' . $customers_values['customers_email_address'] . ')');

      // Move that ADOdb pointer!
      $mail_result->MoveNext();
    }
?>
              <tr>
                <td class="main"><?php echo TEXT_CUSTOMER; ?></td>
                <td><?php echo oos_draw_pull_down_menu('customers_email_address', $customers, $_GET['customer']);?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_FROM_NAME; ?></td>
                <td><?php echo oos_draw_input_field('from_name', STORE_OWNER); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_FROM_MAIL; ?></td>
                <td><?php echo oos_draw_input_field('from_mail',STORE_OWNER_EMAIL_ADDRESS); ?></td></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_SUBJECT; ?></td>
                <td><?php echo oos_draw_input_field('subject'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
                <td><?php echo oos_draw_textarea_field('message', 'soft', '60', '15'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><?php echo oos_image_swap_submits('send_mail','send_mail_off.gif', IMAGE_SEND_EMAIL); ?></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  }
?>
<!-- body_text_eof //-->
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<?php require 'includes/oos_footer.php'; ?>
<br />
</body>
</html>
<?php require 'includes/oos_nice_exit.php'; ?>