<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   FIDE-ID-Erweiterung
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2023
 */
namespace Schachbulle\ContaoFideidBundle\Modules;

class Form extends \Module
{

	protected $strTemplate = 'mod_fideid';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### FIDE-ID-ANTRAGSFORMULAR ###';
			$objTemplate->title = $this->name;
			$objTemplate->id = $this->id;

			return $objTemplate->parse();
		}
		else
		{
			$this->Template = new \FrontendTemplate($this->strTemplate);
		}

		return parent::generate(); // Weitermachen mit dem Modul
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;

		$link = self::getVerifizierungsseite('token');
		log_message('Bestätigungslink: '.print_r($link, true), 'fideid.log');

		// Template füllen
		$content = self::Formular();
		$this->Template->content = $content;
	}

	protected function Formular()
	{

		// Wurde das Formular zurückgesetzt?
		if(\Input::get('reset_fideidform'))
		{
			\Session::getInstance()->set('fideidform', false);
			\Controller::redirect(str_replace('reset_fideidform=1', '', \Environment::get('request')));
		}
		
		$zufallszahl = rand(1, 99);
		
		// Frontend-CSS einbinden
		$GLOBALS['TL_CSS'][] = 'bundles/contaofideid/css/frontend.css';

		$data = \Session::getInstance()->get('fideidform'); // Sessiondaten laden
		//log_message('Folgende Daten sind in der Sitzung: '.print_r($data, true), 'fideid.log');
		$aktuelleSeite = \Environment::get('request');

		$objForm = new \Haste\Form\Form('fideidform', 'POST', function($objHaste)
		{
			return \Input::post('FORM_SUBMIT') === $objHaste->getFormId();
		});
		
		//echo '<pre>';
		//print_r($_POST);
		//echo '</pre>';

		if(!$data['antrag_seite'])
		{
			// Felder für Antrag Seite 1 hinzufügen
			// Länderkennung GER, Datenweitergabe FIDE, Über 18 -> alles Pflichtfelder
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '1',));
			$objForm->addFormField('antrag_seite1', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite1'], 'class' => '')));
			$objForm->addFormField('germany', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['germany'], 'inputType' => 'checkbox', 'eval' => array('mandatory'=>true, 'class'=>'form-control')));
			$objForm->addFormField('datenschutz', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['datenschutz'], 'inputType' => 'checkbox', 'eval' => array('mandatory'=>true, 'class'=>'form-control')));
			$objForm->addFormField('ueber18', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['ueber18'], 'inputType' => 'checkbox', 'eval' => array('mandatory'=>true, 'class'=>'form-control')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
		}
		elseif($data['antrag_seite'] == 1)
		{
			// Felder für Antrag Seite 2 hinzufügen
			// Antrag für: Vor- und Nachname, Titel, E-Mail, Geburtsdatum, Geschlecht
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '2',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany'],));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18'],));
			$objForm->addFormField('antrag_seite2', array('inputType' => 'explanation',	'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite2'], 'class' => '')));
			$objForm->addFormField('nachname', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['nachname'], 'inputType' => 'text', 'eval' => array('mandatory' => true, 'class'=>'form-control')));
			$objForm->addFormField('vorname', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['vorname'], 'inputType' => 'text', 'eval' => array('mandatory' => true, 'class'=>'form-control')));
			$objForm->addFormField('titel', array('label'   => &$GLOBALS['TL_LANG']['fideid-form']['titel'], 'inputType'  => 'select', 'options'  => &$GLOBALS['TL_LANG']['fideid-form']['titel_optionen'], 'eval'   => array('mandatory' => false, 'includeBlankOption' => true, 'class'=>'form-control')));
			$objForm->addFormField('email', array('label'   => &$GLOBALS['TL_LANG']['fideid-form']['email'], 'inputType'  => 'text', 'eval' => array('mandatory' => true, 'rgxp'=>'email', 'class'=>'form-control')));
			$objForm->addFormField('antrag_seite2_email', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite2_email'], 'class' => '')));
			$objForm->addFormField('geburtsdatum', array('label'   => &$GLOBALS['TL_LANG']['fideid-form']['geburtsdatum'], 'inputType'  => 'text', 'eval'  => array('mandatory'=>true, 'placeholder' => 'TT.MM.JJJJ', 'class'=>'date form-control')));
			$objForm->addFormField('geschlecht', array('label'   => &$GLOBALS['TL_LANG']['fideid-form']['geschlecht'], 'inputType'  => 'select', 'options' => &$GLOBALS['TL_LANG']['fideid-form']['geschlecht_optionen'], 'eval'   => array('mandatory' => true, 'includeBlankOption' => true, 'class'=>'form-control')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}
		elseif($data['antrag_seite'] == 2)
		{
			// Felder für Antrag Seite 3 hinzufügen (wird nur ausgeführt bei unter 18 Jahre)
			// Abfrage der Daten des Formularausfüllers / Ausweis oder Geburtsurkunde der beantragten Person
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '3',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany'],));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18'],));
			$objForm->addFormField('antragsteller_ungleich_person', array('inputType' => 'hidden', 'value'  => $data['antragsteller_ungleich_person'],));
			$objForm->addFormField('unter18', array('inputType' => 'hidden', 'value'  => $data['unter18'],));
			$objForm->addFormField('nachname', array('inputType' => 'hidden', 'value'  => $data['nachname']));
			$objForm->addFormField('vorname', array('inputType' => 'hidden', 'value'  => $data['vorname']));
			$objForm->addFormField('titel', array('inputType' => 'hidden', 'value'  => $data['titel']));
			$objForm->addFormField('email', array('inputType' => 'hidden', 'value'  => $data['email']));
			$objForm->addFormField('geburtsdatum', array('inputType' => 'hidden', 'value'  => $data['geburtsdatum']));
			$objForm->addFormField('geschlecht', array('inputType' => 'hidden', 'value'  => $data['geschlecht']));
			$objForm->addFormField('antrag_seite3', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite3'], 'class' => '')));
			$objForm->addFormField('nachname_person', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['nachname_person'], 'inputType' => 'text', 'eval' => array('mandatory' => true, 'class'=>'form-control')));
			$objForm->addFormField('vorname_person', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['vorname_person'], 'inputType' => 'text', 'eval' => array('mandatory' => true, 'class'=>'form-control')));
			$objForm->addFormField('email_person', array('label'   => &$GLOBALS['TL_LANG']['fideid-form']['email_person'], 'inputType'  => 'text', 'value' => $data['email'], 'eval' => array('mandatory' => true, 'rgxp'=>'email', 'class'=>'form-control')));
			$objForm->addFormField('ausweis', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['ausweis'], 'inputType' => 'upload', 'eval' => array('mandatory' => true, 'maxlength' => \Config::get('maxFileSize'), 'fSize' => \Config::get('maxFileSize'), 'extensions' => 'jpg,jpeg,gif,png,pdf')));
			$objForm->addFormField('antrag_seite3_ausweis', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite3_ausweis'], 'class' => '')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}
		elseif($data['antrag_seite'] == 3)
		{
			// Felder für Antrag Seite 4 hinzufügen
			// Turniername und Verein ja/nein
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '4',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany']));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18']));
			$objForm->addFormField('antragsteller_ungleich_person', array('inputType' => 'hidden', 'value'  => $data['antragsteller_ungleich_person'],));
			$objForm->addFormField('unter18', array('inputType' => 'hidden', 'value'  => $data['unter18'],));
			$objForm->addFormField('nachname', array('inputType' => 'hidden', 'value'  => $data['nachname']));
			$objForm->addFormField('vorname', array('inputType' => 'hidden', 'value'  => $data['vorname']));
			$objForm->addFormField('titel', array('inputType' => 'hidden', 'value'  => $data['titel']));
			$objForm->addFormField('email', array('inputType' => 'hidden', 'value'  => $data['email']));
			$objForm->addFormField('geburtsdatum', array('inputType' => 'hidden', 'value'  => $data['geburtsdatum']));
			$objForm->addFormField('geschlecht', array('inputType' => 'hidden', 'value'  => $data['geschlecht']));
			$objForm->addFormField('nachname_person', array('inputType' => 'hidden', 'value'  => $data['nachname_person']));
			$objForm->addFormField('vorname_person', array('inputType' => 'hidden', 'value'  => $data['vorname_person']));
			$objForm->addFormField('email_person', array('inputType' => 'hidden', 'value'  => $data['email_person']));
			$objForm->addFormField('ausweis', array('inputType' => 'hidden', 'value'  => $data['ausweis']));
			$objForm->addFormField('antrag_seite4', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite4'], 'class' => '')));
			$objForm->addFormField('turnier', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['turnier'], 'inputType' => 'text', 'eval' => array('mandatory'=>true, 'class'=>'form-control')));
			$objForm->addFormField('antrag_seite4_turnier', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite4_turnier'], 'class' => '')));
			$objForm->addFormField('imVerein', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['imVerein'], 'inputType' => 'checkbox', 'eval' => array('mandatory' => false, 'class'=>'form-control')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}
		elseif($data['antrag_seite'] == 4)
		{
			// Felder für Antrag Seite 5 hinzufügen
			// Vereinsname
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '5',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany']));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18']));
			$objForm->addFormField('antragsteller_ungleich_person', array('inputType' => 'hidden', 'value'  => $data['antragsteller_ungleich_person'],));
			$objForm->addFormField('unter18', array('inputType' => 'hidden', 'value'  => $data['unter18'],));
			$objForm->addFormField('nachname', array('inputType' => 'hidden', 'value'  => $data['nachname']));
			$objForm->addFormField('vorname', array('inputType' => 'hidden', 'value'  => $data['vorname']));
			$objForm->addFormField('titel', array('inputType' => 'hidden', 'value'  => $data['titel']));
			$objForm->addFormField('email', array('inputType' => 'hidden', 'value'  => $data['email']));
			$objForm->addFormField('geburtsdatum', array('inputType' => 'hidden', 'value'  => $data['geburtsdatum']));
			$objForm->addFormField('geschlecht', array('inputType' => 'hidden', 'value'  => $data['geschlecht']));
			$objForm->addFormField('nachname_person', array('inputType' => 'hidden', 'value'  => $data['nachname_person']));
			$objForm->addFormField('vorname_person', array('inputType' => 'hidden', 'value'  => $data['vorname_person']));
			$objForm->addFormField('email_person', array('inputType' => 'hidden', 'value'  => $data['email_person']));
			$objForm->addFormField('ausweis', array('inputType' => 'hidden', 'value'  => $data['ausweis']));
			$objForm->addFormField('turnier', array('inputType' => 'hidden', 'value'  => $data['turnier']));
			$objForm->addFormField('imVerein', array('inputType' => 'hidden', 'value'  => $data['imVerein']));
			$objForm->addFormField('antrag_seite5', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite5'], 'class' => '')));
			$objForm->addFormField('verein', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['verein'], 'inputType' => 'text', 'eval' => array('mandatory' => true, 'class'=>'form-control')));
			$objForm->addFormField('antrag_seite5_verein', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite5_verein'], 'class' => '')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}
		elseif($data['antrag_seite'] == 5)
		{
			// Felder für Antrag Seite 6 hinzufügen
			// Ausweis oder Geburtsurkunde, falls noch nicht gesendet
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '6',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany']));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18']));
			$objForm->addFormField('antragsteller_ungleich_person', array('inputType' => 'hidden', 'value'  => $data['antragsteller_ungleich_person'],));
			$objForm->addFormField('unter18', array('inputType' => 'hidden', 'value'  => $data['unter18'],));
			$objForm->addFormField('nachname', array('inputType' => 'hidden', 'value'  => $data['nachname']));
			$objForm->addFormField('vorname', array('inputType' => 'hidden', 'value'  => $data['vorname']));
			$objForm->addFormField('titel', array('inputType' => 'hidden', 'value'  => $data['titel']));
			$objForm->addFormField('email', array('inputType' => 'hidden', 'value'  => $data['email']));
			$objForm->addFormField('geburtsdatum', array('inputType' => 'hidden', 'value'  => $data['geburtsdatum']));
			$objForm->addFormField('geschlecht', array('inputType' => 'hidden', 'value'  => $data['geschlecht']));
			$objForm->addFormField('nachname_person', array('inputType' => 'hidden', 'value'  => $data['nachname_person']));
			$objForm->addFormField('vorname_person', array('inputType' => 'hidden', 'value'  => $data['vorname_person']));
			$objForm->addFormField('email_person', array('inputType' => 'hidden', 'value'  => $data['email_person']));
			$objForm->addFormField('turnier', array('inputType' => 'hidden', 'value'  => $data['turnier']));
			$objForm->addFormField('imVerein', array('inputType' => 'hidden', 'value'  => $data['imVerein']));
			$objForm->addFormField('verein', array('inputType' => 'hidden', 'value'  => $data['verein']));
			$objForm->addFormField('antrag_seite6', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite6'], 'class' => '')));
			$objForm->addFormField('ausweis', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['ausweis'], 'inputType' => 'upload', 'eval' => array('mandatory' => true, 'maxlength' => \Config::get('maxFileSize'), 'fSize' => \Config::get('maxFileSize'), 'extensions' => 'jpg,jpeg,gif,png,pdf')));
			$objForm->addFormField('antrag_seite6_ausweis', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite6_ausweis'], 'class' => '')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}
		elseif($data['antrag_seite'] == 6)
		{
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '7',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany']));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18']));
			$objForm->addFormField('antragsteller_ungleich_person', array('inputType' => 'hidden', 'value' => $data['antragsteller_ungleich_person'],));
			$objForm->addFormField('unter18', array('inputType' => 'hidden', 'value'  => $data['unter18'],));
			$objForm->addFormField('nachname', array('inputType' => 'hidden', 'value'  => $data['nachname']));
			$objForm->addFormField('vorname', array('inputType' => 'hidden', 'value'  => $data['vorname']));
			$objForm->addFormField('titel', array('inputType' => 'hidden', 'value'  => $data['titel']));
			$objForm->addFormField('email', array('inputType' => 'hidden', 'value'  => $data['email']));
			$objForm->addFormField('geburtsdatum', array('inputType' => 'hidden', 'value'  => $data['geburtsdatum']));
			$objForm->addFormField('geschlecht', array('inputType' => 'hidden', 'value'  => $data['geschlecht']));
			$objForm->addFormField('nachname_person', array('inputType' => 'hidden', 'value'  => $data['nachname_person']));
			$objForm->addFormField('vorname_person', array('inputType' => 'hidden', 'value'  => $data['vorname_person']));
			$objForm->addFormField('email_person', array('inputType' => 'hidden', 'value'  => $data['email_person']));
			$objForm->addFormField('ausweis', array('inputType' => 'hidden', 'value'  => $data['ausweis']));
			$objForm->addFormField('turnier', array('inputType' => 'hidden', 'value'  => $data['turnier']));
			$objForm->addFormField('imVerein', array('inputType' => 'hidden', 'value'  => $data['imVerein']));
			$objForm->addFormField('verein', array('inputType' => 'hidden', 'value'  => $data['verein']));
			$objForm->addFormField('antrag_seite7', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite7'], 'class' => '')));
			$objForm->addFormField('bemerkungen', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['bemerkungen'], 'inputType' => 'textarea', 'eval' => array('mandatory' => false, 'class'=>'form-control')));
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}
		elseif($data['antrag_seite'] == 7)
		{
			// Zusammenfassung erstellen
			$summary1 = &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary1'];
			$suchen = array('#germany#', '#datenschutz#', '#ueber18#');
			$ersetzen = array('Ja', 'Ja', 'Ja');
			$summary1 = str_replace($suchen, $ersetzen, $summary1);

			$summary2 = &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary2text'];
			$suchen = array('#vorname#', '#nachname#', '#geschlecht#', '#geburtsdatum#', '#email#');
			$ersetzen = array($data['vorname'], $data['nachname'], $data['geschlecht'], $data['geburtsdatum'], $data['email']);
			$summary2 = str_replace($suchen, $ersetzen, $summary2);

			$summary3 = &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary3text'];
			$suchen = array('#vorname#', '#nachname#', '#email#');
			$ersetzen = array($data['vorname_person'], $data['nachname_person'], $data['email_person']);
			$summary3 = str_replace($suchen, $ersetzen, $summary3);

			$summary4 = &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary4text'];
			$ausweis = $data['ausweis'] ? 'Dokument hochgeladen' : '-';
			if($data['imVerein'])
			{
				$suchen = array('#turnier#', '#verein#', '#ausweis#');
				$ersetzen = array($data['turnier'], $data['verein'], $ausweis);
			}
			else
			{
				$suchen = array('#turnier#', '#verein#', '#ausweis#');
				$ersetzen = array($data['turnier'], '-', $ausweis);
			}
			$summary4 = str_replace($suchen, $ersetzen, $summary4);

			$summary5 = &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary5text'];
			$suchen = array('#bemerkungen#');
			$ersetzen = array(\StringUtil::decodeEntities($data['bemerkungen']));
			$summary5 = str_replace($suchen, $ersetzen, $summary5);

			// Formular generieren
			$objForm->addFormField('antrag_seite', array('inputType' => 'hidden', 'value'  => '8',));
			$objForm->addFormField('germany', array('inputType' => 'hidden', 'value'  => $data['germany']));
			$objForm->addFormField('datenschutz', array('inputType' => 'hidden', 'value'  => $data['datenschutz'],));
			$objForm->addFormField('ueber18', array('inputType' => 'hidden', 'value'  => $data['ueber18']));
			$objForm->addFormField('antragsteller_ungleich_person', array('inputType' => 'hidden', 'value' => $data['antragsteller_ungleich_person'],));
			$objForm->addFormField('unter18', array('inputType' => 'hidden', 'value'  => $data['unter18'],));
			$objForm->addFormField('nachname', array('inputType' => 'hidden', 'value'  => $data['nachname']));
			$objForm->addFormField('vorname', array('inputType' => 'hidden', 'value'  => $data['vorname']));
			$objForm->addFormField('titel', array('inputType' => 'hidden', 'value'  => $data['titel']));
			$objForm->addFormField('email', array('inputType' => 'hidden', 'value'  => $data['email']));
			$objForm->addFormField('geburtsdatum', array('inputType' => 'hidden', 'value'  => $data['geburtsdatum']));
			$objForm->addFormField('geschlecht', array('inputType' => 'hidden', 'value'  => $data['geschlecht']));
			$objForm->addFormField('nachname_person', array('inputType' => 'hidden', 'value'  => $data['nachname_person']));
			$objForm->addFormField('vorname_person', array('inputType' => 'hidden', 'value'  => $data['vorname_person']));
			$objForm->addFormField('email_person', array('inputType' => 'hidden', 'value'  => $data['email_person']));
			$objForm->addFormField('ausweis', array('inputType' => 'hidden', 'value'  => $data['ausweis']));
			$objForm->addFormField('turnier', array('inputType' => 'hidden', 'value'  => $data['turnier']));
			$objForm->addFormField('imVerein', array('inputType' => 'hidden', 'value'  => $data['imVerein']));
			$objForm->addFormField('verein', array('inputType' => 'hidden', 'value'  => $data['verein']));
			$objForm->addFormField('bemerkungen', array('inputType' => 'hidden', 'value'  => $data['bemerkungen']));
			$objForm->addFormField('antrag_seite8', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8'], 'class' => '')));
			$objForm->addFormField('antrag_seite8_summary1', array('inputType' => 'explanation', 'eval' => array('text' => $summary1, 'class' => '')));
			if($data['antragsteller_ungleich_person'])
			{
				// Antragsteller und beantragte Person unterschiedlich
				$objForm->addFormField('antrag_seite8_summary2', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary2'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary2text', array('inputType' => 'explanation', 'eval' => array('text' => $summary2, 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary3', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary3'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary3text', array('inputType' => 'explanation', 'eval' => array('text' => $summary3, 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary4', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary4'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary4text', array('inputType' => 'explanation', 'eval' => array('text' => $summary4, 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary5', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary5'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary5text', array('inputType' => 'explanation', 'eval' => array('text' => $summary5, 'class' => '')));
			}
			else
			{
				// Antragsteller und beantragte Person gleich
				$objForm->addFormField('antrag_seite8_summary2', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary2'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary2text', array('inputType' => 'explanation', 'eval' => array('text' => $summary2, 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary4', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary4'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary4text', array('inputType' => 'explanation', 'eval' => array('text' => $summary4, 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary5', array('inputType' => 'explanation', 'eval' => array('text' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite8_summary5'], 'class' => '')));
				$objForm->addFormField('antrag_seite8_summary5text', array('inputType' => 'explanation', 'eval' => array('text' => $summary5, 'class' => '')));
			}
			$objForm->addCaptchaFormField('captcha');
			$objForm->addFormField('submit', array('label' => &$GLOBALS['TL_LANG']['fideid-form']['submit_all'], 'inputType' => 'submit', 'eval' => array('class'=>'btn btn-primary')));
			$objForm->addFormField('reset', array('inputType' => 'explanation',	'eval' => array('text' => '<a href="'.$aktuelleSeite.'?reset_fideidform=1">Formular zurücksetzen</a>', 'class' => '')));
		}

		// Validieren und prüfen, ob das Formular gesendet wurde
		if($objForm->validate())
		{
			// Alle gesendeten und analysierten Daten holen (funktioniert nur mit POST)
			$arrData = $objForm->fetchAll();
			self::FormularSichern($arrData); // Formular in Session sichern
			\Controller::reload();
		}

		// Formular als String zurückgeben
		return $objForm->generate();

	}

	protected function FormularSichern($data)
	{
		global $zufallszahl;

		if($data['antrag_seite'] == 2)
		{
			// Geburtsdatum prüfen, steht im Format TT.MM.JJJJ im Formularfeld
			$alter = \Schachbulle\ContaoHelperBundle\Classes\Alter::Jahre($data['geburtsdatum']);
			if($alter >= 18)
			{
				// Formularseite 3 überspringen
				$data['antrag_seite']++;
				$data['antragsteller_ungleich_person'] = '';
				$data['unter18'] = '';
			}
			else
			{
				// Beantragte Person ist unter 18, deshalb muß der Antragsteller ein anderer sein
				$data['antragsteller_ungleich_person'] = '1';
				$data['unter18'] = '1';
			}
		}
		elseif($data['antrag_seite'] == 3 || $data['antrag_seite'] == 6)
		{
			// Auf Seite 3 bzw. 6 wurde eine Datei hochgeladen
			if($_SESSION['FILES']['ausweis'])
			{
				$uploadordner = \FilesModel::findByUuid($GLOBALS['TL_CONFIG']['fideidverwaltung_uploads']);
				$zieldatei = date('Ymd-hi_').$_SESSION['FILES']['ausweis']['name'];
				$dateipfad = TL_ROOT.'/'.$uploadordner->path.'/'.$zieldatei;
				move_uploaded_file($_SESSION['FILES']['ausweis']['tmp_name'], $dateipfad); // Hochgeladene Datei in Zielordner verschieben
				self::writeDbafs($uploadordner->path, $zieldatei); // Datei in Dateiverwaltung eintragen
				$objFile = \FilesModel::findByPath($dateipfad);
				$data['ausweis'] = $objFile->id;
			}
		}
		elseif($data['antrag_seite'] == 4) // kommt von Abfrage Verein ja/nein
		{
			// Auf Seite 4 die Checkbox imVerein auswerten
			if(!$data['imVerein'])
			{
				// Vereinslos und kein Ausweis vorhanden -> zu Seite 6 (Ausweis-Upload) springen
				$data['antrag_seite']++;
				if($data['ausweis'])
				{
					// Ausweis ist bereits vorhanden -> zu Seite 7 (Ende) springen
					$data['antrag_seite']++;
				}
			}
		}
		elseif($data['antrag_seite'] == 5) // kommt von Abfrage Vereinsname
		{
			if($data['ausweis'])
			{
				// Ausweis bereits vorhanden -> Seite 6 (Ausweis-Upload) überspringen
				$data['antrag_seite']++;
			}
			elseif(!$data['ausweis'] && $data['imVerein'])
			{
				// Ausweis nicht nötig, da Vereinsmitglied -> Seite 6 (Ausweis-Upload) überspringen
				$data['antrag_seite']++;
			}
		}
		
		// Sichert die Formulardaten in der Sitzung
		\Session::getInstance()->set('fideidform', $data);
		$data = \Session::getInstance()->get('fideidform'); // Sessiondaten laden

		log_message('Folgende Formulardaten wurden in der Sitzung gespeichert: '.print_r($data, true), 'fideid.log');
		
		// Formularstand in Datenbank speichern, das REQUEST_TOKEN dient als ID
		$record = \Database::getInstance()->prepare("SELECT * FROM tl_fideid WHERE token=?")
		                                  ->execute(REQUEST_TOKEN);
		if($record->numRows) $id = $record->id;
		else $id = false;

		// Feld ausweis auswerten
		$objFile = \FilesModel::findOneBy('id', $data['ausweis']);

		// Token für E-Mail-Verifizierung erstellen
		if($data['antrag_seite'] == 8) $token = bin2hex(openssl_random_pseudo_bytes(16));
		
		// Datensatz füllen
		$set = array
		(
			'tstamp'                        => time(),
			'token'                         => $data['antrag_seite'] == 8 ? '' : REQUEST_TOKEN, // Beim letzten Speichern token leeren
			'form_completely'               => $data['antrag_seite'] == 8 ? '1' : '', // Beim letzten Speichern Formular komplett
			'form_confirmed'                => '',
			'form_token'                    => $data['antrag_seite'] == 8 ? $token : '', // Beim letzten Speichern E-Mail-Token generieren
			'ueber18'                       => $data['ueber18'] ? '1' : '',
			'status'                        => $data['antrag_seite'] == 8 ? '1' : '0', // Beim letzten Speichern 1 = Unbearbeitet, sonst 0 = Formular nicht übertragen
			'formulardatum'                 => time(),
			'antragsteller_ungleich_person' => $data['antragsteller_ungleich_person'] ? '1' : '',
			'nachname_person'               => $data['nachname_person'] ? $data['nachname_person'] : '',
			'vorname_person'                => $data['vorname_person'] ? $data['vorname_person'] : '',
			'email_person'                  => $data['email_person'] ? $data['email_person'] : '',
			'art'                           => '',
			'nachname'                      => $data['nachname'] ? $data['nachname'] : '',
			'vorname'                       => $data['vorname'] ? $data['vorname'] : '',
			'titel'                         => $data['titel'] ? $data['titel'] : '',
			'geburtsdatum'                  => $data['geburtsdatum'] ? self::DatumToZeitstempel($data['geburtsdatum']) : 0,
			'geschlecht'                    => $data['geschlecht'] ? $data['geschlecht'] : '',
			'email'                         => $data['email'] ? $data['email'] : '',
			'datenschutz'                   => $data['datenschutz'] ? '1' : '',
			'imVerein'                      => $data['imVerein'] ? '1' : '',
			'verein'                        => $data['verein'] ? $data['verein'] : '',
			'unter18'                       => $data['unter18'] ? '1' : '',
			'ausweis'                       => $data['ausweis'] ? $objFile->uuid : '',
			'elterneinverstaendnis'         => $data['elterneinverstaendnis'] ? '1' : '',
			'turnier'                       => $data['turnier'] ? $data['turnier'] : '',
			'germany'                       => $data['germany'] ? '1' : '',
			'bemerkungen'                   => $data['bemerkungen'] ? $data['bemerkungen'] : '',
		);
		log_message('Folgende Daten wurden in tl_fideid gespeichert: '.print_r($set, true), 'fideid.log');
		if($id)
		{
			// Update des Datensatzes
			$objUpdate = \Database::getInstance()->prepare("UPDATE tl_fideid %s WHERE id=?")
			                                     ->set($set)
			                                     ->execute($id);
			//\Controller::createNewVersion('tl_fideid', $id); // funktioniert nur im Backend, siehe Version 1.3.1
		}
		else
		{
			// Neuen Datensatz schreiben
			$objInsert = \Database::getInstance()->prepare("INSERT INTO tl_fideid %s")
			                                     ->set($set)
			                                     ->execute();
		}

		// Formular beenden
		if($data['antrag_seite'] == 8)
		{
			self::Mailversand($data, $token);
			\Session::getInstance()->set('fideidform', false);
			\Controller::reload();
		}
	}
	
	/**
	 * Versendet eine E-Mail mit den eingegebenen Daten und einem Verifizierungslink
	 */
	protected function Mailversand($data, $token)
	{
		$link = self::getVerifizierungsseite($token);
		log_message('Bestätigungslink: '.print_r($link, true), 'fideid.log');
		$text = '<html><head><title></title></head><body>';
		$text .= '<p>Liebe Schachfreundin, lieber Schachfreund,</p>';
		$text .= '<p>wir haben einen Antrag für eine FIDE-Identifikationsnummer von Ihnen erhalten. Sie müssen Ihren Antrag bestätigen, indem Sie <a href="'.$link.'" target="_blank">diesen Link anklicken</a>!</p>';
		$text .= '<p>Die FIDE-Identifikationsnummer wurde beantragt für:</p>';
		$text .= '<ul>';
		$text .= '<li>Vorname: <b>'.$data['vorname'].'</b></li>';
		$text .= '<li>Nachname: <b>'.$data['nachname'].'</b></li>';
		$text .= '<li>Geschlecht: <b>'.$data['geschlecht'].'</b></li>';
		$text .= '<li>Geburtsdatum: <b>'.$data['geburtsdatum'].'</b></li>';
		$text .= '<li>E-Mail: <b>'.$data['email'].'</b></li>';
		$text .= '<li>Turnier/Veranstaltung: <b>'.$data['turnier'].'</b></li>';
		$text .= '<li>Verein: <b>'.($data['imVerein'] ? $data['verein'] : '-').'</b></li>';
		$text .= '<li>Ausweis/Geburtsurkunde: <b>'.($data['ausweis'] ? 'Dokument hochgeladen' : 'nicht erforderlich').'</b></li>';
		$text .= '</ul>';
		if($data['antragsteller_ungleich_person'])
		{
			$text .= '<h3>Angaben zum Antragsteller</h3>';
			$text .= '<ul>';
			$text .= '<li>Vorname: <b>'.$data['vorname_person'].'</b></li>';
			$text .= '<li>Nachname: <b>'.$data['nachname_person'].'</b></li>';
			$text .= '<li>E-Mail: <b>'.$data['email_person'].'</b></li>';
			$text .= '</ul>';
		}
		if($data['bemerkungen'])
		{
			$text .= '<h3>Bemerkungen</h3>';
			$text .= '<p>'.\StringUtil::decodeEntities($data['bemerkungen']).'</p>';
			$text .= '<p><i>Diese E-Mail wurde automatisch erstellt.</i></p></body></html>';
		}
		
		$objEmail = new \Email();
		$objEmail->charset = 'utf-8';
		$objEmail->from = 'fideid@schachbund.de';
		$objEmail->fromName = 'Deutscher Schachbund | FIDE-ID-Antrag';
		$objEmail->subject = 'FIDE-ID-Antrag für '.$data['vorname'].' '.$data['nachname'];
		$objEmail->html = $text;
		$objEmail->sendCc('fideid@schachbund.de');
		$objEmail->sendBcc('Frank Hoppe <webmaster@schachbund.de>');
		$objEmail->sendTo($data['email']);
	}

	/**
	 * Gibt die URL zur Bestätigungsseite zurück
	 */
	public function getVerifizierungsseite($token)
	{
		if($GLOBALS['TL_CONFIG']['fideidverwaltung_bestaetigungsseite'])
		{
			$pageModel = \PageModel::findByPK($GLOBALS['TL_CONFIG']['fideidverwaltung_bestaetigungsseite']);
		
			if($pageModel)
			{
				$url = \Environment::get('url').'/'.\Controller::generateFrontendUrl($pageModel->row()).'?token='.$token;
				return $url;
			}
		}
		return '';

	}

	/**
	 * Wandelt ein Datum TT.MM.JJJJ in einen Unix-Zeitstempel um
	 */
	protected function DatumToZeitstempel($string)
	{
		$tag = substr($string, 0, 2);
		$monat = substr($string, 3, 2);
		$jahr = substr($string, 6, 4);
		return mktime(0, 0, 0, $monat, $tag, $jahr);
	}

	/**
	 * Generiert den Datensatz in tl_files
	 * (copied from FormFileUpload.php)
	 *   
	 * @param string $strUploadFolder  ohne Prefix TL_ROOT/, ohne Suffix /
	 * @param string $filename
	 */
	protected function writeDbafs($strUploadFolder, $filename)
	{
		// Generate the DB entries
		$strFile = $strUploadFolder . '/' . $filename;
		$objFile = \FilesModel::findByPath($strFile);
		
		// Existing file is being replaced (see contao/core#4818)
		if ($objFile !== null)
		{
			$objFile->tstamp = time();
			$objFile->path   = $strFile;
			$objFile->hash   = md5_file(TL_ROOT . '/' . $strFile);
			$objFile->save();
		}
		else
		{
			\Dbafs::addResource($strFile);
		}
		
		// Update the hash of the target folder
		\Dbafs::updateFolderHashes($strUploadFolder);
		
	}

}
