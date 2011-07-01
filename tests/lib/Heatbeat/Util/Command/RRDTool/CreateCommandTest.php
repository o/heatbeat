<?php

namespace Heatbeat\Util\Command\RRDTool;

use Heatbeat\Util\CommandExecutor;

/**
 * Test class for CreateCommand.
 */
class CreateCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider createCommandDataProvider
     */
    public function testCommand($step, $start, $overwrite, $datastores, $rras, $commandString) {
        $commandObject = new CreateCommand();
        $commandObject->setStep($step);
        $commandObject->setStart($start);
        $commandObject->setOverwrite($overwrite);
        $commandObject->setDatastores($datastores);
        $commandObject->setRras($rras);
        $executor = new CommandExecutor();
        $executor->setCommandObject($commandObject);
        $executor->prepare();
        $this->assertEquals($executor->getCommandString(), $commandString);
    }

    public function createCommandDataProvider() {
        return array(
            array(
                600,
                1308830883,
                true,
                array(
                    new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'test',
                        'type' => 'GAUGE',
                        'heartbeat' => 600,
                        'min' => 0,
                        'max' => 100
                            )
                    )
                ),
                array(
                    new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'AVERAGE',
                        'xff' => 0.5,
                        'steps' => 1,
                        'rows' => 273
                            )
                    )
                ),
                "rrdtool create --start '1308830883' --step '600' 'DS:test:GAUGE:600:0:100' 'RRA:AVERAGE:0.5:1:273'"
            ),
            array(
                300,
                1308830882,
                false,
                array(
                    new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'foo',
                        'type' => 'COUNTER',
                        'heartbeat' => 1200,
                        'min' => 0,
                        'max' => 500
                            )
                    )
                ),
                array(
                    new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'LAST',
                        'xff' => 0.5,
                        'steps' => 1,
                        'rows' => 100
                            )
                    ),
                    new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'MAX',
                        'xff' => 1,
                        'steps' => 2,
                        'rows' => 576
                            )
                    )
                ),
                "rrdtool create --no-overwrite --start '1308830882' --step '300' 'DS:foo:COUNTER:1200:0:500' 'RRA:LAST:0.5:1:100' 'RRA:MAX:1:2:576'"
            ),
            array(
                1200,
                1308830881,
                false,
                array(
                    new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'bar',
                        'type' => 'DERIVE',
                        'heartbeat' => 1800,
                        'min' => 100,
                        'max' => 300
                            )
                    ),
                    new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'baz',
                        'type' => 'GAUGE',
                        'heartbeat' => 800,
                        'min' => 10,
                        'max' => 20
                            )
                    )
                ),
                array(
                    new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'MIN',
                        'xff' => 0.1,
                        'steps' => 8,
                        'rows' => 300
                            )
                    )
                ),
                "rrdtool create --no-overwrite --start '1308830881' --step '1200' 'DS:bar:DERIVE:1800:100:300' 'DS:baz:GAUGE:800:10:20' 'RRA:MIN:0.1:8:300'"
            )
        );
    }

}

?>
