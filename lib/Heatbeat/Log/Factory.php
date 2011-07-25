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
 * @package     Heatbeat\Log
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Log;

use Heatbeat\Autoloader,
    Heatbeat\Log\Handler\RotatingFileHandler,
    Heatbeat\Log\Handler\DummyHandler,
    Heatbeat\Exception\LoggingException,
    Heatbeat\Parser\Config\ConfigParser as Config;

/**
 * Factory for logging
 *
 * @category    Heatbeat
 * @package     Heatbeat\Log
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Factory {
    const FILE_HANDLER = 'RotatingFileHandler';
    const DUMMY_HANDLER = 'DummyHandler';

    private $handler;

    public function __construct($handler) {
        $config = new Config();
        $config->setFilepath(Autoloader::getInstance()->getPath(Autoloader::FOLDER_ROOT));
        $config->setFilename(Config::FILENAME);
        $config->parse();
        $values = $config->getConfigurationOptions()->offsetGet('log');
        $this->setHandler($handler);
        if ($values['enabled'] == false)
            $this->setHandler(self::DUMMY_HANDLER);
    }

    public function getHandler() {
        switch ($this->handler) {
            case self::FILE_HANDLER:
                return new RotatingFileHandler();
                break;

            case self::DUMMY_HANDLER:
                return new DummyHandler();
                break;

            default:
                throw new LoggingException(sprintf('Logging handler not found : %s', $this->handler));
                break;
        }
    }

    private function setHandler($handler) {
        $this->handler = $handler;
    }

}