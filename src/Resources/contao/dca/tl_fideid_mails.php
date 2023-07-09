<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Table tl_fideid_mails
 */
$GLOBALS['TL_DCA']['tl_fideid_mails'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_fideid',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sent_state ASC', 'sent_date DESC'),
			'headerFields'            => array('vorname', 'nachname', 'geburtsdatum'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_fideid_mails', 'listEmails')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_mails']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_mails']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_mails']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_mails']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_mails']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'send' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_fideid_mails']['send'],
				'href'                => 'key=send',
				'icon'                => 'bundles/contaofideid/images/email_senden.png'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{text_legend},subject,content;{template_legend},template,preview'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_fideid.id',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'flag'                    => 11,
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'template' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['template'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_fideid_mails', 'getTemplates'),
			'eval'                    => array
			(
				'includeBlankOption'  => true,
				'tl_class'            => 'w50',
				'submitOnChange'      => true
			),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'preview' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['preview'],
			'input_field_callback'    => array('tl_fideid_mails', 'getPreview'),
			'exclude'                 => false,
		),
		'subject' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['subject'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'decodeEntities'      => true, 
				'maxlength'           => 255, 
				'helpwizard'          => true, 
				'tl_class'            => 'long clr'
			),
			'explanation'             => 'fideid_templates',
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'content' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['content'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array
			(
				'rte'                 => 'tinyMCE',
				'helpwizard'          => true,
				'tl_class'            => 'long clr',
			),
			'explanation'             => 'fideid_templates',
			'sql'                     => "mediumtext NULL"
		),
		'sent_state' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_state'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
				'isBoolean'           => true,
			),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'sent_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_date'],
			'sorting'                 => true,
			'flag'                    => 6,
			'eval'                    => array
			(
				'rgxp'                => 'date',
				'doNotCopy'           => true,
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sent_text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_text'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
			),
			'sql'                     => "mediumtext NULL"
		),
		'sent_from' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_from'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
			),
			'sql'                     => "mediumtext NULL"
		),
		'sent_to' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_to'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
			),
			'sql'                     => "mediumtext NULL"
		),
		'sent_cc' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_cc'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
			),
			'sql'                     => "mediumtext NULL"
		),
		'sent_bcc' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_fideid_mails']['sent_bcc'],
			'eval'                    => array
			(
				'doNotCopy'           => true,
			),
			'sql'                     => "mediumtext NULL"
		),
	)
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_fideid_mails extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * List records
	 *
	 * @param array $arrRow
	 *
	 * @return string
	 */
	public function listEmails($arrRow)
	{
		// Template aus Datenbank laden
		$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id=?")
		                               ->execute($arrRow['template']);

		$spieler = \Database::getInstance()->prepare("SELECT * FROM tl_fideid WHERE id=?")
		                                   ->execute($arrRow['pid']);

		if($tpl->numRows)
		{
			// Betreffzeile festlegen
			$arrRow['subject'] = $arrRow['subject'] ? $arrRow['subject'] : $tpl->subject;
			// Text festlegen
			preg_match('/<body>(.*)<\/body>/s', $tpl->template, $matches); // Body extrahieren
			$content = \StringUtil::restoreBasicEntities($matches[1]); // [nbsp] und Co. ersetzen
			// Felder den Tokens zuweisen
			$arrTokens = array
			(
				'status'                        => $spieler->status,
				'formulardatum'                 => date('d.m.Y H:i', $spieler->formulardatum),
				'antragsteller_ungleich_person' => $spieler->antragsteller_ungleich_person,
				'nachname_person'               => $spieler->nachname_person,
				'vorname_person'                => $spieler->vorname_person,
				'email_person'                  => $spieler->email_person,
				'art'                           => $spieler->art,
				'nachname'                      => $spieler->nachname,
				'vorname'                       => $spieler->vorname,
				'titel'                         => $spieler->titel,
				'geburtsdatum'                  => date('d.m.Y', $spieler->geburtsdatum),
				'geschlecht'                    => $spieler->geschlecht,
				'email'                         => $spieler->email,
				'fide_id'                       => $spieler->fide_id,
				'nuligalight'                   => $spieler->nuligalight,
				'datenschutz'                   => $spieler->datenschutz,
				'verein'                        => $spieler->verein,
				'ausweis'                       => $spieler->ausweis,
				'elterneinverstaendnis'         => $spieler->elterneinverstaendnis,
				'turnier'                       => $spieler->turnier,
				'germany'                       => $spieler->germany,
				'bemerkungen'                   => $spieler->bemerkungen,
				'intern'                        => $spieler->intern,
				'subject'                       => $arrRow['subject'],
				'content'                       => $arrRow['content'],
				'signatur'                      => $GLOBALS['TL_CONFIG']['fideidverwaltung_mailsignatur'],
			);
			$arrRow['subject'] = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($arrRow['subject'], $arrTokens);
			$content = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($content, $arrTokens);
		}
		else
		{
			// Kein Template gefunden
			$content = 'Kein Template gefunden!';
		}

		// Empfänger-Ausgabe vorbereiten
		$to = unserialize($arrRow['sent_to']);
		if(is_array($to)) $to = implode('', $to);
		$cc = unserialize($arrRow['sent_cc']);
		if(is_array($cc)) $cc = implode('', $cc);
		$bcc = unserialize($arrRow['sent_bcc']);
		if(is_array($bcc)) $bcc = implode('', $bcc);

		return '
<div class="cte_type ' . (($arrRow['sent_state'] && $arrRow['sent_date']) ? 'published' : 'unpublished') . '"><strong>' . $arrRow['subject'] . '</strong> - ' . (($arrRow['sent_state'] && $arrRow['sent_date']) ? 'Versendet am '.Date::parse(Config::get('datimFormat'), $arrRow['sent_date']) : 'Nicht versendet'). '<br>
<span style="color:black;">Von:</span> <span style="color:blue;">'.htmlentities($arrRow['sent_from']).'</span>
<span style="color:black;">An:</span> <span style="color:blue;">'.htmlentities($to).'</span><br>
<span style="color:black;">Cc:</span> <span style="color:blue;">'.htmlentities($cc).'</span>
<span style="color:black;">Bcc:</span> <span style="color:blue;">'.htmlentities($bcc).'</span>
</div>
<div class="limit_height' . (!Config::get('doNotCollapse') ? ' h128' : '') . '">' . (!$arrRow['send_text'] ? '
' . \StringUtil::insertTagToSrc($content) . '<hr>' : '' ) . '
</div>' . "\n";

	}

	public function getPreview(\DataContainer $dc)
	{
		// Templatestatus
		if($dc->activeRecord->template)
		{
			// Spieler laden
			$spieler = \Database::getInstance()->prepare("SELECT * FROM tl_fideid WHERE id=?")
			                                   ->execute($dc->activeRecord->pid);
			// Template laden
			$tpl = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE id=?")
			                               ->execute($dc->activeRecord->template);

			if($tpl->numRows)
			{
				// Betreffzeile festlegen
				$subject = $dc->activeRecord->subject ? $dc->activeRecord->subject : $tpl->subject;
				// Text festlegen
				preg_match('/<body>(.*)<\/body>/s', $tpl->template, $matches); // Body extrahieren
				$content = \StringUtil::restoreBasicEntities($matches[1]); // [nbsp] und Co. ersetzen  
				// Felder den Tokens zuweisen
				$arrTokens = array
				(
					'status'                        => $spieler->status,
					'formulardatum'                 => date('d.m.Y H:i', $spieler->formulardatum),
					'antragsteller_ungleich_person' => $spieler->antragsteller_ungleich_person,
					'nachname_person'               => $spieler->nachname_person,
					'vorname_person'                => $spieler->vorname_person,
					'email_person'                  => $spieler->email_person,
					'art'                           => $spieler->art,
					'nachname'                      => $spieler->nachname,
					'vorname'                       => $spieler->vorname,
					'titel'                         => $spieler->titel,
					'geburtsdatum'                  => date('d.m.Y', $spieler->geburtsdatum),
					'geschlecht'                    => $spieler->geschlecht,
					'email'                         => $spieler->email,
					'fide_id'                       => $spieler->fide_id,
					'nuligalight'                   => $spieler->nuligalight,
					'datenschutz'                   => $spieler->datenschutz,
					'verein'                        => $spieler->verein,
					'ausweis'                       => $spieler->ausweis,
					'elterneinverstaendnis'         => $spieler->elterneinverstaendnis,
					'turnier'                       => $spieler->turnier,
					'germany'                       => $spieler->germany,
					'bemerkungen'                   => $spieler->bemerkungen,
					'intern'                        => $spieler->intern,
					'subject'                       => $dc->activeRecord->subject,
					'content'                       => $dc->activeRecord->content,
					'signatur'                      => $GLOBALS['TL_CONFIG']['fideidverwaltung_mailsignatur'],
				);
				$subject = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($subject, $arrTokens);
				$subject = '<div class="tl_preview"><b>'.$subject.'</b></div>';
				$content = \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($content, $arrTokens);
				$content = '<div class="tl_preview"><p>'.$content.'</p></div>';
			}
			else
			{
				// Kein Template gefunden
				$content = '<p><b>Kein Template gefunden!</b></p>';
			}
		}
		else
		{
			$content = '<p><b>Keine Vorlage ausgewählt</b></p>';
		}

		$subject .= 'Betreff';
		
		$string = '
<div class="long clr widget">
	<h3><label>'.$GLOBALS['TL_LANG']['tl_fideid_mails']['preview'][0].'</label></h3>
	'.$subject.'
	<p class="tl_help tl_tip" title="">'.$GLOBALS['TL_LANG']['tl_fideid_mails']['preview_subject'][1].'</p>
</div>
<div class="long clr widget">
	'.$content.'
	<p class="tl_help tl_tip" title="">'.$GLOBALS['TL_LANG']['tl_fideid_mails']['preview_text'][1].'</p>
</div>';

		return $string;
	}

	public function getTemplates(\DataContainer $dc)
	{

		// Neue Templates laden
		$result = \Database::getInstance()->prepare("SELECT * FROM tl_fideid_templates WHERE published = ?")
		                                  ->execute(1);

		$options = array();
		while($result->next())
		{
			$options[$result->id] = $result->name.($result->description ? ' ('.$result->description.')' : '');
		}

		return $options;

	}

}
