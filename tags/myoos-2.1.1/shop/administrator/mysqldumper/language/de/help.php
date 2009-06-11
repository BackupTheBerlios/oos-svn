<?php
if(file_exists("./../../work/config/parameter.php")){
	@include("./../../work/config/parameter.php");
}
@include("./../../inc/functions_global.php");
@include("./../../language/".$config["language"]."/lang.php");
@include("./../../language/".$config["language"]."/lang_help.php");
echo MSDHeader(2);
echo headline($lang['credits']);
?>
<div id="content">
<h3>&Uuml;ber dieses Projekt</h3>
Die Idee f&uuml;r dieses Projekt kam von Daniel Schlichtholz.<p>Er er&ouml;ffnete 2004 das Forum <a href="http://www.mysqldumper.de/board" target="_blank">MySQLDumper</a>, und schon bald fanden sich Hobby-Programmierer, die neue Skripte schrieben und die von Daniel erweiterten.<br>Innerhalb k&uuml;rzester Zeit entstand aus dem kleinen Backupskript ein stattliches Projekt.<p>Wenn Du Vorschl&auml;ge zur Verbesserung hast, dann wende Dich an das MySQLDumper-Forum <a href="http://www.mysqldumper.de/board" target="_blank">http://www.mysqldumper.de/board</a>.<p>Wir w&uuml;nschen Dir viel Vergn&uuml;gen mit diesem Projekt.<br><p><h4>Das MySQLDumper-Team</h4>

<table><tr><td><img src="../../images/logo.gif" alt="MySQLDumper" width="160" height="42" border="1"></td><td valign="top">
Daniel Schlichtholz - Steffen Kamper<br>
Perlscript mit Unterst&uuml;tzung von Detlev Richter<br>
</td></tr></table>
<br>

<h3>MySQLDumper Hilfe</h3>


<h4>Download</h4>
Dieses Script erhaltet Ihr auf der Homepage von MySQLDumper.<br>
Es empfiehlt sich, die Homepage regelm&auml;&szlig;ig zu besuchen, um Updates und
Hilfestellungen zu erlangen.<br>
Die Adresse lautet: <a href="http://www.mysqldumper.de" target="_blank">
http://www.mysqldumper.de</a>

<h4>Systemvoraussetzung</h4>
Das Script arbeitet auf jedem Server (Windows, Linux, ...) <br>
mit PHP >= Version 4.3.4 mit GZip-Unterst&uuml;tzung, MySQL (ab Version 3.23), JavaScript (muss aktiviert sein).

<a href="../../install.php?language=de" target="_top"><h4>Installation</h4></a>
Die Installation geht einfach von statten.
Entpackt das Archiv in einen beliebigen Ordner.<br>
Ladet alle Dateien auf Euren Webserver hoch. (z. B. in die unterste Ebene in [Server Webverzeichnis/]MySQLDumper)<br>
... fertig!<br>
Ihr k&ouml;nnt MySQLDumper nun im Webbrowser durch "http://mein-webserver/MySQLDumper" aufrufen,<br>
um die Installation abzuschlie&szlig;en. Folgt einfach den Instruktionen.<br>
<br><b>Hinweis:</b><br><i>Falls auf Eurem Server der PHP-Safemode eingeschaltet ist, darf das Script keine
Verzeichnisse erstellen.<br>
Dies m&uuml;sst Ihr dann von Hand nachholen, da MySqlDump die Daten geordnet in
Verzeichnissen ablegt.<br>
Das Script bricht mit einer entsprechenden Anweisung ab!<br>
Nachdem Ihr die Verzeichnisse (dem Hinweis entsprechend) erstellt habt, l&auml;uft es normal und ohne Einschr&auml;nkungen.</i>

<a name="perl"></a><h4>Perlskript Anleitung</h4>
Die Meisten haben ein cgi-bin Verzeichnis, in dem Perl ausgef&uuml;hrt werden kann. <br>
Dies ist meist per Browser &uuml;ber http://www.domain.de/cgi-bin/ erreichbar. <br>
<br>
F&uuml;r diesen Fall bitte folgende Schritte durchf&uuml;hren:<br><br>

