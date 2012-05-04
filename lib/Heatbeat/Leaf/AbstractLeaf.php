<?php

/**
 * Copyright 2012 Osman Ungur
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); 
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at 
 *
 *          http://www.apache.org/licenses/LICENSE-2.0 
 *
 * Unless required by applicable law or agreed to in writing, software 
 * distributed under the License is distributed on an "AS IS" BASIS, 
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. 
 * See the License for the specific language governing permissions and 
 * limitations under the License. 
 *
 * @category    Heatbeat
 * @package     Heatbeat\Leaf
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2012 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Leaf;

use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\ConstraintValidatorFactory;

/**
 * Class that abstracts leafs
 *
 * @category    Heatbeat
 * @package     Heatbeat\Leaf
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class AbstractLeaf {

    private $values;

    function __construct(array $values) {
        $this->values = array_merge($this->getDefaultValues(), $values);
    }

    /**
     * Validates values with validation rules
     * 
     * @return boolean
     * @throws LeafValidationException 
     */
    public function validate() {
        $validator = new Validator(
                        new ClassMetadataFactory(new StaticMethodLoader()),
                        new ConstraintValidatorFactory()
        );
        $violations = $validator->validateValue($this->values, $this->getValidationRules());

        if ($violations->count()) {
            $violation = $violations->offsetGet(0);
            throw new LeafValidationException(
                    sprintf('Leaf validation error at %s%s with message: %s', get_class($this), $violation->getPropertyPath(), $violation->getMessage())
            );
        }
        return true;
    }

    /**
     * Returns value of key, when key not found returns false
     * 
     * @param type $key
     * @return boolean|mixed
     */
    public function getValue($key) {
        if (array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }
        throw new \UnexpectedValueException(sprintf('Provided field %s was not found', $key));
    }

    /**
     * Returns default values for leaf
     * @return array
     */
    public function getDefaultValues() {
        return array();
    }

    /**
     * Returns valid datastore types
     * @return array
     */
    public function getValidDatastoreTypes() {
        return array(
            'GAUGE',
            'COUNTER',
            'DERIVE',
            'ABSOLUTE'
        );
    }

}