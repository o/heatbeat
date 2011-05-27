<?php

namespace Heatbeat\Command\RRDTool;

/**
 * Test class for Update.
 */
class UpdateTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider testSetValuesDataProvider
     */
    public function testSetValues($time, $values) {
        $command = new Update;
        $this->assertTrue($command->setValues($time, $values));
    }

    public function testSetValuesDataProvider() {
        return array(
            array('Now', array(9, 4, 3, 5)),
            array('1 hour ago', array(1.2, 3.4, 5.7)),
            array(1306445720, array(55, 60)),
            array(1306273330, array(10))
        );
    }

}

?>
