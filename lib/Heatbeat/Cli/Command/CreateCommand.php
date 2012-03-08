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
    Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Parser\Template\TemplateParser as Template,
    Heatbeat\Command\RRDTool\RRDToolCommand as RRDTool,
    Heatbeat\Command\RRDTool\CreateCommand as RRDCreate,
    Heatbeat\Executor\Executor,
    Heatbeat\Exception\SourceException;

/**
 * Callback for CLI Tool create command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class CreateCommand extends HeatbeatCommand {

    public function configure() {
        $this
                ->setName('create')
                ->setDescription('Creates RRD files')
                ->addOption('overwrite', null, InputOption::VALUE_NONE, "This option overwrites all created RRD's");
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
                $commandObject = new RRDCreate();
                $commandObject->setFilename($this->pathUtility->getRRDFilePath($entity->getUniqueIdentifier()));
                $commandObject->setOverwrite($input->getOption('overwrite'));
                $commandObject->setStep($template->getTemplateOptions()->offsetGet('step'));
                $commandObject->setDatastores($template->getDatastores());
                $commandObject->setRras($template->getRras());
                $this->executeCommand($input, $output, $commandObject, $this->pathUtility->getRRDFilePath($entity->getUniqueIdentifier()));
            } catch (\Exception $e) {
                $this->logError($e);
                $this->renderError($e, $output);
                continue;
            }
        }
        $output->writeln($this->getSummary());
    }

}
