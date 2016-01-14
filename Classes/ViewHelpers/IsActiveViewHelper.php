<?php
namespace BERGWERK\BwrkFluidmenu\ViewHelpers;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class IsActiveViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * @param int $number
     * @param array $array
     * @return string
     */
    public function render($number, $array)
    {
        if(in_array($number, $array))
        {
            return 'active';
        }
        return '';
    }
}