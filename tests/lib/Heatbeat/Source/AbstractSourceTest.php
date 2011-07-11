<?php

namespace Heatbeat\Source;

/**
 * Test class for AbstractSource.
 */
class AbstractSourceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractSource
     */
    protected $object;

    protected function setUp() {
        $this->object = $this->getMockForAbstractClass('\Heatbeat\Source\AbstractSource');
    }

    public function inputOutputDataProvider() {
        return array(
            array(array('foo' => 'bar', 'baz' => 'fuu')),
            array(array('a' => 'journey', 'never' => 'ends')),
            array(array('temp' => '12', 'type' => 'f')),
            array(array('arg1' => 'state', 'arg2' => 'trance')),
            array(array('loc' => 'NY'))
        );
    }

    /**
     *
     * @dataProvider inputOutputDataProvider
     */
    public function testSetGetInput($input) {
        $input = new SourceInput($input);
        $this->assertClassHasAttribute('input', '\Heatbeat\Source\AbstractSource');
        $this->assertAttributeEmpty('input', $this->object);
        $this->object->setInput(new SourceInput($input));
        $this->assertAttributeNotEmpty('input', $this->object);
        $this->assertAttributeEquals($input, 'input', $this->object);
        $this->assertAttributeInstanceOf('\Heatbeat\Source\SourceInput', 'input', $this->object);
        $this->assertEquals($input, $this->object->getInput());
        $this->assertInstanceOf('\Heatbeat\Source\SourceInput', $this->object->getInput());
    }

    /**
     *
     * @dataProvider inputOutputDataProvider
     */
    public function testSetGetOutput($output) {
        $output = new SourceOutput($output);
        $this->assertClassHasAttribute('output', '\Heatbeat\Source\AbstractSource');
        $this->assertAttributeEmpty('output', $this->object);
        $this->object->setOutput($output);
        $this->assertAttributeNotEmpty('output', $this->object);
        $this->assertAttributeEquals($output, 'output', $this->object);
        $this->assertAttributeInstanceOf('\Heatbeat\Source\SourceOutput', 'output', $this->object);
        $this->assertEquals($output, $this->object->getOutput());
        $this->assertInstanceOf('\Heatbeat\Source\SourceOutput', $this->object->getOutput());
    }

    /**
     * @expectedException \Heatbeat\Exception\SourceException
     */
    public function testPerform() {
        $this->object->perform();
    }

}

?>
