<?php

namespace Heatbeat\Command;

/**
 * Update
 *
 * Implementation of update command
 *
 * @package    Heatbeat
 * @subpackage Heatbeat\Command
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
class Update extends Shared {
    const SUBCOMMAND = 'update';

    private $time;
    private $values;

    public function setTime($time = 'N') {
        $this->time = $time;
    }

    public function setValues(array $values) {
        $this->values = \implode(self::SEPERATOR, $values);
    }

    public function getTime() {
        return $this->time;
    }

    public function getValues() {
        return $this->values;
    }

    public function execute() {
        $this->addArgument($this->getTime() . self::SEPERATOR . $this->getValues());
        return parent::execute();
    }

}