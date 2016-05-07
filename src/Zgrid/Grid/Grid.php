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
use Zgrid\Validator\RequestValidator;
use Zgrid\Schema\Schema;

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
	 * Rows
	 *
	 * @var Row[]
	 */
	private $rows;

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
			$requestValidator = new RequestValidator($this->getSchema());
			$errors = $requestValidator->validate($this->request);

			if (! empty($errors)) {
				throw new \LogicException(implode(', ', $errors));
			}

			$this->rows = $this->source->getData($this->request);

			if (! $this->rows instanceof \Traversable) {
				throw new \RuntimeException('Data provider must provide data as a Traversable instance');
			}
		}

		return $this->rows;
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
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return $this->getRows();
	}
}
