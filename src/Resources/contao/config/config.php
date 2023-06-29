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
	'tables'         => array('tl_fideid', 'tl_fideid_templates'),
	'icon'           => 'bundles/contaofideid/images/icon.png',
);

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['storeFormData'][] = array('Schachbulle\ContaoFideidBundle\Classes\SaveAusweis', 'storeFormData');
$GLOBALS['TL_HOOKS']['prepareFormData'][] = array('Schachbulle\ContaoFideidBundle\Classes\CopyEmail', 'prepareFormData');
