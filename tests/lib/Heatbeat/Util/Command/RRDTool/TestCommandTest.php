<?php

namespace Heatbeat\Util\Command\RRDTool;

/**
 * Test class for TestCommand.
 */
class TestCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var TestCommand
     */
    protected $object;

    protected function setUp() {
        $this->object = new TestCommand;
    }

    public function testDefaultCommandName() {
        $this->assertEquals(
                $this->object->getCommand(), 'rrdtool'
        );
    }

    public function testPredefinedSubCommandName() {
        $this->assertEquals(
                $this->object->getSubCommand(), 'test'
        );
    }

    public function testSetGetCommand() {
        $command = 'ls';
        $this->assertTrue($this->object->setCommand($command));
        $this->assertEquals(
                $command, $this->object->getCommand()
        );
    }

    public function testSetGetSubCommand() {
        $subcommand = 'clear';
        $this->assertTrue($this->object->setSubCommand($subcommand));
        $this->assertEquals(
                $subcommand, $this->object->getSubCommand()
        );
    }

    public function testSetGetArguments() {
        $arguments = array('foo', 'bar', 'baz');
        $this->assertTrue($this->object->setArguments($arguments));
        $this->assertEquals(
                $arguments, $this->object->getArguments()
        );
    }

    protected function resetArgs() {
        $this->object->setArguments(array());
    }

    public function testAddGetArgument() {
        $this->resetArgs();
        $this->assertTrue($this->object->addArgument('test'));
        $this->assertEquals(array('test'), $this->object->getArguments());
    }

    public function testSetGetOptions() {
        $options = array('foo' => 'bar', 'baz' => 'moar');
        $this->assertTrue($this->object->setOptions($options));
        $this->assertEquals(
                $options, $this->object->getOptions()
        );
    }

    private function resetOpts() {
        $this->object->setOptions(array());
    }

    public function testSetGetOption() {
        $this->resetOpts();
        $this->assertTrue($this->object->setOption('baz', 'bar'));
        $this->assertEquals(array('baz' => 'bar'), $this->object->getOptions());
    }

}

?>
