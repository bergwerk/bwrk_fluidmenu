<?php

namespace BERGWERK\BwrkFluidmenu;

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

use TYPO3\CMS\Core\Configuration\ConfigurationManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class TyposcriptConfiguration
 * @package BERGWERK\BwrkFluidmenu
 */
class TyposcriptConfiguration
{
	//<editor-fold desc=". Private Region .">
	/**
	 * @var array
     */
	private static $_cache = array();

	/**
	 * @param $key
	 * @return mixed
     */
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

	/**
	 * @param null $key
	 * @return mixed
     */
	public static function getExtensionConfiguration($key = null)
	{
		$extensionSetup = 'plugin.tx_bwrkfluidmenu.settings.';
		$newKey = $extensionSetup . $key;

		return self::getConfiguration($newKey);
	}

	/**
	 * @param $data
	 * @param $keys
	 * @return array|null
     */
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

	/**
	 * @param $configuration
	 * @return array
     */
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

	/**
	 * @return int
     */
	public static function getRootPageId()
	{
		return (int) self::getExtensionConfiguration('rootPageId');
	}
}