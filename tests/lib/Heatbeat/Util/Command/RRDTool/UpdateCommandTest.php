<?php

namespace Heatbeat\Util\Command\RRDTool;

/**
 * Test class for UpdateCommand.
 */
class UpdateCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var UpdateCommand
     */
    protected $object;

    protected function setUp() {
        $this->object = new UpdateCommand;
    }

    public function assertPreConditions() {
        $this->assertEquals('rrdtool', $this->object->getCommand());
        $this->assertEquals('updatev', $this->object->getSubCommand());
    }

    public function valueDataProvider() {
        return array(
            array(
                new \Heatbeat\Source\SourceOutput(array(
                    'ds1' => 1,
                    'ds2' => 0.8
                )),
                array('template' => 'ds1:ds2'),
                array('N:1:0.8')
            ),
            array(
                new \Heatbeat\Source\SourceOutput(array(
                    'foo' => 8,
                    'bar' => 15,
                    'baz' => 12
                )),
                array('template' => 'foo:bar:baz'),
                array('N:8:15:12')
            ),
            array(
                new \Heatbeat\Source\SourceOutput(array(
                    'temp1' => 500,
                )),
                array('template' => 'temp1'),
                array('N:500')
            )
        );
    }

    /**
     * @dataProvider valueDataProvider
     */
    public function testSetValues($values, $resultopts, $resultargs) {
        $this->assertEmpty($this->object->getArguments());
        $this->assertEmpty($this->object->getOptions());
        $this->object->setValues($values);
        $this->assertEquals($resultopts, $this->object->getOptions());
        $this->assertEquals($resultargs, $this->object->getArguments());
    }

    public function testSetValuesWithFailValues() {
        $this->setExpectedException('\ErrorException');
        $this->object->setValues('bogus');
    }

}

?>
