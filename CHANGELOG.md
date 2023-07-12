# DSB-FIDE-ID-Registrierung Changelog

## Version 1.1.3 (2023-07-12)

* Add: tl_fideid.unter18 -> Antragsteller ist unter 18 Jahre alt
* Add: tl_fideid.imVerein -> Antragsteller ist Vereinsmitglied
* Delete: tl_fideid.art -> zum Löschen vormerken, da aufgrund der beiden Checkboxen nicht mehr benötigt

## Version 1.1.2 (2023-07-12)

* Fix: Prüfung ob E-Mail-Adressen gesetzt sind und nicht doppelt, bevor eine Mail rausgeht

## Version 1.1.1 (2023-07-10)

* Add: tl_fideid.ueber18 -> wird im Formular abgefragt, im Backend wird die Checkbox versteckt
* Add: tl_fideid.turnierlink -> Zeigt einen Link zur FIDE-Seite mit den registrierten Turnieren an.

## Version 1.1.0 (2023-07-09)

* Fix: Falsches E-Mail-Icon in tl_fideid -> zeigt falschen Status an
* Change: Übersetzungen dieser E-Mail-Info ausgelagert nach languages
* Add: tl_fideid_templates.subject -> Betreffzeile in Templates festlegen
* Add: In der E-Mail wird jetzt die Betreffzeile aus dem Template verwendet, die von der Betreffzeile in der E-Mail überschrieben werden kann.
* Add: Hilfe in tl_fideid_templates.subject, tl_fideid_templates.template, tl_fideid_mails.subject und tl_fideid_mails.content
* Add: tl_fideid_templates.speedbutton und tl_fideid_templates.buttonname für Aktivierung eines Buttons für schnellen E-Mail-Versand
* Add: tl_fideid.speedmail -> Formularbereich mit Buttons für den schnellen E-Mail-Versand
* Add: Klasse Speedmailer.php für den schnellen E-Mail-Versand

## Version 1.0.0 (2023-07-04)

* Change: tl_fideid -> Farbe des Spielers nur rot, grün und blau
* Fix: Fehler bei Icon-Verlinkung E-Mail

## Version 0.4.2 (2023-07-04)

* Fix: Darstellung E-Mail-Button tl_fideid verbessert

## Version 0.4.1 (2023-07-02)

* Add: E-Mail-Funktion ausgebaut und Fehler beseitigt
* Add: Speicherung der Absender/Empfänger beim Versand

## Version 0.4.0 (2023-06-30)

* Fix: Wenn Imagick nicht installiert ist, kommt eine Fehlermeldung -> Abfrage eingebaut, ob Imagick vorhanden ist
* Change: Icons Tabelle tl_fideid und tl_fideid_templates ausgetauscht
* Add: Tabelle tl_fideid_mails -> Verwaltung der E-Mails
* Add: Tabelle tl_settings -> Einstellungen
* Add: E-Mail-Funktionen ausgebaut

## Version 0.3.0 (2023-06-29)

* Add: tl_fideid.nuligalight -> Checkbox für Bestätigung der Eintragung der FIDE-ID in der Mitgliederverwaltung
* Delete: tl_fideid.abschnitt -> Hilfsfeld hat negative Auswirkungen im Formular
* Add: tl_fideid.ausweisbox -> Vorschau/Link der angehängten Datei (Unterstützung für: pdf, jpg, png, gif)
* Add: Tabelle tl_fideid_templates -> Verwaltung der E-Mail-Templates

## Version 0.2.6 (2023-06-26)

* Fix: Änderungen aus Version 0.2.4 rückgängig gemacht, da der storeFormData-Hook erst nach dem E-Mail-Versand aktiv wird.
* Add: Helper-Klasse CopyEmail, um E-Mail-Adresse des Antragstellers zum Auftraggeber zu kopieren -> Fehler "Could not set reply-to address ##form_email_person## for message ID 58: Address in mailbox given [##form_email_person##] does not comply with RFC 2822, 3.6.2." (Funktion NotificationCenter\Gateway\Email::sendDraft) verhindern

## Version 0.2.5 (2023-06-26)

* Fix: PHP-Fehler in Zeile 36 SaveAusweis

## Version 0.2.4 (2023-06-26)

* Add: Prüffunktion im storeFormData-Hook, ob beide E-Mail-Adressen angegeben sind. Contao versendet nur Mails, wenn ein angegebenes Token auch existiert.

## Version 0.2.3 (2023-06-26)

* Fix: tl_fideid.verein -> kein Pflichtfeld!
* Fix: tl_fideid.turnier -> kein Pflichtfeld!
* Add: tl_fideid.abschnitt -> Hilfsfeld für die Formularposition

## Version 0.2.2 (2023-06-26)

* Fix: tl_fideid.formulardatum abwärts statt aufwärts sortieren
* Add: Ausgabe ausweis.log aktiviert, um zu sehen ob elterneinverstaendnis korrekt da ist.

## Version 0.2.1 (2023-06-26)

* Fix: Der storeFormData-Hook hat keine Daten zurückgegeben
* Fix: Übersetzungen ausweis-Feld korrigiert

## Version 0.2.0 (2023-06-26)

* Change: Farbliche Kennzeichnung Bearbeitungsstatus kontrastreicher gemacht
* Add: Helper-Klasse SaveAusweis, um Datei-Uploads des Formulars abzufangen und den Upload entsprechend aufzubereiten (UUID erstellen)

## Version 0.1.1 (2023-06-25)

* Delete: Toggle-Icon, da es ersetzt wird durch eine Status-Auswahlliste
* Add: tl_fideid.status -> Auswahlliste für Bearbeitungsstatus
* Delete: tl_fideid.antragsteller -> Turnierleiter-Option entfällt, deshalb nicht mehr benötigt
* Add: tl_fideid.bemerkungen -> Textarea für Bemerkungen vom Formularabsender
* Add: tl_fideid.antragsteller_ungleich_person -> Optionales Feld, welches bei true die Auftraggeber-Felder einblendet

## Version 0.1.0 (2023-06-22)

* Add: tl_fideid.formulardatum -> Ungefährer Versandzeitpunkt des Antrags
* Change: tl_fideid.infobox -> String für FIDE-System generieren
* Change: Felder für Filter, Sortierung, Suche optimiert
* Add: Datensatz wird mit roter Schrift ausgegeben in Übersicht, wenn unbearbeitet.

## Version 0.0.4 (2023-06-22)

* Change tl_fideid.geburtsdatum -> SQL geändert von int(10) unsigned auf int(12) signed, um auch negative Zahlen verwenden zu können

## Version 0.0.3 (2023-06-21)

* Ausbau des Bundles

## Version 0.0.2 (2023-06-21)

* Ausbau des Bundles

## Version 0.0.1 (2023-06-21)

* Ersteinrichtung der Erweiterung für Contao 4 als Bundle
