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
 * Class Object Handler WgteamsPersons
 */

class PersonsHandler extends \XoopsPersistableObjectHandler
{
    /*
    * @var mixed
    */
    private $helper = null;

    /*
     * Constructor
     *
     * @param string $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'mod_wgteams_persons', Persons::class, 'person_id', 'person_firstname');
        /** @var \XoopsModules\Wgteams\Helper $this->helper */
        $this->helper = \XoopsModules\Wgteams\Helper::getInstance();
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function &create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param  int $i field id
     * @param null $fields
     * @return mixed reference to the <a href='psi_element://TDMCreateFields'>TDMCreateFields</a> object
     *                object
     */
    public function &get($i = null, $fields = null)
    {
        return parent::get($i, $fields);
    }

    /**
     * get inserted id
     *
     * @param null
     * @return integer reference to the {@link TDMCreateFields} object
     */
    public function &getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * get IDs of objects matching a condition
     *
     * @param  \CriteriaElement $criteria {@link CriteriaElement} to match
     * @return array  of object IDs
     */
    public function &getIds(\CriteriaElement $criteria)
    {
        return parent::getIds($criteria);
    }

    /**
     * insert a new field in the database
     *
     * @param \XoopsObject $field reference to the {@link TDMCreateFields}
     *                            object
     * @param bool         $force
     *
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function &insert(\XoopsObject $field, $force = false)
    {
        if (!parent::insert($field, $force)) {
            return false;
        }

        return true;
    }

    /**
     * Get Count Persons
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountPersons($start = 0, $limit = 0, $sort = 'person_id ASC, person_firstname', $order = 'ASC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getCount($criteria);
    }

    /**
     * Get All Persons
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllPersons($start = 0, $limit = 0, $sort = 'person_id ASC, person_firstname', $order = 'ASC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getAll($criteria);
    }
}
