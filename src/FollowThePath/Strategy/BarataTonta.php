<?php
namespace FollowThePath\Strategy;

class BarataTonta implements Strategy
{
    private $area=[];
    private $position=[];
    private $path = [];
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
    }
    
    public function move($try=0)
    {
        $maxX = count($this->area[0])-1;
        $maxY = count($this->area)-1;
        if (!is_null($this->position)){
            $move = ['x'=>$this->position['x'],'y'=>$this->position['y']];
            $this->position = null;
        }
        else
            $move = ['x'=>rand(0, $maxX), 'y'=>rand(0, $maxY)];
        $moveString = "{$move['x']},{$move['y']}";
        if (!in_array($moveString, $this->path)){
//            echo "x:{$move['x']}, y:{$move['y']}\n";
            $this->path[] = $moveString;
            return $move;
        }
        if($try> ($maxY * $maxX))
            return null;
        return $this->move(++$try);
    }
    public function receiveFeedback($feedback){
        if(!$feedback){
            array_pop($this->path);
        }
    }
    public function getPath()
    {
        return $this->path;
    }
}