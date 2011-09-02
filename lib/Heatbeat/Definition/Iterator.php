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
 * @package     Heatbeat\Definition
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Definition;

/**
 * Zero-index based simple iterator used for traversing nodes in definitions
 *
 * @category    Heatbeat
 * @package     Heatbeat\Definition
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Iterator implements \Iterator, \Countable {

    private $storage = array();
    private $index = 0;

    function __construct($storage = null) {
        $this->storage = $storage;
    }

    public function rewind() {
        $this->index = 0;
    }

    public function valid() {
        return isset($this->storage[$this->index]);
    }

    public function key() {
        return $this->index;
    }

    public function current() {
        return $this->storage[$this->index];
    }

    public function next() {
        return $this->index++;
    }

    public function count() {
        return count($this->storage);
    }

    public function push($value) {
        return array_push($this->storage, $value); 
    }

}

?>
