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
 * Userlogs component helper.
 *
 * @since  3.6
 */
 abstract class UserlogsHelper
 {
    /**
     * Method to extract data array of objects into CSV file
     *
     * @param array $data Has the data to be exported
     *
     * @return void
     *
     * @since 3.6
     */
    public function dataToCsv($data)
    {
        $date = JFactory::getDate();
        $filename = "Logs_" . $date;
        $data = json_decode(json_encode($data), true);
        $dispatcher = JEventDispatcher::getInstance();
        $app = JFactory::getApplication();
        $app
		->setHeader('Content-Type', 'application/csv', true)
		->setHeader('Content-Disposition', 'attachment; filename="'.$filename.'.csv"', true);
        $app->sendHeaders();
        $fp = fopen('php://temp', 'r+');
        ob_end_clean();
        foreach ($data as $log)
        {
            $dispatcher->trigger('onLogMessagePrepare', array (&$log['message'], $log['extension']));
            $log['ip_address'] = JText::_($log['ip_address']);
            $log['extension'] = UserlogsHelper::translateExtensionName(strtoupper(strtok($log['extension'], '.')));
            fputcsv($fp, $log, ',');
        }
        rewind($fp);
        $content = stream_get_contents($fp);
        echo $content;
        fclose($fp);

        $app->close();
    }

    /**
     * Change the retrived extension name to more user friendly name
     *
     * @param   string  $extension  Extension name
     *
     * @return  string  Translated extension name
     *
     * @since   3.6
     */
    public function translateExtensionName($extension)
    {
        $lang = JFactory::getLanguage();
        $source = JPATH_ADMINISTRATOR . '/components/' . $extension;

        $lang->load("$extension.sys", JPATH_ADMINISTRATOR, null, false, true)
         ||	$lang->load("$extension.sys", $source, null, false, true);

        return JText::_($extension);
    }
 }
