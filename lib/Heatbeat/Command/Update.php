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
 * Implementation for RRDTool update command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */

class Update extends Shared {
    const SUBCOMMAND = 'update';

    private $time;
    private $values;

    public function setTime($time = 'N') {
        $this->time = $time;
    }

    public function setValues(array $values) {
        $this->values = \implode(self::SEPERATOR, $values);
    }

    public function getTime() {
        return $this->time;
    }

    public function getValues() {
        return $this->values;
    }

    public function execute() {
        $this->addArgument($this->getTime() . self::SEPERATOR . $this->getValues());
        return parent::execute();
    }

}