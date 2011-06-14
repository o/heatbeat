<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DatastoreNode.
 */
class DatastoreNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData = array(
        'name' => 'test',
        'type' => 'GAUGE',
        'heartbeat' => 600,
        'min' => 0,
        'max' => 100
    );

    /**
     * @dataProvider dsDataProvider
     */
    public function testGetAsString($name, $type, $heartbeat, $min, $max, $result) {
        $object = new DatastoreNode(array(
                    'name' => $name,
                    'type' => $type,
                    'heartbeat' => $heartbeat,
                    'min' => $min,
                    'max' => $max
                ));
        $this->assertEquals($result, $object->getAsString());
    }

    public function dsDataProvider() {
        return array(
            array('temp', 'GAUGE', 600, 0, 100, 'DS:temp:GAUGE:600:0:100'),
            array('ifOutOctets', 'COUNTER', 1800, 0, 4294967295, 'DS:ifOutOctets:COUNTER:1800:0:4294967295')
        );
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate1() {
        $array = $this->validationData;
        unset($array['name']);
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate2() {
        $array = $this->validationData;
        unset($array['type']);
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate3() {
        $array = $this->validationData;
        unset($array['heartbeat']);
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate4() {
        $array = $this->validationData;
        unset($array['min']);
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate5() {
        $array = $this->validationData;
        unset($array['max']);
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate6() {
        $array = $this->validationData;
        $array['type'] = 'FOO';
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate7() {
        $array = $this->validationData;
        $array['heartbeat'] = 'foo';        
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate8() {
        $array = $this->validationData;
        $array['min'] = 'foo';        
        $object = new DatastoreNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidate9() {
        $array = $this->validationData;
        $array['max'] = 'foo';        
        $object = new DatastoreNode($array);
        $object->validate();
    }

}

?>
