<?php

namespace Heatbeat;

/**
 * Autoloader
 *
 * Heatbeat autoloader
 *
 * @package    Heatbeat
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
use \Symfony\Component\ClassLoader\UniversalClassLoader;

class Autoloader {
    const FOLDER_TEMPLATE = 'template';
    const FOLDER_EXTERNAL = 'external';
    const FOLDER_LIBRARY = 'lib';
    const FOLDER_RRD = 'rrd';

    private static $instance;
    private $loader;
    private $paths;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->setPaths();
        $this->register();
    }

    private function setPaths() {
        $rootPath = realpath(dirname(__DIR__) . \DIRECTORY_SEPARATOR . '..');
        $this->paths = array(
            'root' => $rootPath,
            'lib' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_LIBRARY,
            'template' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_TEMPLATE,
            'external' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_EXTERNAL,
            'rrd' => $rootPath . \DIRECTORY_SEPARATOR . self::FOLDER_RRD
        );
    }

    private function register() {
        require_once 'lib/Symfony/Component/ClassLoader/UniversalClassLoader.php';
        $loader = new UniversalClassLoader();
        $loader->registerNamespaces(array(
            'Symfony\Component' => $this->getPath('lib'),
            'Heatbeat' => $this->getPath('lib'),
                )
        );

        $loader->register();
        $this->setLoader($loader);
    }

    private function setLoader($loader) {
        $this->loader = $loader;
    }

    public function getPath($path) {
        return $this->paths[$path];
    }

}

?>
