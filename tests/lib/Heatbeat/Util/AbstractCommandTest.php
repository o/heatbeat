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

    protected function assertPreConditions() {
        $this->assertAttributeEmpty('arguments', $this->object);
        $this->assertAttributeEmpty('options', $this->object);
        $this->assertAttributeEmpty('command', $this->object);
        $this->assertAttributeEmpty('subCommand', $this->object);
    }

    /**
     * @dataProvider commandProvider
     */
    public function testSetGetCommand($command) {
        $this->assertTrue($this->object->setCommand($command));
        $this->assertAttributeNotEmpty('command', $this->object);
        $this->assertAttributeEquals($command, 'command', $this->object);
        $this->assertEquals(
                $command, $this->object->getCommand()
        );
    }

    public function commandProvider() {
        return array(
            array('git'),
            array('svn'),
            array('more'),
            array('tail'),
            array('bzr')
        );
    }

    /**
     *
     * @dataProvider subcommandProvider
     */
    public function testSetGetSubCommand($subcommand) {
        $this->assertTrue($this->object->setSubCommand($subcommand));
        $this->assertAttributeNotEmpty('subCommand', $this->object);
        $this->assertAttributeEquals($subcommand, 'subCommand', $this->object);
        $this->assertEquals(
                $subcommand, $this->object->getSubCommand()
        );
    }

    public function subcommandProvider() {
        return array(
            array('revert'),
            array('checkout'),
            array('log'),
            array('commit'),
            array('branch')
        );
    }

    /**
     * @dataProvider argumentsProvider
     */
    public function testSetGetArguments($arguments) {
        $this->assertTrue($this->object->setArguments($arguments));
        $this->assertAttributeNotEmpty('arguments', $this->object);
        $this->assertAttributeEquals($arguments, 'arguments', $this->object);
        $this->assertEquals(
                $arguments, $this->object->getArguments()
        );
    }

    public function argumentsProvider() {
        return array(
            array(array(1, 2, 3)),
            array(array('foo', 'bar', 'baz')),
            array(array('some', 'arguments')),
            array(array('filename.rrd')),
            array(array('lots', 'of', 'string', 'arguments'))
        );
    }

    /**
     * @dataProvider argumentProvider
     */
    public function testAddGetArgument($argument) {
        $this->assertTrue($this->object->addArgument($argument));
        $this->assertAttributeNotEmpty('arguments', $this->object);
        $this->assertAttributeContains($argument, 'arguments', $this->object);
        $this->assertEquals(
                array($argument), $this->object->getArguments()
        );
    }

    public function argumentProvider() {
        return array(
            array('test'),
            array('foo'),
            array('bar'),
            array('baz'),
            array('arg'),
        );
    }

    /**
     * @dataProvider optionProvider
     */
    public function testSetGetOptions($key, $value) {
        $options = array($key => $value);
        $this->assertTrue($this->object->setOptions($options));
        $this->assertAttributeNotEmpty('options', $this->object);
        $this->assertAttributeEquals($options, 'options', $this->object);
        $this->assertArrayHasKey($key, $this->object->getOptions());
        $this->assertEquals(
                $options, $this->object->getOptions()
        );
    }

    /**
     * @dataProvider optionProvider
     */
    public function testSetGetOption($key, $value) {
        $this->assertTrue($this->object->setOption($key, $value));
        $this->assertAttributeNotEmpty('options', $this->object);
        $this->assertAttributeEquals(array($key => $value), 'options', $this->object);
        $this->assertArrayHasKey($key, $this->object->getOptions());
        $this->assertEquals
                (array($key => $value), $this->object->getOptions()
        );
    }

    public function optionProvider() {
        return array(
            array('baz', 'bar'),
            array('foo', 'baz'),
            array('width', 12),
            array('min', 5),
            array('step', 300)
        );
    }

}

?>
