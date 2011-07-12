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

    public function testSetCommand() {
        $this->assertNull($this->object->getCommand());
        $this->object->setCommand('git');
        $this->assertEquals('git', $this->object->getCommand());
    }

    public function testSetSubCommand() {
        $this->assertNull($this->object->getSubCommand());
        $this->object->setSubCommand('checkout');
        $this->assertEquals('checkout', $this->object->getSubCommand());
    }

    public function testSetArguments() {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setArguments(array('foo', 'bar', 'baz'));
        $this->assertEquals(array('foo', 'bar', 'baz'), $this->object->getArguments());

        $this->setExpectedException('\ErrorException');
        $this->object->setArguments('bogus');
    }

    public function testAddArgument() {
        $this->assertEmpty($this->object->getArguments());
        $this->object->addArgument('arg');
        $this->assertContains('arg', $this->object->getArguments());
    }

    public function testSetOptions() {
        $this->assertEmpty($this->object->getOptions());
        $this->object->setOptions(array('foo' => 'bar', 'baz' => 'do'));
        $this->assertEquals(array('foo' => 'bar', 'baz' => 'do'), $this->object->getOptions());

        $this->setExpectedException('\ErrorException');
        $this->object->setOptions('bogus');
    }

    public function testSetOption() {
        $this->assertEmpty($this->object->getOptions());
        $this->object->setOption('baz');
        $this->assertContains(array('baz' => true), $this->object->getOptions());

        $this->object->setOption('flag', 'value');
        $this->assertContains(array('flag' => 'value'), $this->object->getOptions());
    }

    public function testGetCommand() {
        $this->assertNull($this->object->getCommand());
        $this->object->setCommand('svn');
        $this->assertEquals('svn', $this->object->getCommand());
    }

    public function testGetSubCommand() {
        $this->assertNull($this->object->getSubCommand());
        $this->object->setSubCommand('revert');
        $this->assertEquals('revert', $this->object->getSubCommand());
    }

    public function testGetArguments() {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setArguments(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->object->getArguments());
    }

    public function testGetOptions() {
        $this->assertEmpty($this->object->getOptions());
        $this->object->setOptions(array('foo' => 'graph'));
        $this->assertEquals(array('foo' => 'graph'), $this->object->getOptions());
    }

}

?>
