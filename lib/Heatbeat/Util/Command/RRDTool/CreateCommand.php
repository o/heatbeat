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
 * @package     Heatbeat\Util\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Util\Command\RRDTool;

use Heatbeat\Parser\Template\Node\DatastoreNode as Datastore,
    Heatbeat\Parser\Template\Node\RraNode as RRA;

/**
 * Implementation for RRDTool create command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class CreateCommand extends RRDToolCommand {
    const PARAMETER_STEP = 'step';
    const PARAMETER_START = 'start';
    const PARAMETER_NO_OVERWRITE = 'no-overwrite';
    protected $subCommand = 'create';

    /**
     *
     * @param int $step
     * @return bool 
     */
    public function setStep($step) {
        $this->setOption(self::PARAMETER_STEP, $step);
    }

    /**
     *
     * @param array $datastores
     * @return bool 
     */
    public function setDatastores(array $datastores) {
        foreach ($datastores as $datastore) {
            $object = new Datastore($datastore);
            $object->validate();
            $this->addArgument($object->getAsString());
        }
    }

    /**
     *
     * @param array  $rras
     * @return bool 
     */
    public function setRras(array $rras) {
        foreach ($rras as $rra) {
            $object = new RRA($rra);
            $object->validate();
            $this->addArgument($object->getAsString());
        }
    }

    /**
     * Sets overwriting behaviour for existing RRD file
     * 
     * @param bool $value
     * @return bool 
     */
    public function setOverwrite($value) {
        $this->setOption(self::PARAMETER_NO_OVERWRITE, ($value ? false : true));
    }

    /**
     * Prepares start option of create command
     */
    private function setStart() {
        $this->setOption(self::PARAMETER_START, time() - (30 * 60));
    }

    public function init() {
        $this->setOverwrite(true);
        $this->setStart();
    }

}