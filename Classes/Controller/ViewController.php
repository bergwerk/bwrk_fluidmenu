<?php

namespace BERGWERK\BwrkFluidmenu\Controller;

use BERGWERK\BwrkFluidmenu\TyposcriptConfiguration;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ViewController extends ActionController
{
    /**
     * @var int
     */
    protected $rootPageId = 0;

    /**
     * @var \BERGWERK\BwrkFluidmenu\Utility\CacheUtility
     * @inject
     */
    protected $cacheUtility;

    /**
     * @var string
     */
    protected $pagesToExclude = '';

    /**
     * @var int
     */
    protected $pid = 0;

    /**
     * @var int
     */
    protected $entryLevel = 0;

    /**
     * @return string|void
     */
    public function indexAction()
    {
        $menuType = isset($this->settings['menuType']) ? $this->settings['menuType'] : 'Default';
        $this->pid = $GLOBALS['TSFE']->id;

        $cacheIdentifier = $this->actionMethodName.$menuType.$this->pid;

        if(!is_null($GLOBALS['TSFE']->fe_user->user))
        {
            $cacheIdentifier.= $GLOBALS['TSFE']->fe_user->user['ses_id'];
        }

        $html = $this->cacheUtility->getCache($cacheIdentifier);
        if(!$html)
        {
            $this->entryLevel = $this->settings['entryLevel'];
            $this->rootPageId = $this->settings['rootPageId'];


            $activePages = $this->getActivePages();
            $rootPageId = $this->getRootPageId();

            $this->view->assignMultiple(
                array(
                    'pId' => $rootPageId,
                    'layer' => 0,
                    'menuType' => $menuType,
                    'activePages' => $activePages
                )
            );

            $html = $this->view->render();

            $this->cacheUtility->setCache($html, $cacheIdentifier);
        }

        return $html;
    }

    private function getActivePages()
    {
        $array = array();
        foreach($GLOBALS['TSFE']->rootLine as $page)
        {
            $array[] = $page['uid'];
        }
        return $array;
    }

    private function getRootPageId()
    {
        if(!empty($this->entryLevel))
        {
            $activePages = array_reverse($this->getActivePages());
            return $activePages[$this->entryLevel];
        }
        return $this->rootPageId;
    }
}