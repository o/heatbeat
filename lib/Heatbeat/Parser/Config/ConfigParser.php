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
 * @package     Heatbeat\Parser\Config
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser\Config;

use Heatbeat\Parser\AbstractParser,
    Heatbeat\Autoloader,
    Heatbeat\Parser\Config\Node\ConfigurationNode as ConfigurationOptions,
    Heatbeat\Exception\ConfigException,
    Heatbeat\Parser\Config\Node\GraphNode as GraphDefinition;

/**
 * Config file parser
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Config
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class ConfigParser extends AbstractParser {
    const FILENAME = 'config';

    public function __construct($folder) {
        $this->setFilePath($folder);
        $this->setFilename(self::FILENAME);
        $this->parse();
    }

    public function getConfigurationOptions() {
        $values = $this->getValues();
        if ($values->offsetExists('configuration') AND count($values->offsetGet('configuration'))) {
            $configurationOptions = new ConfigurationOptions($values->offsetGet('configuration'));
            $configurationOptions->validate();
            return $configurationOptions;
        } else {
            throw new ConfigException('Configuration options is not defined in config.yml');
        }
    }

    public function getGraphEntities() {
        $values = $this->getValues();
        if ($values->offsetExists('graphs') AND count($values->offsetGet('graphs'))) {
            return array_map(function($definition) {
                        $object = new GraphDefinition($definition);
                        $object->validate();
                        return $object;
                    }, $values->offsetGet('graphs'));
        } else {
            throw new ConfigException('You must define at least one graph definition in config.yml');
        }
    }

}