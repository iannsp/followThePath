<?php
namespace FollowThePath\Strategy;
    
class DummyTest extends \PHPUnit_Framework_TestCase
{
    
    public function testSetArea()
    {
        $d = new Dummy(['x'=>0,'y'=>0]);
        $area = [
            [0,0,0],
            [0,0,0]
        ];
        $dummyArea  = $d->setArea(['x'=>3,'y'=>2]);
        $this->assertEquals($area,$dummyArea); 
    }
    public function testSetMoveForceFirstMove()
    {
        $d = new Dummy(['x'=>0,'y'=>0]);
        $area = [
            [0,0,0],
            [0,0,0]
        ];
        $dummyArea  = $d->setArea(['x'=>count($area[0]),'y'=>count($area)]);
        $this->assertEquals(['x'=>0,'y'=>0],$d->move(2,2)); 
    }
    public function testSetMove()
    {
        $d = new Dummy(['x'=>0,'y'=>0]);
        $area = [
            [0,0,0],
            [0,0,0]
        ];
        $dummyArea  = $d->setArea(['x'=>count($area[0]),'y'=>count($area)]);
        $this->assertEquals(['x'=>0,'y'=>0],$d->move(2,2)); 
        $this->assertEquals(['x'=>2,'y'=>2],$d->move(2,2)); 
    }

}