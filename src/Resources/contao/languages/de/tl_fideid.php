<?php

/**
 * Backend-Modul: Übersetzungen im Eingabeformular
 */
$GLOBALS['TL_LANG']['tl_fideid']['infobox_legend'] = 'String für das FIDE-System';

$GLOBALS['TL_LANG']['tl_fideid']['auftraggeber_legend'] = 'Auftraggeber/Kontakt';
$GLOBALS['TL_LANG']['tl_fideid']['nachname_person'] = array('Nachname', 'Geben Sie hier den Nachnamen des Auftraggebers ein.');
$GLOBALS['TL_LANG']['tl_fideid']['vorname_person'] = array('Vorname', 'Geben Sie hier den Vornamen des Auftraggebers ein.');
$GLOBALS['TL_LANG']['tl_fideid']['email_person'] = array('E-Mail', 'Geben Sie hier die E-Mail-Adresse des Auftraggebers ein.');
$GLOBALS['TL_LANG']['tl_fideid']['art'] = array('Art des Antrags', 'Art des Antrags');

$GLOBALS['TL_LANG']['tl_fideid']['antragsteller_legend'] = 'Antragsteller';
$GLOBALS['TL_LANG']['tl_fideid']['nachname'] = array('Nachname', 'Geben Sie hier den Nachnamen des Antragstellers ein.');
$GLOBALS['TL_LANG']['tl_fideid']['vorname'] = array('Vorname', 'Geben Sie hier den Vornamen des Antragstellers ein.');
$GLOBALS['TL_LANG']['tl_fideid']['titel'] = array('Titel', 'Akademischer Titel');
$GLOBALS['TL_LANG']['tl_fideid']['geburtsdatum'] = array('Geburtsdatum', 'Geburtsdatum im Format TT.MM.JJJJ');
$GLOBALS['TL_LANG']['tl_fideid']['geschlecht'] = array('Geschlecht', 'Geschlecht des Antragstellers');
$GLOBALS['TL_LANG']['tl_fideid']['email'] = array('E-Mail', 'Geben Sie hier die E-Mail-Adresse des Antragstellers ein.');

$GLOBALS['TL_LANG']['tl_fideid']['fide_id_legend'] = 'FIDE-Identifikationsnummer';
$GLOBALS['TL_LANG']['tl_fideid']['fide_id'] = array('FIDE-Identifikationsnummer', 'Zugeteilte FIDE-Identifikationsnummer');

$GLOBALS['TL_LANG']['tl_fideid']['antragsteller_multiple_legend'] = 'Mehrere Antragsteller';
$GLOBALS['TL_LANG']['tl_fideid']['antragsteller'] = array('Antragsteller', 'Je Zeile ein Antragsteller');

$GLOBALS['TL_LANG']['tl_fideid']['datenschutz_legend'] = 'Datenschutz';
$GLOBALS['TL_LANG']['tl_fideid']['datenschutz'] = array('Datenweitergabe an die FIDE', 'Der Antragsteller willigt ein, daß der Deutsche Schachbund die Daten an die FIDE weitergibt.');

$GLOBALS['TL_LANG']['tl_fideid']['verein_legend'] = 'Verein';
$GLOBALS['TL_LANG']['tl_fideid']['verein'] = array('Verein', 'Verein des Antragstellers');

$GLOBALS['TL_LANG']['tl_fideid']['intern_legend'] = 'Interne Bemerkungen';
$GLOBALS['TL_LANG']['tl_fideid']['intern'] = array('Bemerkungen', 'Interne Bemerkungen');

$GLOBALS['TL_LANG']['tl_fideid']['publish_legend'] = 'Bearbeitungsstatus';
$GLOBALS['TL_LANG']['tl_fideid']['publish'] = array('Fertig', 'Der Antrag wurde fertig bearbeitet.');

/**
 * Buttons für Operationen
 */

$GLOBALS['TL_LANG']['tl_fideid']['new'] = array('Neuer Antrag', 'Neuen Antrag anlegen');
$GLOBALS['TL_LANG']['tl_fideid']['edit'] = array('Antrag bearbeiten', 'Antrag %s bearbeiten');
$GLOBALS['TL_LANG']['tl_fideid']['copy'] = array('Antrag kopieren', 'Antrag %s kopieren');
$GLOBALS['TL_LANG']['tl_fideid']['delete'] = array('Antrag löschen', 'Antrag %s löschen');
$GLOBALS['TL_LANG']['tl_fideid']['toggle'] = array('Antrag aktivieren/deaktivieren', 'Antrag %s aktivieren/deaktivieren');
$GLOBALS['TL_LANG']['tl_fideid']['show'] = array('Antragsdetails anzeigen', 'Details des Antrags %s anzeigen');
/**
 * Select-Felder
 */

$GLOBALS['TL_LANG']['tl_fideid']['art_optionen'] = array
(
	'Mitglied'          => 'Der Antragsteller ist DSB-Vereinsmitglied und über 18 Jahre alt',
	'Mitglied_u18'      => 'Der Antragsteller ist DSB-Vereinsmitglied und unter 18 Jahre alt',
	'Kein_Mitglied'     => 'Der Antragsteller ist vereinslos und über 18 Jahre alt',
	'Kein_Mitglied_u18' => 'Der Antragsteller ist vereinslos und unter 18 Jahre alt',
	'Turnierleiter'     => 'Ich bin Turnierleiter und möchte mehrere ID\'s beantragen',
);

$GLOBALS['TL_LANG']['tl_fideid']['titel_optionen'] = array
(
	'Dr.'        => 'Dr.',
	'Dr. Dr.'    => 'Dr. Dr.',
	'Prof.'      => 'Prof.',
	'Prof. Dr.'  => 'Prof. Dr.',
);

$GLOBALS['TL_LANG']['tl_fideid']['geschlecht_optionen'] = array
(
	'M'    => 'Männlich',
	'W'    => 'Weiblich',
	'D'    => 'Divers',
);
