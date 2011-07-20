<?php

namespace Heatbeat\Parser;

/**
 * Test class for Validator.
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Validator
     */
    protected $object;

    protected function setUp() {
        $this->object = new Validator;
    }

    public function validAlphanumProvider() {
        return array(
            array('foo'),
            array('noSoupForYou'),
            array(12),
            array('datastore2'),
            array('IAMVALID')
        );
    }

    public function inValidAlphanumProvider() {
        return array(
            array('meh_'),
            array('foo bar'),
            array('baz/'),
            array('1231*'),
            array('IAMNOTVALID!!')
        );
    }

    /**
     * @dataProvider validAlphanumProvider
     */
    public function testIsAlphanum($param) {
        $this->assertTrue($this->object->isAlphanum($param));
    }

    /**
     * @dataProvider inValidAlphanumProvider
     */
    public function testIsAlphanumFail($param) {
        $this->assertFalse($this->object->isAlphanum($param));
    }

    public function validHexProvider() {
        return array(
            array('FFFF00'),
            array(000000),
            array('00AAAA'),
            array(187263),
            array('ADDAEE')
        );
    }

    public function invalidHexProvider() {
        return array(
            array('FFFF0G'),
            array('GGGGGG'),
            array('00AHAA'),
            array('78687V'),
            array('ADXAEE')
        );
    }

    /**
     * @dataProvider validHexProvider
     */
    public function testIsHex($param) {
        $this->assertTrue($this->object->isHex($param));
    }

    /**
     * @dataProvider invalidHexProvider
     */
    public function testIsHexFail($param) {
        $this->assertFalse($this->object->isHex($param));
    }

    public function testIsNotBlank() {
        $this->assertFalse($this->object->isNotBlank(''));
        $this->assertFalse($this->object->isNotBlank(NULL));
        $this->assertTrue($this->object->isNotBlank(0));
        $this->assertTrue($this->object->isNotBlank('foo'));
        $this->assertTrue($this->object->isNotBlank(FALSE));
        $this->assertTrue($this->object->isNotBlank(TRUE));
    }

    public function validIntProvider() {
        return array(
            array(0),
            array(300),
            array(100000),
            array(2147483647),
            array(59830741908237490)
        );
    }

    public function invalidIntProvider() {
        return array(
            array(0.5),
            array(-1),
            array('foo'),
            array(false),
            array(new \stdClass)
        );
    }

    /**
     * @dataProvider validIntProvider
     */
    public function testIsInt($param) {
        $this->assertTrue($this->object->isInt($param));
    }

    /**
     * @dataProvider invalidIntProvider
     */
    public function testIsIntFail($param) {
        $this->assertFalse($this->object->isInt($param));
    }

    public function validArrayKeyProvider() {
        return array(
            array('foo', array('foo' => 'bar')),
            array('foo', new \ArrayObject(array('foo' => 'bar'))),
            array('foo', new \ArrayIterator(array('foo' => 'bar'))),
            array('foo', array('foo' => array(1, 2, 3 => array('baz'))))
        );
    }

    public function invalidArrayKeyProvider() {
        return array(
            array('this', array('foo' => 'bar')),
            array('cf', new \ArrayObject(array('baz' => 'bar'))),
            array('mf', new \ArrayIterator(array('foolish' => 'bar'))),
            array('amf', array('foo' => 'bar'))
        );
    }

    /**
     * @dataProvider validArrayKeyProvider
     */
    public function testHasArrayKey($key, $array) {
        $this->assertTrue($this->object->hasArrayKey($key, $array));
    }

    /**
     * @dataProvider invalidArrayKeyProvider
     */
    public function testHasArrayKeyFail($key, $array) {
        $this->assertFalse($this->object->hasArrayKey($key, $array));
    }

    public function validArrayContainProvider() {
        return array(
            array('foo', array('foo', 'bar')),
            array('baz', array('foo', 'baz')),
            array(1, array(1, 2, 3)),
            array('ccc', new \ArrayIterator(array(1 => 'ccc', 2 => 'meh')))
        );
    }

    public function invalidArrayContainProvider() {
        return array(
            array('a', array('foo', 'bar')),
            array('b', array('foo', 'baz')),
            array(4, array(1, 2, 3)),
            array('fff', new \ArrayIterator(array(1 => 'ccc', 2 => 'meh')))
        );
    }

    /**
     * @dataProvider validArrayContainProvider
     */
    public function testHasContains($needle, $haystackarray) {
        $this->assertTrue($this->object->hasContains($needle, $haystackarray));
    }

    /**
     * @dataProvider invalidArrayContainProvider
     */
    public function testHasContainsFail($needle, $haystackarray) {
        $this->assertFalse($this->object->hasContains($needle, $haystackarray));
    }

}

?>
