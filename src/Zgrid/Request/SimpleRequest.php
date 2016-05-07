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

namespace Zgrid\Request;

/**
 * Simple request container
 */
class SimpleRequest implements RequestInterface
{
	/**
	 * Limit
	 *
	 * @var int
	 */
	private $limit = self::DEFAULT_LIMIT;
	
	/**
	 * Offset
	 *
	 * @var int
	 */
	private $offset = self::DEFAULT_OFFSET;
	
	/**
	 * Orders' set
	 *
	 * @var array
	 */
	private $order = [];
	
	/**
	 * Searches' set
	 *
	 * @var array
	 */
	private $search = [];
	
	/**
	 * Global search
	 *
	 * @var string
	 */
	private $globalSearch;
	
	/**
	 * Set limit
	 * 
	 * @param  int $limit
	 * @return SimpleRequest
	 */
	public function setLimit($limit)
	{
		$this->limit = (int) $limit;
		
		return $this;
	}
	
	/**
	 * Set offset
	 * 
	 * @param  int $offset
	 * @return SimpleRequest
	 */
	public function setOffset($offset)
	{
		$this->offset = $offset;
		
		return $this;
	}
	
	/**
	 * Set order by property
	 * 
	 * @param  string $property
	 * @param  string $direction
	 * @return SimpleRequest
	 */
	public function setOrderBy($property, $direction = self::ORDER_ASC)
	{
		$this->order[trim($property)] = strtolower(trim($direction));
		
		return $this;
	}
	
	/**
	 * Set search by property
	 * 
	 * @param  string $property
	 * @param  string $string
	 * @return SimpleRequest
	 */
	public function setSearchBy($property, $string)
	{
		$this->search[trim($property)] = (string) $string;
		
		return $this;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getGlobalSearch()
	{
		return $this->globalSearch;
	}

	/**
     * {@inheritdoc}
     */
	public function getLimit()
	{
		return $this->getLimit();
	}

	/**
     * {@inheritdoc}
     */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
     * {@inheritdoc}
     */
	public function getOrder()
	{
		return $this->order;
	}

	/**
     * {@inheritdoc}
     */
	public function getOrderFor($name)
	{
		if (isset($this->order[$name])) {
			return $this->order[$name];
		}
	}

	/**
     * {@inheritdoc}
     */
	public function getSearch()
	{
		return $this->search;
	}

	/**
     * {@inheritdoc}
     */
	public function getSearchFor($name)
	{
		if (isset($this->search[$name])) {
			return $this->search[$name];
		}
	}
}