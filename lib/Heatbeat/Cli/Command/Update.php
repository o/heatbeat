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
    Heatbeat\Autoloader,
    Heatbeat\Command\RRDTool\RRDToolCommand as RRDTool,
    Heatbeat\Command\RRDTool\Update as RRDUpdate,
    Heatbeat\InputOutput\SourceInput as Input,
    Heatbeat\Source\SourceException;

/**
 * Callback for CLI Tool update command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Update extends HeatbeatCommand {

    public function configure() {
        $this
                ->setName('update')
                ->setDescription('Updates all RRD files')
                ->addOption('no-graph', null, InputOption::VALUE_NONE, 'If set, graphs not will be created.');
    }

    /**
     * Executes command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        foreach ($this->getConfig()->getGraphEntities() as $entity) {
            try {
                if ($entity->offsetGet('enabled') === false)
                    continue;
                $template = $this->getTemplate($entity->offsetGet('template'));
                $pluginInstance = $this->getPluginInstance($template->getTemplateOptions()->offsetGet('source-name'));
                if ($entity->offsetExists('arguments') AND count($entity->offsetGet('arguments'))) {
                    $pluginInstance->setInput(new Input($entity->offsetGet('arguments')));
                }
                $pluginInstance->perform();
                $commandObject = new RRDUpdate();
                $commandObject->setFilename($entity->getRRDFilename());
                $commandObject->setValues($pluginInstance->getOutput());
                $this->executeCommand($input, $output, $commandObject, $entity->getRRDFilename() . RRDTool::RRD_EXT);
            } catch (\Exception $e) {
                $this->logError($e);
                $this->renderError($e, $output);
                continue;
            }
        }
        $output->writeln($this->getSummary());
        if ($input->getOption('no-graph') === false) {
            $this->runGraphCommand($input, $output);
        }
    }

    /**
     * Invokes heatbeat:graph command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function runGraphCommand(InputInterface $input, OutputInterface $output) {
        $command = $this->getApplication()->find('graph');
        $input = new Console\Input\ArrayInput(
                        array(
                            'command' => 'graph',
                            '--verbose' => $input->getOption('verbose')
                        )
        );
        $command->run($input, $output);
    }

}
