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
 * Test command for unit tests
 *
 * @category    Heatbeat
 * @package     Heatbeat\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Test extends Shared {

    protected $commandName = 'test';

    public function setFooFlag() {
        $this->setOption('foo');
    }

    public function setBarValue($bar) {
        $this->setOption('bar', $bar);
    }

    public function overrideOptions(array $options) {
        $this->setOptions($options);
    }

    public function addAnArgument($value) {
        $this->addArgument($value);
    }

    public function overrideCommand($command) {
        $this->setCommand($command);
    }

    public function overrideSubcommand($subCommand) {
        $this->setSubCommand($subCommand);
    }

}