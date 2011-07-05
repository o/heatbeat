<?php

namespace Heatbeat\Util;

/**
 * Test class for AbstractCommand.
 */
class AbstractCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractCommand
     */
    protected $object;

    protected function setUp() {
        $this->object = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
    }

    public function testSetGetCommand() {
        $command = 'svn';
        $this->assertTrue($this->object->setCommand($command));
        $this->assertEquals(
                $command, $this->object->getCommand()
        );
    }

    public function testSetGetSubCommand() {
        $subcommand = 'revert';
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

    public function testAddGetArgument() {
        $this->object->setArguments(array());
        $this->assertTrue($this->object->addArgument('test'));
        $this->assertEquals(
                array('test'), $this->object->getArguments()
        );
    }

    public function testSetGetOptions() {
        $options = array('foo' => 'bar', 'baz' => 'moar');
        $this->assertTrue($this->object->setOptions($options));
        $this->assertEquals(
                $options, $this->object->getOptions()
        );
    }

    public function testSetGetOption() {
        $this->assertTrue($this->object->setOption('baz', 'bar'));
        $this->assertEquals
                (array('baz' => 'bar'), $this->object->getOptions()
        );
    }

}

?>
