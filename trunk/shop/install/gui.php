<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: gui.php,v 1.18.2.1 2002/04/03 21:03:19 jgm 
   ----------------------------------------------------------------------
   POST-NUKE Content Management System
   Copyright (C) 2001 by the Post-Nuke Development Team.
   http://www.postnuke.com/
   ----------------------------------------------------------------------
   Based on:
   PHP-NUKE Web Portal System - http://phpnuke.org/
   Thatware - http://thatware.org/
   ----------------------------------------------------------------------
   LICENSE

   This program is free software; you can redistribute it and/or
   modify it under the terms of the GNU General Public License (GPL)
   as published by the Free Software Foundation; either version 2
   of the License, or (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   To read the license please visit http://www.gnu.org/copyleft/gpl.html
   ----------------------------------------------------------------------
   Original Author of file:  Gregor J. Rothfuss
   Purpose of file: Provide gui rendering functions for the installer.
   ---------------------------------------------------------------------- */


  function oos_httpCoreDir() {
   if (!empty($_SERVER['SCRIPT_FILENAME'])) {
     return dirname($_SERVER['SCRIPT_FILENAME']) . '/';
   }
   return $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/';
  }


  function oos_realpath($directory) {
    return str_replace('\\', '/', realpath($directory));
  }


  function oos_guessInput($name, $values, $default='') {

    $selection = '<select name="'. $name .'">';
    foreach ($values as $k=>$v) {
      $selection .= '<option value="' . $k . '"';
      if ( $default == $k) {
        $selection .= ' selected="selected"';
      }
      $selection .= '>'. $v . '</option> ';
    }
    $selection .= '</select>';

    return  $selection;

  }



function print_CHMcheck() {
   global $currentlang;

   echo '<font class="oos-title">' . DBINFO . ':&nbsp;</font><br />' . "\n" .
        '<font class="oos-normal">' . CHM_CHECK_1 . '</font><br /><br />' . "\n" .
        '<form action="step.php" method="post"><center>' . "\n";
   print_FormEditabletext(0);
   echo '<input type="hidden" name="currentlang" value="' . $currentlang .'">' . "\n" .
        '<input type="hidden" name="op" value="Submit"><br /><br />' . "\n" .
        '<input type="submit" value="' . BTN_SUBMIT . '"></center></form>' . "\n";

}


function writeable_oosConfigure() {

  if (file_exists(oos_realpath(dirname(__FILE__) . '/../includes') . '/configure.php') && !is_writeable(oos_realpath(dirname(__FILE__) . '/../includes') . '/configure.php')) {
    @chmod(oos_realpath(dirname(__FILE__) . '/../includes') . '/configure.php', 0777);
  }
}


/**
 * This function prints the "This is your setting" area 
 */
function print_FormText() {
   global $dbhost, $dbuname, $dbpass, $dbname, $prefix_table, $dbtype;

   echo '<table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left">' . DBHOST . '</td>' . "\n" .
        '   <td class="toggle">' . $dbhost . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left">' . DBUNAME . '</td>' . "\n" .
        '   <td class="toggle">' . $dbuname . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left">' . DBPASS . '</td>' . "\n" .
        '  <td class="toggle">' . $dbpass . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left">' . DBNAME . '</td>' . "\n" .
        '   <td class="toggle">' . $dbname . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left">' . DBPREFIX . '</td>' . "\n" .
        '   <td class="toggle">' . $prefix_table . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left">' . DBTYPE . '</td>' . "\n" .
        '   <td class="toggle">' . $dbtype . '</td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";
}

function print_FormServer() {

   if ($_POST['enable_ssl'] == false) {
      $ssl = NO;
   } else {
      $ssl = YES;
   }
   echo '<table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">HTTP Server</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['oos_server'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">HTTPS SERVER</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['oos_ssl_server'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . CONFIG_VIRTUAL_1 . '</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $ssl . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
  
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain static1</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['static1'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain image01</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['image01'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain chive</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['chive'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .        
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain tracking</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['tracking'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain wordpress</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['wordpress'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
                
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . VIRTUAL_7 . '</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['oos_shop_dir'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . VIRTUAL_4 . '</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['oos_root_path'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_5 . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $_POST['oos_shop_path'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . VIRTUAL_9 . '</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $_POST['oos_template_dir'] . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";
}

function print_FormTmpServer() {

   if ($_POST['tmpsession'] == 'file') {
     $tmp_session = TMP_CONFIG_VIRTUAL_3;
   } else {
     $tmp_session = TMP_CONFIG_VIRTUAL_4;
   }
   if ($_POST['tmp_session_crypt'] == false) {
     $session_crypt = NO;
   } else {
     $session_crypt = YES;
   }
   echo '<table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . TMP_VIRTUAL_1 . ':</font></td>' . "\n" .
        '   <td><font class="oos-normal">' . $tmp_session . '</font></td>' . "\n" .
        ' </tr>' . "\n";
   if ($_POST['tmpsession'] == 'db') {
     echo  ' <tr>' . "\n" .
     '   <td align="left"><font class="oos-normal">' . TMP_CONFIG_VIRTUAL_5 . '</font></td>' . "\n" .
     '   <td><font class="oos-normal">' . $session_crypt . '</font></td>' . "\n" .
           ' </tr>' . "\n";
   }
   echo ' <tr>' . "\n" .
        '  <td colspan="2"><img src="images/trans.gif" border="0" alt="" width="1" height="10"></td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";
}


function print_FormEditabletext() {
   global $dbhost, $dbuname, $dbpass, $dbname, $prefix_table;

   echo '<table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . DBHOST . '<br /><font class="small">' . DBHOST_DESC . '</font></td>' . "\n" .
        '   <td><input type="text" name="dbhost" SIZE=30 maxlength=80 value="' . $dbhost . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . DBUNAME . '<br /><font class="small">' . DBUNAME_DESC . '</font></td>' . "\n" .
        '   <td><input type="text" name="dbuname" SIZE=30 maxlength=80 value="' . $dbuname . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . DBPASS . '<br /><font class="small">' . DBPASS_DESC . '</font></td>' . "\n" .
        '  <td><input type="text" name="dbpass" SIZE=30 maxlength=80 value="' . $dbpass . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . DBNAME . '<br /><font class="small">' . DBNAME_DESC . '</font></td>' . "\n" .
        '   <td><input type="text" name="dbname" SIZE=30 maxlength=80 value="' . $dbname . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . DBPREFIX . '<br /><font class="small">' . DBPREFIX_DESC . '</font></td>' . "\n" .
        '   <td><input type="text" name="prefix_table" SIZE=30 maxlength=80 value="' . $prefix_table .'"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">' . DBTYPE . '</font><br /><font class="small">' . DBTYPE_DESC . '</font></td>' . "\n" .
        '   <td><select name="dbtype"><option value="mysql" selected>&nbsp;MySQL&nbsp;</option><option value="mysqli">&nbsp;MySQLi&nbsp;</option><option value="postgres">&nbsp;Postgres&nbsp;</option></select></td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";

}


/**
 * This function prints the <input type=hidden> area 
 */
function print_FormHidden() {
   global $update;

   reset($_POST);
   while (list($key, $value) = each($_POST)) {
     if ( (!is_array($_POST[$key])) && ($key != 'op') ) {
       echo '<input type="hidden" name="'. $key . '" value="' . htmlspecialchars(stripslashes($value)) . '">' . "\n";
     }
   }

}

function print_DBHidden() {
   echo '<input type="hidden" name="currentlang" value="' . $_POST['currentlang'] . '">' . "\n" .
        '<input type="hidden" name="dbhost" value="' . $_POST['dbhost'] . '">' . "\n" .
        '<input type="hidden" name="dbuname" value="' . $_POST['dbuname'] . '">' . "\n" .
        '<input type="hidden" name="dbpass" value="' . $_POST['dbpass'] . '">' . "\n" .
        '<input type="hidden" name="dbname" value="' . $_POST['dbname'] . '">' . "\n" .
        '<input type="hidden" name="prefix_table" value="' . $_POST['prefix_table'] . '">' . "\n" .
        '<input type="hidden" name="dbtype" value="' . $_POST['dbtype'] . '">' . "\n";
}

function print_ServerHidden() {
   echo '<input type="hidden" name="host_conf" value="' . $_POST['host_conf'] . '">' . "\n" .
        '<input type="hidden" name="oos_server" value="' . $_POST['oos_server'] . '">' . "\n" .
        '<input type="hidden" name="oos_ssl_server" value="' . $_POST['oos_ssl_server'] . '">' . "\n" .
        '<input type="hidden" name="static1" value="' . $_POST['static1'] . '">' . "\n" .
        '<input type="hidden" name="image01" value="' . $_POST['image01'] . '">' . "\n" .
        '<input type="hidden" name="chive" value="' . $_POST['chive'] . '">' . "\n" .
        '<input type="hidden" name="tracking" value="' . $_POST['tracking'] . '">' . "\n" .
        '<input type="hidden" name="wordpress" value="' . $_POST['wordpress'] . '">' . "\n" .      
        '<input type="hidden" name="enable_ssl" value="' . $_POST['enable_ssl'] . '">' . "\n" .
        '<input type="hidden" name="oos_root_path" value="' . $_POST['oos_root_path'] . '">' . "\n" .
        '<input type="hidden" name="oos_shop_path" value="' . $_POST['oos_shop_path'] . '">' . "\n" .
        '<input type="hidden" name="oos_shop_dir" value="' . $_POST['oos_shop_dir'] . '">' . "\n" .
        '<input type="hidden" name="oos_template_dir" value="' . $_POST['oos_template_dir'] . '">' . "\n";
}

function print_ServerTmpHidden() {
   echo '<input type="hidden" name="tmpsession" value="' . $_POST['tmpsession'] . '">' . "\n" .
        '<input type="hidden" name="tmp_session_crypt" value="' . $_POST['tmp_session_crypt'] . '">' . "\n" .
        '<input type="hidden" name="enable_ssl" value="' . $_POST['enable_ssl'] . '">' . "\n";
}


function print_ConfigTmpServerInfo() {

  If ($_POST['rewrite'] != 'none') {
    $oos_shop_path = $_POST['oos_shop_path'];
    $oos_template_dir = $_POST['oos_template_dir'];
    $rewrite = $_POST['rewrite'];
    $oos_shop_dir = $_POST['oos_shop_dir'];

    printf(INSTALL_WRITE_FILE,
       '<font class="oos-error"><b>' . $oos_shop_path . '.htaccess</b></font>'
    );

    $htaccess = @file_get_contents($oos_shop_path . '.htaccess');

    if (php_sapi_name() == 'cgi' || php_sapi_name() == 'cgi-fcgi') {
      $htaccess_cgi = '_cgi';
    } else {
      $htaccess_cgi = '';
    }

    /* Detect comptability with php_value directives */

    if ($htaccess_cgi == '') {
      $response = '';
      $oos_host     = preg_replace('@^([^:]+):?.*$@', '\1', $_SERVER['HTTP_HOST']);
      $oos_shop_dir = $_POST['oos_shop_dir'];

      $old_htaccess = @file_get_contents($oos_shop_path . '.htaccess');
      $fp = @fopen($oos_shop_path . '.htaccess', 'w');
      if ($fp) {
        fwrite($fp, 'php_value register_globals off'. "\n" .'php_value session.use_trans_sid 0');
        fclose($fp);

        $sock = @fsockopen($oos_host, $_SERVER['SERVER_PORT'], $errorno, $errorstring, 10);
        if ($sock) {
          fputs($sock, "GET {$oos_shop_dir} HTTP/1.0\r\n");
          fputs($sock, "Host: $oos_host\r\n");
          fputs($sock, "User-Agent: OSIS Online Shop/{OOS_VERSION}\r\n");
          fputs($sock, "Connection: close\r\n\r\n");

          while (!feof($sock) && strlen($response) < 4096) {
            $response .= fgets($sock, 400);
          }
          fclose($sock);
        }

        /* If we get HTTP 500 Internal Server Error, we have to use the .cgi template */
        if (preg_match('@^HTTP/\d\.\d 500@', $response)) {
          $htaccess_cgi = '_cgi';
        }

        if (!empty($old_htaccess)) {
          $fp = @fopen($oos_shop_path . '.htaccess', 'w');
          fwrite($fp, $old_htaccess);
          fclose($fp);
        } else {
          @unlink($oos_shop_path. '.htaccess');
        }
      }
    }

    if ($rewrite == 'rewrite') {
      $template = 'htaccess' . $htaccess_cgi . '_rewrite.tpl';
    } elseif ($rewrite == 'errordocs') {
      $template = 'htaccess' . $htaccess_cgi . '_errordocs.tpl';
    } else {
      $template = 'htaccess' . $htaccess_cgi . '_normal.tpl';
    }

    if (!($a = file($oos_template_dir . 'htaccess/' . $template, 1))) {
      echo '<br/><font class="oos-error"><b>' . ERROR_TEMPLATE_FILE . '</b></font>';
    }

    $content = str_replace(
                 array(
                   '{PREFIX}',
                   '{errorFile}',
                   '{indexFile}',
                   '{logFile}',
                 ),

                 array(
                   $oos_shop_dir,
                   'error.php',
                   'index.php',
                   $oos_template_dir . 'logs/php_error.log',
                 ),

                 implode('', $a)
              );
    $fp = @fopen($oos_shop_path . '.htaccess', 'w');
    if (!$fp) {
      printf(FILE_WRITE_ERROR, '<font class="oos-error"><b>' . $oos_shop_path . '.htaccess</b></font>');
      printf(COPY_CODE_BELOW , $oos_shop_path . '.htaccess', 'oos', htmlspecialchars($content));
    } else {
      // Check if an old htaccess file existed and try to preserve its contents. Otherwise completely wipe the file.
      if ($htaccess != '' && preg_match('@^(.*)#\s+BEGIN\s+OOS.*#\s+END\s+OOS(.*)$@isU', $htaccess, $match)) {
        // Code outside from oos-code was found.
        fwrite($fp, $match[1] . $content . $match[2]);
      } else {
        fwrite($fp, $content);
      }
      fclose($fp);
      echo DONE;
    }
  } else {
    echo '<font class="oos-title">' . TMP_CONFIG_VIRTUAL_2 . '&nbsp;</font><br />' . "\n" .
         '<br /><br /><br /><center>';
    print_FormTmpServer();
    echo '<form name="ChangeTmpServer" action="step.php" method="post">' . "\n";
    print_FormHidden();
    echo '<input type="hidden" name="op" value="ChangeTmpServer">' . "\n" . 
         '<input type="submit" value="' . BTN_CHANGE_INFO . '"><br />' . "\n" .
         '</form></center>' . "\n" .
         '<br />' . "\n" .
         '<font class="oos-normal">' . CONFIG_VIRTUAL_3 . '</font><br /><br />' . "\n";

  }
  echo '<br>';
  echo '<table width="90%" align="center">' . "\n" .
       ' <tr>' . "\n" .
       '  <td align="center">' . "\n";
  echo '<form name="admin" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="Admin">' . "\n";
  echo '<input type="submit" value="' . BTN_NEXT . '">' . "\n" .
       '</form></td>' . "\n" .
       ' </tr>' . "\n" .
       '</table></form>' . "\n";
}


function print_ChangeTmpServer() {

   echo '<font class="oos-title">' . TMP_VIRTUAL_1 . ':&nbsp;</font>' . "\n" .
        '<font class="oos-normal">' . TMP_VIRTUAL_2 . '</font>' . "\n";

   if ($_POST['tmp_session_crypt'] == false) {
     $session_crypt = '<input type="checkbox" name="tmp_session_crypt">';
   } else {
     $session_crypt = '<input type="checkbox" name="tmp_session_crypt" checked>';
   }
   if ($_POST['tmpsession'] == 'file') {
     $tmp_session_file = '<input type="radio" name="tmpsession" value="file" checked>';
     $tmp_session_db = '<input type="radio" name="tmpsession" value="db">';
   } else {
     $tmp_session_file = '<input type="radio" name="tmpsession" value="file">';
     $tmp_session_db = '<input type="radio" name="tmpsession" value="db" checked>';
   }
   if ($_POST['tmpsession'] == 'file') {
     if (!is_dir(session_save_path())) {
       echo '<br /><font class="oos-error">' .  TMP_SESSION_NON_EXISTENT . '</font>' . "\n";
     } elseif (!is_writeable(session_save_path())) {
       echo '<br /><font class="oos-error">' .  TMP_SESSION_DIRECTORY_NOT_WRITEABLE . '</font>' . "\n"; 
     }
   }

   echo '<br /><br />' . "\n" .
        '<center><form action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . TMP_VIRTUAL_3 . '</font></td>' . "\n" .
        '  <td>' . $tmp_session_file . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . TMP_VIRTUAL_4 . '</font></td>' . "\n" .
        '  <td>' . $tmp_session_db  . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . TMP_VIRTUAL_5 . '</font></td>' . "\n" .
        '  <td>' . $session_crypt . '</td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";
   echo print_DBHidden();
   echo print_ServerHidden();
   echo '<input type="hidden" name="op" value="ConfigTmpServer">' . "\n" .
        '<input type="submit" value="' . BTN_SET_LOGIN . '">' . "\n" .
        '</form></center>' . "\n";
}


function print_Admin() {
   global $currentlang;

   echo '<font class="oos-title">' . CONTINUE_1 . ':&nbsp;</font>' . "\n" .
        '<font class="oos-normal">' . CONTINUE_2 . '</font>' . "\n" .
        '<br /><br />' . "\n" .
        '<center><form action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_GENDER . '</font></td>' . "\n" .
        '  <td><font class="oos-normal"><input type="radio" name="gender" value="m" checked>&nbsp;' . MALE . '&nbsp;&nbsp;<input type="radio" name="gender" value="f">&nbsp;' . FEMALE . '&nbsp;</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_FIRSTNAME . '</font></td>' . "\n" .
        '  <td><input type="text" name="firstname" SIZE=30 maxlength=80 value=""></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_NAME . '</font></td>' . "\n" .
        '  <td><input type="text" name="name" SIZE=30 maxlength=80 value="Admin"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_PASS . '</font></td>' . "\n" .
        '  <td><input type="password" name="pwd" SIZE=30 maxlength=80 value=""></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_REPEATPASS . '</font></td>' . "\n" .
        '  <td><input type="password" name="repeatpwd" SIZE=30 maxlength=80 value=""></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_EMAIL . '</font></td>' . "\n" .
        '  <td><input type="text" name="email" SIZE=30 maxlength=80 value="none@myoos.de"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_PHONE . '</font></td>' . "\n" .
        '  <td><input type="text" name="phone" SIZE=30 maxlength=80 value=""></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_FAX . '</font></td>' . "\n" .
        '  <td><input type="text" name="fax" SIZE=30 maxlength=80 value=""></td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n" .
        '<br /><br />' . "\n";
   print_FormHidden();
   echo '<input type="hidden" name="op" value="Login">' . "\n" .
        '<input type="submit" value="' . BTN_CONTINUE . '">' . "\n" .
        '</form></center>' . "\n";

}



function print_ChangeLogin() {
   global $currentlang, $gender, $firstname, $name, $pwd, $repeatpwd, $email, $phone, $fax, $root_path, $oos_url; 

   echo '<font class="oos-title">' . CONTINUE_1 . '</font>' . "\n";

   if ($pwd == '') {
     echo '<br /><font class="oos-error">' . ADMIN_ERROR . '&nbsp;' . ADMIN_PASSWORD_ERROR . '</font>' . "\n";
   } 
   if ($email == '') {
     echo '<br /><font class="oos-error">' . ADMIN_ERROR . '&nbsp;' . ADMIN_EMAIL_ERROR. '</font>' . "\n";
   }
   if ($pwd != $repeatpwd) {
     echo '<br /><font class="oos-error">' . ADMIN_ERROR . '&nbsp;' . PASSWORD_ERROR . '</font>' . "\n";
   } 
   if ($gender == 'm') {
     $oos_radio_gender = '<input type="radio" name="gender" value="m" checked>&nbsp;' . MALE . '&nbsp;&nbsp;<input type="radio" name="gender" value="f">&nbsp;' . FEMALE . '&nbsp';
   } else {
     $oos_radio_gender = '<input type="radio" name="gender" value="m">&nbsp;' . MALE . '&nbsp;&nbsp;<input type="radio" name="gender" value="f" checked>&nbsp;' . FEMALE . '&nbsp';
   }
   echo '<br /><br />' . "\n" .
        '<center><form action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_GENDER . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $oos_radio_gender . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_FIRSTNAME . '</font></td>' . "\n" .
        '  <td><input type="text" name="firstname" SIZE=30 maxlength=80 value="' . $firstname . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_NAME . '</font></td>' . "\n" .
        '  <td><input type="text" name="name" SIZE=30 maxlength=80 value="' . $name . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_PASS . '</font></td>' . "\n" .
        '  <td><input type="password" name="pwd" SIZE=30 maxlength=80 value="' . $pwd . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_REPEATPASS . '</font></td>' . "\n" .
        '  <td><input type="password" name="repeatpwd" SIZE=30 maxlength=80 value="' . $repeatpwd . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_EMAIL . '</font></td>' . "\n" .
        '  <td><input type="text" name="email" SIZE=30 maxlength=80 value="' . $email . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_PHONE . '</font></td>' . "\n" .
        '  <td><input type="text" name="phone" SIZE=30 maxlength=80 value="' . $phone . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_FAX . '</font></td>' . "\n" .
        '  <td><input type="text" name="fax" SIZE=30 maxlength=80 value="' . $fax . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left">&nbsp;</td>' . "\n" .
        '  <td>&nbsp;</td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";
   print_DBHidden();
   print_ServerHidden();
   print_ServerTmpHidden();
   echo '<input type="hidden" name="op" value="Login">' . "\n" .
        '<input type="submit" value="' . BTN_SET_LOGIN . '">' . "\n" .
        '</form></center>' . "\n";

}

function print_Login() {
   global $currentlang, $gender, $firstname, $name, $pwd, $repeatpwd, $email, $phone, $fax, $root_path, $oos_url; 

   $oos_gender = ($gender == 'm') ? MALE : FEMALE;

   echo '<font class="oos-title">' . CONTINUE_1 . ':&nbsp;</font>' . "\n" .
        '<font class="oos-normal">' . CONTINUE_3 . '</font>' . "\n" .
        '<br /><br />' . "\n" .
        '<form name="change login" action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_GENDER . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $oos_gender . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_FIRSTNAME . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $firstname . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_NAME . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $name . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_PASS . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . PASSWORD_HIDDEN . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_REPEATPASS . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . PASSWORD_HIDDEN . '</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_EMAIL . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $email . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_PHONE . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $phone . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . ADMIN_FAX . '</font></td>' . "\n" .
        '  <td><font class="oos-normal">' . $fax . '</font></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left">&nbsp;</td>' . "\n" .
        '  <td>&nbsp;</td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td>&nbsp;</td>' . "\n" .
        '  <td>' . "\n";
   print_FormHidden();
   echo '<input type="hidden" name="op" value="Change Login">' . "\n" . 
        '<input type="submit" value="' . BTN_CHANGE_INFO . '"><br />' . "\n" .
        '  </td>' . "\n" .
        ' </tr>' . "\n" .
        '</table></form>' . "\n" .
        '<font class="oos-normal">' . ADMIN_INSTALL . '</font>' . "\n" .
        '<form name="login install" action="step.php" method="post"><table width="80%" border="0" align="right">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="right">' . "\n";
   print_FormHidden();
   echo '<input type="hidden" name="op" value="Set Login">' . "\n" .
        '<input type="submit" value="' . BTN_LOGIN_SUBMIT . '">' . "\n" .
        ' </td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n" .
        '</form>' . "\n";

}

function print_SetLogin() {

   global $update;

   echo '<form action="step.php" method="post"><center><table width="50%">' . "\n";
   print_FormHidden();
   echo '<tr><td align=center><input type="hidden" name="op" value="Finish">' . "\n" .
        '<input type="submit" value="' . BTN_FINISH . '"></td></tr></table></center></form>' . "\n";
}


function print_oosFinish() {
   global $currentlang;

   $root_path = str_replace("\\","/",getcwd()); // "
   $root_path = str_replace("/install", "", $root_path);

   echo '<font class="oos-title">' . FINISH_1 . '&nbsp;</font>';
   echo '<font class="oos-normal">' . FINISH_2 . '<br /><br /><br />';
   echo '<form action="step.php" method="post">';
   echo '<center><textarea name="license" cols=50 rows=8>';

   include("credits.txt");

   echo '</textarea></form>';
   echo '<br /><br />' . FINISH_3 . '<br /></font>';
   echo '<br /><font class="oos-title">' .  $root_path . '</font><font class="oos-error">/install</font>';
   echo '<br /><br /><font class="oos-title"><a href="../admin/index.php">' . FINISH_4 . '</a></font>';
   echo '</center><br /><br />';
}


function oosSuccess() {
   echo '<font class="oos-title">' . SUCCESS_1 . '</font>' . "\n" .
         '<font class="oos-normal">' . SUCCESS_2 . '<br /><br />' . "\n" .
         '<form action="step.php" method="post"><center><table width="50%">' . "\n";
   print_FormHidden();
   echo '<tr><td align=center><input type="hidden" name="op" value="Finish">' . "\n" .
        '<input type="submit" value="' . BTN_FINISH . '"></td>' . "\n" .
        '</tr></table></center></form></font><br /><br />' . "\n";
}



function print_Submit() {
  echo '<font class="oos-title">' . DBINFO . ':&nbsp;</font>' .
       '<font class="oos-normal">' . SUBMIT_1 . '</font><br /><br />' . "\n" .
       '<br /><center><font class="oos-normal">' . SUBMIT_2 . '</font><br /><br />';
  print_FormText();
  echo '<form name="change info" action="step.php" method="post">' . "\n";
  print_FormHidden();
       '<br />' . "\n" .
       '<font class="oos-normal">' . SUBMIT_3 . '</font></center><br /><br />' . "\n" .
       '<table width="50%" align="center">' . "\n" .
       ' <tr>' . "\n" .
       '  <td>' . "\n";
  echo '<form name="new install" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="Change_Info">' . "\n" .
       '<input type="submit" value="' . BTN_CHANGE_INFO . '">' . "\n" .
       '</form>' . "\n" .
       '  </td>' . "\n" .
       '  <td>' . "\n";
  echo '<form name="update" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="Upgrade">' . "\n" .
       '<input type="submit" value="' . BTN_UPGARDE . '">' . "\n" .
       '</form></td>' . "\n" .
       ' </tr>' . "\n" .
       '</table></form>' . "\n";

}


function print_ConfigServerInfo() {

  echo '<font class="oos-title">' . VIRTUAL_1 . ':&nbsp;</font><br />' . "\n";
  echo '<br />';

  if ($_POST['enable_ssl'] == 'on') {
    $ssl_server = $_POST['oos_ssl_server'];
    $sock = @fsockopen($ssl_server, 443, $errorno, $errorstring, 10);
    if (!$sock) {
      printf(ERROR_NO_HTTPS_SERVER,
       '<font class="oos-error"><b>' . $_POST['oos_ssl_server'] . '</b></font>'
      );
      echo '<br />';
/*
      echo "$errorstring ($errorno)<br/>\n";
      echo $sock;
*/
      $_POST['enable_ssl'] = false;
    }
    @fclose($sock);
  }

  if (!is_dir($_POST['oos_template_dir'])) {
    printf(ERROR_NO_DIRECTORY,
      '<font class="oos-error"><b>' . VIRTUAL_9 . '</b></font>'
    );
  }
  echo '<br />';
  echo '<br /><font class="oos-normal">' . CONFIG_VIRTUAL_2 . '</font><br /><br />' . "\n";
  echo '<center>';
  print_FormServer();
  echo '<form name="ChangeServer" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="ChangeServer">' . "\n" . 
       '<input type="submit" value="' . BTN_CHANGE_INFO . '"><br />' . "\n" .
       '</form></center>' . "\n" .
       '<br />' . "\n" .
       '<font class="oos-normal">' . CONFIG_VIRTUAL_3 . '</font><br /><br />' . "\n" .
       '<table width="90%" align="center">' . "\n" .
       ' <tr>' . "\n" .
       '  <td align="center">' . "\n";
  echo '<form name="admin" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="ConfigTmpServer">' . "\n" .
       '<input type="submit" value="' . BTN_NEXT . '">' . "\n" .
       '</form></td>' . "\n" .
       ' </tr>' . "\n" .
       '</table></form>' . "\n";
}


function print_ChangeServer() {
   global $oos_server, $oos_template_dir, $oos_ssl_server, $enable_ssl, $oos_root_path, $oos_shop_path, $oos_shop_dir, $oos_admin_dir; 

   echo '<font class="oos-title">' . VIRTUAL_1 . '</font>' . "\n";

   if ($_POST['enable_ssl'] == false) {
     $ssl = '<input type="checkbox" name="enable_ssl">';
   } else {
     $ssl = '<input type="checkbox" name="enable_ssl" checked=checked>';
   }
   echo '<br /><br />' . "\n" .
        '<center><form action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">HTTP Server</font></td>' . "\n" .
        '  <td><input type="text" name="oos_server" SIZE=60 maxlength=180 value="' . $oos_server . '"></td>' . "\n" .
        ' </tr>' . "\n" .  
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">HTTPS SERVER</font></td>' . "\n" .
        '  <td><input type="text" name="oos_ssl_server" SIZE=60 maxlength=180 value="' . $oos_ssl_server . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_3 . '</font></td>' . "\n" .
        '  <td>' . $ssl . '</td>' . "\n" .
        ' </tr>' . "\n" .

        '   <td align="left"><font class="oos-normal">SubDomain static1</font></td>' . "\n" .
        '   <td><input type="text" name="static1" SIZE=60 maxlength=180 value="' . $_POST['static1'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain image01</font></td>' . "\n" .
        '   <td><input type="text" name="image01" SIZE=60 maxlength=180 value="' . $_POST['image01'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain chive</font></td>' . "\n" .
        '   <td><input type="text" name="chive" SIZE=60 maxlength=180 value="' . $_POST['chive'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .        
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain tracking</font></td>' . "\n" .
        '   <td><input type="text" name="tracking" SIZE=60 maxlength=180 value="' . $_POST['tracking'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '   <td align="left"><font class="oos-normal">SubDomain wordpress</font></td>' . "\n" .
        '   <td><input type="text" name="wordpress" SIZE=60 maxlength=180 value="' . $_POST['wordpress'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_4 . '</font></td>' . "\n" .
        '  <td><input type="text" name="oos_root_path" SIZE=60 maxlength=180 value="' . $oos_root_path  .'"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_5 . '</font></td>' . "\n" .
        '  <td><input type="text" name="oos_shop_path" SIZE=60 maxlength=80 value="' . $oos_shop_path . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_7 . '</font></td>' . "\n" .
        '  <td><input type="test" name="oos_shop_dir" SIZE=60 maxlength=80 value="' . $oos_shop_dir . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_9 . '</font></td>' . "\n" .
        '  <td><input type="text" name="oos_template_dir" SIZE=60 maxlength=80 value="' . $oos_template_dir . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left">&nbsp;</td>' . "\n" .
        '  <td>&nbsp;</td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n";
   print_DBHidden();
   echo '<input type="hidden" name="host_conf" value="' . $_POST['host_conf'] . '">' . "\n" .
        '<input type="hidden" name="op" value="ConfigServer">' . "\n" .
        '<input type="submit" value="' . BTN_SET_LOGIN . '">' . "\n" .
        '</form></center>' . "\n";
}


function print_Confirm() {

   if (isset($_SERVER['REQUEST_URI']) && (empty($_SERVER['REQUEST_URI']) === false)) {
     $shop_path = $_SERVER['REQUEST_URI'];
   } else {
     $shop_path = $_SERVER['PHP_SELF'];
   }

   $shop_path = substr($shop_path, 0, strpos($shop_path, 'install'));

   $dir_fs_www_root = $_SERVER['DOCUMENT_ROOT']; // this replaced the foor loop

   echo '<font class="oos-title">' . VIRTUAL_1 . ':&nbsp;</font>' . "\n" .
        '<font class="oos-normal">' . VIRTUAL_2 . '</font>' . "\n" .
        '<br /><br />' . "\n" .
        '<center><form action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">HTTP Server</font></td>' . "\n" .
        '  <td><input type="text" name="oos_server" SIZE=60 maxlength=180 value="http://' . $_SERVER['HTTP_HOST'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">HTTPS SERVER</font></td>' . "\n" .
        '  <td><input type="text" name="oos_ssl_server" SIZE=60 maxlength=180 value="https://' . $_SERVER['HTTP_HOST'] .'"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_3 . '</font></td>' . "\n" .
        '  <td><input type="checkbox" name="enable_ssl"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .       
        '  <td align="left"><font class="oos-normal">SubDomain static1</font></td>' . "\n" .
        '  <td><input type="text" name="static1" SIZE=60 maxlength=180 value="http://static1.' . $_SERVER['HTTP_HOST'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">SubDomain image01</font></td>' . "\n" .
        '  <td><input type="text" name="image01" SIZE=60 maxlength=180 value="http://image01.' . $_SERVER['HTTP_HOST'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">SubDomain chive</font></td>' . "\n" .
        '  <td><input type="text" name="chive" SIZE=60 maxlength=180 value="http://chive.' . $_SERVER['HTTP_HOST'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .        
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">SubDomain tracking</font></td>' . "\n" .
        '  <td><input type="text" name="tracking" SIZE=60 maxlength=180 value="http://tracking.' . $_SERVER['HTTP_HOST'] . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">SubDomain wordpress</font></td>' . "\n" .
        '  <td><input type="text" name="wordpress" SIZE=60 maxlength=180 value="http://blog.' . $_SERVER['HTTP_HOST'] . '"></td>' . "\n" .
        ' </tr>' . "\n" . 
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_7 . '</font></td>' . "\n" .
        '  <td><input type="test" name="oos_shop_dir" SIZE=60 maxlength=80 value="' . $shop_path . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_4 . '</font></td>' . "\n" .
        '  <td><input type="text" name="oos_root_path" SIZE=60 maxlength=180 value="' . $dir_fs_www_root .'"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_5 . '</font></td>' . "\n" .
        '  <td><input type="text" name="oos_shop_path" SIZE=60 maxlength=180 value="' . $dir_fs_www_root . $shop_path . '"></td>' . "\n" .
        ' </tr>' . "\n" .
        ' <tr>' . "\n" .
        '  <td align="left"><font class="oos-normal">' . VIRTUAL_9 . '</font></td>' . "\n" .
        '  <td><input type="text" name="oos_template_dir" SIZE=60 maxlength=80 value="'. $dir_fs_www_root . $shop_path . 'oos_temp/"></td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n" .
        '<br /><br />' . "\n";
   print_DBHidden();
   echo '<input type="hidden" name="host_conf" value="' . $_POST['host_conf'] . '">' . "\n" .
        '<input type="hidden" name="op" value="ConfigServer">' . "\n" .
        '<input type="submit" value="' . BTN_CONTINUE . '">' . "\n" .
        '</form></center>' . "\n";

}



function print_Start() {
   echo '<form action="step.php" method="post"><table class="content">' . "\n" .
        ' <tr>' . "\n" .
        '   <td align=center>' . "\n";
   print_FormHidden();
   echo '<input type="hidden" name="op" value="Confirm">' . "\n" .
         '<input type="submit" value="' . BTN_CONTINUE . '"></td>' . "\n" .
         ' </tr>' . "\n" .
         '</table></form>' . "\n";

}


function print_ChangeInfo() {
   global $dbhost, $dbuname, $dbpass, $dbname, $prefix_table ;

  echo '<font class="oos-title">' . CHANGE_INFO_1 . ':&nbsp;</font>' . 
       '&nbsp;<font class="oos-normal">' . CHANGE_INFO_2 . '<br /><br />' . "\n" .
       '<form action="step.php" method="post"><center>' . "\n" .
       '<table class="content">' . "\n" .
       ' <tr>' . "\n" .
       '   <td align="left"><font class="oos-normal">' . DBHOST . '</font></td>' . "\n" .
       '   <td><input type="text" name="dbhost" SIZE=30 maxlength=80 value="' . $dbhost . '"></td>' . "\n" .
       ' </tr>' . "\n" .
       ' <tr>' . "\n" .
       '   <td align="left"><font class="oos-normal">' . DBUNAME . '</font></td>' . "\n" .
       '   <td><input type="text" name="dbuname" SIZE=30 maxlength=80 value="' . $dbuname . '"></td>' . "\n" .
       ' </tr>' . "\n" .
       ' <tr>' . "\n" .
       '  <td align="left"><font class="oos-normal">' . DBPASS . '</font></td>' . "\n" .
       '  <td><input type="text" name="dbpass" SIZE=30 maxlength=80 value="' . $dbpass . '"></td>' . "\n" .
       ' </tr>' . "\n" .
       ' <tr>' . "\n" .
       '   <td align="left"><font class="oos-normal">' . DBNAME . '</font></td>' . "\n" .
       '   <td><input type="text" name="dbname" SIZE=30 maxlength=80 value="' . $dbname . '"></td>' . "\n" .
       ' </tr>' . "\n" .
       ' <tr>' . "\n" .
       '   <td align="left"><font class="oos-normal">' . DBPREFIX . '</font></td>' . "\n" .
       '   <td><input type="text" name="prefix_table" SIZE=30 maxlength=80 value="' . $prefix_table .'"></td>' . "\n" .
       ' </tr>' . "\n" .
       ' <tr>' . "\n" .
       '   <td align="left"><font class="oos-normal">' . DBTYPE . '</font></td>' . "\n" .
       '   <td><select name="dbtype"><option value="mysql" selected>&nbsp;MySQL&nbsp;</option><option value="mysqli">&nbsp;MySQLi&nbsp;</option><option value="postgres">&nbsp;Postgres&nbsp;</option></select></td>' . "\n" .
       ' </tr>' . "\n" .
       '</table>' . "\n" .
       '<br /><br />' . "\n" .
       '<input type="hidden" name="host_conf" value="' . $_POST['host_conf'] . '">' . "\n" .
       '<input type="hidden" name="currentlang" value="' . $_POST['currentlang'] . '">' . "\n" .
       '<input type="hidden" name="op" value="New_Install">' . "\n" .
       '<input type="submit" value="' . BTN_SUBMIT . '">' . "\n" .
       '</center></form></font>' . "\n";

}


function print_NewInstall() {
   echo '<font class="oos-title">' . DBINFO . '</font><br>' . 
        '<center><font class="oos-normal">&nbsp;' . SUBMIT_1 . '</font>' . "\n" .
        '<br /><br />' . "\n";
   print_FormText(); 
   echo '<form name="change info" action="step.php" method="post">' . "\n";
   print_FormHidden();
   echo '<input type="hidden" name="op" value="Change_Info">' . "\n" . 
        '<input type="submit" value="' . BTN_CHANGE_INFO . '"><br />' . "\n" .
        '</form>' . "\n" .
        '<br /><font class="oos-normal">' . NEW_INSTALL_3 . '</font>' . "\n" .
        '<form name="install" action="step.php" method="post"><table width="50%">' . "\n" .
        ' <tr>' . "\n" .
        '   <td align=center><font class="oos-normal">' . NEW_INSTALL_4 . '</font>' . "\n" .
        '     <br /><input type=checkbox name="dbmake"></td>' . "\n" .
        '   <td>';
   print_FormHidden();
   echo '<input type="hidden" name="op" value="Start">' . "\n" .
        '  <input type="submit" value="' . BTN_START . '">' . "\n" .
        '  </td>' . "\n" .
        ' </tr>' . "\n" .
        '</table>' . "\n" .
        '</form></font></center>' . "\n";

}


function print_DBSubmit() {
   global $currentlang;

   echo '<font class="oos-title">' . DBINFO . ':&nbsp;</font><br />' . "\n" .
        '<font class="oos-normal">' . CHM_CHECK_1 . '</font><br /><br />' . "\n" .
        '<form action="step.php" method="post"><center>' . "\n";
   print_FormEditabletext(0);
   echo '<input type="hidden" name="host_conf" value="' . $_POST['host_conf'] . '">' . "\n" .
        '<input type="hidden" name="currentlang" value="' . $currentlang .'">' . "\n" .
        '<input type="hidden" name="op" value="New_Install"><br /><br />' . "\n" .
        '<input type="submit" value="' . BTN_SUBMIT . '"></center></form>' . "\n";

}

function print_oosUpgardeOrInstall() {
   global $currentlang;

  echo '<br /><center>' . "\n" .
       '<font class="oos-normal">' . METHOD_1 . '</font><br /><br />' . "\n" .
       '<table class="content">' . "\n" .
       ' <tr>' . "\n" .
       '  <td align="center">' . "\n";
  echo '<form name="new install" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="PHP_Check">' . "\n" .
       '<input type="submit" value="' . BTN_NEW_INSTALL . '">' . "\n" .
       '</form>' . "\n" .
       '  </td>' . "\n" .
       '  <td align="center">' . "\n";
  echo '<form name="update" action="step.php" method="post">' . "\n";
  print_FormHidden();
  echo '<input type="hidden" name="op" value="Upgrade">' . "\n" .
       '<input type="submit" value="' . BTN_UPGARDE . '">' . "\n" .
       '</form></td>' . "\n" .
       ' </tr>' . "\n" .
       '</table></center>' . "\n";
}


function print_oosDefault() {
   global $currentlang;
   echo '<table width="800" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="21"><img src="images/step_2.png" alt="" width="21" height="21" /></td>
    <td width="758" class="table_head_setuptitle">' . DEFAULT_1  . '</td>
    <td width="21"><img src="images/table_head_right.png" alt="" width="21" height="21" /></td>
    </tr>
    </table>' . "\n";
   echo '<br /><b>' . DEFAULT_2  . '</b><br /><br />';
   echo '<form name="next" action="step.php" method="post">';
   echo '<div class="license-form">
         <div align="middle"  class="form-block" style="padding: 0px;">
       <iframe src="gpl.html" class="license" frameborder="0" scrolling="auto"></iframe>
         </div>
         </div>';
   echo '<input type="hidden" name="currentlang" value="' . $currentlang . '">';
   echo '<input type="hidden" name="op" value="PHP_Check">';
   echo '<center>';
   echo '<input type="checkbox" name="agreecheck"><font class="oos-normal">' . DEFAULT_3 . '</font><br />';
   echo '<input type="submit" value="' . BTN_NEXT . '"><br />';
   echo '</center>'; 
   echo '</form>'; 
}

function print_select_language() {
   echo '<table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="21"><img src="images/step_1.png" alt="" width="21" height="21" /></td>
            <td width="758" class="table_head_setuptitle">' . GREAT  . '</td>
            <td width="21"><img src="images/table_head_right.png" alt="" width="21" height="21" /></td>
          </tr>
        </table>' . "\n" .
        '<p><img src="images/start.png" alt="Shop-Installation" hspace="12" vspace="4" align="right" />' . GREAT_1 . '</p>' . "\n" .
        '<hr align="left" size="1" noshade="noshade" /> <img src="images/arrow_grey.png" alt="" width="11" height="11" align="middle" /><b class="oos-pageTitle"> ' . SELECT_LANGUAGE_1 . '</b>' . "\n" .
        '<form action="step.php" method="post">' . "\n";
   echo lang_dropdown();
   echo '<input type="hidden" name="op" value="Set Language">' . "\n" .
       '<input type="submit" value="' . BTN_SET_LANGUAGE . '">' . "\n" .
       '</form>' . "\n";
}



?>