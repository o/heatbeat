<?php

/**
 * Copyright 2011 Osman Ungur
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
 * @package     Heatbeat\Parser
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser;

/**
 * Class for validating YAML template nodes.
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Validator {

    /**
     * Returns parameter is a valid alphanumeric value
     * 
     * @param string $value
     * @return bool 
     */
    public function isAlphanum($value) {
        return (bool) filter_var(
                $value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/"))
        );
    }

    /**
     * Returns parameter is a valid hex value
     * 
     * @param mixed $value
     * @return bool 
     */
    public function isHex($value) {
        return filter_var(
                $value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/[^0-9a-fA-F]/"))
        );
    }

    /**
     * Returns parameter is blank (like Rails blank)
     * 
     * @param mixed $value
     * @return bool 
     */
    public function isBlank($value) {
        return empty($value) && !is_numeric($value);
    }

    /**
     * Returns parameter is valid int and greater / equal to 0
     * 
     * @param int $value
     * @return bool 
     */
    public function isInt($value) {
        return filter_var($value, FILTER_VALIDATE_INT) === 0 OR !filter_var($value, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0))) === false;
    }

    /**
     * Returns an array has a specified key.
     * 
     * @param mixed $key
     * @param array $searcharray
     * @return type 
     */
    public function hasArrayKey($key, array $searcharray) {
        if (!(is_integer($key) || is_string($key))) {
            return false;
        }
        return array_key_exists($key, $searcharray);
    }

}