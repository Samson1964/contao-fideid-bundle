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
 * Table tl_fideid
 */
$GLOBALS['TL_DCA']['tl_fideid'] = array
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
			'fields'                  => array('tstamp'),
			'flag'                    => 1,
			'panelLayout'             => 'filter,sort;search,limit',
		),
		'label' => array
		(
			'fields'                  => array('nachname', 'vorname', 'geburtsdatum'),
			'format'                  => '%s, %s',
			'showColumns'             => true,
			//'label_callback'          => array('tl_fideid', 'listRecords')
		),
		'global_operations' => array
		(
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
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif',
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
				//'button_callback'     => array('tl_fideid', 'copyArchive')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				//'button_callback'     => array('tl_fideid', 'deleteArchive')
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_fideid']['toggle'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{infobox_legend:hide},infobox;{auftraggeber_legend},nachname_person,vorname_person,email_person,art;{antragsteller_legend},nachname,vorname,titel,geburtsdatum,geschlecht,email;{fide_id_legend:hide},fide_id;{antragsteller_multiple_legend:hide},antragsteller;{datenschutz_legend:hide},datenschutz;{verein_legend:hide},verein;{ausweis_legend:hide},ausweis,elterneinverstaendnis;{turnier_legend:hide},turnier;{germany_legend},germany;{intern_legend:hide},intern;{publish_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'death'                       => 'deathday,deathplace,deathday_alt'
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
			'flag'                    => 5,
			'sorting'                 => true,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'infobox' => array
		(
			'exclude'              => true,
			'input_field_callback' => array('tl_fideid', 'getInfobox')
		),
		'nachname_person' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['nachname_person'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 32,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'vorname_person' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['vorname_person'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 32,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'email_person' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['email_person'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'search'                  => true,
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 255,
				'tl_class'            => 'w50',
				'rgxp'                => 'email'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'art' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['art'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_fideid']['art_optionen'],
			'eval'                    => array
			(
				'mandatory'           => true,
				'includeBlankOption'  => true,
				'maxlength'           => 20,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(20) NOT NULL default ''"
		),
		'nachname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['nachname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 32,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'vorname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['vorname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 32,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'titel' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['titel'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_fideid']['titel_optionen'],
			'eval'                    => array
			(
				'mandatory'           => false,
				'includeBlankOption'  => true,
				'maxlength'           => 10,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'geburtsdatum' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['geburtsdatum'],
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 7,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'mandatory'           => true,
				'doNotCopy'           => true,
				'datepicker'          => true,
				'tl_class'            => 'w50 wizard'
			),
			'load_callback' => array
			(
				array('tl_fideid', 'loadDate')
			),
			'sql'                     => "int(12) signed NOT NULL default 0"
		),
		'geschlecht' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['geschlecht'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'options'                 => &$GLOBALS['TL_LANG']['tl_fideid']['geschlecht_optionen'],
			'eval'                    => array
			(
				'mandatory'           => true,
				'includeBlankOption'  => true,
				'maxlength'           => 1,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(1) NOT NULL default ''"
		),
		'email' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['email'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'search'                  => true,
			'eval'                    => array
			(
				'mandatory'           => false,
				'maxlength'           => 255,
				'tl_class'            => 'w50',
				'rgxp'                => 'email'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'antragsteller' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['antragsteller'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'sql'                     => "text NULL"
		),
		'datenschutz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['datenschutz'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'verein' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['verein'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 255,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'ausweis' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['ausweis'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array
			(
				'filesOnly'           => true,
				'extensions'          => Config::get('validImageTypes'),
				'fieldType'           => 'radio',
				'mandatory'           => false
			),
			'sql'                     => "binary(16) NULL"
		),
		'elterneinverstaendnis' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['elterneinverstaendnis'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'turnier' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['turnier'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 255,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'germany' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['germany'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),


		'fide_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['fide_id'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>10, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'intern' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['intern'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE'),
			'sql'                     => "text NULL"
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid']['published'],
			'inputType'               => 'checkbox',
			'filter'                  => true,
			'eval'                    => array
			(
				'tl_class'            => 'w50',
				'isBoolean'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
	)
);


/**
 * Class tl_fideid
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_fideid extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	public function getInfobox(DataContainer $dc)
	{

		$string = '
<div class="widget long">
  <h3><label>String für FIDE-System</label></h3>
  <p>...</p>
</div>';

		return $string;
	}

	/**
	 * Set the timestamp to 00:00:00 (see #26)
	 *
	 * @param integer $value
	 *
	 * @return integer
	 */
	public function loadDate($value)
	{
		if($value) return strtotime(date('Y-m-d', $value) . ' 00:00:00');
		else return '';
	}

}
