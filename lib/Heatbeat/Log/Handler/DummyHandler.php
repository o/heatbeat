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
 * @package     Heatbeat\Log\Handler
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Log\Handler;

use Heatbeat\Autoloader;

/**
 * Dummy handler, logs nothing
 *
 * @category    Heatbeat
 * @package     Heatbeat\Log\Handler
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class DummyHandler extends AbstractLogHandler implements LogHandlerInterface {

    public function handle() {
        return true;
    }

    public function isHandling() {
        return true;
    }

    public function format() {
        return $this->getMessage();
    }

}