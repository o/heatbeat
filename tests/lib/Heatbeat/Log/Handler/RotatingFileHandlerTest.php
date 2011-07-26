<?php

namespace Heatbeat\Log\Handler;

/**
 * Test class for RotatingFileHandler.
 */
class RotatingFileHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RotatingFileHandler
     */
    protected $object;

    protected function setUp() {
        $factory = new \Heatbeat\Log\Factory(\Heatbeat\Log\FactoryTest::getLogEnabledConfig(), \Heatbeat\Log\Factory::FILE_HANDLER);
        $this->object = $factory->getHandlerObject();
        $this->object->setMessage('foo');
    }

    public function testHandle() {
        $this->assertTrue($this->object->handle());
    }

    public function testIsHandling() {
        $this->assertTrue($this->object->isHandling());
    }

    public function testFormat() {
        $this->object->format();
        $this->assertContains('foo', $this->object->getMessage());
    }

    public function testLog() {
        $this->assertTrue($this->object->log('foo'));
    }

}

?>
