<?php
/**
 * Retrieves and creates the wp-config.php file.
 *
 * The permissions for the base directory must allow for writing files in order
 * for the wp-config.php to be created using this page.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * We are installing.
 *
 * @package WordPress
 */
define('WP_INSTALLING', true);

/**
 * Disable error reporting
 *
 * Set this to error_reporting( E_ALL ) or error_reporting( E_ALL | E_STRICT ) f
or debugging
 */
error_reporting(0);

/**#@+
 * These three defines are required to allow us to use require_wp_db() to load
 * the database class while being wp-content/db.php aware.
 * @ignore
 */
define('ABSPATH', dirname(dirname(__FILE__)).'/');
define('WPINC', 'wp-includes');
define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
/**#@-*/

require_once(ABSPATH . WPINC . '/compat.php');
require_once(ABSPATH . WPINC . '/functions.php');
require_once(ABSPATH . WPINC . '/classes.php');

if (!file_exists(ABSPATH . 'wp-config-sample.php'))
	wp_die('Entschuldige, aber die Datei <code>wp-config-sample.php</code> wird f&uuml;r die Installation ben&ouml;tigt. Bitte lade diese Datei hoch.');

$configFile = file(ABSPATH . 'wp-config-sample.php');

// Check if wp-config.php has been created
if (file_exists(ABSPATH . 'wp-config.php'))
 	wp_die("<p>Die Datei <code>wp-config.php</code> existiert bereits. Wenn du die Angaben &auml;ndern m&ouml;chtest, musst du die Datei vorher l&ouml;schen. Du kannst jetzt die <a href='install.php'>Installation versuchen</a>.</p>");

// Check if wp-config.php exists above the root directory but is not part of another install
if (file_exists(ABSPATH . '../wp-config.php') && ! file_exists(ABSPATH . '../wp-settings.php'))
	wp_die("<p>Die Datei <code>wp-config.php</code> existiert bereits im Verzeichnis &uuml;ber deinem WordPress-Verzeichnis. Wenn Du die Angaben &auml;ndern m&ouml;chtest, muss Du die Datei vorher l&ouml;schen. Du kannst jetzt die <a href='install.php'>Installation versuchen</a>.</p>");

if ( version_compare( '4.3', phpversion(), '>' ) )
	wp_die( sprintf( /*WP_I18N_OLD_PHP*/'Your server is running PHP version %s but WordPress requires at least 4.3.'/*/WP_I18N_OLD_PHP*/, phpversion() ) );

if ( !extension_loaded('mysql') && !file_exists(ABSPATH . 'wp-content/db.php') )
	wp_die( /*WP_I18N_OLD_MYSQL*/'Your PHP installation appears to be missing the MySQL extension which is required by WordPress.'/*/WP_I18N_OLD_MYSQL*/ );

if (isset($_GET['step']))
	$step = $_GET['step'];
else
	$step = 0;

/**
 * Display setup wp-config.php file header.
 *
 * @ignore
 * @since 2.3.0
 * @package WordPress
 * @subpackage Installer_WP_Config
 */
function display_header() {
	header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WordPress &rsaquo; Einrichtung der Konfigurations-Datei</title>
<link rel="stylesheet" href="css/install.css" type="text/css" />

</head>
<body>
<h1 id="logo"><img alt="WordPress" src="images/wordpress-logo.png" /></h1>
<?php
}//end function display_header();

