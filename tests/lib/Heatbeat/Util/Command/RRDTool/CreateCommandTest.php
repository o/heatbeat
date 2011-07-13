<?php

namespace Heatbeat\Util\Command\RRDTool;

/**
 * Test class for CreateCommand.
 */
class CreateCommandTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CreateCommand
     */
    protected $object;

    protected function setUp() {
        $this->object = new CreateCommand;
    }

    public function testInitializedObject() {
        $this->assertEquals('rrdtool', $this->object->getCommand());
        $this->assertEquals('create', $this->object->getSubCommand());
        $this->assertArrayHasKey('no-overwrite', $this->object->getOptions());
        $this->assertArrayHasKey('start', $this->object->getOptions());
        $this->assertContains(array('no-overwrite' => true), $this->object->getOptions());
    }

    public function testSetStep() {
        $this->object->setStep(300);
        $this->assertContains(array('step' => 300), $this->object->getOptions());
    }

    public function datastoreProvider() {
        return array(
            array(
                array(new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'bar',
                        'type' => 'DERIVE',
                        'heartbeat' => 1800,
                        'min' => 100,
                        'max' => 300
                            )
                )),
                'DS:bar:DERIVE:1800:100:300'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'foo',
                        'type' => 'COUNTER',
                        'heartbeat' => 1200,
                        'min' => 0,
                        'max' => 500
                            )
                )),
                'DS:foo:COUNTER:1200:0:500'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'meh',
                        'type' => 'GAUGE',
                        'heartbeat' => 600,
                        'min' => 300,
                        'max' => 1000
                            )
                )),
                'DS:meh:GAUGE:600:300:1000'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'this',
                        'type' => 'ABSOLUTE',
                        'heartbeat' => 60,
                        'min' => 100,
                        'max' => 200
                            )
                )),
                'DS:this:ABSOLUTE:60:100:200'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                        'name' => 'temps',
                        'type' => 'GAUGE',
                        'heartbeat' => 600,
                        'min' => 0,
                        'max' => 273
                            )
                )),
                'DS:temps:GAUGE:600:0:273'
            )
        );
    }

    /**
     * @dataProvider datastoreProvider
     */
    public function testSetDatastores($datastores, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setDatastores($datastores);
        $this->assertContains($result, $this->object->getArguments());
    }

    public function testSetDatastoresWithNonArrayValue() {
        $this->setExpectedException('\ErrorException');
        $this->object->setDatastores('bogus');
    }

    public function rraDataProvider() {
        return array(
            array(
                array(new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'MIN',
                        'xff' => 0.1,
                        'steps' => 8,
                        'rows' => 300
                            )
                )),
                'RRA:MIN:0.1:8:300'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'MAX',
                        'xff' => 1,
                        'steps' => 2,
                        'rows' => 576
                            )
                )),
                'RRA:MAX:1:2:576'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'LAST',
                        'xff' => 0.5,
                        'steps' => 1,
                        'rows' => 100
                            )
                )),
                'RRA:LAST:0.5:1:100'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'AVERAGE',
                        'xff' => 0.1,
                        'steps' => 8,
                        'rows' => 300
                            )
                )),
                'RRA:AVERAGE:0.1:8:300'
            ),
            array(
                array(new \Heatbeat\Parser\Template\Node\RRANode(array(
                        'cf' => 'LAST',
                        'xff' => 1,
                        'steps' => 1,
                        'rows' => 300
                            )
                )),
                'RRA:LAST:1:1:300'
            )
        );
    }

    /**
     * @dataProvider rraDataProvider
     */
    public function testSetRras($rras, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setRras($rras);
        $this->assertContains($result, $this->object->getArguments());
    }

    public function testSetRrasWithNonArrayValue() {
        $this->setExpectedException('\ErrorException');
        $this->object->setRras('bogus');
    }

    public function testSetOverwrite() {
        $this->object->setOverwrite(false);
        $this->assertContains(array('no-overwrite' => true), $this->object->getOptions());

        $this->object->setOverwrite(true);
        $options = $this->object->getOptions();
        $this->assertFalse($options['no-overwrite']);
    }

    public function testSetStart() {
        $this->assertArrayNotHasKey('step', $this->object->getOptions());
        $this->object->setStep(1309467600);
        $this->assertContains(
                array('step' => 1309467600), $this->object->getOptions()
        );

        $this->object->setStep('N');
        $this->assertContains(
                array('step' => 'N'), $this->object->getOptions()
        );

        $this->object->setStep('-1h');
        $this->assertContains(
                array('step' => '-1h'), $this->object->getOptions()
        );
    }

    public function testInit() {
        $this->assertNull($this->object->init());
    }

}

?>
