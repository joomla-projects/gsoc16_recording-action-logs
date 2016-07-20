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
    }
}
