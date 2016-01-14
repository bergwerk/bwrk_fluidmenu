<?php

namespace BERGWERK\BwrkFluidmenu\Domain\Model;

use BERGWERK\BwrkFluidmenu\Domain\Repository\PageRepository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var int
     */
    protected $pid = 0;

    protected $subPages;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }



    public function getHasSubpages()
    {
        $this->getSubpages();

        return count($this->subPages) > 0;
    }

    public function getSubpages()
    {
        if (is_null($this->subPages))
        {
            $this->subPages = PageRepository::create()->findPagesByPid($this->getUid());
        }

        return $this->subPages;
    }
}