<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_userlogs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JLoader::register('UserlogsHelper', JPATH_COMPONENT . '/helpers/userlogs.php');

/**
 * Userlogs list controller class.
 *
 * @since  3.6
 */
class UserlogsControllerUserlogs extends JControllerAdmin
{
    /**
     * Method to get a model object, loading it if required.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   3.6
     */
    public function getModel($name = 'Userlogs', $prefix = 'UserlogsModel',
        $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
    /**
     * Method to export logs
     *
     * @return void
     *
     * @since 3.6
     */
    public function exportLogs()
    {
        // Check for request forgeries.
        JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
        // Get the model
        $model = $this->getModel('userlogs');
        // Get the logs data
        $data = $model->getLogsData();
        // Export data to CSV file
        UserlogsHelper::dataToCsv($data);
        //JFactory::getApplication()->close();
    }
}
