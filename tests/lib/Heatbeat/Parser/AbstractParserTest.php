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

    public function filenameDataProvider() {
        return array(
            array('file.rrd'),
            array('user.rrd'),
            array('foo.rrd')
        );
    }

    /**
     *
     * @dataProvider filenameDataProvider
     */
    public function testSetGetFilename($filename) {
        $this->assertClassHasAttribute('filename', 'Heatbeat\Parser\AbstractParser');
        $this->assertAttributeEmpty('filename', $this->object);
        $this->object->setFilename($filename);
        $this->assertAttributeNotEmpty('filename', $this->object);
        $this->assertEquals($filename, $this->object->getFilename());
    }

    public function filepathDataProvider() {
        return array(
            array('/'),
            array('/home'),
            array('/home/osman')
        );
    }

    /**
     *
     * @dataProvider filepathDataProvider
     */
    public function testSetGetFilepath($filepath) {
        $this->assertClassHasAttribute('filepath', 'Heatbeat\Parser\AbstractParser');
        $this->assertAttributeEmpty('filepath', $this->object);
        $this->object->setFilepath($filepath);
        $this->assertAttributeNotEmpty('filepath', $this->object);
        $this->assertEquals($filepath, $this->object->getFilepath());
    }

    public function failValueProvider() {
        return array(
            array(array()),
            array('path/to/foo'),
            array(new \stdClass)
        );
    }

    /**
     * @expectedException Heatbeat\Exception\HeatbeatException
     * @dataProvider failValueProvider
     */
    public function testFailSetGetValues($values) {
        $this->assertClassHasAttribute('values', 'Heatbeat\Parser\AbstractParser');
        $this->assertAttributeEmpty('values', $this->object);
        $this->object->setValues($values);
        $this->assertInstanceOf('\\ArrayIterator', $this->object->getValues());
    }

    public function valueDataProvider() {
        return array(
            array(array(1, 2, 3)),
            array(array('foo' => 'bar')),
            array(array('osman', 'baz', 'thing'))
        );
    }

    /**
     *
     * @dataProvider valueDataProvider
     */
    public function testSetGetValues($values) {
        $this->assertClassHasAttribute('values', 'Heatbeat\Parser\AbstractParser');
        $this->assertAttributeEmpty('values', $this->object);
        $this->object->setValues($values);
        $this->assertAttributeNotEmpty('values', $this->object);
        $this->assertEquals(new \ArrayIterator($values), $this->object->getValues());
        $this->assertInstanceOf('\\ArrayIterator', $this->object->getValues());
    }

    public function namePathDataProvider() {
        return array(
            array('', 'foo', '/foo.yml'),
            array('/Users/osman', 'test', '/Users/osman/test.yml'),
            array('path/to', 'file', 'path/to/file.yml')
        );
    }

    /**
     *
     * @dataProvider namePathDataProvider
     */
    public function testGetFullPath($filepath, $filename, $result) {
        $this->object->setFilename($filename);
        $this->object->setFilepath($filepath);
        $this->assertEquals($result, $this->object->getFullPath());
    }
    
    public function testParse() {
        $this->markTestIncomplete();
    }

}

?>
