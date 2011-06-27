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

use Heatbeat\Parser\Template\Node\DefNode as DEF,
    Heatbeat\Parser\Template\Node\CDefNode as CDEF,
    Heatbeat\Parser\Template\Node\VDefNode as VDEF,
    Heatbeat\Parser\Template\Node\GPrintNode as GPrint,
    Heatbeat\Parser\Template\Node\ItemNode as Item;

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

    const TEMPLATE_PARAMETER_AUTO = 'auto';
    const PARAMETER_AUTOSCALE_MIN = 'alt-autoscale-min';
    const PARAMETER_AUTOSCALE_MAX = 'alt-autoscale-max';

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
        if ($lowerlimit == self::TEMPLATE_PARAMETER_AUTO) {
            $this->setOption(self::PARAMETER_AUTOSCALE_MIN, true);
        }
        $this->setOption(self::PARAMETER_LOWER_LIMIT, $lowerlimit);
    }

    public function setUpperlimit($upperlimit) {
        if ($upperlimit == self::TEMPLATE_PARAMETER_AUTO) {
            $this->setOption(self::PARAMETER_AUTOSCALE_MAX, true);
        }
        $this->setOption(self::PARAMETER_UPPER_LIMIT, $upperlimit);
    }

    public function setBase($base) {
        $this->setOption(self::PARAMETER_BASE, $base);
    }

    public function setDefs(array $defs) {
        foreach ($defs as $def) {
            $object = new DEF($def);
            $this->addArgument($object->getAsString());
        }
    }

    public function setCdefs(array $cdefs) {
        foreach ($cdefs as $cdef) {
            $object = new CDEF($cdef);
            $this->addArgument($object->getAsString());
        }
    }

    public function setVdefs(array $vdefs) {
        foreach ($vdefs as $vdef) {
            $object = new VDEF($vdef);
            $this->addArgument($object->getAsString());
        }
    }

    public function setGprints(array $gprints) {
        foreach ($gprints as $gprint) {
            $object = new GPrint($gprint);
            $this->addArgument($object->getAsString());
        }
    }

    public function setItems(array $items) {
        foreach ($items as $item) {
            $object = new Item($item);
            $this->addArgument($object->getAsString());
        }
    }

    public function init() {
        $this->setOptions(
                array(
                    'slope-mode' => true,
                    'width' => 800,
                    'height' => 200,
                )
        );
    }

}
