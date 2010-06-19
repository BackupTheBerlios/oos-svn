<?php
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungne gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es auf de {@link http://codex.wordpress.org/Editing_wp-config.php
 * wp-config.php editieren} Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeungsroutine verwendet. Sie wird ausgeführt, wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

// ** MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster** //
/**  Ersetze putyourdbnamehere mit dem Namen der Datenbank, die du verwenden möchtest. */
define('DB_NAME', 'myoos2');

/** Ersetze usernamehere mit deinem MySQL-Datenbank-Benutzernamen */
define('DB_USER', 'root');

/** Ersetze yourpasswordhere mit deinem MySQL-Passwort */
define('DB_PASSWORD', '');

/** Ersetze localhost mit der MySQL-Serveradresse */
define('DB_HOST', 'localhost');

/** Der Datenbankzeichensatz sollte nicht geändert werden */
define('DB_CHARSET', 'utf8');

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel.
 *
 * Ändere jeden KEY in eine beliebiege, möglichst einzigartige Phrase. Du brauchst dich später
 * nicht mehr daran erinnern, also mache sie am besten möglichst lang und kompliziert.
 * Auf der Seite https://api.wordpress.org/secret-key/1.1/ kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein.
 *
 * @seit 2.6.0
 */
define('AUTH_KEY',        '.8 HN;{1RfnTw=RINTbHXhk]$ua_(J^kvh/WCFM5~bFrfR_Bo}*S8G_{QMqL}eY$');
define('SECURE_AUTH_KEY', '_kk$~q-[bv^rFvw7:y0Uu]{N}=v.Oo>OD+:>c19F3|Td*f^S=TT8MVd}B6Pvy8c#');
define('LOGGED_IN_KEY',   '0KdJ0yVmJ.} V**W 2=^{CHUrd xx1BV|A@>.eI{&|LV}%TAY<o&77%4bO0h@B2d');
define('NONCE_KEY',       'u|FIl|QK+]F+JqV:TkOhH|^qQYNr#Q!&Ml]FZ%S-]f|]J$g/!XQ<U)To70hZU~Z}');

/**#@-*/

/**
 * WordPress Datenbnaktabellen-Präfix.
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Sprachdatei
 *
 * Hier kannst du einstellen, welche Sprachdatei benutzt werden soll. Die entsprechende
 * Sprachdatei muss im Ordner wp-content/languages vorhanden sein, beispielsweise de_DE.mo
 * Wenn du nichts einträgst, wird Englisch genommen.
 */
define ('WPLANG', 'de_DE');

/* Das war`s schon, ab hier bitte nichts mehr editieren! Viel Spaß beim bloggen. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
