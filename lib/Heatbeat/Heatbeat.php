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
 * @package     Heatbeat
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat;

use Heatbeat\Autoloader,
    Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Parser\Template\TemplateParser as TemplateLoader,
    Heatbeat\Util\Command\RRDTool\CreateCommand as RRDCreate,
    Heatbeat\Util\Command\RRDTool\UpdateCommand as RRDUpdate,
    Heatbeat\Util\CommandExecutor as Executor,
    Heatbeat\Log\BaseLogger as Logger,
    Heatbeat\Source\SourceInput as Input,
    Heatbeat\Exception\HeatbeatException,
    Heatbeat\Exception\ExecutionException;

/**
 * Heatbeat runner
 *
 * @category    Heatbeat
 * @package     Heatbeat
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Heatbeat {

    private function getTemplate($filename) {
        $template = new TemplateLoader($filename);
        return $template->getValues();
    }

    public function performCreate() {
        $config = Autoloader::getInstance()->getConfig();
        foreach ($config->offsetGet('templates') as $item) {
            $template = $this->getTemplate($item['plugin']);
            $commandObject = new RRDCreate();
            $commandObject->setFilename($item['filename']);
            $rrdDefinition = new \ArrayObject($template->offsetGet('rrd'));
            $commandObject->setDatastores($rrdDefinition->offsetGet('datastores'));
            $commandObject->setRras($rrdDefinition->offsetGet('rras'));
            $executor = new Executor();
            $executor->setCommandObject($commandObject);
            $executor->prepare();
            $executor->execute();
        }
    }

    public function performUpdate() {
        $config = Autoloader::getInstance()->getConfig();
        foreach ($config->offsetGet('templates') as $item) {
            $template = $this->getTemplate($item['plugin']);
            $commandObject = new RRDUpdate();
            $commandObject->setFilename($item['filename']);
            $templateOptions = new \ArrayObject($template['template']['options']);
            $pluginInstance = self::getPluginInstance($templateOptions->offsetGet('source-name'));
            $pluginInstance->setInput(new Input($item['arguments']));
            $pluginInstance->perform();
            $commandObject->setValues(time(), $pluginInstance->getOutput());
            $executor = new Executor();
            $executor->setCommandObject($commandObject);
            $executor->prepare();
            $executor->execute();
        }
    }

    public static function handleErrors($errno, $errstr = '', $errfile = '', $errline = '') {
        if (!(error_reporting() & $errno)) {
            return false;
        }
        $message = sprintf('[%s] %s', 'Error', $errstr);
        Logger::getInstance()->log($message);
    }

    public static function handleExceptions(\Exception $exc) {
        $message = sprintf('[%s] %s', get_class($exc), $exc->getMessage());
        Logger::getInstance()->log($message);
    }

    public static function getPluginInstance($plugin) {
        $namespaced = str_replace('_', "\\", $plugin);
        $class_name = '\\Heatbeat\\Source\\Plugin\\' . $namespaced;
        if (!class_exists($class_name)) {
            throw new HeatbeatException(sprintf('Unable to find source plugin %s', $plugin));
        }
        return new $class_name;
    }

}