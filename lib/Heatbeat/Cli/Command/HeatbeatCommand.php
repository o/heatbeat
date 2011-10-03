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
    Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Heatbeat\Autoloader,
    Heatbeat\Util\CommandExecutor as Executor,
    Heatbeat\Parser\Template\TemplateParser as Template,
    Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Util\AbstractCommand,
    Heatbeat\Log\Factory as Logger,    
    Heatbeat\Exception\SourceException;

/**
 * Shared methods for commands
 *
 * @category    Heatbeat
 * @package     Heatbeat\Cli\Command
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class HeatbeatCommand extends Command {

    private $processStartTime;

    /**
     * Initializes template and command object
     *
     */
    protected function initialize(InputInterface $input, OutputInterface $output) {
        $this->setProcessStartTime();
    }

	public function getConfig()
	{
        $configObject = new Config();
        $configObject->setFilepath(Autoloader::getInstance()->getPath(Autoloader::FOLDER_ROOT));
        $configObject->setFilename(Config::FILENAME);
        $configObject->parse();
		return $configObject;
	}
	
	public function getTemplate($name)
	{
        $templateObject = new Template();
        $templateObject->setFilepath(Autoloader::getInstance()->getPath(Autoloader::FOLDER_TEMPLATE));
		$templateObject->setFilename($name);
		$templateObject->parse();
		return $templateObject;
	}

    /**
     * Sets actual time as float
     */
    private function setProcessStartTime() {
        $this->processStartTime = microtime(true);
    }

    /**
     * Returns command execution time
     *
     * @return float
     */
    private function getExecutionTime() {
        return microtime(true) - $this->processStartTime;
    }

    /**
     * Executes given command object and sends output to console
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param AbstractCommand $commandObject
     * @param string $message
     */
    public function executeCommand(InputInterface $input, OutputInterface $output, AbstractCommand $commandObject, $message) {
        $executor = new Executor();
        $executor->setCommandObject($commandObject);
        $executor->prepare();
        if ($input->getOption('verbose')) {
            $output->writeln($executor->getCommandString());
        }
        $process = $executor->execute();
        if ($process->isSuccessful()) {
            $this->renderSuccess($message, $output);
        }
    }

    /**
     * Returns instance of given plugin name
     *
     * @param string $plugin
     * @return AbstractSource
     */
    public function getPluginInstance($plugin) {
        $namespaced = str_replace('_', "\\", $plugin);
        $class_name = '\\Heatbeat\\Source\\Plugin\\' . $namespaced;
        if (!class_exists($class_name)) {
            throw new SourceException(sprintf('Unable to find source plugin %s', $plugin));
        }
        return new $class_name;
    }

    /**
     * Returns execution time and memory usage of script
     *
     * @return string
     */
    public function getSummary() {
        return sprintf(
                '<comment>Time: %4.2f sec, Memory: %4.2fMb</comment>', number_format($this->getExecutionTime(), 2), memory_get_peak_usage(TRUE) / 1048576
        );
    }

    /**
     * Renders error message of given exception to console
     * 
     * @param \Exception $e
     * @param OutputInterface $output 
     */
    protected function renderError(\Exception $e, OutputInterface $output) {
        $output->writeln(sprintf("<error>Error\t</error> %s", $e->getMessage()));
    }

    /**
     * Renders given success message to console
     *
     * @param string $message
     * @param OutputInterface $output
     */
    protected function renderSuccess($message, OutputInterface $output) {
        $output->writeln(sprintf("<info>Success\t</info> %s", $message));
    }

    /**
     * Logs message of exception to rotating file 
     *
     * @param Exception $e 
     * @return bool
     */
    protected function logError($e)
    {
        $factory = new Logger(Logger::FILE_HANDLER);
        return $factory->getHandlerObject()->log($e->getMessage());
    }

}