<?php

namespace BERGWERK\BwrkFluidmenu;

use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TyposcriptConfiguration
{
	//<editor-fold desc=". Private Region .">
	private static $_cache = array();

	private static function getConfiguration($key)
	{
		if (!isset(self::$_cache[$key]))
		{
			/* @var $objectManager ObjectManager */
			$objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

			/* @var $configurationManager ConfigurationManager */
			$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');

			$setup = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

			$arrayKey = explode('.', $key);

			self::$_cache[$key] = self::getConfigurationSub($setup, $arrayKey);
		}

		return self::$_cache[$key];
	}

	public static function getExtensionConfiguration($key = null)
	{
		$extensionSetup = 'plugin.tx_bwrkfluidmenu.settings.';
		$newKey = $extensionSetup . $key;

		return self::getConfiguration($newKey);
	}

	private static function getConfigurationSub($data, $keys)
	{
		// Get Next Key
		$currentKey = array_shift($keys);

		// If More Keys are present, add "dot"
		if (count($keys) > 0)
		{
			$currentKey .= '.';
		}

		$currentData = null;

		if (isset($data[$currentKey]))
		{
			$currentData = $data[$currentKey];
		}
		else if (isset($data[$currentKey . '.']))
		{
			$currentData = $data[$currentKey . '.'];
		}

		// If No Data is set, return nothing
		if (empty($currentData))
		{
			return null;
		}

		// If no more keys are present, return the value
		if (count($keys) == 0)
		{
			return self::cleanConfiguration($currentData);
		}

		// Check next level
		return self::getConfigurationSub($currentData, $keys);
	}

	private static function cleanConfiguration($configuration)
	{
		if (!is_array($configuration))
		{
			return $configuration;
		}

		$cleanLevel = array();

		foreach ($configuration as $key => $value)
		{
			$newKey = str_replace('.', '', $key);

			$newValue = self::cleanConfiguration($value);

			$cleanLevel[$newKey] = $newValue;
		}

		return $cleanLevel;
	}
	//</editor-fold>

	/**
	 * @return array
	 */
	public static function getPagesToExclude()
	{
		$pagesToExclude = explode(',', self::getExtensionConfiguration('pagesToExclude'));

		$clean = array();

		foreach ($pagesToExclude as $pId)
		{
			$pId = trim($pId);

			if (!empty($pId))
			{
				$clean[] = (int) $pId;
			}
		}

		return $clean;
	}

	public static function getRootPageId()
	{
		return (int) self::getExtensionConfiguration('rootPageId');
	}
}