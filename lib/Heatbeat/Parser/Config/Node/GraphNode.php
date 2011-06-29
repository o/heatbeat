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
 * @package     Heatbeat\Parser\Config\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser\Config\Node;

/**
 * Graph node of config
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Config\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class GraphNode extends AbstractNode implements NodeInterface {

    const FILENAME_SEPERATOR = '-';
    
    public function validate() {
        $this->isDefined('plugin');
        $this->isDefined('enabled');
        return true;
    }

    private function getHash() {
        return substr(sha1(serialize($this)), 0, 8);
    }
    
    public function getRRDFilename() {
        return $this->offsetGet('plugin') . self::FILENAME_SEPERATOR . $this->getHash();
    }

}