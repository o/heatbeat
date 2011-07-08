<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for RrdOptionNode.
 */
class RrdOptionNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new RrdOptionNode($array);
        $this->assertInternalType('array', $array);
        $this->assertArrayHasKey('step', $array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new RrdOptionNode($array);
        $this->assertInternalType('array', $array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('step' => 200)),
            array(array('step' => 500)),
            array(array('step' => 60)),
            array(array('step' => 700)),
            array(array('step' => 1200))
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('step' => 'foo')),
            array(array('step' => -1)),
            array(array('step' => 0.5)),
            array(array('step' => '')),
            array(array('stp' => 1200))
        );
    }

}