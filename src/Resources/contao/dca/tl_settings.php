<?php

/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{fideidverwaltung_legend:hide},fideidverwaltung_mailsignatur,fideidverwaltung_absender';

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
