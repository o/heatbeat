<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for GPrintNode.
 */
class GPrintNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new GPrintNode($array);
        $this->assertSame($result, $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new GPrintNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new GPrintNode($array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('definition-name' => 'foo', 'format' => '%6.2lf %Sbps'), 'GPRINT:foo:%6.2lf %Sbps'),
            array(array('definition-name' => 'temp', 'format' => 'Bar %lf%s'), 'GPRINT:temp:Bar %lf%s'),
            array(array('definition-name' => 'disk1', 'format' => 'Avg %5.2lf'), 'GPRINT:disk1:Avg %5.2lf'),
            array(array('definition-name' => 'cpu', 'format' => 'Cur %5.2lf'), 'GPRINT:cpu:Cur %5.2lf')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('definition-name' => 'foo!', 'format' => '%6.2lf %Sbps')),
            array(array('definition-name' => '', 'format' => '%lf%s')),
            array(array('definition-name' => 'disk1', 'frmat' => 'Avg %5.2lf')),
            array(array('definitionname' => 'cpu', 'format' => 'Cur %5.2lf')),
            array(array('definitionname' => 'cpu', 'format' => ''))
        );
    }

}

?>
