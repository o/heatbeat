<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for VDefNode.
 */
class VDefNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new VDefNode($array);
        $this->assertSame($result, $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new VDefNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new VDefNode($array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'result', 'rpn' => '1,0,value,IF'), 'VDEF:result=1,0,value,IF'),
            array(array('name' => 'inbits', 'rpn' => 'inbytes,8,*'), 'VDEF:inbits=inbytes,8,*'),
            array(array('name' => 'test', 'rpn' => 'number,100000,GT,UNKN,number,IF'), 'VDEF:test=number,100000,GT,UNKN,number,IF'),
            array(array('name' => 'eq', 'rpn' => 'TIME,1202924474,GT,a,a,UN,0,a,IF,IF,TIME,1202924474,GT,c,c,UN,0,c,IF,IF,+'), 'VDEF:eq=TIME,1202924474,GT,a,a,UN,0,a,IF,IF,TIME,1202924474,GT,c,c,UN,0,c,IF,IF,+'),
            array(array('name' => 'foo', 'rpn' => 'a,0,*'), 'VDEF:foo=a,0,*')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('name' => '', 'rpn' => '1,0,value,IF')),
            array(array('name' => 'inbits', 'rpn' => '')),
            array(array('foo' => 'test', 'rpn' => 'number,100000,GT,UNKN,number,IF')),
            array(array('name' => 'foo;', 'baz' => 'a,0,*')),
            array(array('name' => 'ds!', 'rpn' => '1,0,value,IF'))
        );
    }
    

}

?>
