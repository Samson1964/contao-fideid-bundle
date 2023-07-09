<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 */

/**
 * Backend-Modul Übersetzungen
 */

// Zusätzliche Funktionen
$GLOBALS['TL_LANG']['tl_fideid_templates']['fideid'] = array('FIDE-ID-Verwaltung', 'Zurück zur FIDE-ID-Verwaltung');

// Standardfunktionen
$GLOBALS['TL_LANG']['tl_fideid_templates']['new'] = array('Neues Template', 'Neues Template anlegen');
$GLOBALS['TL_LANG']['tl_fideid_templates']['editHeader'] = array("Template %s bearbeiten", "Template %s bearbeiten");
$GLOBALS['TL_LANG']['tl_fideid_templates']['copy'] = array("Template %s kopieren", "Template %s kopieren");
$GLOBALS['TL_LANG']['tl_fideid_templates']['delete'] = array("Template %s löschen", "Template %s löschen");
$GLOBALS['TL_LANG']['tl_fideid_templates']['toggle'] = array("Template %s aktivieren/deaktivieren", "Template %s aktivieren/deaktivieren");
$GLOBALS['TL_LANG']['tl_fideid_templates']['show'] = array("Details zum Template %s anzeigen", "Details zum Template %s anzeigen");

// Formularfelder
$GLOBALS['TL_LANG']['tl_fideid_templates']['name_legend'] = 'Name und Inhalt';
$GLOBALS['TL_LANG']['tl_fideid_templates']['name']= array('Name', 'Name des Templates');
$GLOBALS['TL_LANG']['tl_fideid_templates']['description']= array('Beschreibung', 'Kurze Beschreibung des Templates');
$GLOBALS['TL_LANG']['tl_fideid_templates']['subject']= array('Betreff', 'Betreffzeile der E-Mail. Platzhalter sind möglich, siehe Hilfelink.');
$GLOBALS['TL_LANG']['tl_fideid_templates']['template']= array('HTML-Inhalt', 'HTML-Inhalt des Templates. Verwenden Sie den Hilfe-Link für weitere Informationen.');

$GLOBALS['TL_LANG']['tl_fideid_templates']['speed_legend'] = 'Schneller E-Mail-Versand';
$GLOBALS['TL_LANG']['tl_fideid_templates']['speedbutton']= array('Aktivieren', 'Einen Button für schnellen E-Mail-Versand aktivieren');
$GLOBALS['TL_LANG']['tl_fideid_templates']['buttonname']= array('Text', 'Text auf dem Button');
$GLOBALS['TL_LANG']['tl_fideid_templates']['buttontip']= array('Hilfetext', 'Hilfetext unter dem Button');

$GLOBALS['TL_LANG']['tl_fideid_templates']['publish_legend'] = 'Aktivierung';
$GLOBALS['TL_LANG']['tl_fideid_templates']['published']= array('Aktiv', 'Template aktivieren');

// Beispiel-Template
$GLOBALS['TL_LANG']['tl_fideid_templates']['default_template']= 
'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="Generator" content="Contao Open Source CMS">
	<title>##subject##</title>
</head>
<body>

	##content##

</body>
</html>';
