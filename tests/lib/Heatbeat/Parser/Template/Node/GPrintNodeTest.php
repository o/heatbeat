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
            array(array('definition-name' => 'foo', 'cf' => 'AVERAGE', 'format' => '%6.2lf %Sbps'), 'GPRINT:foo:AVERAGE:%6.2lf %Sbps'),
            array(array('definition-name' => 'temp',  'cf' => 'MAX', 'format' => 'Bar %lf%s'), 'GPRINT:temp:MAX:Bar %lf%s'),
            array(array('definition-name' => 'disk1',  'cf' => 'MIN', 'format' => 'Avg %5.2lf'), 'GPRINT:disk1:MIN:Avg %5.2lf'),
            array(array('definition-name' => 'cpu',  'cf' => 'LAST', 'format' => 'Cur %5.2lf'), 'GPRINT:cpu:LAST:Cur %5.2lf')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('definition-name' => 'foo!', 'cf' => 'AVERAGE', 'format' => '%6.2lf %Sbps')),
            array(array('definition-name' => '', 'cf' => 'AVERAGE', 'format' => '%lf%s')),
            array(array('definition-name' => 'disk1', 'cf' => 'AVERAGE', 'frmat' => 'Avg %5.2lf')),
            array(array('definitionname' => 'cpu', 'cf' => 'AVERAGE', 'format' => 'Cur %5.2lf')),
            array(array('definitionname' => 'cpu', 'cf' => 'AVERAGE', 'format' => '')),
            array(array('definition-name' => 'disk1',  '' => 'MIN', 'format' => 'Avg %5.2lf')),
            array(array('definition-name' => 'cpu',  'cf' => 'MORE', 'format' => 'Cur %5.2lf'))
            );
    }

}

?>
