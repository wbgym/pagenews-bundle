<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */

/**
 * Wbgym/PageNewsBundle
 *
 * @author Webteam WBGym <webteam@wbgym.de>
 * @package WbgymPageNewsBundle 
 * @license LGPL-3.0+
 */

namespace Wbgym\PageNewsBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\NewsBundle\ContaoNewsBundle;
use Codefog\NewsCategoriesBundle\CodefogNewsCategoriesBundle;
use Wbgym\PageNewsBundle\WbgymPageNewsBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(WbgymPageNewsBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                    ContaoNewsBundle::class,
                    CodefogNewsCategoriesBundle::class
                ])
        ];
    }
}