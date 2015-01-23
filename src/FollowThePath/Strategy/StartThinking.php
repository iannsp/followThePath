<?php
namespace FollowThePath\Strategy;

class StartThinking implements Strategy
{
    private $area=[];
    private $position=[];
    private $current; 
    private $path = [];
    private $feedback;
    private $try=0;
    private $plan=[];
    
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
            $this->current = $move;
        }
        else{
                $move = array_pop($this->plan);
            }
        $moveString = "{$move['x']},{$move['y']}";
        $this->path[] = $move;
        return $move;
        if($try> ($maxY * $maxX))
            return null;
        return $this->move(++$try);
    }
    public function receiveFeedback($feedback){
        if(!$feedback){
            array_pop($this->path);
            $this->try++;
        }else{
            $this->try=0;
        }
        if(count($this->plan)==0){
            $this->setPlan(end($this->path));
        }
        $this->feedback = $feedback;
    }
    public function getPath()
    {
        return $this->path;
    }
    private function setPlan($move)
    {
        var_dump("setting a plan...");
        $plan = [];
            $maxX = count($this->area[0])-1;
            $maxY = count($this->area)-1;
            for ($y=($move['y']-1); $y<=($move['y']+1); $y++ ){
                for ($x=($move['x']-1); $x<=($move['x']+1); $x++ ){
                    if ($this->outOfBound(['maxX'=>$maxX, 'maxY'=>$maxY], ['x'=>$x,'y'=>$y])){
                        continue;
                    }
                    $plan[] = ['x'=>$x,'y'=>$y];
                }
            }
            $this->plan = $plan;
    }
    private function outOfBound(array $bounds, array $move){
     return (
         $move['x']<0 || $move['y']<0 || 
         $move['x']>$bounds['maxX'] || $move['y']>$bounds['maxY']
        );   
    }
    
}