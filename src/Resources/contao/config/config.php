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
	'tables'         => array('tl_fideid'),
	'icon'           => 'bundles/contaofideid/images/icon.png',
);
