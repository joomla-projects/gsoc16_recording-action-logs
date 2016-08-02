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
     */
    public function dataToCsv($data)
    {
        $date = JDate::getInstance('now');
        $filename = "Logs_" . $date;
        $data = json_decode(json_encode($data), true);
        $app = JFactory::getApplication();
        $fp = fopen('php://temp', 'r+');
        foreach ($data as $log)
        {
            fputcsv($fp, $log, ',');
        }
        rewind($fp);
        $content = stream_get_contents($fp);
        print $content;
        $app
		-> setHeader('Content-Type', 'application/cvs; charset=utf-8', true)
		-> setHeader('Content-Disposition', 'attachment; filename="'.$filename.'.csv"', true)
		-> setHeader('Content-Transfer-Encoding', 'binary', true)
		-> setHeader('Expires', '0', true)
		-> setHeader('Pragma','no-cache',true);
    }
 }
