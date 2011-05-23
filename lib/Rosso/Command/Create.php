<?php

namespace Rosso\Command;

/**
 * Create
 *
 * Implementation of create command
 *
 * @package    Rosso
 * @subpackage Rosso\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/rosso
 */

/**
 * Dependencies of command
 * Arguments : filename, --step and --start argument (oh also --no-overwrite)
 * Objects : Datastore and RRA arguments
 *
 */
class Create extends Shared {
	const PARAMETER_STEP = 'step';
	const SUBCOMMAND = 'create';

	public function setStep($step = 300) {
		$this->setOption(self::PARAMETER_STEP, $step);
	}

	public function setDatastores(array $datastores) {
		foreach ($datastores as $datastore) {
			$this->addArgument($datastore);
		}
	}

	public function setRras($rras) {
		foreach ($rras as $rra) {
			$this->addArgument($rra);
		}
	}

}