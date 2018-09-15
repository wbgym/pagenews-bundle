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
     * Add teaser to the news template.
     * 
     * @param Template  $objTemplate
     * @param array     $arrRow
     * @param Module    $arrModule
     * 
     * @return void
     */
    public function onParseArticles($objTemplate, $arrRow, $objModule) 
    {
        if ($objTemplate->teaser)
        {
            $strNews = $objTemplate->teaser;
        }
        else 
        {
            $strNews = $objTemplate->text;
        }

        $objTemplate->wbTeaser = $this->generateTeaser($strNews, 200);
    }

    /**
     * Generate one-line Teaser from News markup
     * without any HTML markup (line breaks, etc.)
     * 
     * @param string    $strNews
     * @param int       $length     maximum length of chars (hard break)
     * @return string
     */
    private function generateTeaser($strNews, $length)
    {
        $startPos = strpos($strNews, '<p>');
        $strNews = substr($strNews, $startPos);
        $strStripped = strip_tags($strNews);
        
        return substr($strStripped, 0, $length);
    }
}