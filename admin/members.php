<?php

declare(strict_types=1);

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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version         $Id: 1.0 members.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */

use Xmf\Request;
use XoopsModules\Wgteams;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op       = Request::getString('op', 'list');
$memberId = Request::getInt('member_id');

// Switch options
switch ($op) {
    case 'list':
    default:
        $start        = Request::getInt('start');
        $limit        = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_members.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('members.php'));
        $adminObject->addItemButton(_AM_WGTEAMS_MEMBER_ADD, 'members.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        $membersCount = $membersHandler->getCountMembers();
        $membersAll   = $membersHandler->getAllMembers($start, $limit);
        $GLOBALS['xoopsTpl']->assign('members_count', $membersCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
        // Table view
        if ($membersCount > 0) {
            foreach (\array_keys($membersAll) as $i) {
                $member = $membersAll[$i]->getValuesMember();
                if ('blank.gif' == $member['image']) {
                    $member['image'] = false;
                } else {
                    $image = \WGTEAMS_UPLOAD_PATH . '/members/images/' . $member['image'];
                    $size = \getimagesize($image);
                    $member['image_resxy'] = $size[0] . ' x ' . $size[1];
                }
                $GLOBALS['xoopsTpl']->append('members_list', $member);
                unset($member);
            }
            if ($membersCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($membersCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_THEREARENT_MEMBERS);
        }
        break;
    case 'new':
        $templateMain = 'wgteams_admin_members.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_MEMBERS_LIST, 'members.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('members.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $membersObj = $membersHandler->create();
        $form       = $membersObj->getFormMembers();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('members.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($memberId)) {
            $membersObj = $membersHandler->get($memberId);
        } else {
            $membersObj = $membersHandler->create();
        }
        // Set Vars
        // Set Var member_firstname
        $membersObj->setVar('member_firstname', $_POST['member_firstname']);
        // Set Var member_lastname
        $membersObj->setVar('member_lastname', $_POST['member_lastname']);
        // Set Var member_title
        $membersObj->setVar('member_title', $_POST['member_title']);
        // Set Var member_address
        $membersObj->setVar('member_address', $_POST['member_address']);
        // Set Var member_phone
        $membersObj->setVar('member_phone', $_POST['member_phone']);
        // Set Var member_email
        $membersObj->setVar('member_email', $_POST['member_email']);
        // Set Var member_image
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $maxwidth  = $helper->getConfig('maxwidth');
        $maxheight = $helper->getConfig('maxheight');
        $uploader = new \XoopsMediaUploader(\WGTEAMS_UPLOAD_PATH . '/members/images', $helper->getConfig('wgteams_img_mimetypes'), $helper->getConfig('wgteams_img_maxsize'), $maxwidth, $maxheight);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = mb_substr(\str_replace(' ', '', $_POST['member_lastname'] . $_POST['member_firstname']), 0, 20) . '_' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $membersObj->setVar('member_image', $savedFilename);
                // resize image
                $img_resize = Request::getInt('img_resize');
                if (1 == $img_resize) {
                    $imgHandler                = new Wgteams\Resizer();
                    $maxwidth_imgeditor        = (int)$helper->getConfig('maxwidth_imgeditor');
                    $maxheight_imgeditor       = (int)$helper->getConfig('maxheight_imgeditor');
                    $imgHandler->sourceFile    = \WGTEAMS_UPLOAD_PATH . '/members/images/' . $savedFilename;
                    $imgHandler->endFile       = \WGTEAMS_UPLOAD_PATH . '/members/images/' . $savedFilename;
                    $imgHandler->imageMimetype = $imageMimetype;
                    $imgHandler->maxWidth      = $maxwidth_imgeditor;
                    $imgHandler->maxHeight     = $maxheight_imgeditor;
                    $result = $imgHandler->resizeImage();
                    $membersObj->setVar('member_image', $savedFilename);
                }
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $membersObj->setVar('member_image', Request::getString('member_image'));
        }
        
        // Set Var member_submitter
        $membersObj->setVar('member_submitter', $_POST['member_submitter']);
        // Set Var member_date_create
        $membersObj->setVar('member_date_create', \time());
        // Insert Data
        if ($membersHandler->insert($membersObj)) {
            if ('' !== $uploaderErrors) {
                \redirect_header('members.php?op=edit&member_id=' . $memberId, 4, $uploaderErrors);
            } else {
                \redirect_header('members.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $membersObj->getHtmlErrors());
        $form = $membersObj->getFormMembers();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgteams_admin_members.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_MEMBER_ADD, 'members.php?op=new');
        $adminObject->addItemButton(_AM_WGTEAMS_MEMBERS_LIST, 'members.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('members.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $membersObj = $membersHandler->get($memberId);
        $form       = $membersObj->getFormMembers();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $membersObj = $membersHandler->get($memberId);
        if (1 == Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('members.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $member_img = $membersObj->getVar('member_image');
            $member_id  = $membersObj->getVar('member_id');
            if ($membersHandler->delete($membersObj)) {
                // delete image of this member
                if ('' === !$member_img) {
                    \unlink(\WGTEAMS_UPLOAD_PATH . '/members/images/' . $member_img);
                }
                //delete relations
                $crit_rels = new \CriteriaCompo();
                $crit_rels->add(new \Criteria('rel_member_id', $member_id));
                $relsCount = $relationsHandler->getCount($crit_rels);
                if ($relsCount > 0) {
                    $relationsAll = $relationsHandler->getAll($crit_rels);
                    foreach (\array_keys($relationsAll) as $i) {
                        $relationsObj = $relationsHandler->get($relationsAll[$i]->getVar('rel_id'));
                        $relationsHandler->delete($relationsObj);
                    }
                }
                \redirect_header('members.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $membersObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'member_id' => $memberId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], \sprintf(_AM_WGTEAMS_FORM_SURE_DELETE, $membersObj->getVar('member_firstname')));
        }
        break;
}

require __DIR__ . '/footer.php';