switch($step) {
	case 0:
		display_header();
?>

<p>Willkommen bei WordPress. Bevor wir anfangen k&#246;nnen, ben&#246;tigen wir ein paar Informationen &#252;ber Deine Datenbank. Die folgenden Informationen solltest Du parat haben:</p>
<ol>
  <li>Name der Datenbank</li>
  <li>Benutzername der Datenbank</li>
  <li>Passwort der Datenbank</li>
  <li>Datenbank-Host (<em>MySQL-Serveradresse</em>)</li>
  <li>Tabellen-Pr&#228;fix (<em>Wenn Du auch andere Scripte oder mehrere WordPress-Installationen &#252;ber eine Datenbank laufen lassen m&#246;chtest.</em>) </li>
</ol>
<p><strong>Wenn aus irgendeinem Grund die automatische Erstellung der Dateien nicht funktioniert... keine Panik! Alles was wir hier machen, ist die oben angegebene Information an die Konfigurations-Datei zu &#252;bergeben. Alternativ kannst Du auch die Datei <code>wp-config-sample.php</code> in einem Text-Editor &#246;ffnen, die ben&#246;tigten Informationen dort eingeben, und die Datei als <code>wp-config.php</code> speichern.</strong></p>
<p>Die notwendigen Informationen hast Du von Deinem Provider bekommen. Wenn Du die Informationen verlegt hast, wirst Du Deinen Provider kontaktieren m&#252;ssen, bevor wir fortfahren k&#246;nnen.
<p>Wenn alles klar ist...</p>

<p class="step"><a href="setup-config.php?step=1" class="button">...kann es jetzt losgehen!</a></p>
<?php
	break;

	case 1:
		display_header();
	?>
<form method="post" action="setup-config.php?step=2">
	<p>Nachfolgend mu&szlig;t Du die Angaben zu Deiner Datenbankverbindung einsetzen. Wenn Du dir nicht sicher bist, kontaktiere Deinen Provider.</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Name der Datenbank</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value="wordpress" /></td>
			<td>Der Name der Datenbank unter der WordPress laufen soll.</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">Name des Datenbankbenutzers</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value="username" /></td>
			<td>Dein MySQL-Benutzername.</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Passwort</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value="password" /></td>
			<td>...und Dein MySQL-Passwort.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Datenbank-Host</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>Mit 99%iger Wahrscheinlichkeit musst Du dies nicht &#228;ndern. (<em>MySQL-Serveradresse</em>)</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">Tabellen-Pr&#228;fix</label></th>
			<td><input name="prefix" id="prefix" type="text" id="prefix" value="wp_" size="25" /></td>
			<td>&Auml;ndere das Pr&#228;fix, wenn Du andere Scripte oder mehrere WordPress-Installationen &#252;ber Deine Datenbank laufen lassen m&#246;chtest.</td>
		</tr>
	</table>
	<p class="step"><input name="submit" type="submit" value="Absenden" class="button" /></p>
</form>
<?php
	break;

	case 2:
	$dbname  = trim($_POST['dbname']);
	$uname   = trim($_POST['uname']);
	$passwrd = trim($_POST['pwd']);
	$dbhost  = trim($_POST['dbhost']);
	$prefix  = trim($_POST['prefix']);
	if (empty($prefix)) $prefix = 'wp_';

	// Test the db connection.
	/**#@+
	 * @ignore
	 */
	define('DB_NAME', $dbname);
	define('DB_USER', $uname);
	define('DB_PASSWORD', $passwrd);
	define('DB_HOST', $dbhost);
	/**#@-*/

	// We'll fail here if the values are no good.
	require_wp_db();
	if ( !empty($wpdb->error) )
		wp_die($wpdb->error->get_error_message());

	foreach ($configFile as $line_num => $line) {
		switch (substr($line,0,16)) {
			case "define('DB_NAME'":
				$configFile[$line_num] = str_replace("putyourdbnamehere", $dbname, $line);
				break;
			case "define('DB_USER'":
				$configFile[$line_num] = str_replace("'usernamehere'", "'$uname'", $line);
				break;
			case "define('DB_PASSW":
				$configFile[$line_num] = str_replace("'yourpasswordhere'", "'$passwrd'", $line);
				break;
			case "define('DB_HOST'":
				$configFile[$line_num] = str_replace("localhost", $dbhost, $line);
				break;
			case '$table_prefix  =':
				$configFile[$line_num] = str_replace('wp_', $prefix, $line);
				break;
		}
	}
	if ( ! is_writable(ABSPATH) ) :
		display_header();
?>
<p>Enschuldige, aber die Datei <code>wp-config.php</code> kann nicht erstellt werden.</p>
<p>Du kannst die Datei <code>wp-config.php</code> manuell erstellen und die folgenden Angaben hinein kopieren.</p>

<textarea cols="90" rows="15"><?php
		foreach( $configFile as $line ) {
			echo htmlentities($line);
		}
?></textarea>
<p>Nachdem du das getan hast, klicke auf "Installation starten"</p>
<p class="step"><a href="install.php" class="button">Installation starten</a></p>
<?php
	else :
		$handle = fopen(ABSPATH . 'wp-config.php', 'w');
		foreach( $configFile as $line ) {
			fwrite($handle, $line);
		}
		fclose($handle);
		chmod(ABSPATH . 'wp-config.php', 0666);
		display_header();
?>
<p>Alles klar! Du bist durch den wichtigsten Teil der Installation gekommen. WordPress kann nun mit Deiner Datenbank kommunizieren. Wenn Du bereit bist...</p>

<p class="step"><a href="install.php" class="button">...starten wir die Installation!</a></p>
<?php
	endif;
	break;
}
?>
</body>
</html>
