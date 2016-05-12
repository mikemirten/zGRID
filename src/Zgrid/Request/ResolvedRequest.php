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

use Zgrid\Schema\Schema;

/**
 * Request with data resolved by original orequest and schema
 */
class ResolvedRequest implements RequestInterface
{
	/**
	 * Origin request
	 *
	 * @var RequestInterface
	 */
	protected $request;
	
	/**
	 * Schema
	 *
	 * @var Schema
	 */
	protected $schema;
	
	/**
	 * Resolved order
	 *
	 * @var array 
	 */
	protected $order;
	
	/**
	 * Resolved search
	 *
	 * @var array
	 */
	protected $search;
	
	/**
	 * Constructor
	 * 
	 * @param RequestInterface $request
	 * @param Schema $schema
	 */
	public function __construct(RequestInterface $request, Schema $schema)
	{
		$this->request = $request;
		$this->schema  = $schema;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getGlobalSearch()
	{
		return $this->request->getGlobalSearch();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLimit()
	{
		return $this->request->getLimit();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrder()
	{
		if ($this->order === null) {
			$this->order = [];
			
			foreach ($this->request->getOrder() as $name => $direction)
			{
				$orderBy = $this->schema->getField($name)->getOrderBy();
				
				if (empty($orderBy)) {
					$this->order[$name] = $direction;
				}
				
				$this->order = array_replace(
					$this->order,
					array_fill_keys($orderBy, $direction)
				);
			}
		}
		
		return $this->order;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOrderFor($name)
	{
		$order = $this->getOrder();

		if (isset($order[$name])) {
			return $order[$name];
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPage()
	{
		return $this->request->getPage();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSearch()
	{
		if ($this->search === null) {
			$this->search = [];

			foreach ($this->request->getSearch() as $name => $string)
			{
				$searchBy = $this->schema->getField($name)->getSearchBy();

				if (empty($searchBy)) {
					$this->search[$name] = $string;
					continue;
				}

				$this->search[] = array_fill_keys($searchBy, $string);
			}
		}
		
		return $this->search;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSearchFor($name)
	{
		$search = $this->getSearch();

		if (isset($search[$name])) {
			return $search[$name];
		}
	}
}
