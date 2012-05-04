<?php

namespace Heatbeat\Leaf\Template;

/**
 * Test class for CDef.
 */
class CDefTest extends \PHPUnit_Framework_TestCase {

    public function validDataProvider() {
        return array(
            array(array('name' => 'result', 'rpn' => '1,0,value,IF'), 'CDEF:result=1,0,value,IF'),
            array(array('name' => 'inbits', 'rpn' => 'inbytes,8,*'), 'CDEF:inbits=inbytes,8,*'),
            array(array('name' => 'eth0', 'rpn' => 'number,100000,GT,UNKN,number,IF'), 'CDEF:eth0=number,100000,GT,UNKN,number,IF'),
            array(array('name' => 'eq', 'rpn' => 'TIME,1202924474,GT,a,a,UN,0,a,IF,IF,TIME,1202924474,GT,c,c,UN,0,c,IF,IF,+'), 'CDEF:eq=TIME,1202924474,GT,a,a,UN,0,a,IF,IF,TIME,1202924474,GT,c,c,UN,0,c,IF,IF,+'),
            array(array('name' => 'users_12', 'rpn' => 'a,0,*'), 'CDEF:users_12=a,0,*')
        );
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidateWithValidData($data) {
        $object = new CDefLeaf($data);
        $this->assertTrue($object->validate());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsStringWithValidData($data, $result) {
        $object = new CDefLeaf($data);
        $this->assertEquals($result, $object->getAsString());
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateBlankName() {
        $object = new CDefLeaf(array('name' => null, 'rpn' => 'foo'));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateBlankRpn() {
        $object = new CDefLeaf(array('name' => 'bar', 'rpn' => null));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateNonAlphanumericName() {
        $object = new CDefLeaf(array('name' => 'interface 12', 'rpn' => 'baz'));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Leaf\LeafValidationException
     */
    public function testInvalidateWithLackingValue() {
        $object = new CDefLeaf(array('rpn' => 'foo'));
        $object->validate();
    }

}