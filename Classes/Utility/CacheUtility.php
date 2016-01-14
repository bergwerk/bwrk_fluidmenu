<?php
namespace BERGWERK\BwrkFluidmenu\Utility;

/* * *************************************************************
*
*  Copyright notice
*
*  (c) 2014
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
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
* ************************************************************* */

class CacheUtility extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /*
    Alle möglichen Dinge, die ich an pi-Base geliebt habe...
    Jochen, Sören, Martin: Kann das mal einer sauber machen? ;)
    */

    /**
     * _configurationManager
     *
     * @var mixed
     * @access protected
     */
    protected $_configurationManager;

    /**
     * _extkey
     *
     * @var mixed
     * @access protected
     */
    protected $_extkey;

    /**
     * _request
     *
     * @var mixed
     * @access protected
     */
    protected $_request;

    /**
     * _cObj
     *
     * @var mixed
     * @access protected
     */
    protected $_cObj;

    /**
     * _settings
     *
     * @var mixed
     * @access protected
     */
    protected $_settings;

    /**
     * _configuration
     *
     * @var mixed
     * @access protected
     */
    protected $_configuration;




    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->_extKey = 'bwrk_markermap';
        $this->_configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $this->_request = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Mvc\\Request');
        $this->_cObj = $this->_configurationManager->getContentObject();
        $this->_configuration = $this->_configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $this->_settings = $this->_configuration['settings'];
        $this->_gpVars = $this->_request->getArguments();
    }



    /**
     * getCache function.
     *
     * @access public
     * @param mixed $hashVars (default: null)
     * @return void
     */
    public function getCache ( $hashVars = null )
    {
        $cacheID = $this->getCacheID(array($hashVars));
        $data = \TYPO3\CMS\Frontend\Page\PageRepository::getHash($cacheID);
        return !$data ? false : unserialize($data);
    }


    /**
     * setCache function.
     *
     * @access public
     * @param mixed $data (default: null)
     * @param mixed $hashVars (default: null)
     * @return void
     */
    public function setCache ( $data = null, $hashVars = null )
    {
        $lifetime = mktime(23,59,59) + 1 - time();
        $cacheID = $this->getCacheID(array($hashVars));

        \TYPO3\CMS\Frontend\Page\PageRepository::storeHash( $cacheID, serialize($data), $this->extKey.'_cache', $lifetime );
        return $data;
    }


    /**
     * getCacheID function.
     *
     * @access private
     * @param mixed $hashVars (default: null)
     * @return void
     */
    private function getCacheID ( $hashVars = null )
    {
        $additionalHashVars = array(
            // Auf Seiten-ID beschränken
            'pid'       => $GLOBALS['TSFE']->id,
            // Auf Sprache beschränken
            'lang'      => $GLOBALS['TSFE']->sys_language_uid,
            // Auf UID dieses Content-Elementes (PlugIns) beschränken
            'uid'       => $this->_cObj->data['uid']
        );

        // Vielleicht noch alle Get/Post-Variablen berücksichtigen?
        $additionalHashVars = array_merge($additionalHashVars, $this->_gpVars);

        // Und dann noch die übergebenen Variablen?
        $hashVars = array_merge($additionalHashVars, $hashVars);

        // Einen String aus allem generieren
        $hashString = join('|',array_values($hashVars)).join('|', array_keys($hashVars));

        // ... und als kurzen, unique md5 zurückgeben
        return md5($hashString);
    }

}