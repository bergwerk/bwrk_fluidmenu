<?php

namespace BERGWERK\BwrkFluidmenu\Domain\Model;

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

use BERGWERK\BwrkFluidmenu\Domain\Repository\PageRepository;

/**
 * Class Page
 * @package BERGWERK\BwrkFluidmenu\Domain\Model
 */
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

    /**
     * @var Page[]
     */
    protected $subPages;

    /**
     * @var int
     */
    protected $isSiteroot = 0;

    /**
     * @var string
     */
    protected $target = '';

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


    /**
     * @return bool
     */
    public function getHasSubpages()
    {
        $this->getSubpages();

        return count($this->subPages) > 0;
    }

    /**
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getSubpages()
    {
        if (is_null($this->subPages))
        {
            $this->subPages = PageRepository::create()->findPagesByPid($this->getUid());
        }

        return $this->subPages;
    }

    /**
     * @return int
     */
    public function getIsSiteroot()
    {
        return $this->isSiteroot;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }
}