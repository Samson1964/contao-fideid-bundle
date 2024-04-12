<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   bdf
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2014
 */

/**
 * Backend-Module der FIDE-ID-Verwaltung in das Backend-Menü "Inhalte" einfügen
 */
$GLOBALS['BE_MOD']['content']['fideid'] = array
(
	'tables'            => array('tl_fideid', 'tl_fideid_templates', 'tl_fideid_mails'),
	'icon'              => 'bundles/contaofideid/images/icon.png',
	'send'              => array('Schachbulle\ContaoFideidBundle\Classes\Mailer', 'send'), 
	'getMailbuttons'    => array('Schachbulle\ContaoFideidBundle\Classes\Speedmailer', 'send'),
);

/**
 * Frontend-Module
 */
$GLOBALS['FE_MOD']['application']['fideid_form'] = 'Schachbulle\ContaoFideidBundle\Modules\Form';
$GLOBALS['FE_MOD']['application']['fideid_confirm'] = 'Schachbulle\ContaoFideidBundle\Modules\FormConfirm';

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['storeFormData'][] = array('Schachbulle\ContaoFideidBundle\Classes\SaveAusweis', 'storeFormData');
$GLOBALS['TL_HOOKS']['prepareFormData'][] = array('Schachbulle\ContaoFideidBundle\Classes\CopyEmail', 'prepareFormData');
$GLOBALS['TL_HOOKS']['prepareFormData'][] = array('Schachbulle\ContaoFideidBundle\Classes\FormToken', 'prepareFormData');
