<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'BERGWERK Fluid-Menu',
    'description' => 'Render your Menu with Fluid instead of typoscript. It will give you a mass of performance!',
    'category' => 'plugin',
    'author' => 'BERGWERK',
    'author_email' => 'technik@bergwerk.ag',
    'author_company' => 'BERGWERK Strategie und Marke GmbH',
    'state' => 'stable',
    'version' => '2.2.4',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.0-8.7.99',
            'bwrk_utility' => '2.0.0-3.9.99'
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
