<?php

namespace Heatbeat\Parser\Config\Node;

/**
 * Test class for ConfigurationNode.
 */
class ConfigurationNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($input) {
        $object = new ConfigurationNode($input);
        $this->assertTrue($object->validate());
    }

    /**
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($input) {
        $this->setExpectedException('Heatbeat\Exception\NodeValidationException');
        $object = new ConfigurationNode($input);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('log' => 'foo')),
            array(array('log' => array('foo' => 'baz', 'enabled' => false)))
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('log' => '')),
            array(array('long' => 'foo'))
        );
    }

}

?>
