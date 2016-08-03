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
    protected $loggable_extensions = array();
    protected $jinput;

    public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
        $this->loggable_extensions = $this->params->get('loggable_extensions');
        $this->jinput = JFactory::getApplication()->input;
    }
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
         if($this->params->get('ip_logging'))
         {
             $this->jinput = JFactory::getApplication()->input;
             $ip_address = $this->jinput->server->get('REMOTE_ADDR');
         }
         else
         {
             $ip_address = JText::_('PLG_SYSTEM_USERLOG_DISABLED');
         }
         $columns = array('message', 'log_date', 'extension', 'user_id', 'ip_address');
         $values = array($db->quote($message), $db->quote($date), $db->quote($context), $user->id, $db->quote($ip_address));
         $query
             ->insert($db->quoteName('#__user_logs'))
             ->columns($db->quoteName($columns))
             ->values(implode(',', $values));
         $db->setQuery($query);
         $db->execute();
     }

     /**
 	 * Function to check if a component is loggable or not
 	 *
 	 * @param   string   $extension  The extension that triggered the event
 	 *
 	 * @return  boolean
 	 *
 	 * @since   3.7
 	 */
     protected function checkLoggable($extension)
     {
         if(!in_array($extension, $this->loggable_extensions))
         {
             return false;
         }

         return true;
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
        if ($this->checkLoggable($this->jinput->get('option')))
        {
            $isNew_string = $isNew ? 'true' : 'false';
            $message = '{"title":"'.$article->title.'","isNew":"'.$isNew_string.'", "event":"onContentAfterSave"}';
            $strContext = (string)$context;
            $this->addLogsToDB($message, $strContext);
        }
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
        if ($this->checkLoggable($this->jinput->get('option')))
        {
            $message = '{"title":"'.$article->title.'","event":"onContentAfterDelete"}';
            $strContext = (string)$context;
            $this->addLogsToDB($message, $strContext);
        }
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
        if ($this->checkLoggable($this->jinput->get('option')))
        {
            $message = '{"event":"onContentChangeState",'.
                        '"primary_keys":'.json_encode($pks).',"value":'.(string)$value.'}';
            $strContext = (string)$context;
            $this->addLogsToDB($message, $strContext);
        }
    }

    /**
	 * On installing extensions logging method
	 * This method adds a record to #__user_logs contains (message, date, context, user)
	 * Method is called when an extension is installed
	 *
     * @param   JInstaller  $installer  Installer object
	 * @param   integer     $eid        Extension Identifier
	 *
	 * @return  void
	 *
	 * @since   3.7
	 */
    public function onExtensionAfterInstall($installer, $eid)
    {
        $context = $this->jinput->get('option');
        if($this->checkLoggable($context))
        {
            $message = '{"event":"onExtensionAfterInstall","extenstion_id":'.(string)$eid.'}';
            $this->addLogsToDB($message, $context);
        }
    }

    /**
	 * On uninstalling extensions logging method
	 * This method adds a record to #__user_logs contains (message, date, context, user)
	 * Method is called when an extension is uninstalled
	 *
     * @param   JInstaller  $installer  Installer instance
	 * @param   integer     $eid        Extension id
	 * @param   integer     $result     Installation result
	 *
	 * @return  void
	 *
	 * @since   3.7
	 */
    public function onExtensionAfterUninstall($installer, $eid, $result)
    {
        $context = $this->jinput->get('option');
        if($this->checkLoggable($context))
        {
            $message = '{"event":"onExtensionAfterUninstall","extenstion_id":'.(string)$eid.'}';
            $this->addLogsToDB($message, $context);
        }
    }

    /**
     * On updating extensions logging method
     * This method adds a record to #__user_logs contains (message, date, context, user)
     * Method is called when an extension is updated
     *
     * @param   JInstaller  $installer  Installer instance
     * @param   integer     $eid        Extension id
     *
     * @return  void
     *
     * @since   3.7
     */
    public function onExtensionAfterUpdate($installer, $eid)
    {
        $context = $this->jinput->get('option');
        if($this->checkLoggable($context))
        {
            $message = '{"event":"onExtensionAfterUpdate","extenstion_id":'.(string)$eid.'}';
            $this->addLogsToDB($message, $context);
        }
    }

    /**
	 * On saving user data logging method
	 *
	 * Method is called after user data is stored in the database.
     * This method logs who created/edited any user's data
	 *
	 * @param   array    $user     Holds the new user data.
	 * @param   boolean  $isnew    True if a new user is stored.
	 * @param   boolean  $success  True if user was succesfully stored in the database.
	 * @param   string   $msg      Message.
	 *
	 * @return  void
	 *
	 * @since   3.7
	 */
	public function onUserAfterSave($user, $isnew, $success, $msg)
    {
        $context = $this->jinput->get('option');
        if($this->checkLoggable($context))
        {
            $isNew_string = $isnew ? 'true' : 'false';
            $success_string = $success ? 'true' : 'false';
            $message = '{"edited_user":"'.$user["name"].'","event":"onUserAfterSave",'.
                        '"isNew":"'.$isNew_string.'","success":"'.$success_string.'"}';
            $this->addLogsToDB($message, $context);
        }
    }

    /**
     * On deleting user data logging method
     *
     * Method is called after user data is deleted from the database
     *
     * @param   array    $user     Holds the user data
     * @param   boolean  $success  True if user was succesfully stored in the database
     * @param   string   $msg      Message
     *
     * @return  boolean
     */
     public function onUserAfterDelete($user, $success, $msg)
     {
         $context = $this->jinput->get('option');
         if($this->checkLoggable($context))
         {
             $success_string = $success ? 'true' : 'false';
             $message = '{"deleted_user":"'.$user["name"].'","event":"onUserAfterDelete",'.
                         '"success":"'.$success_string.'"}';
             $this->addLogsToDB($message, $context);
         }
     }

     /**
      * On deleting user group data logging method
      *
      * Method is called after user data is deleted from the database
      *
      * @param   array    $group     Holds the group data
      * @param   boolean  $success  True if user was succesfully stored in the database
      * @param   string   $msg      Message
      *
      * @return  boolean
      */
      public function onUserAfterDeleteGroup($group, $success, $msg)
      {
          $context = $this->jinput->get('option');

          if($this->checkLoggable($context))
          {
              $success_string = $success ? 'true' : 'false';
              $message = '{"deleted_group":"'.$group["title"].'","event":"onUserAfterDeleteGroup",'.
                          '"success":"'.$success_string.'"}';
              $this->addLogsToDB($message, $context);
          }
      }

      /**
       * Method is called before writing logs message to make it more readable
       *
       * @param   string   $message      Message
       * @param   string   $extension    Extension that caused this log
       *
       * @return  boolean
       */
      public function onLogMessagePrepare(&$message, $extension)
      {
          JPlugin::loadLanguage();

          $extension = array_pop(explode('.', $extension));
          $message_to_array = json_decode($message, true);
          switch ($message_to_array['event']) {
              case 'onContentAfterSave':
              if ($message_to_array['isNew'] == 'false')
              {
                  $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_AFTER_SAVE_MESSAGE', ucfirst($extension));
              }
              else
              {
                  $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_AFTER_SAVE_NEW_MESSAGE', $extension);
              }
              if(!empty($message_to_array['title']))
              {
                  $message = $message .  JText::sprintf('PLG_SYSTEM_USERLOG_TITLED', $message_to_array['title']);
              }
                  break;
              case 'onContentAfterDelete':
                $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_AFTER_DELETE_MESSAGE', ucfirst($extension));
                if(!empty($message_to_array['title']))
                {
                    $message = $message .  JText::sprintf('PLG_SYSTEM_USERLOG_TITLED', $message_to_array['title']);
                }
                break;
              case 'onContentChangeState':
                if ($message_to_array['value'] == 0)
                {
                    $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_CHANGE_STATE_UNPUBLISHED_MESSAGE', ucfirst($extension));
                }
                elseif ($message_to_array['value'] == 1)
                {
                    $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_CHANGE_STATE_PUBLISHED_MESSAGE', ucfirst($extension));
                }
                elseif ($message_to_array['value'] == 2)
                {
                    $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_CHANGE_STATE_ARCHIVED_MESSAGE', ucfirst($extension));
                }
                elseif ($message_to_array['value'] == -2)
                {
                    $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_CONTENT_CHANGE_STATE_TRASHED_MESSAGE', ucfirst($extension));
                }
                break;
              case 'onExtensionAfterInstall':
                  $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_EXTENSION_AFTER_INSTALL_MESSAGE', $message_to_array['extenstion_id']);
                break;
              case 'onExtensionAfterUninstall':
                $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_EXTENSION_AFTER_UNINSTALL_MESSAGE', $message_to_array['extenstion_id']);
                break;
              case 'onExtensionAfterUpdate':
                $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_EXTENSION_AFTER_UPDATE_MESSAGE', $message_to_array['extenstion_id']);
                break;
              case 'onUserAfterSave':
                  if ($message_to_array['isNew'] == 'false')
                  {
                      $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_USER_AFTER_SAVE_MESSAGE', $message_to_array['edited_user']);
                  }
                  else
                  {
                      $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_USER_AFTER_SAVE_NEW_MESSAGE', $message_to_array['edited_user']);
                  }
                  break;
            case 'onUserAfterDelete':
                $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_USER_AFTER_DELETE_MESSAGE', $message_to_array['edited_user']);
                break;
            case 'onUserAfterDeleteGroup':
                $message = JText::sprintf('PLG_SYSTEM_USERLOG_ON_USER_AFTER_DELETE_GROUP_MESSAGE', $message_to_array['deleted_group']);
                break;

          }
      }
}
