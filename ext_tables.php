<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_simple_downloadcounter';

    if (TYPO3_MODE === 'BE') {
        /**
         * Registers a Backend Module
         */
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'HauerHeinrich.HhSimpleDownloadcounter',
            'web', // Make module a submodule of 'user'
            'simpledownloadcounter', // Submodule key
            '', // Position
            [
                'Download' => 'list, reset',
            ],
            [
                //'access' => 'user, group',
                //'icon'   => 'EXT:' . $extensionKey . '/ext_icon.gif',
                'labels' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', 'hh-simple-downloadcounter');
});
