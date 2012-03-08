<?php

/**
 * Copyright 2012 Osman Ungur
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
 * @package     Heatbeat\Utility
 * @author      Osman Ungur <osmanungur@gmail.com>
 * @copyright   2011 Osman Ungur
 * @license     http://www.apache.org/licenses/LICENSE-2.0
 * @link        http://github.com/import/heatbeat
 */

namespace Heatbeat\Utility;

/**
 * Helper methods for common file paths
 *
 * @category    Heatbeat
 * @package     Heatbeat\Utility
 * @author      Osman Ungur <osmanungur@gmail.com>
 */
class PathUtility {

    /**
     *
     * @var string 
     */
    private $rootPath;

    /**
     * Extension of rrd files
     */
    const RRD_EXT = '.rrd';

    /**
     * Extension of png files
     */
    const PNG_EXT = '.png';

    /**
     * Extension of png files
     */
    const LOG_EXT = '.log';

    /**
     * Extension of yml files
     */
    const YML_EXT = '.yml';

    /**
     * Filename of config file 
     */
    const CONFIG_FILENAME = 'config';

    function __construct() {
        $this->setRootPath(realpath(dirname(__FILE__) . '/../../../'));
    }

    /**
     * Sets project root path, only usual for unit tests
     * 
     * @param string $rootPath 
     */
    public function setRootPath($rootPath) {
        $this->rootPath = $rootPath;
    }

    /**
     * Returns project root path
     * 
     * @return string 
     */
    public function getRootPath() {
        return $this->rootPath;
    }

    /**
     * Returns path of project folder
     * 
     * @param string $folder
     * @return string 
     */
    public function getFolderPath($folder) {
        return $this->getRootPath() . DIRECTORY_SEPARATOR . $folder;
    }

    /**
     * Returns full path of graph file
     * 
     * @param string $filename
     * @return string 
     */
    public function getGraphFilePath($filename) {
        return $this->getFolderPath('graphs') . DIRECTORY_SEPARATOR . $filename . self::PNG_EXT;
    }

    /**
     * Returns full path of rrd file
     * 
     * @param string $filename
     * @return string 
     */
    public function getRRDFilePath($filename) {
        return $this->getFolderPath('rrd') . DIRECTORY_SEPARATOR . $filename . self::RRD_EXT;
    }

    /**
     * Returns full path of log
     * 
     * @param string $filename
     * @return string 
     */
    public function getLogFilePath($filename) {
        return $this->getFolderPath('logs') . DIRECTORY_SEPARATOR . $filename . self::LOG_EXT;
    }

    /**
     * Returns full path of external script
     * 
     * @param string $filename
     * @return string 
     */
    public function getExternalScriptPath($filename) {
        return $this->getFolderPath('external') . DIRECTORY_SEPARATOR . $filename;
    }

    /**
     * Returns full path of config file
     * 
     * @return string 
     */
    public function getConfigFilePath() {
        return $this->getRootPath() . DIRECTORY_SEPARATOR . self::CONFIG_FILENAME . self::YML_EXT;
    }

    /**
     * Returns full path of template file
     * 
     * @param string $filename
     * @return string 
     */
    public function getTemplateFilePath($filename) {
        return $this->getFolderPath('templates') . DIRECTORY_SEPARATOR . $filename . self::YML_EXT;
    }

}

