<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for GraphOptionNode.
 */
class GraphOptionNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData = array(
        'name' => 'test',
        'label' => 'Test',
        'base' => 1000,
        'lower' => 10,
        'upper' => 50
    );

    public function testValidate() {
        $array = $this->validationData;
        $object = new GraphOptionNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testNameNotExists() {
        $array = $this->validationData;
        unset($array['name']);
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testLabelNotExists() {
        $array = $this->validationData;
        unset($array['label']);
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testBaseNotExists() {
        $array = $this->validationData;
        unset($array['base']);
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testLowerNotExists() {
        $array = $this->validationData;
        unset($array['lower']);
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testUpperNotExists() {
        $array = $this->validationData;
        unset($array['upper']);
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidBase() {
        $array = $this->validationData;
        $array['base'] = 'foo';
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidLower() {
        $array = $this->validationData;
        $array['lower'] = 'bar';
        $object = new GraphOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidUpper() {
        $array = $this->validationData;
        $array['upper'] = 'baz';
        $object = new GraphOptionNode($array);
        $object->validate();
    }

}

?>
