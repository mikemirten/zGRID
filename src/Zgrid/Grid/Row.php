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

/**
 * Row of table
 */
class Row implements \IteratorAggregate
{
	/**
	 * Cells of row
	 *
	 * @var \SplDoublyLinkedList 
	 */
	private $cells;
	
	/**
	 * Metadata
	 *
	 * @var array
	 */
	private $metadata = [];

	/**
	 * Constructor
	 * 
	 * @param array | \Traversable $cells
	 */
	public function __construct($cells = null)
	{
		if ($cells instanceof \SplDoublyLinkedList) {
			$this->cells = $cells;
			
			foreach ($cells as $cell) {
				$cell->setRow($this);
			}
			
			return;
		}

		$this->cells = new \SplDoublyLinkedList();

		if ($cells !== null) {
			foreach ($cells as $cell) {
				$this->appendCell($cell);
			}
		}
	}

	/**
	 * Append cell
	 * 
	 * @param Cell $cell
	 */
	public function appendCell(Cell $cell)
	{
		$cell->setRow($this);
		
		$this->cells->push($cell);
	}

	/**
	 * Prepend cell
	 * 
	 * @param Cell $cell
	 */
	public function prependCell(Cell $cell)
	{
		$cell->setRow($this);
		
		$this->cells->unshift($cell);
	}
	
	/**
	 * Set metadata property
	 * 
	 * @param string $name
	 * @param mixed  $value
	 */
	public function setMetadataProperty($name, $value)
	{
		$this->metadata[$name] = $value;
	}
	
	/**
	 * Get metadata property
	 * 
	 * @param  string $name
	 * @return mixed
	 */
	public function getMetadataProperty($name)
	{
		if (isset($this->metadata[$name])) {
			return $this->metadata[$name];
		}
		
		throw new \LogicException(sprintf('Metadata property "%s" not found', $name));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return $this->cells;
	}
}
