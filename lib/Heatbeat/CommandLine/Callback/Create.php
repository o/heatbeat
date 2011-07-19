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
    Heatbeat\Autoloader,
    Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Parser\Template\TemplateParser as Template,
    Heatbeat\Util\Command\RRDTool\RRDToolCommand as RRDTool,
    Heatbeat\Util\Command\RRDTool\CreateCommand as RRDCreate,
    Heatbeat\Util\CommandExecutor as Executor,
    Heatbeat\Log\BaseLogger as Logger,
    Heatbeat\Exception\SourceException;

/**
 * Callback for CLI Tool create command
 *
 * @category    Heatbeat
 * @package     Heatbeat\CommandLine\Callback
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Create extends Shared {

    public function configure() {
        $this
                ->setName('create')
                ->setDescription('Creates RRD files')
                ->addOption('overwrite', null, InputOption::VALUE_NONE, "This option overwrites all created RRD's");
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        foreach ($this->getConfigObject()->getGraphEntities() as $entity) {
            try {
                $template = $this->getTemplate($entity->offsetGet('template'));
                $commandObject = new RRDCreate();
                $commandObject->setFilename($entity->getRRDFilename());
                $commandObject->setOverwrite($input->getOption('overwrite'));
                $commandObject->setDatastores($template->getRrdDatastores());
                $commandObject->setRras($template->getRrdRras());
                $this->executeCommand($input, $output, $commandObject, sprintf("Success : '%s%s' created", $entity->getRRDFilename(), RRDTool::RRD_EXT));
            } catch (\Exception $e) {
                Logger::getInstance()->log($e->getMessage());
                $output->writeln($e->getMessage());
                continue;
            }
        }
        $output->writeln($this->getSummary());
    }

}
