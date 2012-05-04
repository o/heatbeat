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
 * Datastore leaf of template
 *
 * @category    Heatbeat
 * @package     Heatbeat\Leaf\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class DatastoreLeaf extends AbstractLeaf implements LeafInterface, StringableInterface {

    const PREFIX = 'DS';
    const UNKNOWN = 'U';

    public function getAsString() {
        return implode(self::SEPERATOR, array(
                    self::PREFIX,
                    $this->getValue('name'),
                    strtoupper($this->getValue('type')),
                    $this->getValue('heartbeat'),
                    $this->getValue('min') !== null ? $this->getValue('min') : self::UNKNOWN,
                    $this->getValue('max') !== null ? $this->getValue('max') : self::UNKNOWN,
                ));
    }

    public function getValidationRules() {
        return new Assert\Collection(array(
                    'name' => array(
                        new Assert\NotBlank(),
                        new Assert\Regex(self::ALNUM)
                    ),
                    'type' => array(
                        new Assert\NotBlank(),
                        new Assert\Choice(array('choices' => $this->getValidDatastoreTypes()))
                    ),
                    'heartbeat' => array(
                        new Assert\NotBlank(),
                        new Assert\Min(0)
                    ),
                    'min' => new Assert\Type(array('type' => 'int')),
                    'max' => new Assert\Type(array('type' => 'int')),
                ));
    }

    public function getDefaultValues() {
        return array(
            'min' => null,
            'max' => null
        );
    }

}