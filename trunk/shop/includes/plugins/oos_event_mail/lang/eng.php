<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('PLUGIN_EVENT_MAIL_NAME', 'Send E-Mails');
define('PLUGIN_EVENT_MAIL_DESC', 'Send out e-mails');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE', 'Send Extra Order Emails To');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC', 'Send extra order emails to the following email addresses, in this format: Name 1 &lt;email@address1&gt;');

define('SEND_BANKINFO_TO_ADMIN_TITLE', 'Bankinfo per Mail');
define('SEND_BANKINFO_TO_ADMIN_DESC', 'M&ouml;chten Sie die Bankdaten aus dem Lastschriftverfahren mit der E-Mail erhalten?');

define('EMAIL_TRANSPORT_TITLE', 'E-Mail Transport Method.');
define('EMAIL_TRANSPORT_DESC', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.');

define('EMAIL_LINEFEED_TITLE', 'E-Mail Linefeeds');
define('EMAIL_LINEFEED_DESC', 'Defines the character sequence used to separate mail headers.');

define('EMAIL_USE_HTML_TITLE', 'Use MIME HTML When Sending Emails');
define('EMAIL_USE_HTML_DESC', 'Send e-mails in HTML format');

define('OOS_SMTPAUTH_TITLE', 'Sets SMTP authentication.');
define('OOS_SMTPAUTH_DESC', ' Utilizes the Username and Password variables.');

define('OOS_SMTPUSER_TITLE', 'SMTP username');
define('OOS_SMTPUSER_DESC', 'SMTP username');

define('OOS_SMTPPASS_TITLE', 'SMTP password');
define('OOS_SMTPPASS_DESC', 'SMTP password');

define('OOS_SMTPHOST_TITLE', 'Sets the SMTP hosts.');
define('OOS_SMTPHOST_DESC', 'All hosts must be separated by a semicolon.  You can also specify a different port for each host by using this format: [hostname:port]  (e.g. "smtp1.example.com:25;smtp2.example.com"). Hosts will be tried in order.');

define('OOS_SENDMAIL_TITLE', 'Sets the path of the sendmail program');
define('OOS_SENDMAIL_DESC', '/var/qmail/bin/sendmail');

