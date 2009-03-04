<?php
/* ----------------------------------------------------------------------
   $Id: googel_conversion_tracking.js.php,v 1.2 2008/01/13 10:48:14 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
?>
<!-- Google Code for Purchase Conversion Page -->
<script type="text/javascript" language="JavaScript">
/*<![CDATA[*/

var google_conversion_id = <?php echo GOOGLE_CONVERSION_ID; ?>;
var google_conversion_language = "<?php echo GOOGLE_CONVERSION_LANGUAGE; ?>";
var google_conversion_format = "1";
var google_conversion_color = "666666";
if (1.0) {
  var google_conversion_value = 1.0;
}
var google_conversion_label = "Purchase";
/*]]>*/
</script>

<?php if ($request_type == 'SSL') { ?>

  <script language="JavaScript" src="https://www.googleadservices.com/pagead/conversion.js"></script>
  <noscript><img height=1 width=1 border=0 src="https://www.googleadservices.com/pagead/conversion/<?php echo GOOGLE_CONVERSION_ID; ?>/?value=1.0&label=Purchase&script=0"></noscript>

<?php }else { ?>

  <script language="JavaScript" src="http://www.googleadservices.com/pagead/conversion.js"></script>
  <noscript><img height=1 width=1 border=0 src="http://www.googleadservices.com/pagead/conversion/<?php echo GOOGLE_CONVERSION_ID; ?>/?value=1.0&label=Purchase&script=0"></noscript>

<?php } ?>

