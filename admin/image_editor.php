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
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wgteams
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:50Z XOOPS Project (www.xoops.org) $
 */

use Xmf\Request;
use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Constants;

include __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgteams_admin_image_editor.tpl';

require_once XOOPS_ROOT_PATH . '/header.php';

/** @var \XoopsModules\Wgteams\Utility $utility */
$utility = new \XoopsModules\Wgteams\Utility();

$op       = Request::getString('op', 'list');
$memberId = Request::getInt('member_id', 0);
$origin   = Request::getString('imageOrigin');
$teamId   = Request::getInt('team_id', 0);
$start    = Request::getInt('start', 0);
$limit    = Request::getInt('limit', $helper->getConfig('adminpager'));

// get all objects/classes/vars needed for image editor
$imageClass = 0;
$imgCurrent = [];
if ('member_id' === $origin) {
    $memberId = Request::getInt('imageIdCrop', 0);
}
if ('team_id' === $origin) {
    $teamId = Request::getInt('imageIdCrop', 0);
}
if ( 0 < $memberId ) {
	$imageId      = $memberId;
	$imageHandler = $membersHandler;
	$imageObj     = $membersHandler->get($imageId);
	$imageClass   = Constants::IMAGECLASS_MEMBER;
    $imageOrigin  = 'member_id';
} else {
	if ($teamId > 0) {
		$imageId      = $teamId;
		$imageObj     = $teamsHandler->get($imageId);
		$imageHandler = $teamsHandler;
		$imageClass   = Constants::IMAGECLASS_TEAM;
        $imageOrigin  = 'team_id';
	} else {
		redirect_header('index.php', 3, _AM_WGTEAMS_FORM_ERROR_INVALID_ID);
	}
}

if ($imageClass === Constants::IMAGECLASS_MEMBER) {
    $imgName  = 'member' . $imageId . '.jpg';
    $imageDir = '/uploads/wgteams/members/images/';
    $imgPath  = XOOPS_ROOT_PATH . $imageDir;
    $imgUrl   = XOOPS_URL . $imageDir;
    $imgFinal = $imgPath . $imgName;
    $imgTemp  = WGTEAMS_UPLOAD_PATH . '/temp/' . $imgName;
    $redir    = 'members.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit;
    $nameObj  = 'member_firstname';
    $fieldObj = 'member_image';
    $submObj  = 'member_submitter';
} else {
    $imgName  = 'team' . $imageId . '.jpg';
    $imageDir = '/uploads/wgteams/teams/images/';
    $imgPath  = XOOPS_ROOT_PATH . $imageDir;
    $imgUrl   = XOOPS_URL . $imageDir;
    $imgFinal = $imgPath . $imgName;
    $imgTemp  = WGTEAMS_UPLOAD_PATH . '/temp/' . $imgName;
    $redir    = 'teams.php?op=list&amp;start=' . $start . '&amp;limit=' . $limit;
    $nameObj  = 'team_name';
    $fieldObj = 'team_image';
    $submObj  = 'team_submitter';
}

$imgCurrent['img_name'] = $imageObj->getVar($fieldObj);
$imgCurrent['src'] = $imgUrl . $imageObj->getVar($fieldObj);
$imgCurrent['origin'] = $imageClass;
$images = [];

$image_array = \XoopsLists::getImgListAsArray($imgPath);
$i = 0;
foreach ($image_array as $image_img) {
    if ('blank.gif' !== $image_img) {
        $i++;
        $images[$i]['id'] = 'imageSelect'.$i;
        $images[$i]['name'] = $image_img;
        $images[$i]['title'] = $image_img;
        $images[$i]['origin'] = Constants::IMAGECLASS_MEMBER;
        if ($imgCurrent['img_name'] === $image_img) {
            $images[$i]['selected'] = 1;
        }     
        $images[$i]['src'] = $imgUrl . $image_img;
    }
}
// var_dump($images);
$GLOBALS['xoopsTpl']->assign('images', $images);
unset($images);
// end: get all objects/classes/vars needed for image editor

$uid = $xoopsUser instanceof \XoopsUser ? $xoopsUser->id() : 0;

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet(WGTEAMS_URL . '/assets/css/style.css');
$GLOBALS['xoTheme']->addStylesheet(WGTEAMS_URL . '/assets/css/imageeditor.css');

