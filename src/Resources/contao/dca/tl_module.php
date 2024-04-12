<?php

// Add palette to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['fideid_form'] = '{title_legend},name,headline,type,fideid_formtyp;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['fideid_confirm'] = '{title_legend},name,headline,type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['fideid_formtyp'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['fideid_formtyp'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'eval'                    => array
	(
		'mandatory'           => true, 
		'tl_class'            => 'clr w50'
	),
	'options'                 => array('1', '2', '3'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_module']['fideid_formtyp_options'],
	'sql'                     => "varchar(1) NOT NULL default '1'"
);
