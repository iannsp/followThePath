<?php
namespace FollowThePath;
class Tracker
{
    private $area=[];
    private $areaWithTheLine=[];
    private $iteration = 0;
    private $strategy;
    public function __construct(array $area, Strategy\Strategy $strategy)
    {
        $this->strategy = $strategy;
        $this->strategy->setArea($area);
    }
    public function start(array $areaWithTheLine)
    {
        $this->areaWithTheLine = $areaWithTheLine;
        return $this->iterate();
    }
    public function iterate()
    {
        $result = false;
        $move = $this->strategy->move();
        if (is_null($move)){
            return array(
                'move'=>$move,
                'iteration'=>$this->iteration, 
                'area'=>$this->areaWithTheLine,
            );
        }
        $x = $move['x'];
        $y = $move['y'];
        if ($move==['x'=>1,'y'=>2]){
        }
        if ($this->firstMatchPoint()){
            $result = true;
        }
        else if($this->isContinuousMatch($move)){
            $result = true;
        }
        if($result){
            $this->areaWithTheLine[$y][$x]='.';
        }
        $this->strategy->receiveFeedback($result);
        $this->iteration++;
        if ($this->endTheLine())
        {
            return array(
                'move'=>"end",
                'iteration'=>$this->iteration, 
                'area'=>$this->areaWithTheLine,
            );
        }
        return array(
            'move'=>$move,
            'iteration'=>$this->iteration, 
            'area'=>$this->areaWithTheLine,
            'score'=>$result
        );
    }
    private function firstMatchPoint(){
        $unique = ['0'=>0,'1'=>0,'.'=>0];
        for ($y=0; $y< count($this->areaWithTheLine); $y++){
            $aux = array_count_values($this->areaWithTheLine[$y]);
            foreach ($aux as $auxI=>$auxV){
                $unique[$auxI]+= $auxV;
            }
        }
        return (array_key_exists('.',$unique) && ($unique['.']==0));
    }
    private function endTheLine(){
        $unique = [];
        for ($y=0; $y< count($this->areaWithTheLine); $y++){
            $unique = array_unique(array_merge($unique, array_unique($this->areaWithTheLine[$y])));
        }
        return !in_array('1',$unique);
    }

    private function isContinuousMatch($move)
    {
        $maxX = count($this->areaWithTheLine[0])-1;
        $maxY = count($this->areaWithTheLine)-1;
        for ($y=($move['y']-1); $y<=($move['y']+1); $y++ ){
            for ($x=($move['x']-1); $x<=($move['x']+1); $x++ ){

                if ($this->sameAsMovie($move,['x'=>$x, 'y'=>$y])){
                    continue;
                } 
                if ($this->outOfBound(['maxX'=>$maxX, 'maxY'=>$maxY], ['x'=>$x,'y'=>$y])){
                    continue;
                }
                if ($this->match(['x'=>$x, 'y'=>$y],1)){
                    $matchs["{$x}{$y}"] = ['x'=>$x, 'y'=>$y];
                }
                if($this->match(['x'=>$x, 'y'=>$y],'.') && $this->match($move,1)){
                    return true;
                }

            }
        }
        return false;
    }
    private function match($move, $expected=1)
    {
        return $this->areaWithTheLine[$move['y']][$move['x']]===$expected;
    }
    private function sameAsMovie($move, $newmove){
        return $move == $newmove;
    }
    private function outOfBound(array $bounds, array $move){
     return (
         $move['x']<0 || $move['y']<0 || 
         $move['x']>$bounds['maxX'] || $move['y']>$bounds['maxY']
        );   
    }
    private function render()
    {
        $iteration = $this->areaWithTheLine;
        foreach ($iteration as $iterationLine){
            foreach ($iterationLine as $item){
                echo "{$item} ";
            }
            echo "\n";
        }
    }
}