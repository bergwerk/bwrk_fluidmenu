<?php
namespace BERGWERK\BwrkFluidmenu\ViewHelpers;

class IncrementViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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
     * @param int $number
     * @param string $as
     * @param int $step
     * @return int
     */
    public function render($number, $as, $step = 1)
    {
        $incrementValue = $number + $step;

        $this->renderingContext->getTemplateVariableContainer()->add($as, $incrementValue);

        $html = $this->renderChildren();

        $this->renderingContext->getTemplateVariableContainer()->remove($as);

        return $html;
    }
}