<?php
/* ----------------------------------------------------------------------
   $Id: links_form_check.js.php,v 1.6 2008/01/13 10:48:14 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: links_submit.php,v 1.00 2003/10/03 
   ----------------------------------------------------------------------
   Links Manager

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
?>
<script type="text/javascript" language="JavaScript">
/*<![CDATA[*/

var form = "";
var submitted = false;
var error = false;
var error_message = "";

function check_input(field_name, field_size, message) {
  if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
    var field_value = form.elements[field_name].value;

    if (field_value == '' || field_value.length < field_size) {
      error_message = error_message + "* " + message + "\n";
      error = true;
    }
  }
}

function check_form(form_name) {
  if (submitted == true) {
    alert("<?php echo $aLang['js_error_submitted']; ?>");
    return false;
  }

  error = false;
  form = form_name;
  error_message = "<?php echo $aLang['js_error']; ?>";

  check_input("links_title", <?php echo ENTRY_LINKS_TITLE_MIN_LENGTH; ?>, "<?php echo decode($aLang['entry_links_title_error']); ?>");
  check_input("links_url", <?php echo ENTRY_LINKS_URL_MIN_LENGTH; ?>, "<?php echo decode($aLang['entry_links_url_error']); ?>");
  check_input("links_description", <?php echo ENTRY_LINKS_DESCRIPTION_MIN_LENGTH; ?>, "<?php echo decode($aLang['entry_links_description_error']); ?>");
  check_input("links_contact_name", <?php echo ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH; ?>, "<?php echo decode($aLang['entry_links_contact_name_error']); ?>");
  check_input("links_contact_email", <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>, "<?php echo decode($aLang['entry_links_reciprocal_url_error']); ?>");
  check_input("links_reciprocal_url", <?php echo ENTRY_LINKS_URL_MIN_LENGTH; ?>, "<?php echo decode($aLang['js_email_address']); ?>");

  if (error == true) {
    alert(error_message);
    return false;
  } else {
    submitted = true;
    return true;
  }
}

/*]]>*/
</script>
