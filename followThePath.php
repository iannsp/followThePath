<?php
require 'vendor/autoload.php';
/* This program show a naive implementation of a algorithm using feedback
   to follow the path of a line.
*/  
    
$areaWithTheLine = [
    [0,0,0,0,0,0,0,0,0,0],
    [0,0,1,1,0,0,0,1,1,1],
    [0,1,0,0,1,0,1,0,0,0],
    [0,0,0,0,0,1,0,0,0,0],
    [0,0,0,0,0,0,0,0,0,0]
];

/*
$areaWithTheLine = [
    [0,0,1],
    [0,1,0],
    [1,0,0]
];
*/

/*
$areaWithTheLine = [
    [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0],
    [0,0,1,1,0,0,0,1,1,1,0,0,0,0,0,1,0,0,1,0],
    [0,1,0,0,1,0,1,0,0,0,1,0,0,0,1,0,0,0,0,1],
    [0,0,0,1,0,0,1,0,0,0,0,1,0,1,0,0,0,0,0,0],
    [0,0,0,0,1,1,0,0,0,0,0,0,1,0,0,0,0,0,0,0]
];
*/

$strategy = new \FollowThePath\Strategy\StartThinking(['x'=>0,'y'=>2]);
$tracker  = new \FollowThePath\Tracker(['x'=>count($areaWithTheLine[0]),'y'=>count($areaWithTheLine)], 
$strategy);
$iterate = $tracker->start($areaWithTheLine);
while(is_array($iterate['move'])){
    $iterate = $tracker->iterate();
        $iteration = $iterate['area'];
        foreach ($iteration as $iterationLine){
            foreach ($iterationLine as $item){
                echo "{$item} ";
            }
            echo "\n";
        }
        if(is_array($iterate['move'])){
            echo "move: x:{$iterate['move']['x']}, y:{$iterate['move']['y']}\n";
            echo "iterator:{$iterate['iteration']}\n";
            //usleep(0300000);
            sleep(1);
            print chr(27) . "[2J" . chr(27) . "[;H";
        }
}
if (is_null($iterate['move'])){
    echo "Algoritmo falhou em encontrar o caminho.\n";
}
if ($iterate['move']=='end'){
    echo "Desafio vencido com {$iterate['iteration']}.\n";
}
