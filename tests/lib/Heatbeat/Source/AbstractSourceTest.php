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

    public function testGetInput() {
        $this->assertNull($this->object->getInput());
        $this->object->setInput(new SourceInput(array('foo' => 'baz')));
        $this->assertEquals(new SourceInput(array('foo' => 'baz')), $this->object->getInput());
    }

    public function testSetInput() {
        $this->assertNull($this->object->getInput());
        $this->object->setInput(new SourceInput(array('foo' => 'bar')));
        $this->assertEquals(new SourceInput(array('foo' => 'bar')), $this->object->getInput());

        $this->setExpectedException('\ErrorException');
        $this->object->setInput('bogus');
    }

    public function testGetOutput() {
        $this->assertNull($this->object->getOutput());
        $this->object->setOutput(new SourceOutput(array('foo' => 'baz')));
        $this->assertEquals(new SourceOutput(array('foo' => 'baz')), $this->object->getOutput());
    }

    public function testSetOutput() {
        $this->assertNull($this->object->getOutput());
        $this->object->setOutput(new SourceOutput(array('foo' => 'bar')));
        $this->assertEquals(new SourceOutput(array('foo' => 'bar')), $this->object->getOutput());

        $this->setExpectedException('\ErrorException');
        $this->object->setInput('bogus');
    }

    public function testPerform() {
        $this->setExpectedException('\Heatbeat\Exception\SourceException');
        $this->object->perform();
    }

    public function testgetExternalFolderPath() {
        $this->assertStringEndsWith('heatbeat/external', $this->object->getExternalFolderPath());
    }

}

?>
