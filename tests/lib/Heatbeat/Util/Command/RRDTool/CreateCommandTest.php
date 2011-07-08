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

    public function assertPreConditions() {
        $this->assertAttributeEquals('rrdtool', 'command', $this->object);
        $this->assertAttributeEquals('create', 'subCommand', $this->object);
        $this->assertAttributeEmpty('arguments', $this->object);
        $this->assertAttributeNotEmpty('options', $this->object);
        $this->assertArrayHasKey('no-overwrite', $this->object->getOptions());
        $this->assertArrayHasKey('start', $this->object->getOptions());
        $this->assertAttributeContains(
                array(array('no-overwrite' => true)), 'options', $this->object
        );
    }

    public function stepProvider() {
        return array(
            array(300),
            array(600),
            array(1800),
            array(60),
            array(100)
        );
    }

    /**
     * @dataProvider stepProvider
     */
    public function testSetStep($step) {
        $this->assertArrayNotHasKey('step', $this->object->getOptions());
        $this->object->setStep($step);
        $this->assertAttributeContains(
                array('step' => $step), 'options', $this->object
        );
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
        $this->object->setDatastores($datastores);
        $this->assertAttributeContains(
                $result, 'arguments', $this->object
        );
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
        $this->object->setRras($rras);
        $this->assertAttributeContains(
                $result, 'arguments', $this->object
        );
    }

    public function overwriteDataProvider() {
        return array(
            array(true, false),
            array(false, true)
        );
    }

    /**
     * @dataProvider overwriteDataProvider
     */
    public function testSetOverwrite($overwrite, $result) {
        $this->object->setOverwrite($overwrite);
        $this->assertArrayHasKey('no-overwrite', $this->object->getOptions());
        $options = $this->object->getOptions();
        $this->assertEquals($result, $options['no-overwrite']);
    }

    public function startDataProvider() {
        return array(
            array(1201867500),
            array(1417582388),
            array(1323842093),
            array('N'),
            array(1239717988),
            array(1380980980)
        );
    }

    /**
     * @dataProvider startDataProvider
     */
    public function testSetStart($start) {
        $this->object->setStart($start);
        $this->assertArrayHasKey('start', $this->object->getOptions());
        $this->assertContains(
                array('start' => $start), $this->object->getOptions()
        );
    }

}

?>
