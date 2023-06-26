<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2023 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Schachbulle\ContaoFideidBundle\Classes;

class SaveAusweis extends \Controller
{

	/**
	 * Searches through the DCA and converts a file path to an UUID
	 * if the DCA field is a single fileTree input
	 */
	public function storeFormData($arrSet, \Form $objForm)
	{
		log_message('Vor storeFormData:','ausweis.log');
		log_message(print_r($arrSet,true),'ausweis.log');

		// Evtl. Hochgeladene Datei als UUID speichern
		if($arrSet['ausweis'] && substr($arrSet['ausweis'], 0, 6) == 'files/')
		{
			// Uploadfeld ausweis gefunden, UUID ermitteln und eintragen
			$objFile = \Dbafs::addResource($arrSet['ausweis']);
			$arrSet['ausweis'] = $objFile->uuid;
		}

		// Wenn Auftraggeber-E-Mail nicht vorhanden ist, muß diese auf Antragsteller-E-Mail geändert werden
		if(!isset($arrSet['email_person'])) $arrSet['email_person'] = $arrSet['email'];

		log_message('Nach storeFormData:','ausweis.log');
		log_message(print_r($arrSet,true),'ausweis.log');

		// Daten zurückgeben
		return $arrSet;
	}
}
