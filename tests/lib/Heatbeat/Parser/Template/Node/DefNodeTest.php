<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DefNode.
 */
class DefNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new DefNode($array);
        $this->assertSame($result, $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new DefNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new DefNode($array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'test', 'filename' => 'baz.rrd', 'datastore-name' => 'ds1', 'cf' => 'AVERAGE'), 'DEF:test=baz.rrd:ds1:AVERAGE'),
            array(array('name' => 'def1', 'filename' => 'users.rrd', 'datastore-name' => 'def2', 'cf' => 'MAX'), 'DEF:def1=users.rrd:def2:MAX'),
            array(array('name' => 'tree', 'filename' => 'usage.rrd', 'datastore-name' => 'tree', 'cf' => 'MIN'), 'DEF:tree=usage.rrd:tree:MIN'),
            array(array('name' => 'baz', 'filename' => 'files.rrd', 'datastore-name' => 'bar', 'cf' => 'LAST'), 'DEF:baz=files.rrd:bar:LAST'),
            array(array('name' => 'averages', 'filename' => 'git.rrd', 'datastore-name' => 'averages', 'cf' => 'AVERAGE'), 'DEF:averages=git.rrd:averages:AVERAGE')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('nam' => 'test', 'filename' => 'baz.rrd', 'datastore-name' => 'ds1', 'cf' => 'AVERAGE')),
            array(array('name' => 'def1', 'filenam' => 'users.rrd', 'datastore-name' => 'def2', 'cf' => 'MAX')),
            array(array('name' => 'tree', 'filename' => 'usage.rrd', 'datastorename' => 'tree', 'cf' => 'MIN')),
            array(array('name' => 'baz', 'filename' => 'files.rrd', 'datastore-name' => 'bar', 'cfs' => 'LAST')),
            array(array('name' => '', 'filename' => 'git.rrd', 'datastore-name' => 'averages', 'cf' => 'AVERAGE')),
            array(array('name' => 'test', 'filename' => '', 'datastore-name' => 'ds1', 'cf' => 'AVERAGE')),
            array(array('name' => 'def1', 'filename' => 'users.rrd', 'datastore-name' => '', 'cf' => 'MAX')),
            array(array('name' => 'tree', 'filename' => 'usage.rrd', 'datastore-name' => 'tree', 'cf' => '')),
            array(array('name' => 'baz', 'filename' => 'files.rrd', 'datastore-name' => 'bar', 'cf' => 'LASTS')),
            array(array('name' => 'averages!', 'filename' => 'git.rrd', 'datastore-name' => 'averages', 'cf' => 'AVERAGE')),
            array(array('name' => 'test', 'filename' => 'baz.rrd', 'datastore-name' => 'ds1/', 'cf' => 'AVERAGE'))
        );
    }

}

?>
