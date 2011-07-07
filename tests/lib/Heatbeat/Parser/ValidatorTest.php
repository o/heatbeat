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

    /**
     * @todo Implement testHasArrayKey().
     */
    public function testHasArrayKey() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
