<?php

namespace Heatbeat;

/**
 * Command
 *
 * Abstract class for interacting with command line
 *
 * @package    Heatbeat
 * @author     Osman Üngür <osmanungur@gmail.com>
 * @copyright  2011 Osman Üngür
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://github.com/import/heatbeat
 */
abstract class Command {
    const LONG_OPTION = '--';

    private $command;
    private $subCommand;
    private $arguments = array();
    private $options = array();

    /**
     *
     * @param string $command
     * @return Command
     */
    protected function setCommand($command) {
        $this->command = $command;
        return $this;
    }

    /**
     *
     * @param string $subCommand
     * @return Command
     */
    protected function setSubCommand($subCommand) {
        $this->subCommand = $subCommand;
        return $this;
    }

    /**
     *
     * @param array $arguments
     * @return Command
     */
    protected function setArguments(array $arguments) {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     *
     * @param string $value
     * @return Command
     */
    protected function addArgument($value) {
        $this->arguments[] = $value;
        return $this;
    }

    /**
     *
     * @param array $options
     * @return Command
     */
    protected function setOptions(array $options) {
        $this->options = $options;
        return $this;
    }

    /**
     *
     * @param string $name
     * @param string $value
     * @return Command
     */
    protected function setOption($name, $value = true) {
        $this->options[$name] = $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    private function getCommand() {
        return $this->command;
    }

    /**
     *
     * @return string
     */
    private function getSubCommand() {
        return $this->subCommand;
    }

    /**
     *
     * @return array
     */
    private function getArguments() {
        return $this->arguments;
    }

    /**
     *
     * @return array
     */
    private function getOptions() {
        return $this->options;
    }

    /**
     * Prepares command for execution
     *
     * @return string
     */
    public function prepare() {
        $result = new \ArrayObject();
        $result->append($this->getCommand());
        $result->append($this->getSubCommand());
        foreach ($this->getOptions() as $key => $option) {
            if ($option === false) {
                continue;
            }
            $result->append(self::LONG_OPTION . $key);
            if ($option !== true) {
                $result->append(\escapeshellarg($option));
            }
        }
        foreach ($this->getArguments() as $argument) {
            $result->append(\escapeshellarg($argument));
        }
        return \implode(\chr(32), \iterator_to_array($result));
    }

    public function execute() {
        \exec($this->prepare(), $output, $return_var);
        if ($return_var > 0) {
            throw new \RuntimeException(implode(PHP_EOL, $output), $return_var);
        }
        return implode(PHP_EOL, $output);
    }

}

?>
