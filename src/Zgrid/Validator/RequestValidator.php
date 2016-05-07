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

namespace Zgrid\Validator;

use Zgrid\Schema\Schema;
use Zgrid\Request\RequestInterface;

/**
 * Request data validator
 */
class RequestValidator
{
	/**
	 * Schema provider
	 *
	 * @var Schema
	 */
	public $schema;
	
	/**
	 * Constructor
	 * 
	 * @param Schema $schema
	 */
	public function __construct(Schema $schema)
	{
		$this->schema = $schema;
	}
	
	/**
	 * Validate request
	 * 
	 * @param RequestInterface $request
	 */
	public function validate(RequestInterface $request)
	{
		$errors = [];
		
		$this->validateOrder($request, $errors);
		$this->validateSearch($request, $errors);
		
		return $errors;
	}
	
	/**
	 * Validate order
	 * 
	 * @param RequestInterface $request
	 * @param array            $errors
	 */
	protected function validateOrder(RequestInterface $request, array &$errors)
	{
		foreach ($request->getOrder() as $field => $value) {
			if (! $this->schema->hasField($field)) {
				$errors[] = sprintf('Order cannot be applied to non-existent field "%s"', $field);
				continue;
			}
			
			if (! $this->schema->getField($field)->isOrderable()) {
				$errors[] = sprintf('Field "%s" is not orderable', $field);
			}
			
			if ($value !== RequestInterface::ORDER_ASC && $value !== RequestInterface::ORDER_DESC) {
				$errors[] = sprintf('Invalid order direction "%s" specified for the field "%s"', $value, $field);
			}
		}
	}
	
	/**
	 * Validate search
	 * 
	 * @param RequestInterface $request
	 * @param array            $errors
	 */
	protected function validateSearch(RequestInterface $request, array &$errors)
	{
		foreach ($request->getSearch() as $field => $value) {
			if (! $this->schema->hasField($field)) {
				$errors[] = sprintf('Search cannot be applied to non-existent field "%s"', $field);
				continue;
			}
			
			if (! $this->schema->getField($field)->isSearchable()) {
				$errors[] = sprintf('Field "%s" is not searchable', $field);
			}
			
			if (empty($value)) {
				$errors[] = sprintf('Search string of field "%s" is empty', $value, $field);
			}
		}
	}
}
