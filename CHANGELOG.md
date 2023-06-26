# DSB-FIDE-ID-Registrierung Changelog

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
