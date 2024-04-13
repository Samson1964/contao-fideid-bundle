<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   Linkscollection
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2016 - 2017
 */
namespace Schachbulle\ContaoFideidBundle\Modules;

class FormConfirm extends \Module
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

			$objTemplate->wildcard = '### FIDE-ID-ANTRAGSVERIFIKATION ###';
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
		// Token in URL vorhanden?
		if(\Input::get('token'))
		{
			// Links laden
			$objToken = \Database::getInstance()->prepare('SELECT * FROM tl_fideid WHERE form_token = ?')
			                                    ->execute(\Input::get('token'));

			if($objToken->numRows)
			{
				if($objToken->form_confirmed)
				{
					$content = 'Der Antrag wurde bereits bestätigt.';
				}
				else
				{
					// Version speichern
					//$objVersions = new \Versions('tl_fideid', $objToken->id);
					//log_message($objToken->id,'log_fideid.log');
					//$objVersions->create();
					// Datensatz updaten
					$set = array
					(
						'form_confirmed'      => true,
						'tstamp'              => time(),
					);
					$objUpdate = \Database::getInstance()->prepare('UPDATE tl_fideid %s WHERE form_token = ?')
					                                     ->set($set)
					                                     ->execute(\Input::get('token'));
					$content = 'Der Antrag wurde bestätigt.';
				}
			}
			else
			{
				$content = 'Das Token wurde nicht gefunden.';
			}
		}
		else
		{
			$content = 'Das Token fehlt.';
		}

		// Template füllen
		$this->Template->content = $content;

	}

}
