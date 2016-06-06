<?php
/**
 * @package     Joomla.Plugins
 * @subpackage  System.userlogs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Joomla! Users Actions Logging Plugin.
 *
 * @since  3.7
 */
class PlgSystemUserLogs extends JPlugin
{
    /**
	 * After save content logging method
	 * This method adds a record to #__user_logs contains (message, date, context, user)
	 * Method is called right after the content is saved
	 *
	 * @param   string   $context  The context of the content passed to the plugin
	 * @param   object   $article  A JTableContent object
	 * @param   boolean  $isNew    If the content is just about to be created
	 *
	 * @return  boolean   true if function not enabled, is in front-end or is new. Else true or
	 *                    false depending on success of save function.
	 *
	 * @since   3.7
	 */
    public function onContentAfterSave($context, $article, $isNew)
    {
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $date = JFactory::getDate();
        $query = $db->getQuery(​true​);
        $columns = array('message', 'log_date', 'extension', 'user_id');
        $isNew_string = $isNew ? 'true' : 'false';
        $message = '{"title":"'.$article->title.'","isNew":"'.$isNew_string.'"}';
        $values = array($db->quote($message), $db->quote($date), $db->quote((string)$context), $user->id);
        $query
            ->insert($db->quoteName('#__user_logs'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        $db->setQuery($query);
        $db->execute();
    }
}
