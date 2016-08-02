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
 * View class for a list of logs.
 *
 * @since  1.6
 */
class UserlogsViewUserlogs extends JViewLegacy
{
    /**
	 * An array of items
	 *
	 * @var  array
	 */
	protected $items;

    protected $state;

    public $activeFilters;
    /**
     * Method to display the view.
     *
     * @param   string  $tpl  A template file to load. [optional]
     *
     * @return  void
     *
     * @since   3.6
     */
    public function display($tpl = null)
    {
        if (!JFactory::getUser()->authorise('core.viewlogs', 'com_userlogs'))
		{
			return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
		}

        $this->items     = $this->get('Items');
        $this->state     = $this->get('State');
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
        $this->addToolBar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   3.6
     */
    protected function addToolbar()
    {
        JToolbarHelper::title(JText::_('COM_USERLOGS_MANAGER_USERLOGS'));
        JToolBarHelper::custom('userlogs.exportLogs', 'download', '', 'Export', false);
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
