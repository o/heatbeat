<?php

namespace Heatbeat\Util;

/**
 * Test class for CommandExecutor.
 */
class CommandExecutorTest extends \PHPUnit_Framework_TestCase {

    public function testSetGetCommandObject() {
        $commandObject = new Command\RRDTool\TestCommand();
        $object = new CommandExecutor();
        $object->setCommandObject($commandObject);
        $this->assertEquals(
                $commandObject, $object->getCommandObject()
        );
    }

    public function testSetGetCommandString() {
        $commandString = 'ls -al';
        $object = new CommandExecutor();
        $object->setCommandString($commandString);
        $this->assertEquals(
                $commandString, $object->getCommandString()
        );
    }

    public function testPrepareDataProvider() {
        $object1 = new Command\RRDTool\TestCommand;
        $object2 = new Command\RRDTool\TestCommand;
        $object2->addArgument('baz');
        $object2->setOption('meh', false);
        $object3 = new Command\RRDTool\TestCommand;
        $object3->setCommand('git');
        $object3->setSubCommand('checkout');
        $object3->setOption('track');
        $object3->addArgument('origin/experimental');
        return array(
            array($object1, 'rrdtool test'),
            array($object2, "rrdtool test 'baz'"),
            array($object3, "git checkout --track 'origin/experimental'")
        );
    }

    /**
     * @dataProvider testPrepareDataProvider
     */
    public function testPrepare($commandObject, $result) {
        $object = new CommandExecutor();
        $object->setCommandObject($commandObject);
        $object->prepare();
        $this->assertEquals($result, $object->getCommandString());
    }

    public function testExecute() {
        $object = new CommandExecutor();
        $object->setCommandString('ls -al');
        $result = $object->execute();
        $this->assertTrue($result->isSuccessful());
    }

    /**
     * @expectedException Heatbeat\Exception\ExecutionException
     */
    public function testFailExecute() {
        $object = new CommandExecutor();
        $object->setCommandString('foo --bar');
        $object->execute();
    }

}

?>
