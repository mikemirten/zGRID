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

namespace Zgrid\Grid;

use Zgrid\Schema\Field;
use Zgrid\Request\RequestInterface;

/**
 * Table's column
 */
class Column
{
	/**
	 * Field
	 *
	 * @var Field 
	 */
	protected $field;
	
	/**
	 * Request
	 *
	 * @var RequestInterface 
	 */
	protected $request;
	
	/**
	 * Constructor
	 * 
	 * @param Field            $field
	 * @param RequestInterface $request
	 */
	public function __construct(Field $field, RequestInterface $request)
	{
		$this->field   = $field;
		$this->request = $request;
	}
	
	/**
	 * Get name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->field->getName();
	}
	
	/**
	 * Get title
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->field->getTitle();
	}
	
	/**
	 * Get width
	 * 
	 * @return int
	 */
	public function getWidth()
	{
		return $this->field->getWidth();
	}
	
	/**
	 * Is orderable ?
	 * 
	 * @return bool
	 */
	public function isOrderable()
	{
		return $this->field->isOrderable();
	}
	
	/**
	 * Is serchable ?
	 * 
	 * @return bool
	 */
	public function isSearchable()
	{
		return $this->field->isSearchable();
	}
	
	/**
	 * Get order
	 * 
	 * @return string | null
	 */
	public function getOrder()
	{
		return $this->request->getOrderFor($this->getName());
	}
	
	/**
	 * Get search
	 * 
	 * @return string | null
	 */
	public function getSearch()
	{
		return $this->request->getSearchFor($this->getName());
	}
	
	/**
	 * Get value as a string
	 */
	public function __toString()
	{
		return (string) $this->getTitle();
	}
}
