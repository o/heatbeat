<?php

namespace Heatbeat\Source;

/**
 * Test class for AbstractSource.
 */
class AbstractSourceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractSource
     */
    protected $object;

    protected function setUp() {
        $this->object = $this->getMockForAbstractClass('\Heatbeat\Source\AbstractSource');
    }

    public function testSetGetInput() {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testSetGetOutput() {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    public function testGetExternalFolderPath() {
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @expectedException \Heatbeat\Exception\SourceException
     */
    public function testPerform() {
        $this->object->perform();
    }

}

?>
