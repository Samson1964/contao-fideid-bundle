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

class CopyEmail extends \Backend
{

	public function prepareFormData(&$arrSubmitted, $arrLabels, $objForm)
	{
		// Wenn Auftraggeber-E-Mail nicht vorhanden ist, muß diese auf Antragsteller-E-Mail geändert werden
		if(!isset($arrSubmitted['email_person'])) $arrSubmitted['email_person'] = $arrSubmitted['email'];
	}
}
