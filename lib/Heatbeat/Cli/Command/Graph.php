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
    Heatbeat\Command\RRDTool\GraphCommand as RRDGraph,
    Heatbeat\Exception\SourceException;

/**
 * Callback for CLI Tool graph command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Graph extends HeatbeatCommand {

    public function configure() {
        $this
                ->setName('graph')
                ->setDescription('Creates graphs of RRD files');
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
                for ($index = 0; $index < $template->getGraphEntityCount(); $index++) {
                    $commandObject = new RRDGraph();
                    $commandObject->setGraphFilename($entity->getRRDFilename() . $index);
                    $commandObject->setTitle($template->getGraphOptions($index)->offsetGet('name'));
                    $commandObject->setVerticalLabel($template->getGraphOptions($index)->offsetGet('label'));
                    $commandObject->setBase($template->getGraphOptions($index)->offsetGet('base'));
                    $commandObject->setUpperlimit($template->getGraphOptions($index)->offsetGet('upper'));
                    $commandObject->setLowerlimit($template->getGraphOptions($index)->offsetGet('lower'));
                    $commandObject->setStart($template->getGraphOptions($index)->offsetGet('start'));
                    $commandObject->setDefs($template->getGraphDefs($index, $entity->getRRDFilename()));
                    $commandObject->setItems($template->getGraphItems($index));
                    if ($template->getGraphGprints($index))
                        $commandObject->setGprints($template->getGraphGprints($index));
                    if ($template->getGraphCdefs($index))
                        $commandObject->setCdefs($template->getGraphCdefs($index));
                    if ($template->getGraphVdefs($index))
                        $commandObject->setVdefs($template->getGraphVdefs($index));
                    $this->executeCommand($input, $output, $commandObject, $entity->getRRDFilename() . $index . RRDTool::PNG_EXT);
                }
            } catch (\Exception $e) {
                $this->logError($e);
                $this->renderError($e, $output);
                continue;
            }
        }
        $output->writeln($this->getSummary());
    }

}