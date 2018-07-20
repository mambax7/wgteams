<?php namespace XoopsModules\Wgteams;

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

use XoopsModules\Wgteams;

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/*
 * Class Object Persons
 */

class Persons extends \XoopsObject
{
    /*
    * @var mixed
    */
    private $helper = null;

    /*
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        /** @var Wgteams\Helper $this->helper */
        $this->helper = Wgteams\Helper::getInstance();
        $this->initVar('person_id', XOBJ_DTYPE_INT);
        $this->initVar('person_firstname', XOBJ_DTYPE_TXTBOX);
        $this->initVar('person_lastname', XOBJ_DTYPE_TXTBOX);
        $this->initVar('person_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('person_address', XOBJ_DTYPE_TXTAREA);
        $this->initVar('person_phone', XOBJ_DTYPE_TXTAREA);
        $this->initVar('person_email', XOBJ_DTYPE_TXTBOX);
        $this->initVar('person_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('person_submitter', XOBJ_DTYPE_INT);
        $this->initVar('person_date_create', XOBJ_DTYPE_INT);
    }

    /*
    *  @static function getInstance
    *  @param null
    */
    public static function getInstance()
    {
        static $instance;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /*
     * Get form
     *
     * @param mixed $action
     */
    public function getFormPersons($action = false)
    {
        global $xoopsUser;

        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? sprintf(_AM_WGTEAMS_PERSON_ADD) : sprintf(_AM_WGTEAMS_PERSON_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Persons handler
        //$personsHandler = $this->helper->getHandler('Persons');
        // Form Text PersonFirstname
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_PERSON_FIRSTNAME, 'person_firstname', 50, 255, $this->getVar('person_firstname')), true);
        // Form Text PersonLastname
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_PERSON_LASTNAME, 'person_lastname', 50, 255, $this->getVar('person_lastname')));
        // Form Text PersonTitle
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_PERSON_TITLE, 'person_title', 50, 255, $this->getVar('person_title')));
        // Form Text Area
        $form->addElement(new \XoopsFormTextArea(_AM_WGTEAMS_PERSON_ADDRESS, 'person_address', $this->getVar('person_address'), 4, 47));
        // Form Text Area
        $form->addElement(new \XoopsFormTextArea(_AM_WGTEAMS_PERSON_PHONE, 'person_phone', $this->getVar('person_phone'), 4, 47));
        // Form Text PersonEmail
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_PERSON_EMAIL, 'person_email', 50, 255, $this->getVar('person_email')));
        // Form Upload Image
        $getPersonImage = $this->getVar('person_image');
        $personImage    = $getPersonImage ?: 'blank.gif';
        $imageDirectory = '/uploads/wgteams/persons/images';
        //
        $imageTray   = new \XoopsFormElementTray(_AM_WGTEAMS_PERSON_IMAGE, '<br>');
        $imageSelect = new \XoopsFormSelect(_AM_WGTEAMS_FORM_IMAGE_EXIST, 'person_image', $personImage, 5);
        $imageArray  = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $imageDirectory);
        foreach ($imageArray as $image) {
            $imageSelect->addOption((string)$image, $image);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"image2\", \"person_image\", \"" . $imageDirectory . '", "", "' . XOOPS_URL . "\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $imageDirectory . '/' . $personImage . "' name='image2' id='image2' alt='' style='max-width:100px'>"));
        // Form File
        $fileSelectTray = new \XoopsFormElementTray('', '<br>');
        $fileSelectTray->addElement(new \XoopsFormFile(_AM_WGTEAMS_FORM_UPLOAD_IMG, 'attachedfile', $this->helper->getConfig('maxsize')));
        $fileSelectTray->addElement(new \XoopsFormLabel(''));
        $imageTray->addElement($fileSelectTray);
        $form->addElement($imageTray);
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('person_submitter');
        $form->addElement(new \XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'person_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new \XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'person_date_create', '', $this->getVar('person_date_create')));
        // Send
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesPersons($keys = null, $format = null, $maxDepth = null)
    {
        $ret                = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('person_id');
        $ret['firstname']   = $this->getVar('person_firstname');
        $ret['lastname']    = $this->getVar('person_lastname');
        $ret['title']       = $this->getVar('person_title');
        $ret['address']     = strip_tags($this->getVar('person_address'));
        $ret['phone']       = strip_tags($this->getVar('person_phone'));
        $ret['email']       = $this->getVar('person_email');
        $ret['image']       = $this->getVar('person_image');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('person_submitter'));
        $ret['date_create'] = formatTimestamp($this->getVar('person_date_create'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     **/
    public function toArray()
    {
        $ret  = [];
        $vars = $this->getVars();
        foreach (array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }

        return $ret;
    }
}
