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

class MultiForm extends \Module
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

		// Template füllen
		$content = self::Formular();
		$this->Template->content = $content;
	}

	protected function Formular()
	{

		// Frontend-CSS einbinden
		$GLOBALS['TL_CSS'][] = 'bundles/contaofideid/css/frontend.css';

		$form = new \Schachbulle\ContaoHelperBundle\Classes\Form();
		$seite = \Input::post('seite');

		if(!isset($seite))
		{
			// Keine Formulardaten vorhanden, also Grundformular laden
			// Felder für Antrag Seite 1 hinzufügen
			$form->addField(array('typ' => 'hidden', 'name' => 'FORM_SUBMIT', 'value' => 'form_internetschach'));
			$form->addField(array('typ' => 'hidden', 'name' => 'REQUEST_TOKEN', 'value' => REQUEST_TOKEN));
			$form->addField(array('typ' => 'hidden', 'name' => 'seite', 'value' => '1'));
			$form->addField(array('typ' => 'explanation', 'label' => &$GLOBALS['TL_LANG']['fideid-form']['antrag_seite1']));
			$form->addField(array('typ' => 'explanation', 'label' => &$GLOBALS['TL_LANG']['fideid-form']['germany'][1]));
			$form->addField(array('typ' => 'checkbox', 'name' => 'germany', 'label' => &$GLOBALS['TL_LANG']['fideid-form']['germany'][0]));
			$form->addField(array('typ' => 'explanation', 'label' => &$GLOBALS['TL_LANG']['fideid-form']['datenweitergabe'][1]));
			$form->addField(array('typ' => 'checkbox', 'name' => 'datenweitergabe', 'label' => &$GLOBALS['TL_LANG']['fideid-form']['datenweitergabe'][0]));
			$form->addField(array('typ' => 'submit', 'name' => 'submit_weiter', 'value' => '1', 'label' => &$GLOBALS['TL_LANG']['fideid-form']['submit_seite2']));
		}
		elseif($seite == '1')
		{
			echo '<pre>';
			print_r($_POST);
			echo '</pre>';
		}
		return $form->generate();
	}

}
