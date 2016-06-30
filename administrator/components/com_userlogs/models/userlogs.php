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
 * Methods supporting a list of article records.
 *
 * @since  3.6
 */
class UserlogsModelUserlogs extends JModelList
{
    public function __contruct($config = array())
    {
        if(empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'a.id', 'id',
                'a.extension', 'extension',
                'a.user_id', 'user',
                'a.message', 'message',
                'a.log_date', 'log_date'
            );
        }
        parent::__construct($config);
    }

    /**
	 * Method to auto-populate the model state.
	 *
	 * @return  void
	 */
    protected function populateState($ordering = null, $direction = null)
    {
        $app = JFactory::getApplication('administrator');
        $search = $app->getUserStateFromRequest($this->context . 'filter.search', 'filter_search', '', 'string');
        $this->setState('filter.search', $search);
        $user = $app->getUserStateFromRequest($this->context . 'filter.user', 'filter_user', '', 'string');
        $this->setState('filter.user', $user);
        $extension = $app->getUserStateFromRequest($this->context . 'filter.extension', 'filter_extension', '', 'string');
        $this->setState('filter.extension', $extension);
        $date = $app->getUserStateFromRequest($this->context . 'filter.date', 'filter_date', '', 'string');
        $this->setState('filter.date', $date);
        parent::populateState('a.id', 'desc');
    }

    protected function getListQuery()
    {
        $db    = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select('a.*');
        $query->from($db->quoteName('#__user_logs', 'a'));

        $fullorderCol = $this->state->get('list.fullordering', 'a.id ASC');
        $user = $this->getState('filter.user');
        $extension = $this->getState('filter.extension');
        $search = $this->getState('filter.search');
        $date = $this->getState('filter.date');

        if ($fullorderCol != '')
        {
            $query->order($db->escape($fullorderCol));
        }
        if ($user)
        {
            $query->where($db->quoteName('a.user_id') . ' = ' . (int) $user);
        }
        if ($extension != '')
        {
            $query->where($db->quoteName('a.extension') . ' = ' . $db->quote($extension));
        }
        if (!empty($search))
        {
            $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
			$query->where('(a.message LIKE ' . $search . ')');
        }
        if (!empty($date))
		{
			$query->where($db->quoteName('a.log_date') . ' BETWEEN ' . $db->quote($date. ' 00:00:00') . 'AND' . $db->quote($date. ' 23:59:59'));
		}
        return $query;
    }

}
