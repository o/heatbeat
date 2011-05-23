<?php

require "Symfony/Component/ClassLoader/UniversalClassLoader.php";

/**
 * Loader
 *
 * Main system loader
 *
 * @package    Rosso
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/rosso
 */
use Symfony\Component\ClassLoader\UniversalClassLoader as Loader;

class Rosso {

	static public function load() {
		$loader = new Loader();
		$loader->registerNamespaces(array(
			'Symfony\Component' => __DIR__,
			'Rosso' => __DIR__,
				)
		);

		$loader->register();
	}

	static public function getRootPath() {
		return dirname(__DIR__);
	}

}

?>
