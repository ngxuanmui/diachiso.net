<?php
/**
 * @version		$Id: Info.php 20196 2011-01-09 02:40:25Z ian $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Info table
 *
 * @package		Joomla.Framework
 * @subpackage	com_je_product
 * @since		1.5
 */
class JE_ProductTableInfo extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	1.5
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__je_info', 'id', $_db);
		$this->created = JFactory::getDate()->toMySQL();
	}

	/**
	 * Overloaded check function
	 *
	 * @return	boolean
	 * @see		JTable::check
	 * @since	1.5
	 */
	function check()
	{
		jimport('joomla.filter.output');

		// Set name
		$this->name = htmlspecialchars_decode($this->name, ENT_QUOTES);
		
		// Set alias
		$this->alias = JApplication::stringURLSafe($this->alias);
		if (empty($this->alias)) {
			$this->alias = JApplication::stringURLSafe($this->name);
		}
		
		//post
		$post = JRequest::get('post');
		
		//gmap intergration
		$this->gmap_intergrate = ($post['jform']['gmap_intergrate'] == 1) ? 1 : 0;
		
		// Check the publish down date is not earlier than publish up.
		if (intval($this->publish_down) > 0 && $this->publish_down < $this->publish_up) {
			// Swap the dates.
			$temp = $this->publish_up;
			$this->publish_up = $this->publish_down;
			$this->publish_down = $temp;
		}

		return true;
	}
	/**
	 * method to store a row
	 *
	 * @param boolean $updateNulls True to update fields even if they are null.
	 */
	function store($updateNulls = false)
	{
		if (empty($this->id))
		{
			parent::store($updateNulls);
		}
		else
		{
			// Get the old row
			$oldrow = JTable::getInstance('Info', 'JE_ProductTable');
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}

			// Store the new row
			parent::store($updateNulls);

			// Need to reorder ?
			if ($oldrow->state>=0 && ($this->state < 0))
			{
				// Reorder the oldrow
				$this->reorder('state>=0');
			}
		}
		return count($this->getErrors())==0;
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k) {
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Info','JE_ProductTable');

		// For all keys
		foreach ($pks as $pk)
		{
			// Load the Info
			if(!$table->load($pk))
			{
				$this->setError($table->getError());
			}

			// Verify checkout
			if($table->checked_out==0 || $table->checked_out==$userId)
			{
				// Change the state
				$table->state = $state;
				$table->checked_out=0;
				$table->checked_out_time=0;

				// Check the row
				$table->check();

				// Store the row
				if (!$table->store())
				{
					$this->setError($table->getError());
				}
			}
		}
		return count($this->getErrors())==0;
	}
}

