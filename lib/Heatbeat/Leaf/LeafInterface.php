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
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Leaf;

/**
 * Interface for leafs of nodes
 *
 * @category    Heatbeat
 * @package     Heatbeat\Leaf
 * @author      Osman Ungur <osmanungur@gmail.com>
 */

interface LeafInterface {

    /**
     * Returns validation rules of leaf
     * 
     * @return Symfony\Component\Validator\Constraints\Collection 
     */
    public function getValidationRules();

    /**
     * Returns string represantation of leaf
     * 
     * @return string 
     */
    public function getAsString();
}