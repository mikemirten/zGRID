<?php

/**
 * zGRID core library https://github.com/mikemirten/zGRID
 * Copyright (C) 2016 Mike.Mirten
 * 
 * LICENSE
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright (c) 2016, Mike.Mirten
 * @license   http://www.gnu.org/licenses/gpl.html GPL License
 * @category  zGRID
 * @version   1.0
 */

namespace Zgrid\Schema;

/**
 * Data schema
 */
class Schema implements \IteratorAggregate
{
	/**
	 * Fields
	 *
	 * @var Field[]
	 */
	private $fields = [];
	
	/**
	 * Fields sorder by priority
	 *
	 * @var Field[] 
	 */
	private $sortedFields;
	
	/**
	 * Metadata properties list
	 *
	 * @var array
	 */
	private $metadataProperties = [];

	/**
	 * Add field
	 * 
	 * @param  Field $field
	 * @throws \LogicException
	 */
	public function addField(Field $field)
	{
		$name = $field->getName();

		if (isset($this->fields[$name])) {
			throw new \LogicException(sprintf('Field "%s" already exists', $name));
		}

		$this->fields[$name] = $field;
		$this->sortedFields  = null;
	}

	/**
	 * Has field
	 * 
	 * @return bool
	 */
	public function hasField($name)
	{
		return isset($this->fields[$name]);
	}

	/**
	 * Get field
	 * 
	 * @return Field
	 * @throws \LogicException
	 */
	public function getField($name)
	{
		if (! isset($this->fields[$name])) {
			throw new \LogicException(sprintf('Field "%s" does not exists', $name));
		}

		return $this->fields[$name];
	}

	/**
	 * Get fields
	 * 
	 * @return Field[]
	 */
	public function getFields() {
		if ($this->sortedFields === null) {
			$queue = new \SplPriorityQueue();
			
			foreach (array_reverse($this->fields) as $field) {
				$queue->insert($field, $field->getPriority());
			}
			
			$this->sortedFields = iterator_to_array($queue);
		}
		
		return $this->sortedFields;
	}

	/**
	 * Has at least one orderable field
	 * 
	 * @return bool
	 */
	public function hasOrderable()
	{
		foreach ($this->fields as $field) {
			if ($field->isOrderable()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Has at least one searchable field
	 * 
	 * @return bool
	 */
	public function hasSearchable()
	{
		foreach ($this->fields as $field) {
			if ($field->isSearchable()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Has at least one field involved in global search ?
	 * 
	 * @return bool
	 */
	public function hasGloballySearchable()
	{
		foreach ($this->fields as $field) {
			if ($field->isGloballySearchable()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get globally searchable fild names
	 * 
	 * @return array
	 */
	public function getGloballySearchableNames()
	{
		$names = [];

		foreach ($this->fields as $field) {
			if ($field->isGloballySearchable()) {
				$names[] = $field->getName();
			}
		}

		return $names;
	}
	
	/**
	 * Add metadata property
	 * 
	 * @param string $name
	 */
	public function addMetadataProperty($name)
	{
		$this->metadataProperties[] = $name;
	}
	
	/**
	 * Get metadata properties
	 * 
	 * @return array
	 */
	public function getMetadataProperties()
	{
		return $this->metadataProperties;
	}

	/**
	 * Is the schema empty ?
	 * 
	 * @return bool
	 */
	public function isEmpty()
	{
		return ! empty($this->fields);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->getFields());
	}
}
