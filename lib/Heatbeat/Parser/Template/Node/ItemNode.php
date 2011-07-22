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
 * Item node of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template\Node
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class ItemNode extends AbstractNode implements NodeInterface {

    const STACK = 'STACK';

    public function getAsString() {
        $item = array(
            $this->offsetGet('type'),
            $this->offsetGet('definition-name') . chr(35) . $this->offsetGet('color'),
            $this->offsetGet('legend')
        );
        if ($this->offsetGet('stack') == true)
            array_push($item, self::STACK);
        return implode(self::SEPERATOR, $item);
    }

    public function validate() {
        $this->isDefined('type');
        $this->isValidGraphType('type');
        $this->isDefined('definition-name');
        $this->isValidName('definition-name');
        $this->isDefined('color');
        $this->isValidColor('color');
        $this->isDefined('legend');
        $this->isDefined('stack');
        return true;
    }

}