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

use Heatbeat\Exception\NodeValidationException;

/**
 * Datastore node of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class DatastoreNode extends AbstractNode implements NodeInterface {
    const PREFIX = 'DS';
    private $validTypes = array(
        'GAUGE',
        'COUNTER',
        'DERIVE',
        'ABSOLUTE'
    );

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
        if (!$this->offsetExists('name')) {
            throw new \Heatbeat\Exception\NodeValidationException('Datastore name not defined');
        }
        if (!in_array(strtoupper($this->offsetGet('type')), $this->validTypes)) {
            throw new NodeValidationException(sprintf("Datastore type parameter must be one of these : %s", implode(', ', $this->validTypes)));
        };
        if (!is_int($this->offsetGet('heartbeat'))) {
            throw new NodeValidationException("Datastore heartbeat parameter must be an integer");
        }
        if (!is_int($this->offsetGet('min'))) {
            throw new NodeValidationException("Datastore min parameter must be an integer");
        }
        if (!is_int($this->offsetGet('max'))) {
            throw new NodeValidationException("Datastore max parameter must be an integer");
        }
        return true;
    }

}