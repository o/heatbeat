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
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser\Template\Node;

/**
 * Datastore node of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class DatastoreNode extends AbstractNode implements NodeInterface {
    const PREFIX = 'DS';

    public function getAsString() {
        return implode(self::SEPERATOR, array(
            self::PREFIX,
            $this->offsetGet('name'),
            strtoupper($this->offsetGet('type')),
            $this->offsetGet('heartbeat'),
            $this->offsetGet('min'),
            $this->offsetGet('max')
        ));
    }

    public function validate() {
        $this->isDefined('name');
        $this->isDefined('type');
        $this->isValidType('type');
        $this->isDefined('min');
        $this->isValidInt('min');
        $this->isDefined('max');
        $this->isValidInt('max');
        $this->isDefined('heartbeat');
        $this->isValidInt('heartbeat');
        return true;
    }

}