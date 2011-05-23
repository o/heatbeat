<?php

namespace Rosso;

/**
 * Template
 *
 * Abstract class for YAML templates
 *
 * @package    Rosso
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/rosso
 */
use Symfony\Component\Yaml\Yaml;

class Template {

	private $parser;
	
	function __construct() {
		$this->parser = new Yaml();
	}

	
	
}

?>
