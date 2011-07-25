<?php

namespace Heatbeat\Log;

/**
 * Test class for Factory.
 */
class FactoryTest extends \PHPUnit_Framework_TestCase {

    public static function getLogEnabledConfig() {
        $configObject = new \Heatbeat\Parser\Config\ConfigParser();
        $configObject->setFilepath(__DIR__ . '/fixtures');
        $configObject->setFilename('logenabledconfig');
        $configObject->parse();
        return $configObject;
    }

    public static function getLogDisabledConfig() {
        $configObject = new \Heatbeat\Parser\Config\ConfigParser();
        $configObject->setFilepath(__DIR__ . '/fixtures');
        $configObject->setFilename('logenabledconfig');
        $configObject->parse();
        return $configObject;
    }

    public function testGetFileHandlerObject() {
        $factory = new Factory($this->getLogEnabledConfig(), Factory::FILE_HANDLER);
        $this->assertInstanceOf('Heatbeat\Log\Handler\RotatingFileHandler', $factory->getHandlerObject());
    }

    public function testGetDummyHandlerObject() {
        $factory = new Factory($this->getLogEnabledConfig(), Factory::DUMMY_HANDLER);
        $this->assertInstanceOf('Heatbeat\Log\Handler\DummyHandler', $factory->getHandlerObject());
    }

    public function testGetHandlerObjectWithDisabledConfig() {
        $factory = new Factory($this->getLogDisabledConfig(), Factory::DUMMY_HANDLER);
        $this->assertInstanceOf('Heatbeat\Log\Handler\DummyHandler', $factory->getHandlerObject());
    }

    public function testGetWrongFileHandlerObject() {
        $this->setExpectedException('Heatbeat\Exception\LoggingException');
        $factory = new Factory($this->getLogEnabledConfig(), 'bogus');
        $factory->getHandlerObject();
    }

    public function testGetConfigObject() {
        $configObject = $this->getLogEnabledConfig();
        $object = new Factory($configObject, Factory::DUMMY_HANDLER);
        $this->assertEquals($configObject, $object->getConfigObject());
    }

    public function testSetConfigObject() {
        $configObject = $this->getLogDisabledConfig();
        $object = new Factory($configObject, Factory::FILE_HANDLER);
        $this->assertEquals($configObject, $object->getConfigObject());

        $this->setExpectedException('\ErrorException');
        new Factory(new \stdClass(), Factory::DUMMY_HANDLER);
    }

}

?>
