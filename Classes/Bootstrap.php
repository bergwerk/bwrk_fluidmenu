<?php
namespace BERGWERK\BwrkFluidmenu;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\ViewHelpers\TranslateViewHelper;

class Bootstrap
{
	/**
	 * @return \TYPO3\CMS\Extbase\Object\ObjectManager
	 */
	static public function getObjectManager()
	{
		return GeneralUtility::makeInstance(
			'TYPO3\\CMS\\Extbase\\Object\\ObjectManager'
		);
	}
}