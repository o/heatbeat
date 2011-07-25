<?php

namespace Heatbeat\Log\Handler;

/**
 * Test class for DummyHandler.
 */
class DummyHandlerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var DummyHandler
     */
    protected $object;
    /**
     *
     * @var Factory
     */
    protected $factory;

    protected function setUp() {
        $this->factory = new \Heatbeat\Log\Factory(\Heatbeat\Log\FactoryTest::getLogEnabledConfig(), \Heatbeat\Log\Factory::DUMMY_HANDLER);
        $this->object = $this->factory->getHandlerObject();
    }

    public function testHandle() {
        $method = new \ReflectionMethod($this->object, 'handle');
        $method->setAccessible(TRUE);

        $this->assertTrue($method->invoke($this->object, 'test'));
    }

    public function testIsHandling() {
        $method = new \ReflectionMethod($this->object, 'isHandling');
        $method->setAccessible(TRUE);

        $this->assertTrue($method->invoke($this->object));
    }

    public function testFormat() {
        $method = new \ReflectionMethod($this->object, 'isHandling');
        $method->setAccessible(TRUE);

        $this->assertEquals('foo', $method->invoke($this->object, 'foo'));
    }

    public function testLog() {
        $this->assertTrue($this->object->log('foo'));
    }

}

?>
