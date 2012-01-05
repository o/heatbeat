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

use Heatbeat\Source\AbstractSource,
    Heatbeat\InputOutput\SourceOutput;

/**
 * Abstract source class for data fetching
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class GoogleWeather extends AbstractSource {

    public function perform() {
        $xml = simplexml_load_file('http://www.google.com/ig/api?hl=en&weather=' . $this->getInput()->getValue('location'));
        if (!$xml) {
            throw new SourceException('Unable to fetch data from Google API');
        }

        $humidityXPath = '/xml_api_reply/weather/current_conditions/humidity';
        switch ($this->getInput()->getValue('type')) {
            case 'c':
                $tempXPath = '/xml_api_reply/weather/current_conditions/temp_c';
                break;

            case 'f':
                $tempXPath = '/xml_api_reply/weather/current_conditions/temp_f';
                break;

            default:
                throw new SourceException('Wrong type provided, must be c or f');
                break;
        }

        $temp = $xml->xpath($tempXPath);
        $humidity = $xml->xpath($humidityXPath);

        $output = new SourceOutput();
        $output->setValue('temp', $temp[0]['data']);
        $output->setValue('humidity', preg_replace("/[^0-9]/", '', $humidity[0]['data']));
        $this->setOutput($output);
        return true;
    }

}