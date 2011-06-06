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
 * @package     Heatbeat\Util
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Util;

/**
 * Abstract class for implementing shell commands.
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class AbstractCommand {
    const LONG_OPTION = '--';

    private $command;
    private $subCommand;
    private $arguments = array();
    private $options = array();

    /**
     *
     * @param string $command
     * @return AbstractCommand
     */
    public function setCommand($command) {
        $this->command = $command;
        return $this;
    }

    /**
     *
     * @param string $subCommand
     * @return AbstractCommand
     */
    public function setSubCommand($subCommand) {
        $this->subCommand = $subCommand;
        return $this;
    }

    /**
     *
     * @param array $arguments
     * @return AbstractCommand
     */
    public function setArguments(array $arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     *
     * @param string $value
     * @return AbstractCommand
     */
    public function addArgument($value) {
        $this->arguments[] = $value;
        return $this;
    }

    /**
     *
     * @param array $options
     * @return AbstractCommand
     */
    public function setOptions(array $options) {
        $this->options = $options;
        return $this;
    }

    /**
     *
     * @param string $name
     * @param string $value
     * @return AbstractCommand
     */
    public function setOption($name, $value = true) {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCommand() {
        return $this->command;
    }

    /**
     *
     * @return string
     */
    public function getSubCommand() {
        return $this->subCommand;
    }

    /**
     *
     * @return array
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     *
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

}

?>
