<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for TemplateOptionNode.
 */
class TemplateOptionNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData = array(
        'name' => 'test',
        'version' => '1.0',
        'source-name' => 'Foo_Random'
    );

    public function testValidate() {
        $array = $this->validationData;
        $object = new TemplateOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testNameNotExists() {
        $array = $this->validationData;
        unset($array['name']);
        $object = new TemplateOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testVersionNotExists() {
        $array = $this->validationData;
        unset($array['version']);
        $object = new TemplateOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testSourceNotExists() {
        $array = $this->validationData;
        unset($array['source-name']);
        $object = new TemplateOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testValidSource() {
        $array = $this->validationData;
        $array['source-name'] = 'Foo_Bar';
        $object = new TemplateOptionNode($array);
        $object->validate();
    }

}

?>
