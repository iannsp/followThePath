<?php
namespace FollowThePath\Strategy;

class Dummy implements Strategy
{
    private $area=[];
    private $position=[];
    public function __construct(array $fisrtMove)
    {
        $this->position = $fisrtMove;
    }
    public function setArea(array $area)
    {
        $maxX = $area['x'];
        $maxY = $area['y'];
        for ($y=0; $y< $maxY; $y++){
            $this->area[$y] = [];
            for ($x=0; $x < $maxX; $x++){
                $this->area[$y][$x]=0;
            }
        }
        return $this->area;
    }
    public function move($x=1, $y=1)
    {
        $move = ['x'=>$x, 'y'=>$y];
        if (!is_null($this->position)){
            $move = $this->position;
            $this->position = null;
        }
        return $move;
    }
    public function setPosition($x, $y)
    {
        $this->position = ['x'=>$x, 'y'=>$y];
    }
    public function receiveFeedback($feedback)
    {
    }
}