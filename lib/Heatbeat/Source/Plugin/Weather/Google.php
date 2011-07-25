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
 * @package     Heatbeat\Source\Plugin\Weather
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Source\Plugin\Weather;

use Heatbeat\Source\AbstractSource,
    Heatbeat\Source\SourceOutput,
    Heatbeat\Exception\SourceException;

/**
 * Abstract source class for data fetching
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source\Plugin\Weather
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Google extends AbstractSource {

    public function perform() {
        $xml = simplexml_load_file('http://www.google.com/ig/api?hl=en&weather=' . $this->getInput()->getValue('location'));
        if (!$xml) {
            throw new SourceException('Unable to fetch data from Google API');
        }
        $current = $xml->xpath("/xml_api_reply/weather/current_conditions");
        switch ($this->getInput()->getValue('type')) {
            case 'c':
                $degree = (int) $current[0]->temp_c['data'];
                break;

            case 'f':
                $degree = (int) $current[0]->temp_f['data'];
                break;

            default:
                throw new SourceException('Wrong type provided, must be c or f');
                break;
        }
        $output = new SourceOutput();
        $output->setValue('current', $degree);
        $this->setOutput($output);
        return true;
    }

}