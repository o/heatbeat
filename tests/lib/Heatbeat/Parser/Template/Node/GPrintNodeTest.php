<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for GPrintNode.
 */
class GPrintNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider gprintDataProvider
     */
    public function testGetAsString($definitionname, $format, $result) {
        $object = new GPrintNode(array(
                    'definition-name' => $definitionname,
                    'format' => $format
                ));
        $this->assertEquals($result, $object->getAsString());
    }

    public function gprintDataProvider() {
        return array(
            array('ds0avg', '%6.2lf %Sbps', 'GPRINT:ds0avg:"%6.2lf %Sbps"'),
            array('ds1min', '%6.2lf %Sbps', 'GPRINT:ds1min:"%6.2lf %Sbps"')
        );
    }
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate1() {
        $object = new GPrintNode(array(
                    'definition-name' => 'test'
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */    
    public function testValidate2() {
        $object = new GPrintNode(array(
                    'format' => 'test'
                ));
        $object->validate();
    }

}

?>
