<?php

namespace Heatbeat\Parser;

/**
 * Test class for AbstractParser.
 */
class AbstractParserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractParser
     */
    protected $object;

    protected function setUp() {
        $this->object = $this->getMockForAbstractClass('Heatbeat\Parser\AbstractParser');
    }

    public function testGetFilename() {
        $this->assertNull($this->object->getFilename());
        $this->object->setFilename('foo');
        $this->assertEquals('foo', $this->object->getFilename());
    }

    public function testSetFilename() {
        $this->assertNull($this->object->getFilename());
        $this->object->setFilename('bar');
        $this->assertEquals('bar', $this->object->getFilename());
    }

    public function testSetFilepath() {
        $this->assertNull($this->object->getFilepath());
        $this->object->setFilepath('/path/to/foo');
        $this->assertEquals('/path/to/foo', $this->object->getFilepath());
    }

    public function testGetFilepath() {
        $this->assertNull($this->object->getFilepath());
        $this->object->setFilepath('/path/to/bar');
        $this->assertEquals('/path/to/bar', $this->object->getFilepath());
    }


    public function testGetFullPath() {
        $this->object->setFilepath('/home/osman/devel/heatbeat');
        $this->object->setFilename('test');
        $this->assertEquals('/home/osman/devel/heatbeat/test.yml', $this->object->getFullPath());
    }

    public function validFilenameProvider() {
        return array(
            array('sample1'),
            array('sample2'),
            array('sample3')
        );
    }

    /**
     * @dataProvider validFilenameProvider
     */
    public function testParse($filename) {
        $this->object->setFilepath(__DIR__ . '/fixtures');
        $this->object->setFilename($filename);
        $this->assertFileExists($this->object->getFullPath());
        $this->object->parse();
        $this->assertAttributeInstanceOf('\ArrayIterator', 'values', $this->object);
    }

    public function invalidFilenameProvider() {
        return array(
            array('sample4'),
            array('sample5'),
            array('sample6')
        );
    }

    /**
     * @dataProvider invalidFilenameProvider
     * @expectedException Heatbeat\Exception\HeatbeatException
     */
    public function testParseFail($filename) {
        $this->object->setFilepath(__DIR__ . '/fixtures');
        $this->object->setFilename($filename);
        $this->assertFileNotExists($this->object->getFullPath());
        $this->object->parse();
    }

    public function testGetValues() {
        $this->assertNull($this->object->getValues());
        $this->object->setValues(array(1,2,3));
        $this->assertEquals(new \ArrayIterator(array(1,2,3)), $this->object->getValues());
    }

    public function testSetValues() {
        $this->assertNull($this->object->getValues());
        $this->object->setValues(array(4,5,6));
        $this->assertEquals(new \ArrayIterator(array(4,5,6)), $this->object->getValues());
    }

}

?>
