<?php

namespace Heatbeat\Cli;

/**
 * Update
 *
 * Callback for update cli command
 * 
 * @package    Heatbeat
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
use Symfony\Component\Console\Input\InputArgument,
	Symfony\Component\Console\Input\InputOption,
	Symfony\Component\Console,
	Symfony\Component\Console\Input\InputInterface,
	Symfony\Component\Console\Output\OutputInterface;

class Update extends Console\Command\Command {

	public function configure() {
		$this
				->setName('update')
				->setDescription('Updates all RRD files')
				->setDefinition(array(
					new InputOption('verbose', 'v', InputOption::VALUE_OPTIONAL, 'Prints verbose information about update process')
				));
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		// dummy
		$output->write('All of RRDs updated');
	}

}
