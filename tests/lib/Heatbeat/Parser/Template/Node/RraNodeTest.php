<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for RraNode.
 */
class RraNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new RraNode($array);
        $this->assertArrayHasKey('cf', $array);
        $this->assertArrayHasKey('xff', $array);
        $this->assertArrayHasKey('steps', $array);
        $this->assertArrayHasKey('rows', $array);
        $this->assertEquals($result, $object->getAsString());
        $this->assertInternalType('string', $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new RraNode($array);
        $this->assertInternalType('array', $array);
        $this->assertArrayHasKey('cf', $array);
        $this->assertArrayHasKey('xff', $array);
        $this->assertArrayHasKey('steps', $array);
        $this->assertArrayHasKey('rows', $array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new RraNode($array);
        $this->assertInternalType('array', $array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('cf' => 'AVERAGE', 'xff' => 0.5, 'steps' => 4, 'rows' => 100), 'RRA:AVERAGE:0.5:4:100'),
            array(array('cf' => 'LAST', 'xff' => 1, 'steps' => 1, 'rows' => 324), 'RRA:LAST:1:1:324'),
            array(array('cf' => 'MIN', 'xff' => 0.1, 'steps' => 12, 'rows' => 564), 'RRA:MIN:0.1:12:564'),
            array(array('cf' => 'MAX', 'xff' => 0.5, 'steps' => 6, 'rows' => 456), 'RRA:MAX:0.5:6:456'),
            array(array('cf' => 'AVERAGE', 'xff' => 0.8, 'steps' => 2, 'rows' => 68), 'RRA:AVERAGE:0.8:2:68'),
            array(array('cf' => 'AVERAGE', 'xff' => 0.5, 'steps' => 30, 'rows' => 1000), 'RRA:AVERAGE:0.5:30:1000'),
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('cfs' => 'AVERAGE', 'xff' => 0.5, 'steps' => 4, 'rows' => 100)),
            array(array('cf' => 'AVERAGE', 'xffs' => 0.5, 'steps' => 4, 'rows' => 100)),
            array(array('cf' => 'AVERAGE', 'xff' => 0.5, 'step' => 4, 'rows' => 100)),
            array(array('cf' => 'AVERAGE', 'xff' => 0.5, 'steps' => 4, 'row' => 100)),
            array(array('cf' => 'AVERAGE', 'xff' => 2, 'steps' => 4, 'rows' => 100)),
            array(array('cf' => 'AVERAGE', 'xff' => 'too', 'steps' => 'baz', 'rows' => 100)),
            array(array('cf' => 'AVERAGE', 'xff' => 0.5, 'steps' => 'baz', 'rows' => 100)),
            array(array('cf' => 'AVERAGE', 'xff' => 0.5, 'steps' => 4, 'rows' => 'f99')),
            array(array('cf' => 'AVERAGES', 'xff' => 0.5, 'steps' => 4, 'rows' => 11)),
        );
    }

}