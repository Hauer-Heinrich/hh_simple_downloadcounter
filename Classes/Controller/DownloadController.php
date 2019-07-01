<?php
namespace HauerHeinrich\HhSimpleDownloadcounter\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2019
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
 ***************************************************************/

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * DownloadController
 */
class DownloadController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * fileRepository
     *
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     * @inject
     */
    protected $fileRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $files = $this->fileRepository->findAll();
        $downloads = [];
        foreach ($files as $key => $value) {
            $count = $value->getProperty('download_count');
            if($count > 0) {
                $downloads[$key]= $value;
            }
        }
        $this->view->assign('downloads', $downloads);
    }

    /**
     * action list
     *
     * @param int $uid
     *
     * @return void
     */
    public function resetAction($uid) {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file');
        $queryBuilder
            ->update('sys_file')
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->set('download_count', 0)
            ->execute();

        // $this->redirect('list', $controllerName = NULL, $extensionName = NULL, array $arguments = NULL, $pageUid = NULL, $delay = 0, $statusCode = 303);
        $this->redirect('list');
    }

    /**
     * gets the page title from page id
     *
     * @param $pageId
     */
    public function getPageTitle($pageId) {
        $pageSelect = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Page\PageRepository');
        $pageSelect->init(false);
        $page = $pageSelect->getPage($pageId);

        return $page['title'];
    }
}
