<?php

namespace Heatbeat\Util\Command\RRDTool;

/**
 * Test class for GraphCommand.
 */
class GraphCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var GraphCommand
     */
    protected $object;

    protected function setUp() {
        $this->object = new GraphCommand;
    }

    public function assertPreConditions() {
        $this->assertAttributeEquals('rrdtool', 'command', $this->object);
        $this->assertAttributeEquals('graphv', 'subCommand', $this->object);
        $this->assertAttributeEmpty('arguments', $this->object);
        $this->assertAttributeNotEmpty('options', $this->object);
        $this->assertArrayHasKey('slope-mode', $this->object->getOptions());
        $this->assertArrayHasKey('width', $this->object->getOptions());
        $this->assertArrayHasKey('height', $this->object->getOptions());
        $this->assertArrayHasKey('end', $this->object->getOptions());
        $this->assertAttributeContains(
                array(array('slope-mode' => true)), 'options', $this->object
        );
        $this->assertAttributeContains(
                array(array('width' => 800)), 'options', $this->object
        );
        $this->assertAttributeContains(
                array(array('height' => 200)), 'options', $this->object
        );
        $this->assertAttributeContains(
                array(array('end' => -300)), 'options', $this->object
        );
    }

    /**
     * @todo Implement testSetGraphFilename().
     */
    public function testSetGraphFilename() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSetStart() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetTitle().
     */
    public function testSetTitle() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetVerticalLabel().
     */
    public function testSetVerticalLabel() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetLowerlimit().
     */
    public function testSetLowerlimit() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetUpperlimit().
     */
    public function testSetUpperlimit() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetBase().
     */
    public function testSetBase() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetDefs().
     */
    public function testSetDefs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetCdefs().
     */
    public function testSetCdefs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetVdefs().
     */
    public function testSetVdefs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetGprints().
     */
    public function testSetGprints() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testSetItems().
     */
    public function testSetItems() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @todo Implement testInit().
     */
    public function testInit() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
