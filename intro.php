<?php
include "template_page_beginning.php";
?>
<h1>Intro</h1>
<p>Dies ist eine step-by-step-Anleitung, wie Sie LIPS verwenden. Aus Gruenden der Bandbreite erfolgt die Anleitung hier nur im Textformat. Sie koennen aber eine detailliertere Anleitung (mit Screenshots) aus dem Clearnet herunterladen (folgt).</p>
<h2>Step by step</h2>
<p><b>(A) Einige Bemerkungen vorweg oder: was Ihre Anonymitaet betrifft, bevor Sie LIPS verwenden</b></p>
<table>
<tr><td>Computer</td><td>Beste Wahl ist ein Computer mit Libreboot (<a href="http://www.libreboot.org">www.libreboot.org</a>).</td></tr>
<tr><td>Betriebssystem</td><td>Beste Wahl ist GNU/Linux mit 100% freier Software (<a href="http://www.fsf.org/distros">www.fsf.org/distros</a>).</td></tr>
<tr><td>Tor</td><td>Beste Wahl ist Tails (<a href="http://tails.boum.org">tails.boum.org</a>).</td></tr>
</table>
<p>Explizit raten wir ab von Windows und Mac OS X und empfehlen stattdessen, ein Live-System (CD oder USB-Stick) von Tails zu verwenden. Unter Linux ist das Tor-Browser-Bundle (siehe <a href="http://www.torproject.org">www.torproject.org</a>) ein vertretbarer Kompromiss zwischen Benutzerkonfort (groesser beim Browser-Bundle) und Sicherheit (besser bei Tails).</p>
<p><b>(B) Los geht's - ein anonymes E-Mail-Konto eroeffnen</b></p>
<table>
<tr><td>Anbieter</td><td>Verwenden Sie Sigaint (<A href="http://sigaintevyh2rzvw.onion" target="content">http://sigaintevyh2rzvw.onion</A>) oder Mail2Tor
(<A href="http://mail2tor2zyjdctd.onion/" target="content">http://mail2tor2zyjdctd.onion/</A>)</td></tr>
<tr><td>Registrierung</td><td>Nutzername und Passwort waehlen.</td></tr>
<tr><td>Pseudonym</td><td>Verwenden Sie als Nutzername ein Pseudonym.</a></td></tr>
</table>
<p>Die beiden E-Mail-Dienste sind nur ueber den Tor-Browser / das Tor-Netzwerk erreichbar. Dadurch ist sichergestellt, dass Sie nur verschluesselt und anonym darauf zugreifen koennen (und Ihre Identitaet somit geschuetzt ist)</p>
<p><b>(C) Fast geschafft - ein LIPS-Konto registrieren</b></p>
<p><u>Schritt 1 - E-Mail-Adresse registrieren:</u> Waehlen Sie "Registrieren" und geben Sie Ihre Daten ein (anonyme Mailadresse, PW, Captcha). Nach Absenden des Formulars erhalten Sie einen Aktivierungslink per Mail zugesandt.</p>
<p><u>Schritt 2 - Aktivierungslink bestaetigen:</u> Klicken Sie auf den Aktivierungslink (den Sie per Mail erhalten haben). Dadurch wird Ihr Konto eroeffnet und erhaelt Nutzerstatus 1.</p>
<p><u>Schritt 3 - Einloggen und Daten vervollstaendigen:</u> Loggen Sie sich nun zum ersten Mal ein und vervollstaendigen Sie Ihre Nutzerdaten. Andere Mitglieder koennen Sie nun kontaktieren und Ihnen einen SIM-Karten-Tausch vorschlagen.</p>
<p><u>Schritt 4 - Warten Sie ...:</u> Ab dem ersten Login dauert es maximal 30 Tage bis Ihr Konto vollstaendig aktiviert ist (Nutzerstatus 2). Ab diesem Moment koennen Sie Mitglieder von LIPS selber kontaktieren (nicht nur kontaktiert werden).</p>
<p><b>Geht das nicht schneller ... ?!</b></p>
<p>Doch! Anstatt 30 Tage zu warten, koennen Sie auch selber weitere Mitglieder werben und so die Aktivierung Ihres Kontos beschleunigen. Im Anschluss an Ihr erstes Login, erhalten Sie ein Mail mit einem Einladungslink (alternativ wird dieser Link bei jedem Login angezeigt). Versenden sie diesen <a href="remailer.php">ANONYM</a> an weitere Personen. Sobald sich ein weiteres Mitglied ueber den Link anmeldet, wird ihr Nutzerstatus beim naechsten Login auf 2 gesetzt.</p>
<?php
include "template_page_end.php";
?>
