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
 * @package     Heatbeat\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Command;

/**
 * Implementation for RRDTool create command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Create extends Shared {
    const PARAMETER_STEP = 'step';
    protected $subCommand = 'create';

    /**
     *
     * @param int $step
     * @return bool | InvalidArgumentException 
     */
    public function setStep($step) {
        if (is_int($step)) {
            $this->setOption(self::PARAMETER_STEP, $step);
            return true;
        }
        throw new \InvalidArgumentException("You must provide an integer for step argument");
    }

    /**
     *
     * @param array $datastores
     * @return bool 
     */
    public function setDatastores(array $datastores) {
        foreach ($datastores as $datastore) {
            $this->addArgument($datastore);
        }
        return true;
    }

    /**
     *
     * @param array  $rras
     * @return bool 
     */
    public function setRras(array $rras) {
        foreach ($rras as $rra) {
            $this->addArgument($rra);
        }
        return true;
    }

}