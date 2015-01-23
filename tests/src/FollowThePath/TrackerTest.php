<?php
namespace FollowThePath;
use \FollowThePath\Strategy\Dummy;    
class TrackerTest extends \PHPUnit_Framework_TestCase
{
    private $area = [
            [0,0,1],
            [0,1,1],
            [1,0,0],
            [0,0,0]
        ];
    
    public function testConstruct()
    {
        $lineArea = $this->area;
        $tracker = new Tracker(['x'=>count($lineArea[0]),'y'=>count($lineArea)], new Dummy(['x'=>0,'y'=>0]));
    }
    
    public function testStart()
    {
        $lineArea = $this->area;
        $firstMove = ['x'=>0,'y'=>2];
        $tracker = new Tracker(['x'=>count($lineArea[0]),'y'=>count($lineArea)], new Dummy($firstMove));
        $result = $tracker->start($lineArea);
        $expectedArea = $lineArea;
        $expectedArea[2][0]='.';
        $this->assertEquals([
            'move'=>['x'=>0,'y'=>2],
            'iteration'=>1,
            'area'=>$expectedArea,
            'score'=>true
        ], $result);
    }
    
    public function testIterateGoodMove()
    {
        $lineArea = $this->area;
        $firstMove = ['x'=>0,'y'=>2];
        $tracker = new Tracker(['x'=>count($lineArea[0]),'y'=>count($lineArea)], new Dummy($firstMove));
        $tracker->start($lineArea);
        $result = $tracker->iterate();
        $expectedArea = $lineArea;
        $expectedArea[2][0]='.';
        $expectedArea[1][1]='.';
        $this->assertEquals([
            'move'=>['x'=>1,'y'=>1],
            'iteration'=>2,
            'area'=>$expectedArea,
            'score'=>true
        ], $result);
        
    }
    public function testIterateBadMove()
    {
        $lineArea = $this->area;
        $firstMove = ['x'=>0,'y'=>2];
        $dummy = new Dummy($firstMove);
        $tracker = new Tracker(['x'=>count($lineArea[0]),'y'=>count($lineArea)], $dummy);
        $tracker->start($lineArea);
        $dummy->setPosition(0,0);//
        $result = $tracker->iterate();
        $expectedArea = $lineArea;
        $expectedArea[2][0]='.';
        $this->assertEquals([
            'move'=>['x'=>0,'y'=>0],
            'iteration'=>2,
            'area'=>$expectedArea,
            'score'=>false
        ], $result);
    }

    public function testIterateInLineButNotContinuous()
    {
        $lineArea = $this->area;
        $firstMove = ['x'=>0,'y'=>2];
        $dummy = new Dummy($firstMove);
        $tracker = new Tracker(['x'=>count($lineArea[0]),'y'=>count($lineArea)], $dummy);
        $tracker->start($lineArea);
        $dummy->setPosition(2,1);//
        $result = $tracker->iterate();
        $expectedArea = $lineArea;
        $expectedArea[2][0]='.';
        $this->assertEquals([
            'move'=>['x'=>2,'y'=>1],
            'iteration'=>2,
            'area'=>$expectedArea,
            'score'=>false
        ], $result);
    }
    public function testIterateInLineWithContinuous()
    {
        $lineArea = $this->area;
        $firstMove = ['x'=>0,'y'=>2];
        $dummy = new Dummy($firstMove);
        $tracker = new Tracker(['x'=>count($lineArea[0]),'y'=>count($lineArea)], $dummy);
        $result = $tracker->start($lineArea);
        $expectedArea = $lineArea;
        $expectedArea[2][0]='.';
        $this->assertEquals([
            'move'=>['x'=>0,'y'=>2],
            'iteration'=>1,
            'area'=>$expectedArea,
            'score'=>true
        ], $result);

        $dummy->setPosition(1,1);
        $result = $tracker->iterate();
        $expectedArea = $lineArea;
        $expectedArea[2][0]='.';
        $expectedArea[1][1]='.';
        $this->assertEquals([
            'move'=>['x'=>1,'y'=>1],
            'iteration'=>2,
            'area'=>$expectedArea,
            'score'=>true
        ], $result);


        $dummy->setPosition(2,0);
        $result = $tracker->iterate();
        $expectedArea[0][2]='.';
        $this->assertEquals([
            'move'=>['x'=>2,'y'=>0],
            'iteration'=>3,
            'area'=>$expectedArea,
            'score'=>true
        ], $result);
    }

}