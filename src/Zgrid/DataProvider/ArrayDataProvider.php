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

namespace Zgrid\DataProvider;

use Zgrid\Request\RequestInterface;

use Zgrid\Schema\Schema;
use Zgrid\Schema\Field;

use Zgrid\Grid\Row;
use Zgrid\Grid\Cell;

/**
 * Array source data provider
 */
class ArrayDataProvider implements DataProviderInterface
{
	/**
	 * DataProvider
	 *
	 * @var array
	 */
	private $source;

	/**
	 * Constructor
	 * 
	 * @param array $source
	 */
	public function __construct(array $source)
	{
		$this->source = $source;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getData(RequestInterface $request)
	{
		$data = new \SplDoublyLinkedList();
		
		$source = array_slice(
			$this->source,
			$request->getLimit() * ($request->getPage() - 1),
			$request->getLimit()
		);
		
		foreach ($source as $rowData) {
			$row = new Row();

			foreach ($rowData as $cellData) {
				$row->appendCell(new Cell($cellData));
			}

			$data[] = $row;
		}

		return $data;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getTotal()
	{
		return count($this->source);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSchema()
	{
		$colsNumber = 0;

		foreach ($this->source as $row) {
			$count = count($row);

			if ($count > $colsNumber) {
				$colsNumber = $count;
			}
		}

		$schema = new Schema();

		if ($colsNumber === 0) {
			return $schema;
		}

		$colSize = (int) round(100 / $colsNumber);

		for ($i = 0; $i < $colsNumber; ++ $i) {
			$field = new Field($i);
			$field->setWidth($colSize);

			$schema->addField($field);
		}

		return $schema;
	}

}
