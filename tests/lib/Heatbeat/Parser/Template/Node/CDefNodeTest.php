<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for CDefNode.
 */
class CDefNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData;

    protected function setUp() {
        $this->validationData = array(
            'name' => 'result',
            'rpn' => '1,0,value,IF',
        );
    }

    /**
     * @dataProvider cdefDataProvider
     */
    public function testGetAsString($name, $rpn, $result) {
        $object = new CDefNode(array(
                    'name' => $name,
                    'rpn' => $rpn
                ));
        $this->assertEquals($result, $object->getAsString());
        $this->assertTrue($object->validate());
    }

    public function cdefDataProvider() {
        return array(
            array('inbits', 'inbytes,8,*', 'CDEF:inbits=inbytes,8,*'),
            array('test', 'number,100000,GT,UNKN,number,IF', 'CDEF:test=number,100000,GT,UNKN,number,IF')
        );
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testNameNotExists() {
        $array = $this->validationData;
        unset($array['name']);
        $object = new CDefNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testRpnNotExists() {
        $array = $this->validationData;
        unset($array['rpn']);
        $object = new CDefNode($array);
        $object->validate();
    }

}

?>
