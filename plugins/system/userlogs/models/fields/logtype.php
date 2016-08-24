<?php
/**
 * @package	 Joomla.Administrator
 * @subpackage  System.userlogs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license	 GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('checkboxes');
JLoader::register('UserlogsHelper', JPATH_ADMINISTRATOR . '/components/com_userlogs/helpers/userlogs.php');

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
	 * @var	 string
	 * @since   3.6
	 */
	protected $type = 'logtype';

	public function getOptions()
	{
		// $db = JFactory::getDbo();
		// $query = $db->getQuery(true);
		// $query->select('b.extension');
		// $query->from($db->quoteName('#__user_logs_extensions', 'b'));
		// $db->setQuery($query);
		// $extensions = $db->loadObjectList();
		$extensions = array(
			"com_banners","com_cache","com_categories","com_config","com_contact","com_content","com_installer"
			,"com_media","com_menus","com_messages","com_modules","com_newsfeeds","com_plugins","com_redirect"
			,"com_tags","com_templates","com_users");
		$options = array();
		$defaults = array();

		foreach ($extensions as $e)
		{
			$tmp = array(
				'checked' => true,
			);
			$defaults[] = $e;
			$option = JHtml::_('select.option', $e, UserlogsHelper::translateExtensionName($e));
			$options[] = (object) array_merge($tmp, (array) $option);
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
