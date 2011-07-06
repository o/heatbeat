<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for ItemNode.
 */
class ItemNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData;

    protected function setUp() {
        $this->validationData = array(
            'type' => 'AREA',
            'definition-name' => 'ds0',
            'color' => 'FFF000',
            'legend' => 'Oh my..'
        );
    }

    /**
     * @dataProvider itemDataProvider
     */
    public function testGetAsString($type, $definitionname, $color, $legend, $result) {
        $object = new ItemNode(array(
                    'type' => $type,
                    'definition-name' => $definitionname,
                    'color' => $color,
                    'legend' => $legend
                ));
        $this->assertEquals($result, $object->getAsString());
        $this->assertTrue($object->validate());
    }

    public function itemDataProvider() {
        return array(
            array('LINE', 'ds1', 'FFFFFF', 'Test Legend', 'LINE:ds1#FFFFFF:Test Legend'),
            array('AREA', 'ds0c', 'FF00FF', 'resolution 7200 seconds per interval', 'AREA:ds0c#FF00FF:resolution 7200 seconds per interval'),
            array('STACK', 'ds2', 'FF00FA', 'moo', 'STACK:ds2#FF00FA:moo'),
            array('LINE2', 'meh', 'FF00FC', 'bars', 'LINE2:meh#FF00FC:bars')
        );
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testTypeNotExists() {
        $array = $this->validationData;
        unset($array['type']);
        $object = new ItemNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testDefinitionNotExists() {
        $array = $this->validationData;
        unset($array['definition-name']);
        $object = new ItemNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testColorNotExists() {
        $array = $this->validationData;
        unset($array['color']);
        $object = new ItemNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testLegendNotExists() {
        $array = $this->validationData;
        unset($array['legend']);
        $object = new ItemNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidType() {
        $array = $this->validationData;
        $array['type'] = 'FOO';
        $object = new ItemNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidColor() {
        $array = $this->validationData;
        $array['color'] = 'FFFFFZ';
        $object = new ItemNode($array);
        $object->validate();
    }

}

?>
