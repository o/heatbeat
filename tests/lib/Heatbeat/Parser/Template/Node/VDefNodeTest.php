<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for VDefNode.
 */
class VDefNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData;

    protected function setUp() {
        $this->validationData = array(
            'name' => 'test',
            'rpn' => 'inbytes,10,*',
        );
    }

    /**
     * @dataProvider vdefDataProvider
     */
    public function testGetAsString($name, $rpn, $result) {
        $object = new VDefNode(array(
                    'name' => $name,
                    'rpn' => $rpn
                ));
        $this->assertEquals($result, $object->getAsString());
        $this->assertTrue($object->validate());
    }

    public function vdefDataProvider() {
        return array(
            array('ds2', 'ds0,95,PERCENT', 'VDEF:ds2=ds0,95,PERCENT'),
            array('var_name', 'RPN_expression', 'VDEF:var_name=RPN_expression')
        );
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testNameNotExists() {
        $array = $this->validationData;
        unset($array['name']);
        $object = new VDefNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testRpnNotExists() {
        $array = $this->validationData;
        unset($array['rpn']);
        $object = new VDefNode($array);
        $object->validate();
    }

}

?>
