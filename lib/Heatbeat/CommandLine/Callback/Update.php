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
    Heatbeat\Parser\Template\TemplateParser as TemplateLoader,
    Heatbeat\Util\Command\RRDTool\RRDToolCommand as RRDTool,
    Heatbeat\Util\Command\RRDTool\UpdateCommand as RRDUpdate,
    Heatbeat\Util\CommandExecutor as Executor,
    Heatbeat\Log\BaseLogger as Logger,
    Heatbeat\Source\SourceInput as Input,
    Heatbeat\Parser\Template\Node\TemplateOptionNode as TemplateOptions,
    Heatbeat\Exception\SourceException;

/**
 * Callback for CLI Tool update command
 *
 * @category    Heatbeat
 * @package     Heatbeat\CommandLine\Callback
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Update extends Console\Command\Command {

    public function configure() {
        $this
                ->setName('update')
                ->setDescription('Updates all RRD files');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $config = Autoloader::getInstance()->getConfig();
        foreach ($config->offsetGet('templates') as $item) {
            try {
                $template = $this->getTemplate($item['plugin']);
                $templateOptions = new TemplateOptions($template['template']['options']);
                $templateOptions->validate();
                $pluginInstance = $this->getPluginInstance($templateOptions->offsetGet('source-name'));
                if (array_key_exists('arguments', $item) AND is_array($item['arguments'])) {
                    $pluginInstance->setInput(new Input($item['arguments']));
                }
                $pluginInstance->perform();
                $commandObject = new RRDUpdate();
                $commandObject->setFilename($item['filename']);
                $commandObject->setValues(time(), $pluginInstance->getOutput());
                $executor = new Executor();
                $executor->setCommandObject($commandObject);
                $executor->prepare();
                if ($input->getOption('verbose')) {
                    $output->writeln($executor->getCommandString());
                }
                $process = $executor->execute();
                if ($process->isSuccessful()) {
                    $output->writeln(sprintf("'%s%s' updated successfully.", $item['filename'], RRDTool::RRD_EXT));
                }
            } catch (\Exception $e) {
                Logger::getInstance()->log($e->getMessage());
                $output->writeln($e->getMessage());
                continue;
            }
        }
    }

    private function getTemplate($filename) {
        $template = new TemplateLoader($filename);
        return $template->getValues();
    }

    private function getPluginInstance($plugin) {
        $namespaced = str_replace('_', "\\", $plugin);
        $class_name = '\\Heatbeat\\Source\\Plugin\\' . $namespaced;
        if (!class_exists($class_name)) {
            throw new SourceException(sprintf('Unable to find source plugin %s', $plugin));
        }
        return new $class_name;
    }

}
