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
 * @package     Heatbeat\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Command\RRDTool;

use Heatbeat\Autoloader,
    Heatbeat\Parser\Template\Node\DefNode as DEF,
    Heatbeat\Parser\Template\Node\CDefNode as CDEF,
    Heatbeat\Parser\Template\Node\VDefNode as VDEF,
    Heatbeat\Parser\Template\Node\GPrintNode as GPrint,
    Heatbeat\Parser\Template\Node\ItemNode as Item;

/**
 * Implementation for RRDTool graph command
 *
 * @category    Heatbeat
 * @package     Heatbeat\Command\RRDTool
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class Graph extends RRDToolCommand {

    protected $subCommand = 'graphv';

    const PARAMETER_START = 'start';
    const PARAMETER_TITLE = 'title';
    const PARAMETER_VERTICAL_LABEL = 'vertical-label';
    const PARAMETER_LOWER_LIMIT = 'lower-limit';
    const PARAMETER_UPPER_LIMIT = 'upper-limit';
    const PARAMETER_BASE = 'base';
    const PARAMETER_AUTOSCALE_MIN = 'alt-autoscale-min';
    const PARAMETER_AUTOSCALE_MAX = 'alt-autoscale-max';
    const TEMPLATE_PARAMETER_AUTO = 'auto';
    const TEMPLATE_PARAMETER_UNLIMITED = 'U';

    /**
     * Adds graph filename as argument
     *
     * @param string $graphFilename
     */
    public function setGraphFilename($graphFilename) {
        $this->addArgument(self::getGraphFilePath($graphFilename));
    }

    /**
     * Sets start time of graph
     *
     * @param int|string $start
     */
    public function setStart($start) {
        $this->setOption(self::PARAMETER_START, $start);
    }

    /**
     * Sets title of graph
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->setOption(self::PARAMETER_TITLE, $title);
    }

    /**
     * Sets vertical label of graph
     *
     * @param string $verticalLabel
     */
    public function setVerticalLabel($verticalLabel) {
        $this->setOption(self::PARAMETER_VERTICAL_LABEL, $verticalLabel);
    }

    /**
     * Sets lower limit of graph
     *
     * @param int|string $lowerlimit
     * @return void
     */
    public function setLowerlimit($lowerlimit) {
        if ($lowerlimit === self::TEMPLATE_PARAMETER_AUTO) {
            $this->setOption(self::PARAMETER_AUTOSCALE_MIN, true);
            return;
        }
        $this->setOption(self::PARAMETER_LOWER_LIMIT, $lowerlimit);
    }

    /**
     * Sets upper limit of graph
     *
     * @param int|string $upperlimit
     * @return void
     */
    public function setUpperlimit($upperlimit) {
        if ($upperlimit === self::TEMPLATE_PARAMETER_AUTO) {
            $this->setOption(self::PARAMETER_AUTOSCALE_MAX, true);
            return;
        }
        $this->setOption(self::PARAMETER_UPPER_LIMIT, $upperlimit);
    }

    /**
     * Sets base multiplier 
     *
     * @param int $base
     */
    public function setBase($base) {
        $this->setOption(self::PARAMETER_BASE, $base);
    }

    /**
     * Adds graph definitions as argument
     *
     * @param array $defs
     */
    public function setDefs(array $defs) {
        foreach ($defs as $def) {
            $this->addArgument($def->getAsString());
        }
    }

    /**
     * Adds CDEFs as argument
     *
     * @param array $cdefs
     */
    public function setCdefs(array $cdefs) {
        foreach ($cdefs as $cdef) {
            $this->addArgument($cdef->getAsString());
        }
    }

    /**
     * Adds VDEFs as argument
     *
     * @param array $vdefs
     */
    public function setVdefs(array $vdefs) {
        foreach ($vdefs as $vdef) {
            $this->addArgument($vdef->getAsString());
        }
    }

    /**
     * Adds gprints as argument
     * @param array $gprints
     */
    public function setGprints(array $gprints) {
        foreach ($gprints as $gprint) {
            $this->addArgument($gprint->getAsString());
        }
    }

    /**
     * Adds graph items as argument
     *
     * @param array $items
     */
    public function setItems(array $items) {
        foreach ($items as $item) {
            $this->addArgument($item->getAsString());
        }
    }

    public function init() {
        $this->setOptions(
                array(
                    'slope-mode' => true,
                    'width' => 800,
                    'height' => 200,
                    'end' => -300,
                    'units-exponent' => 0
                )
        );
    }

}