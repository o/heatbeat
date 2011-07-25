<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for ItemNode.
 */
class ItemNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new ItemNode($array);
        $this->assertSame($result, $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new ItemNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new ItemNode($array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('type' => 'AREA', 'definition-name' => 'ds1', 'color' => 'F1BE4F', 'legend' => 'Datastore 1', 'stack' => false), 'AREA:ds1#F1BE4F:Datastore 1'),
            array(array('type' => 'LINE', 'definition-name' => 'ds2', 'color' => 'EE9A37', 'legend' => 'Datastore 2', 'stack' => false), 'LINE:ds2#EE9A37:Datastore 2'),
            array(array('type' => 'LINE1', 'definition-name' => 'dd3', 'color' => 'FF339A', 'legend' => 'DD 3', 'stack' => false), 'LINE1:dd3#FF339A:DD 3'),
            array(array('type' => 'LINE2', 'definition-name' => 'files', 'color' => 'E71966', 'legend' => 'Filez', 'stack' => false), 'LINE2:files#E71966:Filez'),
            array(array('type' => 'LINE3', 'definition-name' => 'temps', 'color' => 'D90A51', 'legend' => 'Temperatures', 'stack' => true), 'LINE3:temps#D90A51:Temperatures:STACK'),
            array(array('type' => 'LINE', 'definition-name' => 'users', 'color' => '000000', 'legend' => 'Users', 'stack' => true), 'LINE:users#000000:Users:STACK')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('typ' => 'AREA', 'definition-name' => 'ds1', 'color' => 'F1BE4F', 'legend' => 'Datastore 1', 'stack' => false)),
            array(array('type' => 'LINE', 'definitionname' => 'ds2', 'color' => 'EE9A37', 'legend' => 'Datastore 2', 'stack' => false)),
            array(array('type' => 'LINE1', 'definition-name' => 'dd3', 'colo' => 'FF339A', 'legend' => 'DD 3', 'stack' => false)),
            array(array('type' => 'LINE2', 'definition-name' => 'files', 'color' => 'E71966', 'legen' => 'Filez', 'stack' => false)),
            array(array('type' => '', 'definition-name' => 'temps', 'color' => 'D90A51', 'legend' => 'Temperatures', 'stack' => false)),
            array(array('type' => 'STACK', 'definition-name' => '', 'color' => '000000', 'legend' => 'Users', 'stack' => false)),
            array(array('type' => 'AREA', 'definition-name' => 'ds1', 'color' => '', 'legend' => 'Datastore 1', 'stack' => false)),
            array(array('type' => 'LINE', 'definition-name' => 'ds2', 'color' => 'EE9A37', 'legend' => '', 'stack' => false)),
            array(array('type' => 'LINE5', 'definition-name' => 'dd3', 'color' => 'FF339A', 'legend' => 'DD 3', 'stack' => false)),
            array(array('type' => 'LINE2', 'definition-name' => 'files', 'color' => 'Z71966', 'legend' => 'Filez', 'stack' => false)),
            array(array('type' => 'LINE3', 'definition-name' => 'temps!', 'color' => 'D90A51', 'legend' => 'Temperatures', 'stack' => false)),
            array(array('type' => 'AREA', 'definition-name' => 'ds1', 'color' => '234533', 'legend' => 'Datastore 1', 'stakc' => false)),
            array(array('type' => 'LINE', 'definition-name' => 'ds3213', 'color' => '456344', 'legend' => 'Datastore 432', 'stack' => ''))
        );
    }

}

?>
