<?php

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
 * @author    Georg Dümmler <gd@bergwerk.ag>
 * @package    TYPO3
 * @subpackage    bwrk_fluidmenu
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
    'title' => 'BERGWERK Fluid-Menu',
    'description' => 'Render your Menu with Fluid instead of typoscript. It will give you a mass of performance!',
    'category' => 'plugin',
    'author' => 'Georg Dümmler',
    'author_email' => 'gd@bergwerk.ag',
    'author_company' => 'www.bergwerk.ag',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '2.3.2',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.0-7.6.99',
            'bwrk_utility' => '2.0.2-2.9.99'
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);