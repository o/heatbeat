<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for TemplateOptionNode.
 */
class TemplateOptionNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new TemplateOptionNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new TemplateOptionNode($array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'Loads', 'version' => 0.1, 'source-name' => 'Foo_Random')),
            array(array('name' => 'Randoms', 'version' => 1, 'source-name' => 'System_Load')),
            array(array('name' => 'Foo', 'version' => 2, 'source-name' => 'Foo_Random')),
            array(array('name' => 'Baz data', 'version' => 0.2, 'source-name' => 'Foo_Random')),
            array(array('name' => 'No name', 'version' => 0.5, 'source-name' => 'Foo_Random'))
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('name' => '', 'version' => 0.1, 'source-name' => 'Foo_Random')),
            array(array('name' => 'Randoms', 'version' => '', 'source-name' => 'System_Load')),
            array(array('name' => 'Foo', 'version' => 2, 'source-name' => '')),
            array(array('names' => 'Baz data', 'version' => 0.2, 'source-name' => 'Foo_Random')),
            array(array('name' => 'No name', 'versions' => 0.5, 'source-name' => 'Foo_Random')),
            array(array('name' => 'No name', 'version' => 0.5, 'sourcename' => 'Foo_Random')),
            array(array('name' => 'Randoms', 'version' => 1, 'source-name' => 'System_Loads'))
        );
    }

}

?>
