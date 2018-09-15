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

use Contao\Model\Collection;
use Contao\ModuleNewsList;

class NewsListener
{
    /**
     * @var \Codefog\NewsCategoriesBundle\EventListener\NewsListener
     */
    private $objCodefogListener;

    /**
     * Construct the object
     * 
     * @param \Codefog\NewsCategoriesBundle\EventListener\NewsListener $listener
     */
    public function __construct($listener)
    {
        $this->objCodefogListener = $listener;
    }


    /**
     * On news list count items
     * 
     * @param array              $archives
     * @param bool|null          $featured
     * @param ModuleNewsList     $module
     * 
     * @return Collection|null
     */
    public function onNewsListCountItems($archives, $featured, ModuleNewsList $module)
    {
        // Consider pre-filtered results from Codefog bundle
        $res = $this->objCodefogListener->onNewsListCountItems($archives, $featured, $module);
        
        if ($res == 0)
        {
            return 0;
        }

        return count($this->onNewsListFetchItems($archives, $featured, 0, 0, $module));
    }

    /**
     * On news list fetch items
     * 
     * @param array             $archives
     * @param bool|null         $featured
     * @param int               $limit
     * @param int               $offset
     * @param ModuleNewsList    $module
     *
     * @return Collection|null
     */
    public function onNewsListFetchItems(array $archives, $featured, $limit, $offset, ModuleNewsList $module)
    {
        if ($module->news_filterDate != 0)
        {
            // Only consider tag-filtered result from Codefog bundle
            $res = $this->objCodefogListener->onNewsListFetchItems($archives, $featured, $limit, $offset, $module);
            $arrModels = $res->getModels();

            $currTime = new \DateTime();
            $currTime->setTimestamp(time());

            foreach ($arrModels as $objModel)
            {
                $newsTime = new \DateTime();
                $newsTime->setTimestamp($objModel->row()['time']); 

                $diff = $newsTime->diff($currTime);

                if ($diff->days <= $module->news_filterDate)
                {
                    $arrModelsRes[] = $objModel; 
                }
            }

            if ($arrModelsRes != null)
            {
                return new Collection($arrModelsRes, 'tl_news');
            }
            return null;
        }

        return false;
    }
}