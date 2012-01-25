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
 * @package     Heatbeat\Source
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Source;

use Heatbeat\Autoloader,
    Heatbeat\InputOutput\SourceInput,
    Heatbeat\InputOutput\SourceOutput,
    Heatbeat\Helper\PathHelper;

/**
 * Abstract source class for data fetching
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
abstract class AbstractSource {

    /**
     * 
     * @var SourceInput
     */
    private $input;
    
    /**
     * 
     * @var SourceOutput
     */
    private $output;

    /**
     * Returns source input
     *
     * @return SourceInput
     */
    public function getInput() {
        return $this->input;
    }

    /**
     * Sets source input
     *
     * @param SourceInput $input
     */
    public function setInput(SourceInput $input) {
        $this->input = $input;
    }

    /**
     * Returns source output
     *
     * @return SourceOutput
     */
    public function getOutput() {
        return $this->output;
    }

    /**
     * Sets source output
     *
     * @param SourceOutput $output 
     */
    public function setOutput(SourceOutput $output) {
        $this->output = $output;
    }

    /**
     * Performs data source fetch
     * 
     * @todo This method will be moved to an external interface
     */
    public function perform() {
        throw new SourceException('You must override the perform() method in the concrete source class.');
    }

}