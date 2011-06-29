<?php

namespace Heatbeat\Util\Command\RRDTool;

use Heatbeat\Source\SourceOutput,
    Heatbeat\Util\CommandExecutor;

/**
 * Test class for UpdateCommand.
 */
class UpdateCommandTest extends \PHPUnit_Framework_TestCase {

    public function setValuesDataProvider() {
        return array(
            array(
                1308837960,
                new SourceOutput(array(
                    'ds1' => 1,
                    'ds2' => 0.8
                )),
                "rrdtool updatev --template 'ds1:ds2' '1308837960:1:0.8'"
            ),
            array(
                1308837060,
                new SourceOutput(array(
                    'foo' => 8,
                    'bar' => 15,
                    'baz' => 12
                )),
                "rrdtool updatev --template 'foo:bar:baz' '1308837060:8:15:12'"
            ),
            array(
                1308837060,
                new SourceOutput(array(
                    'temp1' => 500,
                )),
                "rrdtool updatev --template 'temp1' '1308837060:500'"
            )              
        );
    }

    /**
     * @dataProvider setValuesDataProvider
     */
    public function testSetValues($time, SourceOutput $values, $commandString) {
        $commandObject = new UpdateCommand();
        $commandObject->setValues($time, $values);
        $executor = new CommandExecutor();
        $executor->setCommandObject($commandObject);
        $executor->prepare();
        $this->assertEquals($executor->getCommandString(), $commandString);
    }

}

?>