1. Rufe im MySQLDumper die Seite Backup auf und klicke auf "Backup Perl". <br>
2. Kopiere den Pfad, der hinter Eintrag in crondump.pl f&uuml;r $absolute_path_of_configdir: steht. <br>
3. &Ouml;ffne die Datei "crondump.pl" im Editor.<br>
4. Trage den kopierten Pfad dort bei absolute_path_of_configdir ein (keine Leerzeichen).<br>
5. Speichere crondump.pl .<br>
6. Kopiere crondump.pl, sowie perltest.pl und simpletest.pl ins cgi-bin-Verzeichnis (Ascii-Modus im FTP).<br>
7. Gebe den Dateien die Rechte 755. <br>
7b. Wenn die Endung cgi gew&uuml;nscht ist, &auml;ndere bei allen 3 Dateien die Endung von pl -> cgi (umbenennen). <br>
8. Rufe die Konfiguration im MySQLDumper auf.<br>
9. W&auml;hle die Seite Cronscript. <br>
10. &Auml;ndere Perl Ausf&uuml;hrungspfad in /cgi-bin/ .<br>
10b. Wenn die Scripte .pl haben, &auml;ndere die Dateiendung auf .cgi .<br>
11. Speichere die Konfiguration. <br><br>

Fertig, die Skripte lassen sich nun von der Backupseite aufrufen.<br><br>

Wer Perl in allen Verzeichnissen ausf&uuml;hren kann, dem reichen folgende Schritte:<br><br>

1. Rufe im MySQLDumper die Seite Backup auf. <br>
2. Kopiere den Pfad, der hinter Eintrag in crondump.pl f&uuml;r $absolute_path_of_configdir: steht. <br>
3. &Ouml;ffne die Datei "crondump.pl" im Editor. <br>
4. Trage den kopierten Pfad dort bei absolute_path_of_configdir ein (keine Leerzeichen). <br>
5. Speichere crondump.pl .<br>
6. gebe den Datein die Rechte 755. <br>
6b. Wenn die Endung cgi gew&uuml;nscht ist, &auml;ndere bei allen 3 Dateien die Endung von pl -> cgi (umbenennen). <br>
(ev. 10b+11 von oben)<br>
<br>

Windowsuser m&uuml;ssen bei allen Scripten die erste Zeile &auml;ndern, dort steht der Pfad von Perl. Beispiel: <br>
statt: #!/usr/bin/perl -w <br>
jetzt: #!C:\perl\bin\perl.exe -w <br>

<h4>Bedienung</h4><ul>

<h6>Men&uuml;</h6>
In der obigen Auswahlliste stellt Ihr die Datenbank ein.<br>
Alle Aktionen beziehen sich auf die hier eingestellte Datenbank.

<h6>Startseite</h6>
Hier erfahrt Ihr Einiges &uuml;ber Euer System, die verschiedenen, installierten
Versionen und Details &uuml;ber die konfigurierten Datenbanken.<br>
Wenn Ihr auf den Datenbanknamen klickt, so seht Ihr eine Auflistung der Tabellen
mit der Anzahl der Eintr&auml;ge, der Gr&ouml;&szlig;e und das letzte Aktualisierungsdatum.

<h6>Konfiguration</h6>
Hier k&ouml;nnt Ihr eure Konfiguration bearbeiten, abspeichern oder die Ausgangskonfiguration
wieder herstellen.
<ul><br>
	<li><a name="conf1"></a><strong>Konfigurierte Datenbanken:</strong> die Auflistung der konfigurierten Datenbanken. Die aktive Datenbank wird in <b>bold</b> gelistet. </li>
	<li><a name="conf2"></a><strong>Tabellen-Pr&auml;fix:</strong> hier k&ouml;nnt Ihr (f&uuml;r jede Datenbank) einen Pr&auml;fix angeben. Dies ist ein Filter, der bei Dumps nur die Tabellen ber&uuml;cksichtigt, die mit diesem Pr&auml;fix beginnen (z.B. alle Tabellen, die mit "phpBB_" beginnen). Wenn alle Tabellen dieser Datenbank gespeichert werden sollen,
