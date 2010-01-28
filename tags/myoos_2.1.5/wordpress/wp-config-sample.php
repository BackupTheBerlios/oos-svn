<?php
/**
 * In dieser Datei werden die Grundeinstellungen f�r WordPress vorgenommen.
 *
 * Zu diesen Einstellungne geh�ren: MySQL-Zugangsdaten, Tabellenpr�fix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es auf de {@link http://codex.wordpress.org/Editing_wp-config.php
 * wp-config.php editieren} Seite im Codex. Die Informationen f�r die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeungsroutine verwendet. Sie wird ausgef�hrt, wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

// ** MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster** //
/**  Ersetze putyourdbnamehere mit dem Namen der Datenbank, die du verwenden m�chtest. */
define('DB_NAME', 'putyourdbnamehere');

/** Ersetze usernamehere mit deinem MySQL-Datenbank-Benutzernamen */
define('DB_USER', 'usernamehere');

/** Ersetze yourpasswordhere mit deinem MySQL-Passwort */
define('DB_PASSWORD', 'yourpasswordhere');

/** Ersetze localhost mit der MySQL-Serveradresse */
define('DB_HOST', 'localhost');

/** Der Datenbankzeichensatz sollte nicht ge�ndert werden */
define('DB_CHARSET', 'utf8');

/** Der collate type sollte nicht ge�ndert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschl�ssel.
 *
 * �ndere jeden KEY in eine beliebiege, m�glichst einzigartige Phrase. Du brauchst dich sp�ter
 * nicht mehr daran erinnern, also mache sie am besten m�glichst lang und kompliziert.
 * Auf der Seite https://api.wordpress.org/secret-key/1.1/ kannst du dir alle KEYS generieren lassen.
 * Bitte trage f�r jeden KEY eine eigene Phrase ein.
 *
 * @seit 2.6.0
 */
define('AUTH_KEY', 'put your unique phrase here');
define('SECURE_AUTH_KEY', 'put your unique phrase here');
define('LOGGED_IN_KEY', 'put your unique phrase here');
define('NONCE_KEY', 'put your unique phrase here');
/**#@-*/

/**
 * WordPress Datenbnaktabellen-Pr�fix.
 *
 *  Wenn du verschiedene Pr�fixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Sprachdatei
 *
 * Hier kannst du einstellen, welche Sprachdatei benutzt werden soll. Die entsprechende
 * Sprachdatei muss im Ordner wp-content/languages vorhanden sein, beispielsweise de_DE.mo
 * Wenn du nichts eintr�gst, wird Englisch genommen.
 */
define ('WPLANG', 'de_DE');

/* Das war`s schon, ab hier bitte nichts mehr editieren! Viel Spa� beim bloggen. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
