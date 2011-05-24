<?php

namespace Heatbeat\Command;

/**
 * Graph
 *
 * Implementation of graph command
 *
 * @package    Heatbeat
 * @subpackage Heatbeat\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
class Graph extends Shared {
	const SUBCOMMAND = 'graph';

	const PARAMETER_START = 'start';
	const PARAMETER_TITLE = 'title';
	const PARAMETER_VERTICAL_LABEL = 'vertical-label';
	const PARAMETER_LOWER_LIMIT = 'lower-limit';
	const PARAMETER_UPPER_LIMIT = 'upper-limit';
	const PARAMETER_BASE = 'base';

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
		$this->setOption(self::PARAMETER_LOWER_LIMIT, $lowerlimit);
	}

	public function setUpperlimit($upperlimit) {
		$this->setOption(self::PARAMETER_UPPER_LIMIT, $upperlimit);
	}

	public function setBase($base) {
		$this->setOption(self::PARAMETER_BASE, $base);
	}

	public function setDefs(array $defs) {
		foreach ($defs as $def) {
			$this->addArgument($def);
		}
	}

	public function setCdefs(array $cdefs) {
		foreach ($cdefs as $cdef) {
			$this->addArgument($cdef);
		}
	}

	public function setVdefs(array $vdefs) {
		foreach ($vdefs as $vdef) {
			$this->addArgument($vdef);
		}
	}

	public function setGprints(array $gprints) {
		foreach ($gprints as $gprint) {
			$this->addArgument($gprint);
		}
	}

	public function setElements(array $elements) {
		foreach ($elements as $element) {
			$this->addArgument($element);
		}
	}

}
