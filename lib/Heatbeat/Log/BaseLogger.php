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
    Heatbeat\Log\Handler;

/**
 * Config file parser
 *
 * @category    Heatbeat
 * @package     Heatbeat\Log
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class BaseLogger {

    private static $instance;
    private $isEnabled;
    private $handler;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        $config = Autoloader::getInstance()->getConfig();
        $this->setHandler($config['configuration']['log']['handler']);
        $this->setIsEnabled($config['configuration']['log']['enabled']);
    }

    public function log($data) {
        if ($this->getIsEnabled()) {
            if ($this->getHandler()->isHandling()) {
                $this->getHandler()->handle($data);
                return true;
            }
            return false;
        }
        return false;
        /**
         * @todo Log handling exception
         */
    }

    private function getIsEnabled() {
        return $this->isEnabled;
    }

    public function setIsEnabled($isEnabled) {
        $this->isEnabled = $isEnabled;
    }

    private function getHandler() {
        return $this->handler;
    }

    public function setHandler($handler) {
        $class = "\\Heatbeat\\Log\\Handler\\" . $handler . "Handler";
        $instance = new $class;
        $instance->init();
        $this->handler = $instance;
    }

}