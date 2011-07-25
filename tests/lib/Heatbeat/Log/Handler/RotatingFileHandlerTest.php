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
    }

    public function testHandle() {
        $method = new \ReflectionMethod($this->object, 'handle');
        $method->setAccessible(TRUE);

        $this->assertEquals(3, $method->invoke($this->object, 'OK '));
    }

    public function testIsHandling() {
        $method = new \ReflectionMethod($this->object, 'isHandling');
        $method->setAccessible(TRUE);

        $this->assertTrue($method->invoke($this->object));
    }

    public function testFormat() {
        $method = new \ReflectionMethod($this->object, 'format');
        $method->setAccessible(TRUE);

        $this->assertContains('foo', $method->invoke($this->object, 'foo'));
    }

    public function testLog() {
        $this->assertEquals(20, $this->object->log("Passed"));
    }

}

?>
