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
 * Table tl_news_category
 */

 $GLOBALS['TL_DCA']['tl_news_category']['palettes']['default'] = str_replace('{redirect_legend:hide}','{wbgym_legend},wb_isReportTag;{redirect_legend:hide}',$GLOBALS['TL_DCA']['tl_news_category']['palettes']['default']);

 $GLOBALS['TL_DCA']['tl_news_category']['fields']['wb_isReportTag'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news_category']['wb_isReportTag'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50','unique' => true),
    'sql'                     => ['type' => 'string', 'length' => 1, 'default' => ''],
 );