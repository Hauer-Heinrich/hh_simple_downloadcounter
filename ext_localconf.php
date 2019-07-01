<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_simple_downloadcounter';

    // AJAX eID
    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['count_downloads'] = "EXT:{$extensionKey}/Classes/EidApi/CountDownloads.php";
});
