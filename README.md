# TYPO3 Fluid Menu
------------------

Extension-Key: bwrk_fluidmenu

### Installation

Add this TS Snippet to your Project. `menu_main` is a placeholder, you can rename it.

```
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
``` 

Add this to your Fluid Template

`<f:cObject typoscriptObjectPath="lib.menu_main" />` 


