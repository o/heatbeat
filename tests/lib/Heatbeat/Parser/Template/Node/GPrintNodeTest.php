<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for GPrintNode.
 */
class GPrintNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData = array(
        'definition-name' => 'ds0',
        'format' => '%6.2lf %Sbps'
    );

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
        $array = $this->validationData;
        unset($array['definition-name']);
        $object = new GPrintNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate2() {
        $array = $this->validationData;
        unset($array['format']);
        $object = new GPrintNode($array);
        $object->validate();
    }

}

?>
