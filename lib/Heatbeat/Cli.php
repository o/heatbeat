<?php

namespace Heatbeat;

/**
 * Cli
 *
 * Application class for Cli interface
 *
 * @package    Heatbeat
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
use Symfony\Component\Console\Application,
	Application\Cli\Command;

class Cli extends Application {

	public function __construct() {
		parent::__construct('Welcome to Heatbeat Graphing Tool CLI Interface', '1.0');

		$this->addCommands(array(
			new \Heatbeat\Cli\Update()
		));
	}

}
