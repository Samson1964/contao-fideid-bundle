<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package News
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Table tl_fideid_templates
 */
$GLOBALS['TL_DCA']['tl_fideid_templates'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'switchToEdit'                => true, 
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id'                 => 'primary',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('name'),
			'flag'                    => 1,
			'panelLayout'             => 'filter,sort;search,limit',
			'disableGrouping'         => true,
		),
		'label' => array
		(
			'fields'                  => array('name', 'description', 'subject'),
			'format'                  => '%s %s',
			'showColumns'             => true,
		),
		'global_operations' => array
		(
			'fideid' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_templates']['fideid'],
				'href'                => 'table=tl_fideid',
				'icon'                => 'bundles/contaofideid/images/fideid.png',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			),
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_templates']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_templates']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_templates']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_fideid_templates']['toggle'],
				'attributes'           => 'onclick="Backend.getScrollOffset()"',
				'haste_ajax_operation' => array
				(
					'field'            => 'published',
					'options'          => array
					(
						array('value' => '', 'icon' => 'invisible.svg'),
						array('value' => '1', 'icon' => 'visible.svg'),
					),
				),
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_templates']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('speedbutton'),
		'default'                     => '{name_legend},name,description,subject,template;{speed_legend},speedbutton;{publish_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'speedbutton'                 => 'buttonname,buttontip'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 255, 
				'tl_class'            => 'long'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false,
				'maxlength'           => 255, 
				'tl_class'            => 'long'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['subject'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false,
				'maxlength'           => 255, 
				'helpwizard'          => true, 
				'tl_class'            => 'long'
			),
			'explanation'             => 'fideid_templates',
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['template'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'default'                 => &$GLOBALS['TL_LANG']['tl_fideid_templates']['default_template'],
			'eval'                    => array
			(
				'mandatory'           => true, 
				'preserveTags'        => true, 
				'decodeEntities'      => true, 
				'class'               => 'monospace', 
				'rte'                 => 'ace|php', 
				'helpwizard'          => true, 
				'tl_class'            => 'long'
			),
			'explanation'             => 'fideid_templates',
			'sql'                     => "text NULL"
		),
		'speedbutton' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['speedbutton'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array
			(
				'submitOnChange'      => true, 
				'tl_class'            => 'clr'
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'buttonname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['buttonname'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'maxlength'           => 32, 
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'buttontip' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['buttontip'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'tl_class'            => 'w50'
			),
			'sql'                     => "text NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_templates']['published'],
			'inputType'               => 'checkbox',
			'exclude'                 => true,
			'default'                 => 1,
			'filter'                  => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
	)
);


/**
 * Class tl_fideid_templates
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_fideid_templates extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

}
