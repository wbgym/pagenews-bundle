<?php
/**
 * WBGym
 * 
 * Copyright (C) 2018 Webteam Weinberg-Gymnasium Kleinmachnow
 * 
 * @package   	WGBym
 * @author     	Johannes Cram <johannes@jonesmedia.de>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Wbgym\PageNewsBundle\EventListener;

use Codefog\NewsCategoriesBundle\Model\NewsCategoryModel;
use Wbgym\PageNewsBundle\Teaser;

class TemplateListener
{
    /**
     * Add tag title and tag alias to news list template.
     * 
     * @param Template $template
     * @return void
     */
    public function onParseTemplate($template)
    {
        if ($template->news_filterDefault != null)
        {
            $tagId = unserialize($template->news_filterDefault)[0];
            
            $objModel = NewsCategoryModel::findById($tagId);
            $template->tagTitle = $objModel->getTitle();
            $template->tagAlias = $objModel->alias;
        }
    }

    /**
     * Add a teaser to the news template if no teaser is set.
     * Additionally add a cut-of teaser with max. 200 chars to template.
     * 
     * @param Template  $objTemplate
     * @param array     $arrRow
     * @param Module    $arrModule
     * 
     * @return void
     */
    public function onParseArticles($objTemplate, $arrRow, $objModule) 
    {
        if (!$objTemplate->teaser)
        {
            // Generate teaser part
            $objTemplate->teaser = Teaser::generateTeaser($objTemplate->text);

            // Remove teaser part from full text for consistency
            $objTemplate->text = str_replace($objTemplate->teaser, '', $objTemplate->text);
        }
        
        // Generate cutTeaser
        $objTemplate->cutTeaser = Teaser::generateCutTeaser($objTemplate->teaser);
    }


}