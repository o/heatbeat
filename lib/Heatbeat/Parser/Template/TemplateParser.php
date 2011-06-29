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
 * @package     Heatbeat\Parser\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Parser\Template;

use Heatbeat\Parser\AbstractParser,
    Heatbeat\Autoloader,
    Heatbeat\Parser\Template\Node\TemplateOptionNode as TemplateOptions,
    Heatbeat\Parser\Template\Node\RrdOptionNode as RrdOptions,
    Heatbeat\Parser\Template\Node\DatastoreNode as Datastore,
    Heatbeat\Parser\Template\Node\GraphOptionNode as GraphOptions,
    Heatbeat\Parser\Template\Node\ItemNode as Item,
    Heatbeat\Parser\Template\Node\DefNode as Def,
    Heatbeat\Parser\Template\Node\CDefNode as CDef,
    Heatbeat\Parser\Template\Node\CDefNode as VDef,
    Heatbeat\Parser\Template\Node\GPrintNode as GPrint,
    Heatbeat\Parser\Template\Node\RraNode as Rra,
    Heatbeat\Util\Command\RRDTool\RRDToolCommand as RRDTool,
    Heatbeat\Exception\TemplateException;

/**
 * Template file parser
 *
 * @category    Heatbeat
 * @package     Heatbeat\Parser\Template
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class TemplateParser extends AbstractParser {

    public function __construct($filename) {
        $this->setFilePath(Autoloader::getInstance()->getPath(Autoloader::FOLDER_TEMPLATE));
        $this->setFilename($filename);
        $this->setValues($this->parse());
    }

    public function getTemplateOptions() {
        $values = $this->getValues();
        if ($values->offsetExists('template') AND array_key_exists('options', $values['template'])) {
            $templateOptions = new TemplateOptions($values['template']['options']);
            $templateOptions->validate();
            return $templateOptions;
        } else {
            throw new TemplateException(sprintf('Template options is not defined in template %s', $this->getFullPath()));
        }
    }

    public function getRrdOptions() {
        $values = $this->getValues();
        if ($values->offsetExists('rrd') AND array_key_exists('options', $values['rrd'])) {
            $rrdOptions = new RrdOptions($values['rrd']['options']);
            $rrdOptions->validate();
            return $rrdOptions;
        } else {
            throw new TemplateException(sprintf('RRD options is not defined in template %s', $this->getFullPath()));
        }
    }

    public function getRrdDatastores() {
        $values = $this->getValues();
        if ($values->offsetExists('rrd') AND array_key_exists('datastores', $values['rrd']) AND count($values['rrd']['datastores'])) {
            return array_map(function($datastore) {
                        $object = new Datastore($datastore);
                        $object->validate();
                        return $object;
                    }, $values['rrd']['datastores']);
        } else {
            throw new TemplateException(sprintf('You must define at least one datastore in template %s', $this->getFullPath()));
        }
    }

    public function getRrdRras() {
        $values = $this->getValues();
        if ($values->offsetExists('rrd') AND array_key_exists('rras', $values['rrd']) AND count($values['rrd']['rras'])) {
            $newValues = array();
            foreach ($values['rrd']['rras'] as $rra) {
                $consolidationFunctions = $rra['cf'];
                if (is_array($consolidationFunctions)) {
                    foreach ($consolidationFunctions as $consolidationFunction) {
                        $newRra = array();
                        $newRra['cf'] = $consolidationFunction;
                        $newRra['xff'] = $rra['xff'];
                        $newRra['steps'] = $rra['steps'];
                        $newRra['rows'] = $rra['rows'];
                        $object = new Rra($newRra);
                        $object->validate();
                        array_push($newValues, $object);
                    }
                } else {
                    $object = new Rra($rra);
                    $object->validate();
                    array_push($newValues, $object);
                }
            }
            return $newValues;
        } else {
            throw new TemplateException(sprintf('You must define at least one Round Robin Archive in template %s', $this->getFullPath()));
        }
    }

    public function getGraphEntityCount() {
        $values = $this->getValues();
        if ($values->offsetExists('graphs') AND $values->offsetGet('graphs')) {
            return count($values->offsetGet('graphs'));
        } else {
            throw new TemplateException(sprintf('No graphs defined in template %s', $this->getFullPath()));
        }
    }

    private function getGraphIndex($index) {
        $values = $this->getValues();
        if (array_key_exists($index, $values['graphs'])) {
            return new \ArrayObject($values['graphs'][$index]);
        } else {
            throw new TemplateException(sprintf('No graph definition found in template %s with index %s', $this->getFullPath(), $index));
        }
    }

    public function getGraphOptions($index) {
        $values = $this->getGraphIndex($index);
        if ($values->offsetExists('options') AND count($values->offsetGet('options'))) {
            $graphOptions = new GraphOptions($values->offsetGet('options'));
            $graphOptions->validate();
            return $graphOptions;
        } else {
            throw new TemplateException(sprintf('Graph options is not defined in template %s', $this->getFullPath()));
        }
    }

    public function getGraphItems($index) {
        $values = $this->getGraphIndex($index);
        if ($values->offsetExists('items') AND count($values->offsetGet('items'))) {
            return array_map(function($item) {
                        $object = new Item($item);
                        $object->validate();
                        return $object;
                    }, $values->offsetGet('items'));
        } else {
            throw new TemplateException(sprintf('Graph items is not defined in template %s', $this->getFullPath()));
        }
    }

    public function getGraphGprints($index) {
        $values = $this->getGraphIndex($index);
        if ($values->offsetExists('gprints') AND count($values->offsetGet('gprints'))) {
            return array_map(function($gprint) {
                        $object = new GPrint($gprint);
                        $object->validate();
                        return $object;
                    }, $values->offsetGet('gprints'));
        } else {
            return false;
        }
    }

    public function getGraphDefs($index, $filename) {
        $values = $this->getGraphIndex($index);
        if ($values->offsetExists('defs') AND count($values->offsetGet('defs'))) {
            return array_map(function($def, $filename) {
                        $object = new Def($def);
                        $object->offsetSet('filename', RRDTool::getRRDFilePath($filename));
                        $object->validate();
                        return $object;
                    }, $values->offsetGet('defs'), array_fill(0, count($values->offsetGet('defs')), $filename));
        } else {
            throw new TemplateException(sprintf('Graph definitions is not defined in template %s', $this->getFullPath()));
        }
    }

    public function getGraphCdefs($index) {
        $values = $this->getGraphIndex($index);
        if ($values->offsetExists('cdefs') AND count($values->offsetGet('cdefs'))) {
            return array_map(function($cdef) {
                        $object = new CDef($cdef);
                        $object->validate();
                        return $object;
                    }, $values->offsetGet('cdefs'));
        } else {
            return false;
        }
    }

    public function getGraphVdefs($index) {
        $values = $this->getGraphIndex($index);
        if ($values->offsetExists('vdefs') AND count($values->offsetGet('vdefs'))) {
            return array_map(function($vdef) {
                        $object = new VDef($vdef);
                        $object->validate();
                        return $object;
                    }, $values->offsetGet('vdefs'));
        } else {
            return false;
        }
    }

}

