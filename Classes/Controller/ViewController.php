<?php

namespace BERGWERK\BwrkFluidmenu\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Georg Dümmler <gd@bergwerk.ag>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 *
 * @author	Georg Dümmler <gd@bergwerk.ag>
 * @package	TYPO3
 * @subpackage	bwrk_fluidmenu
 ***************************************************************/

use BERGWERK\BwrkFluidmenu\Domain\Model\Page;
use BERGWERK\BwrkUtility\Utility\CacheUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class ViewController
 * @package BERGWERK\BwrkFluidmenu\Controller
 */
class ViewController extends ActionController
{
    /**
     * @var int
     */
    protected $rootPageId = 0;

    /**
     * @var \BERGWERK\BwrkUtility\Utility\CacheUtility
     */
    protected $cacheUtility;

    /**
     * @var \BERGWERK\BwrkFluidmenu\Domain\Repository\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * @var string
     */
    protected $pagesToExclude = '';

    /**
     * @var int
     */
    protected $pid = 0;

    /**
     * @var string
     */
    protected $menuType = '';

    /**
     * @var int
     */
    protected $entryLevel = 0;

    /**
     * @var int
     */
    protected $showLevels = 0;

    /**
     * Initialize Actions
     */
    protected function initializeAction()
    {
        parent::initializeAction();

        $this->cacheUtility = new CacheUtility('bwrk_fluidmenu');

        $this->pid = $GLOBALS['TSFE']->id;
        $this->menuType = isset($this->settings['menuType']) ? $this->settings['menuType'] : 'Default';

        $this->showLevels = isset($this->settings['showLevels']) && !empty($this->settings['showLevels']) ? $this->settings['showLevels'] : 50;
        $this->entryLevel = $this->settings['entryLevel'];
        $this->pagesToExclude = $this->settings['pagesToExclude'];
        $this->rootPageId = $this->getRecursiveRootpageId($this->pid);
    }


    /**
     * @return string|void
     */
    public function indexAction()
    {
        $cacheIdentifier = $this->getCacheIdentifier();
        $this->cacheUtility->setCacheIdentifier($cacheIdentifier);

        $html = $this->cacheUtility->getCache();
        if(!$html)
        {
            $activePages = $this->getActivePages();
            $rootPageId = $this->getRootPageIdWithEntryLevel();

            $this->view->assignMultiple(
                array(
                    'pId' => $rootPageId,
                    'layer' => 0,
                    'menuType' => $this->menuType,
                    'activePages' => $activePages,
                    'showLevels' => ($this->showLevels - 1)
                )
            );

            $html = $this->view->render();

            $this->cacheUtility->setCache($html);
        }

        return $html;
    }

    /**
     * @return array
     */
    private function getActivePages()
    {
        $array = array();
        $pagesToExcludeArray = array_map('trim', explode(',', $this->pagesToExclude));
        foreach($GLOBALS['TSFE']->rootLine as $page)
        {
            $pageUid = $page['uid'];
            if(!in_array($pageUid, $pagesToExcludeArray))
            {
                $array[] = $page['uid'];
            }
        }

        return $array;
    }

    /**
     * @return int
     */
    private function getRootPageIdWithEntryLevel()
    {
        if(!empty($this->entryLevel))
        {
            $activePages = array_reverse($this->getActivePages());
            return $activePages[$this->entryLevel];
        }
        return $this->rootPageId;
    }

    /**
     * @return string
     */
    private function getCacheIdentifier()
    {
        $cacheIdentifier = $this->actionMethodName.$this->menuType.$this->pid;

        if(!is_null($GLOBALS['TSFE']->fe_user->user))
        {
            $cacheIdentifier.= $GLOBALS['TSFE']->fe_user->user['ses_id'];
        }
        return $cacheIdentifier;
    }

    /**
     * @param $uid
     * @return int
     */
    private function getRecursiveRootpageId($uid)
    {
        /** @var Page $page */
        $page = $this->pageRepository->findByUid($uid);

        if($page) {
            if($page->getPid() == 0) return $page->getUid();

            if($page->getIsSiteroot() == 0) return $this->getRecursiveRootpageId($page->getPid());
        }
        return $page->getUid();
    }
}