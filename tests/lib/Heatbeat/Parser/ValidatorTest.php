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

    public function alphanumProvider() {
        return array(
          array('foo'),
          array('noSoupForYou'),
          array(12),
          array('datastore2'),
          array('IAMVALID')
        );
    }

    /**
     * @dataProvider alphanumProvider
     */
    public function testIsAlphanum($param) {
        $this->assertTrue($this->object->isAlphanum($param));
    }

    /**
     * @todo Implement testIsHex().
     */
    public function testIsHex() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testIsBlank().
     */
    public function testIsBlank() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
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
