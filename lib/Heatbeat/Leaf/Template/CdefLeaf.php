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
 * @package     Heatbeat\Leaf\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2012 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Leaf\Template;

use Heatbeat\Leaf\AbstractLeaf;
use Heatbeat\Leaf\LeafInterface;
use Heatbeat\Leaf\StringableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CDEF leaf of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Leaf\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class CDefLeaf extends AbstractLeaf implements LeafInterface, StringableInterface {

    const PREFIX = 'CDEF';

    public function getAsString() {
        return self::PREFIX . self::SEPERATOR . $this->getValue('name') . self::EQUAL . $this->getValue('rpn');
    }

    public function getValidationRules() {
        return new Assert\Collection(array(
                    'name' => array(
                        new Assert\NotBlank(),
                        new Assert\Regex(self::ALNUM)
                    ),
                    'rpn' => new Assert\NotBlank()
                ));
    }

}