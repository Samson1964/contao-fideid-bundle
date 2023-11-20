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

class FormToken extends \Backend
{

	public function prepareFormData(&$arrSubmitted, $arrLabels, $objForm)
	{
		//log_message(print_r($arrSubmitted,true),'log_fideid.log');
		// Wenn Feld formulardatum vorhanden ist, kann ein Token gesetzt werden
		if(isset($arrSubmitted['formulardatum']))
		{
			$arrSubmitted['form_token'] = bin2hex(openssl_random_pseudo_bytes(16));
			$arrSubmitted['form_confirmed'] = '';
		}
		//log_message(print_r($arrSubmitted,true),'log_fideid.log');
		//log_message(print_r($objForm,true),'log_fideid.log');
	}
}
