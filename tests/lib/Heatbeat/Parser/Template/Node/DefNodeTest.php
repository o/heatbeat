<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DefNode.
 */
class DefNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider defDataProvider
     */
    public function testGetAsString($name, $filename, $datastorename, $cf, $result) {
        $object = new DefNode(array(
                    'name' => $name,
                    'filename' => $filename,
                    'datastore-name' => $datastorename,
                    'cf' => $cf
                ));
        $this->assertEquals($result, $object->getAsString());
    }

    public function defDataProvider() {
        return array(
            array('ds0a', 'test.rrd', 'ds0', 'AVERAGE', 'DEF:ds0a=test.rrd:ds0:AVERAGE'),
            array('fooDS', 'baz.rrd', 'barDS', 'LAST', 'DEF:fooDS=baz.rrd:barDS:LAST'),
        );
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate1() {
        $object = new DefNode(array(
                    'filename' => 'baz.rrd',
                    'datastore-name' => 'barDS',
                    'cf' => 'LAST'
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate2() {
        $object = new DefNode(array(
                    'name' => 'fooDS',
                    'datastore-name' => 'barDS',
                    'cf' => 'LAST'
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate3() {
        $object = new DefNode(array(
                    'name' => 'fooDS',
                    'filename' => 'baz.rrd',
                    'cf' => 'LAST'
                ));
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate4() {
        $object = new DefNode(array(
                    'name' => 'fooDS',
                    'filename' => 'baz.rrd',
                    'datastore-name' => 'barDS',
                    'cf' => 'LOL'
                ));
        $object->validate();
    }

}

?>
