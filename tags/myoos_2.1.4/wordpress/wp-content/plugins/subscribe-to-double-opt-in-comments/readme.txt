=== Subscribe to Double-Opt-In Comments ===
Contributors: Tobiask
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3736248
Tags: comments, subscribe, double opt in, kommentar, abonnieren, opt in, optin, kommentare, benachrichtigung
Requires at least: 2.5
Tested up to: 2.9
Stable tag: 4.1

Based on the well known Subscribe-to-Comments PlugIn, but now with double-opt-in feature to prevent spam.

== Changelog ==

= 4.0 =
* Stable and working with WP 2.9.
* No e-mail on spam comments anymore.
* Check if comment exists on confirmation, error message if not.

= 4.0 =
* Added more documentation. ;)

= 3.9 =
* Added some documentation.

= 3.8 =
* Made changes for full WP 2.9 support.

= 3.7 =
* Fixed a translation bug. Added French translation files.

= 3.6 =
* Changed back to TEXT-E-Mails because of some problems, but HTML Tags will be stripped out now.

= 3.5 =
* Tested with WP 2.8.5

= 3.4 =
* Danish language files added

= 3.3 =
* Fixed Bug: links not clickable in html mails

= 3.2 =
* New language added: Turkish

= 3.1 =
* Bugs fixed

= 3.0 =
* Bugs fixed

= 2.9 =
* HTML instead of TXT Mails

= 2.8 =
* Minor Bugfixes

= 2.7 =
* Added uninstall routine

= 2.6 =
* Added language files support for German and Slovak, translate this plugin into your language if you want, .pot file is attached.

= 2.5 =
* Added textbox to admininterface to edit confirmation text

= 2.4 =
* Fixed Custom Style for Subscription Manager Bug

= 2.3 =
* Fixed clear:both Bug

= 2.2 =
* Tested with WP v2.8.4

= 2.1 =
* Tested with WP v2.8.3

= 2.0 =
* Tested with WP v2.8.2

= 1.9 =
* Tested with WP v2.8.1

= 1.8 =
* Some multilanguage features added

= 1.7 =
* Bugfixing

= 0.1 - 1.6 =
* Added double-opt-in features and did some bugfixes etc.

== Description ==

= English =

Allows readers to receive notifications of new comments that are posted to an entry, with double-opt-in Feature. 
First, the user will get an e-mail with a confirmation link, after the user has confirmed the subscription, he or she will be noticed about new comments. 
Plugin based on Mark Jaquith "Subscribe to Comments".
More information on my blog: <a href="http://www.sjmp.de/internet/subscribe-to-comments-mit-double-opt-in-pruefung/">sjmp.de</a>.

Language support: English, German, Slovak, Turkish, Danish, French.

= Deutsch =

Weiterentwicklung der bekannten Version des "Subscribe to Comments" Plugins von Mark Jaquith.
Jetzt mit Double-Opt-In Feature. Wichtig f&uuml;r deutsche Blogger. User muessen ein Abo eines Blogposts erst via E-Mail bestaetigen.
Danach erhalten sie erst eine Mail falls ein neuer Kommentar gepostet wurde. So werden Spameintragungen ausgeschlossen.
Mehr dazu auch auf meinem Blog: <a href="http://www.sjmp.de/internet/subscribe-to-comments-mit-double-opt-in-pruefung/">sjmp.de</a>.

Sprachunterst&uuml;tzung: Deutsch, Englisch, Slowakisch, Tuerkisch, Daenisch, Franzoesisch.

== Installation ==

= English =

1. Upload all files to the "/wp-content/plugins/" directory
2. Activate the plugin through the "Plugins" menu in your WordPress Adminpanel
3. Set settings via "Settings" menu in WordPress
4. Ready, steady, go :)

= Deutsch =

1. Dateien ins "/wp-content/plugins" Verzeichnis laden
2. Im Adminbereich das Plugin aktivieren
3. Einstellungen anpassen, ebenfalls im Adminbereich!
4. Fertig, jetzt darf man sich freuen :)

== Frequently Asked Questions ==

= How can I change the place of the subscription checkbox? =

Use this code (within the loop) in your template file, to change the place of the checkbox: <code><?php show_subscription_checkbox(); ?></code>

= Can people subscribe manually without commenting? =

Yes, just place this code snippet in your template: <code><?php show_manual_subscription_form(); ?></code>

== Screenshots ==

1. Part of the settings menu