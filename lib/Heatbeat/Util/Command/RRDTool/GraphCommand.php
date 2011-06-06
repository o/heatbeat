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
 * @package     Heatbeat\Util\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Util\Command\RRDTool;

/**
 * Implementation for RRDTool graph command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Util\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class GraphCommand extends RRDToolCommand {
    protected $subCommand = 'graph';

    const PARAMETER_START = 'start';
    const PARAMETER_TITLE = 'title';
    const PARAMETER_VERTICAL_LABEL = 'vertical-label';
    const PARAMETER_LOWER_LIMIT = 'lower-limit';
    const PARAMETER_UPPER_LIMIT = 'upper-limit';
    const PARAMETER_BASE = 'base';

    public function setGraphFilename($graphFilename) {
        $this->addArgument($graphFilename);
    }

    public function setStart($start) {
        $this->setOption(self::PARAMETER_START, $start);
    }

    public function setTitle($title) {
        $this->setOption(self::PARAMETER_TITLE, $title);
    }

    public function setVerticalLabel($verticalLabel) {
        $this->setOption(self::PARAMETER_VERTICAL_LABEL, $verticalLabel);
    }

    public function setLowerlimit($lowerlimit) {
        $this->setOption(self::PARAMETER_LOWER_LIMIT, $lowerlimit);
    }

    public function setUpperlimit($upperlimit) {
        $this->setOption(self::PARAMETER_UPPER_LIMIT, $upperlimit);
    }

    public function setBase($base) {
        $this->setOption(self::PARAMETER_BASE, $base);
    }

    public function setDefs(array $defs) {
        foreach ($defs as $def) {
            $this->addArgument($def);
        }
    }

    public function setCdefs(array $cdefs) {
        foreach ($cdefs as $cdef) {
            $this->addArgument($cdef);
        }
    }

    public function setVdefs(array $vdefs) {
        foreach ($vdefs as $vdef) {
            $this->addArgument($vdef);
        }
    }

    public function setGprints(array $gprints) {
        foreach ($gprints as $gprint) {
            $this->addArgument($gprint);
        }
    }

    public function setElements(array $elements) {
        foreach ($elements as $element) {
            $this->addArgument($element);
        }
    }

}
