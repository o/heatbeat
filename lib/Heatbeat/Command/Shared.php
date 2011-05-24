<?php

namespace Heatbeat\Command;

/**
 * Shared
 *
 * Common methods for commands
 *
 * @package    Heatbeat
 * @subpackage Heatbeat\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
use \Heatbeat\Command;

abstract class Shared extends Command {
    const SEPERATOR = ':';
    const EXECUTABLE = 'rrdtool';

    public function __construct() {
        $this->setCommand(self::EXECUTABLE);
        $this->setSubCommand(self::SUBCOMMAND);
    }

    public function setFilename($filename) {
        $this->addArgument($filename);
    }

}