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
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Cli\Command;

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Heatbeat\Source\SourceInput,
    Heatbeat\Exception\SourceException;

/**
 * Callback for CLI Tool test command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class TestSource extends Shared {

    public function configure() {
        $this
                ->setName('test:source')
                ->setDescription('Makes tests for source plugin with given arguments')
                ->setDefinition(array(
                    new InputArgument('source', InputArgument::REQUIRED, 'Source plugin name'),
                    new InputArgument('args', InputArgument::OPTIONAL, 'Arguments as key:value like "foo:bar|bar:baz"')
                ));
    }

    /**
     * Executes command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $instance = false;
        try {
            $instance = $this->getPluginInstance($input->getArgument('source'));
            $arguments = $input->getArgument('args');
            if ($arguments) {
                $instance->setInput($this->prepareArgs($arguments));
            } else {
                $instance->setInput(new SourceInput());
            }
            $instance->perform();
            $this->renderSuccess('Fetched', $output);
            foreach ($instance->getOutput() as $key => $value) {
                $output->writeLn(sprintf("Key : %s \t Value : %s", $key, $value));
            }
        } catch (\Exception $e) {
            $this->renderError($e, $output);
            $output->writeLn('Input values :');
            foreach ($instance->getInput() as $key => $value) {
                $output->writeLn(sprintf("Key : %s \t Value : %s", $key, $value));
            }
        }
    }

    /**
     * Prepares key:value values as SourceInput
     *
     * @param string $arguments
     * @return SourceInput
     */
    private function prepareArgs($arguments) {
        $sourceArray = array();
        $argumentsArray = explode("|", $arguments);
        foreach ($argumentsArray as $argument) {
            $kv = explode(":", $argument);
            $sourceArray[$kv[0]] = $kv[1];
        }
        return new SourceInput($sourceArray);
    }

}
