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

    public function testInit() {
        $this->assertEquals('create', $this->object->getSubCommand());
        $this->assertEquals('rrdtool', $this->object->getCommand());
        $this->assertEmpty($this->object->getArguments());
        $this->assertNotNull($this->object->getOptions());
        $this->assertArrayHasKey('no-overwrite', $this->object->getOptions());
        $this->assertArrayHasKey('start', $this->object->getOptions());
        $this->assertContains(
                array(array('no-overwrite' => true)), $this->object->getOptions()
        );        
    }

    public function testSetStep() {
        $this->assertArrayNotHasKey('step', $this->object->getOptions());
        $this->object->setStep(300);
        $this->assertContains(
                array('step' => 300), $this->object->getOptions()
        );
        $this->object->setStep(600);
        $this->assertContains(
                array('step' => 600), $this->object->getOptions()
        );
    }

    public function testSetDatastores() {
        $datastores = array(
            new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                'name' => 'bar',
                'type' => 'DERIVE',
                'heartbeat' => 1800,
                'min' => 100,
                'max' => 300
                    )
            ),
            new \Heatbeat\Parser\Template\Node\DatastoreNode(array(
                'name' => 'foo',
                'type' => 'COUNTER',
                'heartbeat' => 1200,
                'min' => 0,
                'max' => 500
                    )
            )
        );
        $this->object->setDatastores($datastores);
        $this->assertContains(
                'DS:bar:DERIVE:1800:100:300', $this->object->getArguments()
        );
        $this->assertContains(
                'DS:foo:COUNTER:1200:0:500', $this->object->getArguments()
        );
    }

    public function testSetRras() {
        $rras = array(
            new \Heatbeat\Parser\Template\Node\RRANode(array(
                'cf' => 'MIN',
                'xff' => 0.1,
                'steps' => 8,
                'rows' => 300
                    )
            ),
            new \Heatbeat\Parser\Template\Node\RRANode(array(
                'cf' => 'MAX',
                'xff' => 1,
                'steps' => 2,
                'rows' => 576
                    )
            )
        );
        $this->object->setRras($rras);
        $this->assertContains(
                'RRA:MIN:0.1:8:300', $this->object->getArguments()
        );
        $this->assertContains(
                'RRA:MAX:1:2:576', $this->object->getArguments()
        );
    }

    public function testSetOverwrite() {
        $this->object->setOverwrite(true);
        $this->assertNotContains(
                array(array('no-overwrite' => false)), $this->object->getOptions()
        );
        $this->object->setOverwrite(false);
        $this->assertContains(
                array(array('no-overwrite' => true)), $this->object->getOptions()
        );
    }

    public function testSetStart() {
        $this->object->setStart(1309867467);
        $this->assertContains(
                array('start' => 1309867467), $this->object->getOptions()
        );        
    }

}

?>
