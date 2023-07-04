# DSB-FIDE-ID-Registrierung Changelog

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
