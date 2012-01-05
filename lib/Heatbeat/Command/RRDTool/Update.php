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
 * @package     Heatbeat\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Command\RRDTool;

use Heatbeat\InputOutput\SourceOutput;

/**
 * Implementation for RRDTool update command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Update extends RRDToolCommand {

    protected $subCommand = 'updatev';
    const PARAMETER_TEMPLATE = 'template';
    const RRDTOOL_NOW = 'N';

    /**
     * Prepares time and data arguments for updating RRD 
     * 
     * @param int $time
     * @param SourceOutput $values
     * @return bool 
     */
    public function setValues(SourceOutput $values) {
        $this->addArgument(self::RRDTOOL_NOW . self::SEPERATOR . implode(self::SEPERATOR, iterator_to_array($values)));
        $this->setDatastoreTemplate($values);
    }

    /**
     * Prepares template option for update command
     * 
     * @param SourceOutput $values 
     */
    private function setDatastoreTemplate(SourceOutput $values) {
        $this->setOption(self::PARAMETER_TEMPLATE, implode(self::SEPERATOR, array_keys(iterator_to_array($values))));
    }

}