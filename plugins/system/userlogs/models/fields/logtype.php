<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_userlogs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('checkboxes');

/**
 * Field to load a list of all users that have logged actions
 *
 * @since 3.6
 */
class JFormFieldLogType extends JFormFieldCheckboxes
{
    /**
     * The form field type.
     *
     * @var     string
     * @since   3.6
     */
    protected $type = 'logtype';

    public function getOptions()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('b.extension');
        $query->from($db->quoteName('#__user_logs_extensions', 'b'));
        $db->setQuery($query);
        $extensions = $db->loadObjectList();
        $options = array();
        $defaults = array();

        foreach ($extensions as $e)
        {
            $tmp = array(
                'checked' => true,
            );
            $defaults[] = $e->extension;
            $option = JHtml::_('select.option', $e->extension, $this->translateExtensionName($e->extension));
            $options[] = (object) array_merge($tmp, (array) $option);
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
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
    protected function translateExtensionName($extension)
    {
        $lang = JFactory::getLanguage();
        $source = JPATH_ADMINISTRATOR . '/components/' . $extension;

        $lang->load("$extension.sys", JPATH_ADMINISTRATOR, null, false, true)
         ||	$lang->load("$extension.sys", $source, null, false, true);

        return JText::_($extension);
     }
}
