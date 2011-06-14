<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for CDefNode.
 */
class CDefNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider cdefDataProvider
     */
    public function testGetAsString($name, $rpn, $result) {
        $object = new CDefNode(array(
            'name' => $name,
            'rpn' => $rpn
        ));
        $this->assertEquals($result, $object->getAsString());
    }
    
    public function cdefDataProvider() {
        return array(
            array('inbits', 'inbytes,8,*', 'CDEF:inbits=inbytes,8,*'),
            array('var_name', 'RPN_expression', 'CDEF:var_name=RPN_expression')
        );
    }

}

?>
