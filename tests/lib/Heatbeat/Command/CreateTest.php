<?php

namespace Heatbeat\Command;

/**
 * Test class for Create.
 */
class CreateTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider testSetStepDataProvider
     */
    public function testSetStep($step) {
        $command = new Create;
        $this->assertTrue($command->setStep($step));
    }

    public function testSetStepDataProvider() {
        return array(
            array(60),
            array(120),
            array(300),
            array(600)
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetStepFailure() {
        $command = new Create();
        $command->setStep('foo');
    }

    public function complexArgumentsProvider() {
        return array(
            array(
                'test.rrd',
                600,
                array(
                    'DS:speed:COUNTER:600:U:U'
                ),
                array(
                    'RRA:AVERAGE:0.5:1:24',
                    'RRA:AVERAGE:0.5:6:10'
                ),
                "rrdtool create --step '600' 'test.rrd' 'DS:speed:COUNTER:600:U:U' 'RRA:AVERAGE:0.5:1:24' 'RRA:AVERAGE:0.5:6:10'"
            ),
            array(
                'filename.rrd',
                300,
                array(
                    'foo'
                ),
                array(
                    'bar',
                    'baz'
                ),
                "rrdtool create --step '300' 'filename.rrd' 'foo' 'bar' 'baz'"
            )            
        );
    }

    /**
     * @dataProvider complexArgumentsProvider
     */
    public function testComplexArguments($filename, $step, $datastores, $rras, $result) {
        $command = new Create();
        $command->setFilename($filename);
        $command->setStep($step);
        $command->setDatastores($datastores);
        $command->setRras($rras);
        $this->assertEquals($command->prepare(), $result);
    }

}

?>
