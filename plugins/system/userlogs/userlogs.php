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
	 * Function to add logs to the database
	 * This method adds a record to #__user_logs contains (message, date, context, user)
	 *
	 * @param   string   $message  The contents of the message to be logged
	 * @param   string   $context  The context of the content passed to the plugin
	 *
	 * @return  void
	 *
	 * @since   3.7
	 */
     protected function addLogsToDB($message, $context)
     {
         $db = JFactory::getDbo();
         $user = JFactory::getUser();
         $date = JFactory::getDate();
         $query = $db->getQuery(​true​);
         $columns = array('message', 'log_date', 'extension', 'user_id');
         $values = array($db->quote($message), $db->quote($date), $db->quote($context), $user->id);
         $query
             ->insert($db->quoteName('#__user_logs'))
             ->columns($db->quoteName($columns))
             ->values(implode(',', $values));
         $db->setQuery($query);
         $db->execute();
     }
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
        $isNew_string = $isNew ? 'true' : 'false';
        $message = '{"title":"'.$article->title.'","isNew":"'.$isNew_string.'", "event":"onContentAfterSave"}';
        $strContext = (string)$context;
        $this->addLogsToDB($message, $strContext);
    }

    /**
	 * After delete content logging method
	 * This method adds a record to #__user_logs contains (message, date, context, user)
	 * Method is called right after the content is deleted
	 *
	 * @param   string   $context  The context of the content passed to the plugin
	 * @param   object   $article  A JTableContent object
	 *
	 * @return  void
	 *
	 * @since   3.7
	 */
    public function onContentAfterDelete($context, $article)
    {
        $message = '{"title":"'.$article->title.'","event":"onContentAfterDelete"}';
        $strContext = (string)$context;
        $this->addLogsToDB($message, $strContext);
    }

    /**
	 * On content change status logging method
	 * This method adds a record to #__user_logs contains (message, date, context, user)
	 * Method is called when the status of the article is changed
	 *
	 * @param   string   $context  The context of the content passed to the plugin
	 * @param   array    $pks      An array of primary key ids of the content that has changed state.
     * @param   int      $value    The value of the state that the content has been changed to.
	 *
	 * @return  void
	 *
	 * @since   3.7
	 */
    public function onContentChangeState($context, $pks, $value)
    {
        $message = '{"event":"onContentChangeState",'.
                    '"primary_keys":'.json_encode($pks).',"value":'.(string)$value.'}';
        $strContext = (string)$context;
        $this->addLogsToDB($message, $strContext);
    }
}
