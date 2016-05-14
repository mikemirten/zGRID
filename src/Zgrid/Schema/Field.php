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
 * Field of schema
 */
class Field
{
	/**
	 * Name
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Title
	 *
	 * @var string
	 */
	private $title;
	
	/**
	 * Type of field
	 *
	 * @var string
	 */
	private $type;

	/**
	 * width
	 * 
	 * @var int
	 */
	private $width;

	/**
	 * Property name
	 *
	 * @var string
	 */
	private $property;

	/**
	 * Orderable by the field
	 *
	 * @var bool 
	 */
	private $orderable = false;
	
	/**
	 * Order by properties
	 *
	 * @var array
	 */
	private $orderBy = [];

	/**
	 * Searchable by the field
	 *
	 * @var bool
	 */
	private $searchable = false;
	
	/**
	 * Search by properties
	 *
	 * @var array
	 */
	private $searchBy = [];

	/**
	 * Involved in global search
	 *
	 * @var bool
	 */
	private $globalSearchable = false;
	
	/**
	 * Priority
	 * 
	 * @var int
	 */
	private $priority = 0;
	
	/**
	 * On cell click url
	 *
	 * @var string 
	 */
	private $cellLink;

	/**
	 * Constructor
	 * 
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * Get name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Set cell link
	 * 
	 * @param string $link
	 */
	public function setCellLink($link)
	{
		$this->cellLink = $link;
	}
	
	/**
	 * Get cell link
	 * 
	 * @return string | null
	 */
	public function getCellLink()
	{
		return $this->cellLink;
	}

	/**
	 * Set title
	 * 
	 * @param type $title
	 */
	public function setTitle($title)
	{
		return $this->title = $title;
	}

	/**
	 * Get title
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		if ($this->title === null) {
			return ucwords(preg_replace('~([a-z]+)([A-Z]+)~', '$1 $2', $this->name));
		}

		return $this->title;
	}
	
	/**
	 * Set type
	 * 
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
	
	/**
	 * Get type
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set width
	 * 
	 * @param int $width
	 */
	public function setWidth($width)
	{
		$this->width = $width;
	}

	/**
	 * Get width
	 * 
	 * @return int
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * Set property name
	 * 
	 * @param string $property
	 */
	public function setProperty($property)
	{
		$this->property = $property;
	}

	/**
	 * Get property
	 * 
	 * @return string
	 */
	public function getProperty()
	{
		return $this->property;
	}

	/**
	 * Set orderable
	 * 
	 * @param bool $orderable
	 */
	public function setOrderable($orderable = true)
	{
		$this->orderable = $orderable;
	}

	/**
	 * Is orderable ?
	 * 
	 * @return bool
	 */
	public function isOrderable()
	{
		return $this->orderable;
	}
	
	/**
	 * Set order by
	 * 
	 * @param array $orderBy
	 */
	public function setOrderBy(array $orderBy)
	{
		$this->orderBy = $orderBy;
	}

	/**
	 * Get order by
	 * 
	 * @return array
	 */
	public function getOrderBy()
	{
		return $this->orderBy;
	}
	
	/**
	 * Set searchable
	 * 
	 * @param bool $searchable
	 */
	public function setSearchable($searchable = true)
	{
		$this->searchable = $searchable;
	}

	/**
	 * Is serchable ?
	 * 
	 * @return bool
	 */
	public function isSearchable()
	{
		return $this->searchable;
	}
	
	/**
	 * Set "search by" properties
	 * 
	 * @param array $searchBy
	 */
	public function setSearchBy(array $searchBy)
	{
		$this->searchBy = $searchBy;
	}
	
	/**
	 * Get "search by" properties
	 * 
	 * @return array
	 */
	public function getSearchBy()
	{
		return $this->searchBy;
	}

	/**
	 * Set globally searchable
	 * 
	 * @param bool $searchable
	 */
	public function setGloballySearchable($searchable = true)
	{
		$this->globalSearchable = $searchable;
	}

	/**
	 * Is globally serchable ?
	 * 
	 * @return bool
	 */
	public function isGloballySearchable()
	{
		return $this->globalSearchable;
	}
	
	/**
	 * Set priority
	 * 
	 * @param int $priority
	 */
	public function setPriority($priority)
	{
		$this->priority = (int) $priority;
	}
	
	/**
	 * Get priority
	 * 
	 * @return int
	 */
	public function getPriority()
	{
		return $this->priority;
	}
}
