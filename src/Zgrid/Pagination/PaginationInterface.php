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

namespace Zgrid\Pagination;

/**
 * Pagination interface
 */
interface PaginationInterface
{		
	/**
	 * Get number of previous page
	 * if current not first
	 * 
	 * @return int | null
	 */
	public function getPrevious();
	
	/**
	 * Get number of next page
	 * if current not last
	 * 
	 * @return int | null
	 */
	public function getNext();
	
	/**
	 * Get number of first page
	 * if current not first
	 * 
	 * @return int | null
	 */
	public function getFirst();
	
	/**
	 * Get number of last page
	 * if current not last
	 * 
	 * @return int | null
	 */
	public function getLast();
	
	/**
	 * Get range of pages
	 * 
	 * @return \Traversable
	 */
	public function getRange();
	
	/**
	 * Get number of current page
	 * 
	 * @return int
	 */
	public function getCurrent();
	
	/**
	 * Get total pages number
	 * 
	 * @return int
	 */
	public function getTotal();
}
