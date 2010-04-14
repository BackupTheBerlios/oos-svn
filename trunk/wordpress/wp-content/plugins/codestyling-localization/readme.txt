=== Codestyling Localization ===
Contributors: codestyling
Tags: gettext, language, translation, poedit, localization, plugin, wpmu
Requires at least: 2.5
Tested up to: 3.0-beta1
Stable tag: 1.96

You can manage and edit all gettext translation files (*.po/*.mo) directly out of WordPress Admin Center without any need of an external editor.

== Description ==

You can manage and edit all gettext translation files (*.po/*.mo) directly out of your WordPress Admin Center without any need of an external editor.
It automatically detects the gettext ready components (like WordPress itself or any plugin / theme supporting gettext), is able to scan the related source files and assists you using Google translate API during translation.
This plugin supports WordPress MU and allows explicit WPMU plugin translation too. It newly introduces ignore-case and regular expression search during translation.

= Requirements =
1. WordPress version 2.5 and later
1. PHP Interpreter version 4.4.2 or later
1. PHP Tokenizer Module (normally standard, required since version 1.90)

Please visit [the official website](http://www.code-styling.de/english/development/wordpress-plugin-codestyling-localization-en "Codestyling Localization") for further details and the latest information on this plugin.

= Details =
1. automatic detection of gettext ready components like WordPress, Plugins or Themes
1. creation of new language translation files at choosen language (ensures correct plural definitions too)
1. inplace adjusting of *.mo/*.po file permissions to be able to tranlate it
1. component specific (re)scan of source file to build the updated catalog entries
1. wrapping multiple plugins using same textdomain into one translation unit (like plugin and it's widget(s))
1. extended editing of full gettext catalog assisted by using Google translate API
1. full catalog search (exact match) with instant result set view for source or target language
1. correct handling of language dependend plural forms by providing appropriated edit dialog
1. first support of WMPU plugins started at version 1.60
1. complete WordPress support related to multiple textdomains included (since WP 2.8 nad higher)
1. complete support of developer code comments for translators
1. complete support of context based gettext functions and displays this at editor qualified
1. supports also translation of non gettexted code parts, that marked as to be replaced in PHP files directly
1. handles textdomain separation for each module (WP, Plugins, Themes) to avoid standard textdomain usage been part of *.mo file
1. support of Theme language file sub folder (introduced at WordPress version 2.7 and higher)

= Announcement =
As i stated at one of my articles [Features and Future Development](http://www.code-styling.de/english/wordpress-localization-features-and-future-development) this Version 1.x trunk will be maintained now only.
This is because of complete rewrite and massive feature implementation of version 2.x series. This may also imply, that the new upcomming version (planned for end of September) will run at first release from WP 2.7 and not lower versions.
I will nevertheless support the 1.x trunk, but it would not get more features from now. Please look at the article, it also shows more sneak peak screens of upcomming features. 
Additionally to the statement above (moved to September 2010) i did a step between 1.x and 2.x trunc. The version 1.9 already contains some fully rewritten new core parts out of 2.0 version. 
The UI is planned to be redesigned in 2.0 version.

== Installation ==

1. Uncompress the download package
1. Upload folder including all files and sub directories to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Translate your resources using 'Manage' menu at new 'Localization' sub menu

== Changelog ==

= Version 1.96 =
* Bugfix: WPMU plugin handling problems fixed
* Bugfix: changes at WP 3.0 help system adapted (temporary work arround)
* Bugfix: WordPress scanning sanatized because of WP 3.0 default theme changes
* Bugfix: changed javascipt escape functions adapted
* Bugfix: level_10 security replaced by manage_options
* Hint: not fully tested at activated multi-site installations 

= Version 1.95 =
* Bugfix: WP localization engine has been changed in 2.9, freezes parsing and avoids loading of generated mo files! 

= Version 1.94 =
* Bugfix: WordPress theme core management uses full path instead of relative path, WordPress behavior change! 

= Version 1.93 =
* Bugfix: sub directory detection for language files at plugins/themes sometimes accidentally failed.

= Version 1.92 =
* Bugfix: final parsing cleanup sometimes accidentally wiped out more than 80% as old (obsolete) entries.
* Bugfix: WordPress 2.8 new textdomain "continents-cities" accidentally detected as main textdomain.

= Version 1.91 =
* Bugfix: work around a currently not fixed preg_match bug in PHP module PCRE, versions >= 5.2.0
* Bugfix: broken encoding of *.po file will be repaired to UTF-8 during load (2nd preg_match PHP bug)
* Bugfix: pre-select of primary textdomain didn't work as expected
* Bugfix: avoid saving any default (WordPress) depended *.mo files at plugin or theme section
* Bugfix: skip bad gettext function arguments (mostly stacked function calls inside gettext functions)
* Bugfix: safe *.po header handling to avoid erase of header fields
* Bugfix: plugin own untranslatable UI phrase made tranlatable
* Bugfix: description row resized and editor hint description added
* Bugfix: Changelog typo damaged the backend installation UI
* Known Limit: javascript runtime in IE only gets exceeded if tried to translate WordPress itself (gets done in 2.0)
* Known Limit: file permissions won't work at safemode based server/hosts (comming soon)
* Known Limit: on safemode based systems creation of unaccessable *.po / *.mo files (comming soon)

= Version 1.90 =
* Bugfix: having only a *.mo file accidentally states a writing error
* Bugfix: accidentally wrong parsing in  rare cases of *.po files
* Feature: support of textdomain separation to avoid unnecessary default textdomain phrases in component *.mo files
* Feature: introducing a *.po file extension, that supports multiple textdomains inside one *.po file
* Feature: complete 2.8+ support of all newly introduced gettext functions and extensions
* Feature: supports visualization of developer comments for translators from code
* Feature: visualization of context dependend gettext phrases
* Feature: scanning speed improved, WordPress scan time >= 270s now needs 20s upto 40s (upto 10 times faster)
* Feature: new scanning and translation file engine
* Feature: supports for WordPress versions >= 2.7 that themes can have their own sub directory for translations.
* Languages: Belarusian translation based on 1.80 attached
* Languages: Arabic (Saudi Arabia) translation based on 1.80 attached


= Version 1.80 =
* Bugfix: open entities at markup closed
* Bugfix: Opera Bug solved, embedded 0 in string issue damaged plural saving
* Bugfix: IE Bugs solved, table cellpadding and coloring fixed
* Bugfix: page size and search fields now updates correctly because of autocomplete issues
* Bugfix: languages with only 1 plural form (japanes as example) now working as expected
* Feature: Pagination repeated at end of table
* Feature: introduced jump to top button at the end of table
* Feature: editing dialog now supports "save & previous" and "save & next"
* Feature: actual row been edited will be highlighted in background
* Feature: japanese language file attached
* Feature: Czech language file attached
* Feature: Danish language file attached

= Version 1.72 =
* Bugfix: enabled fa_IR (persian Language) for initial creation
* Feature: updated russian language file (meets now 1.71/1.72 content fully)
* Feature: udpated spain language file (translation mistake contained)

= Version 1.70 =
* Bugfix: setting pages of other plugins like vipers-video-quicktags did crash, if this plugin has been actived
* Bugfix: not all potential translateable plugins has been detected (analysis of coding syntax too strict)
* Bugfix: final compatibility on WordPress 2.7 have not been meet fully
* Feature: if language file path detection of plugins is not clear, directory tree will be shown for choise
* Feature: primary search function now also possible with ignore-case
* Feature: secondary search function introduced that enables regular expressions by dialog

= Version 1.65 =
* Bugfix: scan process of WPMU plugins shows warning message at produced page
* Bugfix: several plugins/themes could not be detected as translatable because of extra whitespace in function call
* Bugfix: wrong named theme localization files were shown but not editable, illegal syntax will now be skipped
* Feature: inital integration into WordPress 2.7 Context Help System to provide plugin specific help topics
* Feature: display new WordPress 2.7 tools icon at plugin page headline

= Version 1.60 =
* Bugfix: CSS style at WP 2.7 has been changed, minor adaption to be able to display dialogs correctly
* Bugfix: empty WordPress main language directory forces new file creation at wrong folder
* Bugfix: none existing WordPress main languages directories (US version) leads to error display
* Bugfix: prevent directory listing of plugin by .htaccess file attached to package
* Feature: none existing WordPress main languages directory can be created by plugin
* Feature: WPMU plugin support, detection of normal and WPMU version and ability to translate mu-plugins

= Version 1.55 =
* Bugfix: WordPress 2.7-hemorrhage introduces WP_ADMIN set additional during DOING_AJAX (ajax requests)

= Version 1.51 =
* Bugfix: SVN version number fix
* Feature: language attached, Traditional Chinese Taiwan by Gary

= Version 1.30 =
* Feature: supports now PHP 4, tested with PHP 4.4.2 and higher
* Feature: provides a copy action at each row, that makes original persistent as translation

= Version 1.21 =
* Bugfix: stylesheet now only gets loaded at plugins pages, backward compatibility support has broken thickbox styles at other pages
* Feature: Italian translation by Gianni has been added

= Version 1.2 =
* Feature: published at "http://wordpress.org/extend/plugins/codestyling-localization/"

= Version 1.1 =
* Bugfix: backslahed po-file header values causes IE to stop reponding during editor launch
* Bugfix: special path detection doesn&#8217;t recognize deep folder structure related textdomain loading
* Bugfix: stylesheet doesn&#8217;t show file/comment tooltip inside visble client area
* Bugfix: scrolling to source line number fails with script error, if *.po file is outdated and line exceeds total count
* Feature: &#8220;X-Poedit-Basepath&#8221; and &#8220;X-Poedit-SearchPath-0&#8243; at *.po file header will be relativized during read
* Feature: now supports file permission display and change capability
* Feature: collects multiple plugins at same textdomain as childs at first occurance
* Feature: show error message using thickbox instead of alert() except Google Translate errors

= Version 1.02 =
* Feature: downgrade code, runs now with WordPress 2.5 and above

= Version 1.01 =
* Bugfix: potential modified plugin path using constants has not been respected

= Version 1.0 =
* Bugfix: version control has been done too strictly, WP 2.6.0 doesn&#8217;t exist, reduced to 2.6
* Bugfix: locale definitions accidentally states, that zu_ZU (isiZulu) will be supported by Google translate, disabled

= Version 0.99 =
* Bugfix: remove accidentally usage of global $file, breaks plugin and theme editor
* Bugfix: plugins, that are gettext ready but textdomain can&#8217;t be detected, will be handled with their plugin filename as textdomain by default
* Feature: plugin activation checks now required versions (WordPress / PHP) and reports qualified messages at fail case

= Version 0.98 =
* Feature: extended to use Google translate API

= Version 0.97 =
* Bugfix: simple plugin analysis runs recursive over total plugin path
* Bugfix: language file naming convention was wrong
* Bugfix: missing escapement of names breaks javascript
* Bugfix: avoid deprecated constant usage
* Bugfix: fix table size avoid using full screen width at adminimize plugin

= Version 0.96 =
* Bugfix: Valid XHTML 1.0 Transitional
* Feature: switching to editor now shows loading indicator
* community closed tests lauched

= Version 0.10 =
* start of coding (alpha) @ 2008-06-21


== Frequently Asked Questions ==

= History? =
Please visit [the official website](http://www.code-styling.de/english/development/wordpress-plugin-codestyling-localization-en "Codestyling Localization") for the latest information on this plugin.

= Where can I get more information? =
Please visit [the official website](http://www.code-styling.de/english/development/wordpress-plugin-codestyling-localization-en "Codestyling Localization") for the latest information on this plugin.

== Screenshots ==
1. management center
1. language creation
1. rescan source files
1. catalog content editor
1. simple gettext entry
1. plural gettext entry
1. non gettext code hints for tranlators
1. separate multiple textdomains during mo-file generation


== Other Notes ==
= Acknowledgements =
Thanks to [Frank Bueltge](http://bueltge.de/ "Frank Bueltge") , Ingo Henze and  [Alphawolf](http://www.schloebe.de/ "Alphawolf") for qualified beta testing and improvement comments and [Knut Sparhell](http://sparhell.no/knut/ "Knut Sparhell") who detects the 'short_open_tag = off' Bug contained.
Also many thanks for all that qualified translations:
[Gianni](http://gidibao.net/ "Gianni") for the quick Italiano translation 
[Gary](http://www.gary711.net/ "Gary") for traditional Chinese Taiwan 中文(台灣)
jtoth for Română translation
Дмитрий for Русский translation
[keopx](http://www.keopx.net/ "keopx") for Basque and Spain translation
Lionel Chollet, Gilles Wittezaele, [Fabien Waroux](http://wp.fabonweb.net/ "Fabien Waroux") for French translation
dreamcolor for Chinese China (中华人民共和国)
Thanks to [Thomas Urban](http://www.toxa.de "Thomas Urban") for contributing a faster mo file reading implementation.

= Licence =
This plugins is released under the GPL, you can use it free of charge on your personal or commercial blog. 

= Translations =
The german translation has been created with this plugin itself. Feel free to make you translation related to your native language.
If you have a ready to publish translation of this plugin not pre-packaged yet, please send me an email. I will extend the package and remark your work at Acknowledgements.

