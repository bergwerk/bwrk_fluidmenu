<?php
namespace BERGWERK\BwrkFluidmenu\ViewHelpers\Page;

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
use BERGWERK\BwrkFluidmenu\Domain\Repository\PageRepository;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class MenuViewHelper
 * @package BERGWERK\BwrkFluidmenu\ViewHelpers\Page
 */
class MenuViewHelper extends AbstractViewHelper {

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $cObj;

    /**
     * @param int $pId
     * @param string $pagesToExclude
     * @return string
     */
    public function render($pId, $pagesToExclude)
    {
        $pagesToExclude = array_map('trim', explode(',', $pagesToExclude));
        $pagesToReturn = array();
        /** @var Page[] $pages */
        $pages = PageRepository::create()->findPagesByPid($pId);
        foreach($pages as $page)
        {
            if(!in_array($page->getUid(), $pagesToExclude))
            {
                $pagesToReturn[] = $page;
            }
        }
        return $pagesToReturn;
    }
}