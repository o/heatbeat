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

}