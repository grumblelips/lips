<?php
include "template_page_beginning.php";
?>
<h1>Readme</h1>
<pre class="longtext"> 
LIPS – Link to Itineration Prepaid SIM-Card

(1) Installation

Hinweis zum Server: Installieren Sie LIPS nicht im Clearnet – Sie gefährden dadurch nicht nur Ihre eigene Anonymität, sondern auch jene der Nutzer/innen! Hosting-Möglichkeiten im Tor-Netzwerk finden Sie im Hidden Wiki.

Um Ihre eigene Version von LIPS auf einem Server zu installieren, gehen Sie wie folgt vor:

a) Laden Sie das Tar-File lips.tar.gz herunter und entpacken Sie dieses.
b) Öffnen Sie das File connect_to_database.php und tragen Sie hier Ihre Passwörter für die Datenbank sowie die URL der Webseite ein.
c) Kopieren Sie sämtliche Dateien per FTP in das WWW-Verzeichnis des Servers.
d) Führen Sie im Browser das PHP-Programm http://ihre_url/create_table.php aus (die nötigen Tabellen in der Datenbank werden erstellt).
e) Die Webseite sollte nun laufen (sofern Sie Mails über SMTP versenden, kontrollieren Sie die Datei common_mailer.php).

Sicherheitshinweis: Vergewissern Sie sich vor dem Hochladen, dass die Dateien connect_to_database.php, common_mailer.php und das allenfalls von Ihnen neu komprimierte lips.tar.gz keine persönlichen Credentials enthalten!

(2) Dokumentation

Anbei werden einige Grundfunktionen von LIPS dokumentiert (weitere Kommentare auf englisch direkt im Quelltext).

(a) Login

Die Registrierung einer E-Mail-Adresse läuft folgendermassen ab:

i) Der Nutzer trägt eine E-Mail und ein Passwort und schickt es per POST an den Server.
ii) Das Passwort wird mit SHA256 gehasht und zusammen mit der E-Mail-Adresse in die Tabelle register geschrieben. Für das Hashing werden zwei Salze generiert (und ebenfalls in register eingetragen): salt1 für das Login und salt2 für den Einladungslink.
iii) Es wird eine Zufallszahl value generiert und zusammen mit salt1 ein weiterer Registrierungshash generiert und ebenfalls in register eingetragen.
iv) Es wird ein Validierungslink erstellt, der aus der E-Mail-Adresse und dem value besteht. Zusätzlich wird ein zweiter Wert entrance hinzugefügt, falls die Registrierung über einen Einladungslink erfolgte (der Wert entrance wird in diesem Fall aus der SESSION-variable entrance ausgelesen). Der Link wird über den anonymen Remailer anonymouse versandt (es wird das Webformular genutzt – das Formular wird via PHP zusammengestellt und per POST an anonymouse geschickt).
v) Der Nutzer klickt auf den Validierungslink, den er per Mail erhalten hat. Die Werte email, value und entrance werden per GET übermittelt.
vi) Der Benutzer muss noch einmal sein Passwort eingeben. Es werden anschliessend zwei Hashes berechnet: der Validierungshash (aus value und salt1) und der Passworthash (aus dem Passwort und salt1). Stimmen beide mit den Werten in Register überein, werden die E-Mail-Adresse, der Passwort-Hash und die beiden Salze in die Tabelle user kopiert (und – mit Ausnahme der E-Mail-Adresse – die Werte in Register gelöscht). Dem Benutzer wird der Status 1 zugeschrieben, d.h. seine E-Mail-Adresse ist bestätigt. Mit Status zwei kann der Nutzer sein Passwort nicht ändern und die E-Mail-Adressen anderer Mitglieder werden bei der Suchfunktion mit * zensiert.
vii) Beim ersten Login, wird mit dem Passwort und salt2 ein Einladungshash generiert. Dieser wird zusammen zwei weiteren Feldern in die Tabelle entrance geschrieben: used mit dem Wert 0 (gibt an, wie viele weitere Mitglieder sich über den Einladungshash registriert haben) und expiration (ist das Erstregistrierungsdatum + 30 Tage). Danach wird ein Einladungslink erstellt (der keine persönlichen Daten, sondern nur den entrance-Hash enthält) und wiederum per Remailer an den Nutzer geschickt.
viii) Bei jedem weiteren Login wird aus dem Passwort und salt2 wiederum der Einladungshash generiert. Danach wird überprüft, ob der Einladungshash in der Tabelle entrance vorhanden und das Feld used > 0 ist. Ist dies der Fall, wird der Nutzerstatus auf 2 erhöht und eine entsprechende Meldung angezeigt. Ansonsten wird der Nutzerstatus 1 und der Einladungslink angezeigt (er wird jedoch nicht mehr verschickt).

(b) Nutzerstatus

Der Nutzerstatus 1 kann auf drei Arten auf 2 erhöht werden:

