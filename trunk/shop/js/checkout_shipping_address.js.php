<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_shipping_address.php,v 1.8 2003/02/13 04:23:22 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

?>
<script type="text/javascript" language="JavaScript">
/*<![CDATA[*/

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

// one button is not an array
  if (document.checkout_address.address[0]) {
    document.checkout_address.address[buttonSelect].checked=true;
  } else {
    document.checkout_address.address.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}

function check_form() {
  var error = 0;
  var error_message = "<?php echo $aLang['js_error']; ?>";

  var firstname = document.checkout_address.firstname.value;
  var lastname = document.checkout_address.lastname.value;
  var street_address = document.checkout_address.street_address.value;
  var postcode = document.checkout_address.postcode.value;
  var city = document.checkout_address.city.value;

  if (firstname == '' && lastname == '' && street_address == '') {
    return true;
  }

<?php
  if (ACCOUNT_GENDER == 'true') {
?>
  if (document.checkout_address.elements['gender'].type != "hidden") {
    if (document.checkout_address.gender[0].checked || document.checkout_address.gender[1].checked) {
    } else {
      error_message = error_message + "<?php echo decode($aLang['js_gender']); ?>";
      error = 1;
    }
  }
<?php
  }
?>
  if (firstname == "" || firstname.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo decode($aLang['js_first_name']); ?>";
    error = 1;
  }

  if (lastname == "" || lastname.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo decode($aLang['js_last_name']); ?>";
    error = 1;
  }

  if (street_address == "" || street_address.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo decode($aLang['js_address']); ?>";
    error = 1;
  }

  if (postcode == "" || postcode.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo decode($aLang['js_post_code']); ?>";
    error = 1;
  }

  if (city == "" || city.length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo decode($aLang['js_city']); ?>";
    error = 1;
  }
<?php
  if (ACCOUNT_STATE == 'true') {
?>
  if (document.checkout_address.state.value == "" || document.checkout_address.state.length < <?php echo ENTRY_STATE_MIN_LENGTH; ?> ) {
     error_message = error_message + "<?php echo decode($aLang['js_state']); ?>";
     error = 1;
  }
<?php
  }
?>

  if (document.checkout_address.country.value == 0) {
    error_message = error_message + "<?php echo decode($aLang['js_country']); ?>";
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
/*]]>*/
</script>
