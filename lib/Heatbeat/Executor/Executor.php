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
 * @package     Heatbeat\Executor
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Executor;

/**
 * Class for executing shell commands
 *
 * @category    Heatbeat
 * @package     Heatbeat\Executor
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Executor {

    private $command;
    private $cwd;
    private $env;
    private $options;
    private $stdin;
    private $stdout;
    private $stderr;
    private $status;
    private $exitcode;

    public function run() {
        $process = proc_open($this->command, array(array('pipe', 'r'), array('pipe', 'w'), array('pipe', 'w')), $pipes, $this->cwd, $this->env);
        if (!is_resource($process)) {
            throw new ExecutionException('Unable to start a new process.');
        }

        list($this->stdin, $this->stdout, $this->stderr) = array_map(function($pipe) {
                    return stream_get_contents($pipe);
                }, $pipes);
        
        $this->status = proc_get_status($process);
        $exitcode = proc_close($process);
        $this->exitcode = $this->status['running'] ? $exitcode : $this->status['exitcode'];
    }

    /**
     *
     * @param string $command
     * @return Executor 
     */
    public function setCommand($command) {
        $this->command = $command;
        return $this;
    }

    /**
     *
     * @param string $cwd
     * @return Executor 
     */
    public function setCwd($cwd) {
        $this->cwd = $cwd;
        return $this;
    }

    /**
     *
     * @param array $env
     * @return Executor 
     */
    public function setEnv(array $env) {
        $this->env = $env;
        return $this;
    }

    /**
     *
     * @param array $options
     * @return Executor 
     */
    public function setOptions(array $options) {
        $this->options = $options;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getInput() {
        return $this->stdin;
    }

    /**
     *
     * @return string
     */
    public function getOutput() {
        return $this->stdout;
    }

    /**
     *
     * @return string
     */
    public function getErrorOutput() {
        return $this->stderr;
    }

    /**
     *
     * @return array
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     *
     * @return int
     */
    public function getExitcode() {
        return $this->exitcode;
    }

    /**
     *
     * @return bool
     */
    public function isSuccess() {
        return $this->exitcode === 0;
    }

}