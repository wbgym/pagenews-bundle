<?php

/**
 * WBGym
 *
 * Copyright (C) 2008-2013 Webteam Weinberg-Gymnasium Kleinmachnow
 *
 * @package 	WGBym
 * @author 		Marvin Ritter <marvin.ritter@gmail.com>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/*
* HOOKS
*/
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('WBGym\WBNews','parseTaggedArticles');

?>