so lasst das Feld einfach leer.</li>
	<li><a name="conf3"></a><strong>GZip-Kompression:</strong> Hier kann die Kompression aktiviert werden. Empfehlenswert ist die Aktivierung, da die Dateien doch wesentlich kleiner werden und Speicherplatz immer rar ist.</li>
	<li><a name="conf5"></a><strong>Email mit Dumpfile:</strong> Ist diese Option aktiviert, so wird nach abgeschlossenem Backup eine Email mit dem Dump als Anhang verschickt (Vorsicht, Kompression sollte unbedingt an sein, sonst wird der Anhang zu gross und kann evtl. nicht versandt werden!).</li>
	<li><a name="conf6"></a><strong>Email-Adresse:</strong> Empf&auml;ngeradresse f&uuml;r die Email.</li>
	<li><a name="conf7"></a><strong>Absender der Email:</strong> diese Adresse taucht als Absender in der Email auf.</li>
	<li><a name="conf13"></a><strong>FTP-Transfer: </strong>Ist diese Option aktiviert, so wird nach abgeschlossenem Backup die Backupdatei per FTP versandt.</li>
	<li><a name="conf14"></a><strong>FTP Server: </strong>Die Adresse des FTP-Servers (z. B. ftp.mybackups.de).</li>
	<li><a name="conf15"></a><strong>FTP Server Port: </strong>Der Port des FTP-Servers (in der Regel 21).</li>
	<li><a name="conf16"></a><strong>FTP User: </strong>Der Benutzername des FTP-Accounts. </li>
	<li><a name="conf17"></a><strong>FTP Passwort: </strong>Das Passwort des FTP-Accounts. </li>
	<li><a name="conf18"></a><strong>FTP Upload-Ordner: </strong>Das Verzeichnis, in das die Backupdatei soll (es m&uuml;ssen Upload-Berechtigungen bestehen!).</li>
	<li><a name="conf8"></a><strong>Automatisches L&ouml;schen der Backups:</strong> Wenn diese Option aktiviert ist, werden &auml;ltere Backups nach den folgenden Regeln automatisch gel&ouml;scht. Kombinationen sind m&ouml;glich.</li>
	<li><a name="conf9"></a><strong>Alter der Dateien (in Tagen):</strong> Ein Wert > 0 l&ouml;scht alle Backupdateien, die &auml;lter als diese Angabe sind.</li>
	<li><a name="conf10"></a><strong>Anzahl von Backupdateien:</strong> Ein Wert > 0 l&ouml;scht alle Backupdateien, bis auf die hier angegebe Zahl.</li>
	<li><a name="conf11"></a><strong>Sprache:</strong> hier legst du die Sprache f&uuml;r das Interface fest.</li>
</ul>

<h6>Verwaltung</h6>
Hier werden die eigenlichen Aktionen durchgef&uuml;hrt.<br>
Es werden Dir alle Dateien im Backup-Verzeichnis angezeigt.
F&uuml;r die Aktionen "Restore" und "Delete" muss eine Datei selektiert sein.
<UL>
	<li><strong>Restore:</strong> Hiermit wird die Datenbank mit der ausgew&auml;hlten Backupdatei aktualisiert.</li>
	<li><strong>Delete:</strong> Hiermit kannst Du die selektierte Backupdatei l&ouml;schen.</li>
	<li><strong>Neues Backup starten:</strong> Hier startest Du ein neues Backup (Dump) nach den in der Konfiguration eingestellten Parametern.</li>
</UL>

<h6>Log</h6>
Hier kannst Du die Logeintr&auml;ge sehen und l&ouml;schen.
<h6>Credits / Hilfe</h6>
diese Seite.
</ul>
<h3>Unsere Sponsoren</h3>
Die Sponsoren finden Sie auch auf der <a class="ul" href="http://www.mysqldumper.de/de/index.php?m=7" target="_blank">Sponsorenseite</a><br>
<?php echo MSDFooter();?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>