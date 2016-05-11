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

interface RequestInterface
{
	const DEFAULT_LIMIT = 25;
	const DEFAULT_PAGE  = 1;

	const ORDER_ASC  = 'asc';
	const ORDER_DESC = 'desc';

	/**
	 * Get limit per page
	 * 
	 * @return int
	 */
	public function getLimit();

	/**
	 * Get page number
	 * 
	 * @return int
	 */
	public function getPage();

	/**
	 * Get order
	 * 
	 * [
	 *     property1 => direction1,
	 *     property2 => direction2
	 * ]
	 * 
	 * @return array
	 */
	public function getOrder();

	/**
	 * Get order direction for property
	 * 
	 * @param  string $name
	 * @return string | null
	 */
	public function getOrderFor($name);

	/**
	 * Get search
	 * 
	 * [
	 *     property1 => search1,
	 *     property2 => search2
	 * ]
	 * 
	 * @return array
	 */
	public function getSearch();

	/**
	 * Get search string for property
	 * 
	 * @param  string $name
	 * @return string | null
	 */
	public function getSearchFor($name);

	/**
	 * Get global search
	 * 
	 * @return string | null
	 */
	public function getGlobalSearch();
}
