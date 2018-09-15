<?php

/**
 * WBGym
 *
 * Copyright (C) 2008-2018 Webteam Weinberg-Gymnasium Kleinmachnow
 *
 * @package 	WGBym
 * @author 		Marvin Ritter <marvin.ritter@gmail.com>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/*
* HOOKS
*/

// Insert Hooks at beginning to make sure they are acutally executed
$GLOBALS['TL_HOOKS']['newsListFetchItems'] = array_merge(array(array('wbgym_pagenews.listener.news', 'onNewsListFetchItems')), $GLOBALS['TL_HOOKS']['newsListFetchItems']);
$GLOBALS['TL_HOOKS']['newsListCountItems'] = array_merge(array(array('wbgym_pagenews.listener.news', 'onNewsListCountItems')), $GLOBALS['TL_HOOKS']['newsListCountItems']);
$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('wbgym_pagenews.listener.template', 'onParseTemplate');
$GLOBALS['TL_HOOKS']['parseArticles'][] = array('wbgym_pagenews.listener.template', 'onParseArticles');

?>
