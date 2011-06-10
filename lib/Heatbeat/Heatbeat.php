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

use Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Parser\Template\TemplateParser as TemplateLoader,
    Heatbeat\Util\Command\RRDTool\CreateCommand as RRDToolCreate,
    Heatbeat\Util\CommandExecutor as Executor;

/**
 * Heatbeat runner
 *
 * @category    Heatbeat
 * @package     Heatbeat
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Heatbeat {

    public function getConfig() {
        $config = new Config;
        return $config->getValues();
    }

    public function getTemplate($filename) {
        $template = new TemplateLoader($filename);
        return $template->getValues();
    }

    public function performCreate() {
        $config = $this->getConfig();
        foreach ($config->offsetGet('templates') as $item) {
            $template = $this->getTemplate($item['name']);
            $commandObject = new RRDToolCreate();
            $commandObject->setFilename($template->offsetGet('filename'));
            $rrdDefinition = new \ArrayObject($template->offsetGet('rrd'));
            $commandObject->setDatastores($rrdDefinition->offsetGet('datastores'));
            $commandObject->setRras($rrdDefinition->offsetGet('rras'));
            $executor = new Executor();
            $executor->setCommandObject($commandObject);
            $executor->prepare();
            return $executor->execute();
        }
    }

}