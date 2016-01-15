*****************************************************
*** 1. TypoScript Definition
*****************************************************

lib.menu_main = USER_INT
lib.menu_main {
    userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = BwrkFluidmenu
    pluginName = Pi1
    settings {
        // Posible Types: Default, Submenu, Mobile
        menuType = Default

        // Depends on Rootpage e.g.
        entryLevel =

        // Comma seperated list of page uids
        pagesToExclude =

        // How much menu levels you want to display
        showLevels =
    }
}


*****************************************************
*** 2. Fluid Call
*****************************************************

<f:cObject typoscriptObjectPath="lib.menu_main" />