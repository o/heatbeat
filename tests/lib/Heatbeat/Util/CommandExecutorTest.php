<?php

namespace Heatbeat\Util;

/**
 * Test class for CommandExecutor.
 */
class CommandExecutorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CommandExecutor
     */
    protected $object;

    protected function setUp() {
        $this->object = new CommandExecutor;
    }

    public function testGetCommandObject() {
        $commandObject = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $this->assertNull($this->object->getCommandObject());
        $this->object->setCommandObject($commandObject);
        $this->assertTrue($commandObject == $this->object->getCommandObject());
    }

    public function testSetCommandObject() {
        $commandObject = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $this->assertNull($this->object->getCommandObject());
        $this->object->setCommandObject($commandObject);
        $this->assertTrue($commandObject == $this->object->getCommandObject());

        $this->setExpectedException('\ErrorException');
        $this->object->setCommandObject('bogus');
    }

    public function testGetCommandString() {
        $this->assertNull($this->object->getCommandString());
        $this->object->setCommandString('git checkout -b dev');
        $this->assertEquals('git checkout -b dev', $this->object->getCommandString());
    }

    public function testSetCommandString() {
        $this->assertNull($this->object->getCommandString());
        $this->object->setCommandString('uptime');
        $this->assertEquals('uptime', $this->object->getCommandString());
    }


    public function prepareDataProvider() {
        $example1 = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $example1->setCommand('rrdtool');
        $example1->setSubCommand('create');
        $example1->setOption('foo', 'bar');
        $example2 = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $example2->setCommand('svn');
        $example2->setSubCommand('log');
        $example2->addArgument('path/to/file');
        $example2->setOption('meh', false);
        $example3 = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $example3->setCommand('git');
        $example3->setSubCommand('checkout');
        $example3->setOption('track');
        $example3->addArgument('origin/experimental');
        return array(
            array($example1, "rrdtool create --foo 'bar'"),
            array($example2, "svn log 'path/to/file'"),
            array($example3, "git checkout --track 'origin/experimental'")
        );
    }

    /**
     * @dataProvider prepareDataProvider
     */
    public function testPrepare($commandObject, $result) {
        $this->object->setCommandObject($commandObject);
        $this->object->prepare();
        $this->assertEquals($result, $this->object->getCommandString());
    }

    public function testExecute() {
        $this->object->setCommandString('hostname');
        $process = $this->object->execute();
        $this->assertTrue($process->isSuccessful());

        $this->setExpectedException('Heatbeat\Exception\ExecutionException');
        $this->object->setCommandString('bogus');
        $this->object->execute();
    }

}

?>