i) Jemand registriert sich über den Einladungslink bei LIPS. In diesem Fall wird das Feld used in der Tabelle entrance um 1 erhöht (gilt, sobald der neue Benutzer seine E-Mail-Adresse via Link bestätigt hat). 
ii) Jemand registriert sich ohne Einladung bei LIPS. In diesem Fall wird zufällig ein Hash mit dem Feld used = 0 in der Tabelle entrance ausgewählt und used um den Wert 1 erhöht.
iii) Seit der Registrierung des Nutzers sind mehr als 30 Tage vergangen. Dies wird direkt beim Login über das Feld expiration in entrance überprüft.

Sobald eine der obigen Bedingungen für den Einladungshash zutrifft, wird der Nutzerstatus des Nutzers, dessen Hash aus passwort und salt2 passt, beim nächsten Login auf 2 erhöht. Ab dann kann er sein Passwort ändern und die E-Mail-Adressen werden in der Suchfunktion nicht mehr zensuriert.

(c) Passwort


i) Sicherheit: Das Passwort wird nirgendwo gespeichert (weder in der Datenbank noch in einer Session-Variablen). Gespeichert wird lediglich der Hash-Wert (SHA256 aus Passwort und salt1) in der Tabelle register. Nach dem Überprüfen des Passworts beim Login, wird die Session-Variable eingeloggt = true verwendet. Als eingeloggter User können alle Lesefunktionen (Suchfunktion, Darstellung eigener Daten) verwendet werden. Für jede Schreibfunktion (Änderung der persönlichen Daten, des Passworts oder Löschen des Kontos) wird dieser Variablen aus Sicherheitsgründen nicht vertraut und es muss erneut das Passwort eingegeben werden.

ii) Ändern: Das alte Passwort wird geprüft und das neue (falls beide Eingaben identisch) wird mit salt neu gehasht und der Wert in die Tabelle user geschrieben.

iii) Anfordern: Wurde das Passwort vergessen, kann für eine registrierte E-Mail-Adresse ein neues angelegt werden. Der Vorgang ähnelt der Erstregistrierung: E-Mail und das gewünschte Passwort müssen angegeben werden. Danach wird wieder ein Zufallswert value und ein neues salt erstellt, aus denen ein neuer Registrierungshash errechnet wird. Dieser wird in register abgelegt und ein Validierungslink per E-Mail versandt. Solange dieser Validierungslink nicht angeklickt wurde, bleibt das aktuelle, in user gespeicherte Passwort gültig. Zur Sicherheit muss auch nach dem Anklicken des Validierungslinks das neue Passwort noch einmal eingegeben werden. Ist dieses nicht richtig, bleibt weiterhin das aktuelle, in user gespeicherte Passwort gültig.

(d) Daten

Daten in LIPS werden entweder in der Datenbank (Tabellen register, user, entrance) oder in Session-Variablen gespeichert. Die Dateneingabe erfolgt über Formulare und die Methoden POST und GET (letzteres nur im Falle von Validierungslinks, die über Mail versandt werden). Datenabfragen erfolgen über SQL mit fixen Querys, im Falle der Suchfunktion auch mit variablen Querys (die anhand der gewählten Suchkriterien erstellt werden).
Aus Sicherheitsgründen werden sämtliche Daten in sämtliche Richtungen (Lesen und Schreiben) durch die Funktion valin() in validate_input.php validiert, d.h. Formulardaten, Datenbankdaten, Session-Variablen sowie Daten, die via POST oder GET übermittelt werden.

(e) Sessions

Sessions werden in handle_session.php über die variable duration auf 300 Sekunden (= 5 Minuten) beschränkt. Das Browser-Cookie ist länger aktiv (kann über Konfigurationsfile auf dem Server oder eventuell die Funktion setcookie() geändert werden).

(f) Layout

Das Layout wird im CSS-File lipsstyle.css definiert. Die meisten Seiten verwenden die Templates template_page_beginning.php und template_page_end.php, welches mittels PHP-include eingefügt werden (dazwischen befindet sich die division (div) content, in welcher der Hauptinhalt angezeigt wird).

(g) Menus

Befinden sich als Listen im File menu_raw.html (html-code ohne head- und body-Tag).

(h) Mailing

Sämtliche Mailings werden von der Funktion send_the_dove() in common_mailer.php versandt. Im Moment werden die Mails via anonymen Remailer versandt (die Methode ist relativ unzuverlässig – es braucht manchmal 3-4 Versuche, bis ein Mail wirklich versandt wird, dafür ist sie 100% anonym). Die Datei enthält weiteren (auskommentierten) Code zum Versand von Mails via SMTP-Server (benötigt wird die PEAR-Bibliothek; diese Methode war – in Verbindung mit einem anonymen Mailkonto – ursprünglich die erste Wahl und hat im Clearnet auch funktioniert, innerhalb von Tor traten jedoch Probleme mit der Verschlüsselung auf, weshalb sie wieder deaktiviert wurde). 

Für die Arbeit am Quellcode ausserhalb von Tor wird drigend empfohlen, die Mailfunktion durch Auskommentieren des Remailer-Teils zu desaktivieren und stattdessen die auskommentierte Faksimile-Funktion zu verwenden. Diese zeigt den Inhalt des zu versendenden Mails direkt im Browser an, sodass die korrekte Funktionsweise ohne Mailversand simuliert werden kann.
</pre>
<?php
include "template_page_end.php";
?>