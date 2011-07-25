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

use Symfony\Component\Process\Process,
    Heatbeat\Exception\ExecutionException;

/**
 * Class for executing shell commands.
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class CommandExecutor {
    const LONG_OPTION = '--';

    /**
     *
     * @var AbstractCommand 
     */
    private $commandObject;
    /**
     *
     * @var string 
     */
    private $commandString;

    /**
     * Returns command object
     * 
     * @return AbstractCommand
     */
    public function getCommandObject() {
        return $this->commandObject;
    }

    /**
     * Sets command object
     * 
     * @param AbstractCommand $commandObject 
     */
    public function setCommandObject(AbstractCommand $commandObject) {
        $this->commandObject = $commandObject;
    }

    /**
     * Returns prepared command string
     * 
     * @return string 
     */
    public function getCommandString() {
        return $this->commandString;
    }

    /**
     * Sets prepared command string
     * 
     * @param string $commandString 
     */
    public function setCommandString($commandString) {
        $this->commandString = $commandString;
    }

    /**
     * Prepares command for execution
     *
     */
    public function prepare() {
        $result = new \ArrayObject();
        $result->append($this->getCommandObject()->getCommand());
        $result->append($this->getCommandObject()->getSubCommand());
        foreach ($this->getCommandObject()->getOptions() as $key => $option) {
            if ($option === false) {
                continue;
            }
            $result->append(self::LONG_OPTION . $key);
            if ($option !== true) {
                $result->append(escapeshellarg($option));
            }
        }
        foreach ($this->getCommandObject()->getArguments() as $argument) {
            $result->append(escapeshellarg($argument));
        }
        $this->setCommandString(implode(chr(32), iterator_to_array($result)));
    }

    /**
     * Executes prepared command string
     * 
     * @return Process 
     * @throws ExecutionException
     */
    public function execute() {
        $process = new Process($this->getCommandString());
        $process->setEnv(explode(PATH_SEPARATOR, \getenv('PATH')));
        $process->setTimeout(5);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ExecutionException($process->getErrorOutput());
        }
        return $process;
    }

}