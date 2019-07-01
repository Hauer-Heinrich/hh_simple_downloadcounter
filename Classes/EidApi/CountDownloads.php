<?php
namespace HauerHeinrich\HhSimpleDownloadcounter\Controller\EidApi;

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * This class could called via eID
 *
 * @package TYPO3
 * @subpackage my_extkey
 */
class CountDownloads {

    private $params = [];

    /**
     * Initialize Extbase
     *
     * @param \array $TYPO3_CONF_VARS
     */
    public function __construct($TYPO3_CONF_VARS) {
        foreach ($_GET as $key => $value) {
            $this->params[$this->escape_input($key)] = $this->escape_input($value);
        }
    }

    public function updateCount():bool {
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $file = $resourceFactory->getFileObjectFromCombinedIdentifier($this->params['file']);

        if($file) {
            $fileUid = $file->getUid();

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable("sys_file");
            $currentCount = $queryBuilder
                ->select('download_count')
                ->from('sys_file')
                ->where(
                    $queryBuilder->expr()->eq('uid', $fileUid)
                )
                ->execute()
                ->fetchAll();

            $newCount = $currentCount[0]['download_count'] + 1;

            $queryBuilder
                ->update('sys_file')
                ->where(
                    $queryBuilder->expr()->eq('uid', $fileUid)
                )
                ->set('download_count', $newCount)
                ->execute();

            return true;
        }

        return false;
    }

    public function outputStream() {
        if($this->params['file'] && file_exists($this->params['file'])) {
            $file = $this->params['file'];
            header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . filesize($file));
            header("Connection: close");
        }
    }

    /**
     * escape's a given string or array
     * @param  [string or array] $data - array to escape
     * @return [array] - returns the escaped array
     */
    public function escape_input($data) {
        $tmp_str_replace_orig = array('"', "'", "<", ">", " ");
        $tmp_str_replace_target = array('', "", "", "", "");

        if(is_array($data)) {
            $tempData = $data;
            foreach ($tempData as &$arr) {
                $arr = str_replace($tmp_str_replace_orig, $tmp_str_replace_target, stripslashes(trim($arr)));
            }
        } else {
            $tempData = str_replace($tmp_str_replace_orig, $tmp_str_replace_target, stripslashes(trim($data)));
        }

        return $tempData;
    }
}

global $TYPO3_CONF_VARS;
$eid = GeneralUtility::makeInstance('GroundStack\HhThemeMutterKind\Controller\EidApi\CountDownloads', $TYPO3_CONF_VARS);
if($eid->updateCount()) {
    $eid->outputStream();
}
