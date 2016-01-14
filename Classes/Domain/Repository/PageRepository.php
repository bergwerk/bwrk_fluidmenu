<?php
namespace BERGWERK\BwrkFluidmenu\Domain\Repository;

use BERGWERK\BwrkFluidmenu\Bootstrap;
use BERGWERK\BwrkFluidmenu\TyposcriptConfiguration;

class PageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function initializeObject()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface $querySettings */
        $querySettings = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface');
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return static
     */
    static public function create()
    {
        return Bootstrap::getObjectManager()->get(get_called_class());
    }

    public function findPagesByPid($pid)
    {
        $query = $this->createQuery();


        $logicalAndConstraints = array(
            $query->equals('pid', $pid),
            $query->logicalOr(
                $query->equals('doktype', 1),
                $query->equals('doktype', 4),
                $query->equals('doktype', 3)
            ),
            $query->equals('nav_hide', 0),
        );


        $pagesToExclude = TyposcriptConfiguration::getPagesToExclude();

        if(!empty($pagesToExclude))
        {
            $toExcludeArray = array();
            foreach ($pagesToExclude as $pageToExclude) {
                $toExcludeArray[] = $query->logicalNot(
                    $query->equals('uid', $pageToExclude)
                );
            }
            $logicalAndConstraints[] = $query->logicalAnd($toExcludeArray);
        }


        $query->matching(
            $query->logicalAnd(
                $logicalAndConstraints
            )
        );

        return $query->execute();
    }


}