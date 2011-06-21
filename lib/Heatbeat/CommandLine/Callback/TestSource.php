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
 * @package     Heatbeat\CommandLine\Callback
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\CommandLine\Callback;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Heatbeat\Source\SourceInput;

/**
 * Callback for CLI Tool test command
 *
 * @category    Heatbeat
 * @package     Heatbeat\CommandLine\Callback
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class TestSource extends Console\Command\Command {

    public function configure() {
        $this
                ->setName('test:source')
                ->setDescription('Makes tests for source plugin with given arguments')
                ->setDefinition(array(
                    new InputArgument('source', InputArgument::REQUIRED, 'Source plugin name'),
                    new InputArgument('args', InputArgument::OPTIONAL, 'Arguments as key:value')
                ));
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $namespaced = str_replace('_', "\\", $input->getArgument('source'));
        $class_name = 'Heatbeat\\Source\\Plugin\\' . $namespaced;
        if (!class_exists($class_name)) {
            $output->write(sprintf('Failed : Unable to find source plugin %s', $namespaced), true);
        }
        $instance = new $class_name;
        $arguments = $input->getArgument('args');
        if ($arguments) {
            $sourceArray = array();
            $argumentsArray = explode("|", $arguments);
            foreach ($argumentsArray as $argument) {
                $kv = explode(":", $argument);
                $sourceArray[$kv[0]] = $kv[1];
            }
            $inputArguments = new SourceInput($sourceArray);
            $instance->setInput($inputArguments);
        }
        $instance->perform();
        if ($instance->getIsSuccessful()) {
            $output->write('Status : Success', true);
            $output->write('Results :', true);
            foreach ($instance->getOutput() as $key => $value) {
                $output->write(sprintf("Key : %s, Value : %s", $key, $value), true);
            }
        } else {
            $output->write('Status : Failed', true);
            $output->write(sprintf('Error message : %s', $instance->getErrorMessage()), true);
            $output->write('Input values :', true);
            foreach ($instance->getInput() as $key => $value) {
                $output->write(sprintf("Key : %s, Value : %s", $key, $value), true);
            }
        }
    }

}
