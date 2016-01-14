*****************************************************
*** 1. TypoScript Definition
*****************************************************

lib.menu_main >
lib.menu_main = USER_INT
lib.menu_main {
    userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = BwrkFluidmenu
    pluginName = Pi1
    settings {
        // Posible Types: Default, Submenu, Mobile
        menuType = Default
    }
}


*****************************************************
*** 2. Fluid Call
*****************************************************

<f:cObject typoscriptObjectPath="lib.menu_main" />


*****************************************************
*** 3. TypoScript Settings
*****************************************************

plugin.tx_bwrkfluidmenu {
    settings {
        // Depends on Rootpage e.g.
        entryLevel =

        // Comma seperated list of page uids
        pagesToExclude =
    }
}