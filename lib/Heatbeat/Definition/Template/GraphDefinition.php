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
 * @package     Heatbeat\Definition\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Definition\Template;

use Heatbeat\Definition\Iterator;

/**
 * Iterator for graph definitions
 *
 * @category    Heatbeat
 * @package     Heatbeat\Definition\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class GraphDefinition extends Iterator {

    public function getOptions() {
        
    }

    public function getItems() {
        return new ItemDefinition(parent::current());
    }

    public function getGprints() {
        return new GprintDefinition(parent::current());
    }

    public function getDefs() {
        return new DefDefinition(parent::current());
    }

    public function getCdefs() {
        return new CdefDefinition(parent::current());
    }

    public function getVdefs() {
        return new VdefDefinition(parent::current());
    }

}