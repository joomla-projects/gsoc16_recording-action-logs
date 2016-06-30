<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_userlogs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;
JFormHelper::loadFieldClass('list');
/**
 * Field to load a list of all users that have logged actions
 */
class JFormFieldExtension extends JFormFieldList
{

    /**
    * The form field type.
    *
    * @var     string
    * @since   1.6
    */
   protected $type = 'extension';

   public function getOptions()
   {
       $db = JFactory::getDbo();
       $query = $db->getQuery(true);
       $query->select('DISTINCT b.extension');
       $query->from($db->quoteName('#__user_logs', 'b'));
       $db->setQuery($query);
       $extensions = $db->loadObjectList();
       $options = array();
       foreach ($extensions as $e) {
           $options[] = JHtml::_('select.option', $e->extension);
        }
        $options = array_merge(parent::getOptions(), $options);
       return $options;
   }

}
