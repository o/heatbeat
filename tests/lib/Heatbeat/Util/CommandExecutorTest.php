<?php

namespace Heatbeat\Util;

/**
 * Test class for CommandExecutor.
 */
class CommandExecutorTest extends \PHPUnit_Framework_TestCase {

    public function testSetGetCommandObject() {
        $commandObject = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $object = new CommandExecutor();
        $this->assertObjectHasAttribute('commandObject', $object);
        $this->assertAttributeEmpty('commandObject', $object);
        $object->setCommandObject($commandObject);
        $this->assertAttributeNotEmpty('commandObject', $object);        
        $this->assertAttributeEquals($commandObject, 'commandObject', $object);
        $this->assertEquals(
                $commandObject, $object->getCommandObject()
        );
    }

    public function testSetGetCommandString() {
        $commandString = 'ls -al';
        $object = new CommandExecutor();
        $this->assertObjectHasAttribute('commandString', $object);        
        $this->assertAttributeEmpty('commandString', $object);
        $object->setCommandString($commandString);
        $this->assertAttributeNotEmpty('commandString', $object);        
        $this->assertAttributeEquals($commandString, 'commandString', $object);
        $this->assertEquals(
                $commandString, $object->getCommandString()
        );
    }

    public function prepareDataProvider() {
        $object1 = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $object1->setCommand('rrdtool');
        $object1->setSubCommand('create');
        $object1->setOption('foo', 'bar');
        $object2 = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $object2->setCommand('svn');
        $object2->setSubCommand('log');
        $object2->addArgument('path/to/file');
        $object2->setOption('meh', false);
        $object3 = $this->getMockForAbstractClass('Heatbeat\Util\AbstractCommand');
        $object3->setCommand('git');
        $object3->setSubCommand('checkout');
        $object3->setOption('track');
        $object3->addArgument('origin/experimental');
        return array(
            array($object1, "rrdtool create --foo 'bar'"),
            array($object2, "svn log 'path/to/file'"),
            array($object3, "git checkout --track 'origin/experimental'")
        );
    }

    /**
     * @dataProvider prepareDataProvider
     */
    public function testPrepare($commandObject, $result) {
        $object = new CommandExecutor();
        $object->setCommandObject($commandObject);
        $object->prepare();
        $this->assertEquals($result, $object->getCommandString());
    }

    public function validCommandProvider() {
        return array(
            array('ls -al'),
            array('df'),
            array('cd /'),
            array('hostname'),
            array('rrdtool -v')
        );
    }

    /**
     *
     * @dataProvider validCommandProvider
     */
    public function testExecute($command) {
        $object = new CommandExecutor();
        $object->setCommandString($command);
        $result = $object->execute();
        $this->assertTrue($result->isSuccessful());
    }

    public function invalidCommandProvider() {
        return array(
            array('foo -h'),
            array('bar help'),
            array('baz --version'),
            array('moar file'),
            array('hai')
        );
    }

    /**
     * @dataProvider invalidCommandProvider
     * @expectedException Heatbeat\Exception\ExecutionException
     */
    public function testExecuteFail($command) {
        $object = new CommandExecutor();
        $object->setCommandString($command);
        $object->execute();
    }

}

?>
