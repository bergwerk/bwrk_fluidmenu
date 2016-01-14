<?php
namespace BERGWERK\BwrkFluidmenu\ViewHelpers\Page;

use BERGWERK\BwrkFluidmenu\Domain\Repository\PageRepository;

class MenuViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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
     * @return string
     */
    public function render($pId)
    {
        return PageRepository::create()->findPagesByPid($pId);
    }
}