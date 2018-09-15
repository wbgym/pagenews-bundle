<?php

/**
 * WBGym
 * 
 * Copyright (C) 2017 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package 	WGBym
 * @author 		Johannes Cram <johannes@jonesmedia.de>
 * @license 	http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Table tl_module
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace('numberOfItems,','numberOfItems,news_filterDate,',$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace('{template_legend:hide}','{wbgym_legend},wb_tagNewsPage;{template_legend:hide}',$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']);
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader'] = str_replace('{template_legend:hide}','{wbgym_legend},wb_tagNewsPage;{template_legend:hide}',$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']);

$GLOBALS['TL_DCA']['tl_module']['fields']['news_filterDate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['news_filterDate'],
	'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp' => 'digit', 'tl_class' => 'w50'),
    'sql'                     => ['type' => 'integer', 'length' => 50, 'default' => 0, 'unsigned' => true]
);

$GLOBALS['TL_DCA']['tl_module']['fields']['wb_tagNewsPage'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['wb_tagNewsPage'],
	'exclude'                 => true,
    'inputType'               => 'pageTree',
    'foreignKey'              => 'tl_page.title',
    'eval'                    => array('mandatory' => true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
    'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),
    'sql'                     => ['type' => 'integer', 'length' => 10, 'default' => 0, 'unsigned' => true]
);
