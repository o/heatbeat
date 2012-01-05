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

use Heatbeat\Autoloader;

/**
 * Class for logging Heatbeat events
 *
 * @category    Heatbeat
 * @package     Heatbeat\Log
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Logger {
    const FILENAME_FORMAT = '%Y-%m-%d';
    const FILENAME_EXT = '.log';

    /**
     *
     * @var string
     */
    private $message;

    /**
     *
     * @param string $message
     * @return Logger 
     */
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function getLogFolder() {
        return Autoloader::getInstance()->getPath(Autoloader::FOLDER_LOG);
    }

    public function getLogFilename() {
        return $this->getLogFolder() . DIRECTORY_SEPARATOR . strftime(self::FILENAME_FORMAT) . self::FILENAME_EXT;
    }

    public function log() {
        if (is_writable($this->getLogFolder())) {
            return file_put_contents($this->getLogFilename(), sprintf("%s \t %s \r\n", time(), $this->message), FILE_APPEND | LOCK_EX);
        }
        throw new LoggingException('Unable to log message. Please check your log directory is writable.');
    }

}
