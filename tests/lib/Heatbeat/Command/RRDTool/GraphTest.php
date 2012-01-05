<?php

namespace Heatbeat\Command\RRDTool;

/**
 * Test class for GraphCommand.
 */
class GraphTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var GraphCommand
     */
    protected $object;

    protected function setUp() {
        $this->object = new Graph;
    }

    public function testInitializedObject() {
        $this->assertEquals('rrdtool', $this->object->getCommand());
        $this->assertEquals('graphv', $this->object->getSubCommand());
        $this->assertContains(array(array('slope-mode' => true)), $this->object->getOptions());
        $this->assertContains(array(array('width' => 800)), $this->object->getOptions());
        $this->assertContains(array(array('height' => 200)), $this->object->getOptions());
        $this->assertContains(array(array('end' => -300)), $this->object->getOptions());
        $this->assertContains(array(array('units-exponent' => true)), $this->object->getOptions());
    }

    public function testSetGraphFilename() {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setGraphFilename('file');
        $this->assertNotEmpty($this->object->getArguments());
    }

    public function testSetStart() {
        $this->assertArrayNotHasKey('start', $this->object->getOptions());
        $this->object->setStart('N');
        $this->assertContains(array('start' => 'N'), $this->object->getOptions());
    }

    public function testSetTitle() {
        $this->assertArrayNotHasKey('title', $this->object->getOptions());
        $this->object->setTitle('Lovely graph');
        $this->assertContains(array('title' => 'Lovely graph'), $this->object->getOptions());
    }

    public function testSetVerticalLabel() {
        $this->assertArrayNotHasKey('vertical-label', $this->object->getOptions());
        $this->object->setVerticalLabel('Users');
        $this->assertContains(array('vertical-label' => 'Users'), $this->object->getOptions());
    }

    public function testSetLowerlimit() {
        $this->assertArrayNotHasKey('lower-limit', $this->object->getOptions());
        $this->object->setLowerlimit(1);
        $this->assertContains(array('lower-limit' => 1), $this->object->getOptions());


        $this->object->setLowerlimit('auto');
        $this->assertContains(array('alt_autoscale_min' => true), $this->object->getOptions());
    }

    public function testSetUpperlimit() {
        $this->assertArrayNotHasKey('upper-limit', $this->object->getOptions());
        $this->object->setUpperlimit(100);
        $this->assertContains(array('upper-limit' => 100), $this->object->getOptions());

        $this->object->setUpperlimit('auto');
        $this->assertContains(array('alt_autoscale_max' => true), $this->object->getOptions());
    }

    public function testSetBase() {
        $this->assertArrayNotHasKey('base', $this->object->getOptions());
        $this->object->setBase(1024);
        $this->assertContains(array('base' => 1024), $this->object->getOptions());
    }

    /**
     * @dataProvider Heatbeat\Parser\Template\Node\DefNodeTest::validDataProvider
     */
    public function testSetDefs($def, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setDefs(array(new \Heatbeat\Parser\Template\Node\DefNode($def)));
        $this->assertContains($result, $this->object->getArguments());
    }

    /**
     * @dataProvider Heatbeat\Parser\Template\Node\CDefNodeTest::validDataProvider
     */
    public function testSetCdefs($cdef, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setCDefs(array(new \Heatbeat\Parser\Template\Node\CDefNode($cdef)));
        $this->assertContains($result, $this->object->getArguments());
    }

    /**
     * @dataProvider Heatbeat\Parser\Template\Node\VDefNodeTest::validDataProvider
     */
    public function testSetVdefs($vdef, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setVDefs(array(new \Heatbeat\Parser\Template\Node\VDefNode($vdef)));
        $this->assertContains($result, $this->object->getArguments());
    }

    /**
     * @dataProvider Heatbeat\Parser\Template\Node\GPrintNodeTest::validDataProvider
     */
    public function testSetGprints($gprint, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setGprints(array(new \Heatbeat\Parser\Template\Node\GPrintNode($gprint)));
        $this->assertContains($result, $this->object->getArguments());
    }

    /**
     * @dataProvider Heatbeat\Parser\Template\Node\ItemNodeTest::validDataProvider
     */
    public function testSetItems($item, $result) {
        $this->assertEmpty($this->object->getArguments());
        $this->object->setItems(array(new \Heatbeat\Parser\Template\Node\ItemNode($item)));
        $this->assertContains($result, $this->object->getArguments());
    }

    public function testInit() {
        $this->assertNull($this->object->init());
    }

}

?>
