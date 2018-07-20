<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgTeams module for xoops
 *
 * @copyright       The XOOPS Project (https://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 */

use Xmf\Request;

require __DIR__   . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getString('op', 'list');
// Request person_id
$personId = Request::getInt('person_id', 0);
// Switch options
switch ($op) {
    case 'list':
    default:
        $start        = Request::getInt('start', 0);
        $limit        = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_persons.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation(basename(__FILE__)));
        $adminObject->addItemButton(_AM_WGTEAMS_PERSON_ADD, 'persons.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $personsCount = $personsHandler->getCountPersons();
        $personsAll   = $personsHandler->getAllPersons($start, $limit);
        $GLOBALS['xoopsTpl']->assign('persons_count', $personsCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
        // Table view
        if ($personsCount > 0) {
            foreach (array_keys($personsAll) as $i) {
                $person = $personsAll[$i]->getValuesPersons();
                $GLOBALS['xoopsTpl']->append('persons_list', $person);
                unset($person);
            }
            if ($personsCount > $limit) {
                require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($personsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_THEREARENT_PERSONS);
        }
        break;

    case 'new':
        $templateMain = 'wgteams_admin_persons.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_PERSONS_LIST, 'persons.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation(basename(__FILE__)));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $personsObj = $personsHandler->create();
        $form       = $personsObj->getFormPersons();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('persons.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($personId)) {
            $personsObj = $personsHandler->get($personId);
        } else {
            $personsObj = $personsHandler->create();
        }
        // Set Vars
        // Set Var person_firstname
        $personsObj->setVar('person_firstname', $_POST['person_firstname']);
        // Set Var person_lastname
        $personsObj->setVar('person_lastname', $_POST['person_lastname']);
        // Set Var person_title
        $personsObj->setVar('person_title', $_POST['person_title']);
        // Set Var person_address
        $personsObj->setVar('person_address', $_POST['person_address']);
        // Set Var person_phone
        $personsObj->setVar('person_phone', $_POST['person_phone']);
        // Set Var person_email
        $personsObj->setVar('person_email', $_POST['person_email']);
        // Set Var person_image
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploader = new \XoopsMediaUploader(WGTEAMS_UPLOAD_PATH . '/persons/images', $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = preg_replace('/^.+\.([^.]+)$/sU', '', $_FILES['attachedfile']['name']);
            $imgName   = str_replace(' ', '', $_POST['person_firstname']) . '.' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $personsObj->setVar('person_image', $uploader->getSavedFileName());
            }
        } else {
            $personsObj->setVar('person_image', $_POST['person_image']);
        }
        // Set Var person_submitter
        $personsObj->setVar('person_submitter', $_POST['person_submitter']);
        // Set Var person_date_create
        $personsObj->setVar('person_date_create', time());
        // Insert Data
        if ($personsHandler->insert($personsObj)) {
            redirect_header('persons.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $personsObj->getHtmlErrors());
        $form =& $personsObj->getFormPersons();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'edit':
        $templateMain = 'wgteams_admin_persons.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_PERSON_ADD, 'persons.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGTEAMS_PERSONS_LIST, 'persons.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation(basename(__FILE__)));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $personsObj = $personsHandler->get($personId);
        $form       = $personsObj->getFormPersons();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'delete':
        $personsObj = $personsHandler->get($personId);
        if (\Xmf\Request::hasVar('ok', 'REQUEST') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('persons.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($personsHandler->delete($personsObj)) {
                redirect_header('persons.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $personsObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'person_id' => $personId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], sprintf(_AM_WGTEAMS_FORM_SURE_DELETE, $personsObj->getVar('person_firstname')));
        }
        break;
}

require __DIR__   . '/footer.php';