// add scripts
$GLOBALS['xoTheme']->addScript(XOOPS_URL . '/modules/wgteams/assets/js/admin.js');

// assign vars
$GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_16', WGTEAMS_ICONS_URL . '/16');
$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_32', WGTEAMS_ICONS_URL . '/32');
$GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_upload_path', WGTEAMS_UPLOAD_PATH);
$GLOBALS['xoopsTpl']->assign('wgteams_upload_image_url', $imgUrl);
$GLOBALS['xoopsTpl']->assign('gridtarget', $imgName);
$GLOBALS['xoopsTpl']->assign('imgCurrent', $imgCurrent);
$GLOBALS['xoopsTpl']->assign('imageId', $imageId);
$GLOBALS['xoopsTpl']->assign('imageOrigin', $imageOrigin);

// Breadcrumbs
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));
$xoBreadcrumbs[] = ['title' => _AM_WGTEAMS_IMG_EDITOR];

// get config for images
$maxwidth  = $helper->getConfig('maxwidth');
$maxheight = $helper->getConfig('maxheight');

switch ($op) {

    case 'creategrid':
        // create an image grid based on given sources
        $type   = Request::getInt('type', 4);
        $src[1] = Request::getString('src1', '');
        $src[2] = Request::getString('src2', '');
        $src[3] = Request::getString('src3', '');
        $src[4] = Request::getString('src4', '');
        $src[5] = Request::getString('src5', '');
        $src[6] = Request::getString('src6', '');
        $target = Request::getString('target', '');
        // replace thumbs dir by dir for medium images, only for wggallery
        // $src[1] = str_replace('/thumbs/', '/medium/', $src[1]);
        // $src[2] = str_replace('/thumbs/', '/medium/', $src[2]);
        // $src[3] = str_replace('/thumbs/', '/medium/', $src[3]);
        // $src[4] = str_replace('/thumbs/', '/medium/', $src[4]);
        // $src[5] = str_replace('/thumbs/', '/medium/', $src[5]);
        // $src[6] = str_replace('/thumbs/', '/medium/', $src[6]);
        
        $images = [];
        for ($i = 1; $i <= 6; $i++) {
            if ('' !== $src[$i]) {
                $file       = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $src[$i]);
                $images[$i] = ['file' => $file, 'mimetype' => mime_content_type($file)];
            }
        }

        // create basic image
        $tmp   = imagecreatetruecolor($maxwidth, $maxheight);
        $imgBg = imagecolorallocate($tmp, 0, 0, 0);
        imagefilledrectangle($tmp, 0, 0, $maxwidth, $maxheight, $imgBg);

        $final = XOOPS_UPLOAD_PATH . '/wgteams/temp/' . $target;
        unlink($final);
        imagejpeg($tmp, $final);
        imagedestroy($tmp);

        $imgTemp = XOOPS_UPLOAD_PATH . '/wgteams/temp/' . $uid . 'imgTemp';

        $imgHandler = new Wgteams\Resizer();
        if (4 === $type) {
            for ($i = 1; $i <= 4; $i++) {
                unlink($imgTemp . $i . '.jpg');
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)round($maxwidth / 2 - 1);
                $imgHandler->maxHeight     = (int)round($maxheight / 2 - 1);
                $imgHandler->jpgQuality    = 90;
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 4;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 4; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                unlink($imgTemp . $i . '.jpg');
            }
        }
        if (6 === $type) {
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)round($maxwidth / 3 - 1);
                $imgHandler->maxHeight     = (int)round($maxheight / 2 - 1);
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 6;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                unlink($imgTemp . $i . '.jpg');
            }
        }

        break; 

    case 'cropimage':
        // save base64_image and resize to maxwidth/maxheight
        $base64_image_content = Request::getString('croppedImage', '');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            file_put_contents($imgTemp, base64_decode(str_replace($result[1], '', $base64_image_content), true));
        }

        $imgHandler                = new Wgteams\Resizer();
        $imgHandler->sourceFile    = $imgTemp;
        $imgHandler->endFile       = $imgTemp;
        $imgHandler->imageMimetype = 'image/jpeg';
        $imgHandler->maxWidth      = $maxwidth;
        $imgHandler->maxHeight     = $maxheight;
        $ret                       = $imgHandler->resizeImage();

        unlink($imgFinal);
        break;
    case 'saveImageSelected':
        // save image selected from list of available images in upload folder
        // Set Vars
        $image_id = Request::getString('image_id');
        $imageObj->setVar($fieldObj, $image_id);
		$imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {  
			redirect_header($redir, 2, _AM_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        break;
        
    case 'saveGrid':
        // save before created grid image
        $imgTempGrid = Request::getString('gridImgFinal');
        $ret = rename($imgTempGrid, $imgFinal);
        // Set Vars
        $imageObj->setVar($fieldObj, $imgName);
		$imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
			redirect_header($redir, 2, _AM_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'saveCrop':
        // save before created grid image
        $ret = rename($imgTemp, $imgFinal);
        // Set Vars
        $imageObj->setVar($fieldObj, $imgName);
        $imageObj->setVar($submObj, $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj, true)) {
            redirect_header($redir, 2, _AM_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'uploadImage':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($redir, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Set Vars
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $uploader       = new \XoopsMediaUploader($imgPath, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = 'album' . $albId . '.' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $imageObj->setVar($fieldObj, $savedFilename);
                // resize image
                $maxwidth = $helper->getConfig('maxwidth');
                $maxheight = $helper->getConfig('maxheight');

                $imgHandler                = new Wgteams\Resizer();
                $imgHandler->sourceFile    = WGTEAMS_UPLOAD_IMAGE_PATH . '/albums/' . $savedFilename;
                $imgHandler->endFile       = WGTEAMS_UPLOAD_IMAGE_PATH . '/albums/' . $savedFilename;
                $imgHandler->imageMimetype = $imageMimetype;
                $imgHandler->maxWidth      = $maxwidth;
                $imgHandler->maxHeight     = $maxheight;
                $result                    = $imgHandler->resizeImage();

                $imageObj->setVar($fieldObj, $savedFilename);
                $imageObj->setVar($submObj, $uid);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
        }
        if ('' !== $uploaderErrors) {
            redirect_header($redir, $uploaderErrors);
        }
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            redirect_header($redir, 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        $form = $imageObj->getFormUploadImage($imageOrigin, $imageId);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
        
    case 'imghandler':
    default:
        $GLOBALS['xoTheme']->addStylesheet(WGTEAMS_URL . '/assets/css/cropper.min.css');
        $GLOBALS['xoTheme']->addScript(WGTEAMS_URL . '/assets/js/cropper.min.js');
        $GLOBALS['xoTheme']->addScript(WGTEAMS_URL . '/assets/js/cropper-main.js');

        $GLOBALS['xoopsTpl']->assign('nbModals', [1, 2, 3, 4, 5, 6]);
		
        // get form for upload album image
        $currImage   = $imageObj->getVar($fieldObj);
        if ('' == $currImage) {
            $currImage = 'blank.gif';
        }
        $form = getFormUploadImage($imageOrigin, $imageId);
        $GLOBALS['xoopsTpl']->assign('form_uploadimage', $form->render());

        $GLOBALS['xoopsTpl']->assign('btn_style', 'btn-default');

        break;
}

$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));

// Description
// $utility::getMetaDescription(_AM_WGTEAMS_ALBUMS);

include __DIR__ . '/footer.php';

/**
 * @public function getFormUploadAlbumimage:
 * provide form for uploading a new album image
 * @param $imageOrigin
 * @param $imageId
 * @return \XoopsThemeForm
 */
function getFormUploadImage($imageOrigin, $imageId)
{
    $helper = \XoopsModules\Wgteams\Helper::getInstance();
    // Get Theme Form
    xoops_load('XoopsFormLoader');
    $form = new \XoopsThemeForm('', 'formuploadimmage', 'image_editor.php', 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
    // upload new image
    $imageTray3      = new \XoopsFormElementTray(_AM_WGTEAMS_FORM_UPLOAD_IMG, '<br>');
    $imageFileSelect = new \XoopsFormFile('', 'attachedfile', $helper->getConfig('maxsize'));
    $imageTray3->addElement($imageFileSelect);
    $form->addElement($imageTray3);

    $form->addElement(new \XoopsFormHidden($imageOrigin, $imageId));
    $form->addElement(new \XoopsFormHidden('op', 'uploadImage'));
    $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));

    return $form;
}
