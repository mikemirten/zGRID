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

/**
 * Cell of table's row
 */
class Cell
{
	/**
	 * Content
	 *
	 * @var mixed
	 */
	private $content;
	
	/**
	 * Field
	 *
	 * @var Field
	 */
	private $field;
	
	/**
	 * Parent row
	 *
	 * @var Row
	 */
	private $row;

	/**
	 * Constructor
	 * 
	 * @param mixed $content
	 */
	public function __construct($content, Field $field)
	{
		$this->content = $content;
		$this->field   = $field;
	}
	
	/**
	 * Set parent row
	 * 
	 * @param  Row $row
	 * @throws \LogicException
	 */
	public function setRow(Row $row)
	{
		if ($this->row !== null) {
			throw new \LogicException('Cell already belongs to a row');
		}
		
		$this->row = $row;
	}

	/**
	 * Get content
	 * 
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}
	
	/**
	 * Get type
	 * 
	 * @return string
	 */
	public function getType()
	{
		return $this->field->getType();
	}
	
	/**
	 * Has link
	 * 
	 * @return bool
	 */
	public function hasLink()
	{
		return $this->field->getCellLink() !== null;
	}
	
	/**
	 * Get url if the cell is a link
	 * 
	 * @return string
	 */
	public function getLink()
	{
		$link = $this->field->getCellLink();
		
		if ($link === null) {
			return;
		}
		
		return preg_replace_callback('~\{([^}]+)\}~', function($matches) {
			if ($this->row === null) {
				throw new \LogicException('Cell doesn\'t belongs to a row');
			}
			
			return $this->row->getMetadataProperty($matches[1]);
		}, $link);
	}

	/**
	 * Get value as a string
	 */
	public function __toString()
	{
		return (string) $this->getContent();
	}
}
