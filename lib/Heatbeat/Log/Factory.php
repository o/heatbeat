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
    Heatbeat\Parser\Config\ConfigParser as Config,
    Heatbeat\Log\Handler\LogHandlerInterface;

/**
 * Factory for logging
 *
 * @category    Heatbeat
 * @package     Heatbeat\Log
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Factory {
    const FILE_HANDLER = 1;
    const DUMMY_HANDLER = 2;

    private $handlerObject;

    public function __construct($handler) {
        $this->setHandler($handler);
    }

    /**
     * Sets handler interface object
     *
     * @param string $handler
     */
    private function setHandler($handler) {
        switch ($handler) {
            case self::FILE_HANDLER:
                $this->setHandlerObject(new RotatingFileHandler());
                return true;
                break;

            case self::DUMMY_HANDLER:
                $this->setHandlerObject(new DummyHandler());
                return true;
                break;

            default:
                throw new LoggingException(sprintf('Logging handler not found : %s', $handler));
                break;
        }
    }

    /**
     * Returns log handler interface
     *
     * @return LogHandlerInterface
     */
    public function getHandlerObject() {
        return $this->handlerObject;
    }

    /**
     * Sets log handler object
     *
     * @param AbstractLogHandler $handlerObject
     */
    protected function setHandlerObject(LogHandlerInterface $handlerObject) {
        $this->handlerObject = $handlerObject;
    }

}