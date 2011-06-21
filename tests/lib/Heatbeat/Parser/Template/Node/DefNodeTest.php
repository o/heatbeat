<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DefNode.
 */
class DefNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData = array(
        'name' => 'test',
        'filename' => 'baz.rrd',
        'datastore-name' => 'ds0',
        'cf' => 'AVERAGE'
    );

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
        $this->assertTrue($object->validate());
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
    public function testNameNotExists() {
        $array = $this->validationData;
        unset($array['name']);
        $object = new DefNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testFilenameNotExists() {
        $array = $this->validationData;
        unset($array['filename']);
        $object = new DefNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testDatastoreNotExists() {
        $array = $this->validationData;
        unset($array['datastore-name']);
        $object = new DefNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testCfNotExists() {
        $array = $this->validationData;
        unset($array['cf']);
        $object = new DefNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidCf() {
        $array = $this->validationData;
        $array['cf'] = 'FOO';
        $object = new DefNode($array);
        $object->validate();
    }

}

?>
