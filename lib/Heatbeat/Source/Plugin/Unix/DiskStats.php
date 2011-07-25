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
 * @package     Heatbeat\Source\Plugin\Unix
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Source\Plugin\Unix;

use Heatbeat\Source\AbstractSource,
    Heatbeat\Source\SourceOutput,
    Heatbeat\Exception\SourceException;

/**
 * Class for fetching disk status
 *
 * @category    Heatbeat
 * @package     Heatbeat\Source\Plugin\Unix
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class DiskStats extends AbstractSource {

    const PIPE = '|';
    const KB_MULTIPLIER = 1024;

    public function perform() {
        $total = false;
        $used = false;
        $available = false;
        $command = sprintf("df -k | grep %s | awk '{print $2 \"|\" $3 \"|\" $4}'", $this->getInput()->getValue('disk'));
        $result = shell_exec($command);
        if (strpos($result, self::PIPE)) {
            $exploded = explode(self::PIPE, $result);
            if (count($exploded) > 3) {
                throw new SourceException('Disk argument is not unique');
            }
            list($total, $used, $available) = $exploded;
        } else {
            throw new SourceException('No data available for this disk');
        }
        $output = new SourceOutput();
        $output->setValue('total', $total * self::KB_MULTIPLIER);
        $output->setValue('used', $used * self::KB_MULTIPLIER);
        $output->setValue('available', $available * self::KB_MULTIPLIER);
        $this->setOutput($output);
    }

}