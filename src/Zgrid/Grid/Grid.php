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

use Zgrid\DataProvider\DataProviderInterface;
use Zgrid\Request\RequestInterface;
use Zgrid\Request\SimpleRequest;
use Zgrid\Request\ResolvedRequest;
use Zgrid\Validator\RequestValidator;
use Zgrid\Schema\Schema;
use Zgrid\Pagination\SlidingPagination;
use Zgrid\Exception\InvalidRequest;

/**
 * GRID core
 */
class Grid implements \IteratorAggregate
{
	/**
	 * DataProvider
	 *
	 * @var DataProviderInterface
	 */
	protected $source;

	/**
	 * Request
	 *
	 * @var RequestInterface 
	 */
	protected $request;
	
	/**
	 * Resolved request
	 * Contains data resolved by original request and schema
	 *
	 * @var RequestInterface 
	 */
	protected $resolvedRequest;

	/**
	 * Rows
	 *
	 * @var Row[]
	 */
	private $rows;
	
	/**
	 * Total rows number
	 *
	 * @var int
	 */
	private $totalRows;

	/**
	 * Schema
	 *
	 * @var Schema 
	 */
	private $schema;

	/**
	 * Columns
	 *
	 * @var Column[]
	 */
	private $columns;

	/**
	 * Title
	 *
	 * @var string
	 */
	private $title;
	
	/**
	 * Pagination
	 *
	 * @var \Zgrid\Pagination\PaginationInterface 
	 */
	private $pagination;

	/**
	 * Constructor
	 * 
	 * @param DataProviderInterface $source
	 */
	public function __construct(DataProviderInterface $source, RequestInterface $request = null)
	{
		if ($request === null) {
			$request = new SimpleRequest();
		}

		$this->source  = $source;
		$this->request = $request;
	}

	/**
	 * Set title
	 * 
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * Get title
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Is GRID globally searchable ?
	 * 
	 * @return bool
	 */
	public function isGloballySearchable()
	{
		return $this->getSchema()->hasGloballySearchable();
	}

	/**
	 * Get global search string if defined
	 * 
	 * @return string | null
	 */
	public function getGlobalSearch()
	{
		return $this->request->getGlobalSearch();
	}

	/**
	 * Get rows
	 * 
	 * @return Rows[] Traversable
	 */
	public function getRows()
	{
		if ($this->rows === null) {
			$this->rows = $this->source->getData($this->getResolvedRequest());

			if (! $this->rows instanceof \Traversable) {
				throw new \RuntimeException('Data provider must provide data as a Traversable instance');
			}
		}

		return $this->rows;
	}
	
	/**
	 * Get resolved request
	 * Contains data resolved by original request and schema
	 * 
	 * @return RequestInterface
	 */
	protected function getResolvedRequest()
	{
		if ($this->resolvedRequest === null) {
			$schema = $this->getSchema();
			
			$requestValidator = new RequestValidator($schema);
			$errors = $requestValidator->validate($this->request);
			
			if (! empty($errors)) {
				throw new InvalidRequest(implode(', ', $errors));
			}
			
			$this->resolvedRequest = new ResolvedRequest($this->request, $schema);
		}
		
		return $this->resolvedRequest;
	}

	/**
	 * Get columns
	 * 
	 * @return Column[]
	 */
	public function getColumns()
	{
		if ($this->columns === null) {
			$this->columns = new \SplDoublyLinkedList();

			foreach ($this->getSchema()->getFields() as $field) {
				$this->columns[] = new Column($field, $this->request);
			}
		}

		return $this->columns;
	}
	
	/**
	 * Get total number of records found by request
	 * 
	 * @return int
	 */
	public function getTotal()
	{
		if ($this->totalRows === null) {
			$this->totalRows = $this->source->getTotal($this->getResolvedRequest());
		}
		
		return $this->totalRows;
	}

	/**
	 * Get schema
	 * 
	 * @return Schema
	 */
	public function getSchema()
	{
		if ($this->schema === null) {
			$this->schema = $this->source->getSchema();
		}

		return $this->schema;
	}
	
	/**
	 * Get pagination
	 * 
	 * @return \Zgrid\Pagination\PaginationInterface
	 */
	public function getPagination()
	{
		if ($this->pagination === null) {
			$this->pagination = new SlidingPagination(
				$this->source,
				$this->getResolvedRequest()
			);
		}
		
		return $this->pagination;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return $this->getRows();
	}
}
