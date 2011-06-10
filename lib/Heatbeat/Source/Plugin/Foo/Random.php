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
 * @package     Heatbeat\Source\Plugin\Foo
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Source\Plugin\Foo;

use Heatbeat\Source;

/**
 * Abstract source class for data fetching
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source\Plugin\Foo
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Random extends AbstractSource implements SourceInterface {

    public function perform() {
        /**
         * Getting arguments from config
         */
        $min = $this->getInput()->getValue('min');
        $max = $this->getInput()->getValue('max');

        /**
         * Getting / fetching data
         */
        $rand1 = mt_rand($min, $max);
        $rand2 = mt_rand(0, mt_getrandmax());

        /**
         * Setting output
         */
        $output = new SourceOutput;
        $output->setValue('rand1', $rand1);
        $output->setValue('rand2', $rand2);

        /**
         * Alternative way
         * 
         *      $output = new SourceOutput(
         *          array('rand1' => $rand1),
         *          array('rand2' => $rand2)
         *      );
         *
         */
        $this->setOutput($output);
        
        /**
         * Mark as successful
         */
        $this->setIsSuccessful(true);
    }

}