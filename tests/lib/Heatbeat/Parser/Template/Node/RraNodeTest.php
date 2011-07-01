<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for RraNode.
 */
class RraNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData = array(
        'cf' => 'AVERAGE',
        'xff' => 0.5,
        'steps' => 1,
        'rows' => 273
    );

    /**
     * @dataProvider rraDataProvider
     */
    public function testGetAsString($cf, $xff, $steps, $rows, $result) {
        $object = new RraNode(array(
                    'cf' => $cf,
                    'xff' => $xff,
                    'steps' => $steps,
                    'rows' => $rows
                ));
        $this->assertEquals($result, $object->getAsString());
        $this->assertTrue($object->validate());
    }

    public function rraDataProvider() {
        return array(
            array('AVERAGE', 1, 12, 24, 'RRA:AVERAGE:1:12:24'),
            array('MAX', 0.5, 1, 288, 'RRA:MAX:0.5:1:288')
        );
    }
 
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testCfNotExists() {
        $array = $this->validationData;
        unset($array['cf']);
        $object = new RraNode($array);
        $object->validate();
    }    
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testXffNotExists() {
        $array = $this->validationData;
        unset($array['xff']);
        $object = new RraNode($array);
        $object->validate();
    }        
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testStepsNotExists() {
        $array = $this->validationData;
        unset($array['steps']);
        $object = new RraNode($array);
        $object->validate();
    }        
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testRowsNotExists() {
        $array = $this->validationData;
        unset($array['rows']);
        $object = new RraNode($array);
        $object->validate();
    }    
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidCf() {
        $array = $this->validationData;
        $array['cf'] = 'FOO';
        $object = new RraNode($array);
        $object->validate();
    }    
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidXff() {
        $array = $this->validationData;
        $array['xff'] = 12;
        $object = new RraNode($array);
        $object->validate();
    }  
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidSteps() {
        $array = $this->validationData;
        $array['steps'] = 'foo';
        $object = new RraNode($array);
        $object->validate();
    }     
    
    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidRows() {
        $array = $this->validationData;
        $array['rows'] = 'foo';
        $object = new RraNode($array);
        $object->validate();
    }     
 
    
}