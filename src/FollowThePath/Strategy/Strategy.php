<?php
namespace FollowThePath\Strategy;

interface Strategy{
    public function __construct(array $fisrtMove);
    public function move($try=0);
    public function receiveFeedback($feedback);
}
