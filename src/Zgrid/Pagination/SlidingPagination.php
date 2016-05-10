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

use Zgrid\DataProvider\DataProviderInterface;
use Zgrid\Request\RequestInterface;

/**
 * Sliding pagination
 */
class SlidingPagination implements PaginationInterface, \IteratorAggregate
{
	/**
	 * Slider range size
	 *
	 * @var int
	 */
	protected $rangeSize = 10;
	
	/**
	 * Data provider
	 *
	 * @var DataProviderInterface
	 */
	protected $dataProvider;
	
	/**
	 * Request
	 *
	 * @var RequestInterface 
	 */
	protected $request;
	
	/**
	 * Current page number
	 *
	 * @var int 
	 */
	private $current;
	
	/**
	 * Total pages number
	 *
	 * @var int
	 */
	private $total;
	
	/**
	 * Constructor
	 * 
	 * @param DataProviderInterface $dataProvider
	 * @param RequestInterface      $request
	 */
	public function __construct(DataProviderInterface $dataProvider, RequestInterface $request)
	{
		$this->dataProvider = $dataProvider;
		$this->request      = $request;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getTotal()
	{
		if ($this->total === null) {
			$totalRows = $this->dataProvider->getTotal();
			
			if ($totalRows === 0) {
				return 0;
			}
			
			$limit = $this->request->getLimit();
			
			$this->total = $totalRows > $limit
				? (int) ceil($totalRows / $limit)
				: 1;
		}
		
		return $this->total;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getCurrent()
	{
		if ($this->current === null) {
			$page  = $this->request->getPage();
			$total = $this->getTotal();
			
			$this->current = ($page > $total) ? $total : $page;
		}
		
		return $this->current;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getNext()
	{
		$current = $this->getCurrent();
		
		if ($current < $this->getTotal()) {
			return $current + 1;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPrevious()
	{
		$current = $this->getCurrent();
		
		if ($current > 1) {
			return $current - 1;
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getFirst()
	{
		if ($this->getCurrent() > 1) {
			return 1;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLast()
	{
		$total = $this->getTotal();
		
		if ($this->getCurrent() < $total) {
			return $total;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRange()
	{
		$total   = $this->getTotal();
		$current = $this->getCurrent();
		
		if ($total > $this->rangeSize) {
			$middle = (int) ceil($this->rangeSize / 2);
			
			if ($current - $middle > $total - $this->rangeSize) {
				return $this->buildRange($total - $this->rangeSize + 1, $total);
			}
			
			if ($current - $middle < 0) {
				$middle = $current;
			}
			
			$offset = $current - $middle;
			
			return $this->buildRange($offset + 1, $offset + $this->rangeSize);
		}
		
		return $this->buildRange(1, $total);
	}
	
	/**
	 * Build range
	 * 
	 * @param  int $lower
	 * @param  int $upper
	 * @return \Traversable	
 */
	protected function buildRange($lower, $upper)
	{
		$range = new \SplDoublyLinkedList();
		
		for ($i = $lower; $i <= $upper; ++ $i) {
			$range[] = $i;
		}
		
		return $range;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return $this->getRange();
	}
}