<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_userlogs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


/**
 * Userlogs list controller class.
 *
 * @since  3.6
 */
class UserlogsControllerUserlogs extends JControllerAdmin
{
    public function getModel($name = 'Userlogs', $prefix = 'UserlogsModel',
        $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
}
