<?php

/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{fideidverwaltung_legend:hide},fideidverwaltung_mailsignatur,fideidverwaltung_absender,fideidverwaltung_bestaetigungsseite,fideidverwaltung_uploads';

/**
 * fields
 */

// Absendername und E-Mail die bei Mails verwendet wird
$GLOBALS['TL_DCA']['tl_settings']['fields']['fideidverwaltung_absender'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['fideidverwaltung_absender'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50','preserveTags'=>true)
);

// Mailtemplate
$GLOBALS['TL_DCA']['tl_settings']['fields']['fideidverwaltung_mailsignatur'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['fideidverwaltung_mailsignatur'],
	'inputType'               => 'textarea',
	'eval'                    => array('tl_class'=>'long clr', 'rte' => 'tinyMCE', 'cols' => 80,'rows' => 10)
);

// Seite für das Antrag-Bestätigungs-Modul
$GLOBALS['TL_DCA']['tl_settings']['fields']['fideidverwaltung_bestaetigungsseite'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['fideidverwaltung_bestaetigungsseite'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'foreignKey'              => 'tl_page.title',
	'eval'                    => array
	(
		'mandatory'           => true,
		'fieldType'           => 'radio',
		'tl_class'            => 'w50 clr'
	),
	'sql'                     => "int(10) unsigned NOT NULL default 0",
	'relation'                => array
	(
		'type'                => 'hasOne',
		'load'                => 'lazy'
	)
); 

// Ordner für die Ablage von hochgeladenen Dateien
$GLOBALS['TL_DCA']['tl_settings']['fields']['fideidverwaltung_uploads'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['fideidverwaltung_uploads'],
	'inputType'               => 'fileTree',
	'eval'                    => array
	(
		'multiple'            => false, 
		'fieldType'           => 'radio', 
		'tl_class'            => 'w50'
	),
);
