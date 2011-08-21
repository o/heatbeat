<?php

namespace Heatbeat\Definition\Template;

/**
 * Test class for RraDefinition.
 */
class RraDefinitionTest extends \PHPUnit_Framework_TestCase {

    public function testCurrent() {
        $definition = new RraDefinition(
                        array(array('cf' => 'AVERAGE', 'xff' => 0.8, 'steps' => 2, 'rows' => 68))
        );
        foreach ($definition as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\RraNode', $value);
        }
    }

    public function testCurrentWithMultipleCF() {
        $definition = new RraDefinition(
                        array(array('cf' => array('AVERAGE', 'LAST'), 'xff' => 0.5, 'steps' => 4, 'rows' => 100))
        );
        foreach ($definition as $value) {
            $this->assertInstanceOf('\Heatbeat\Parser\Template\Node\RraNode', $value);
        }
    }
    
    
}

?>
