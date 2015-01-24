**Follow the Path**

It is an area where `0` means empty and `1` mark the track the algorithm need discovery and follow

```php
$areaWithTheLine = [
    [0,0,0,0,0,0,0,0,0,0],
    [0,0,1,1,0,0,0,1,1,1],
    [0,1,0,0,1,0,1,0,0,0],
    [0,0,0,0,0,1,0,0,0,0],
    [0,0,0,0,0,0,0,0,0,0]
];
```

Everything you need is implements the namespace `FollowThePath\Strategy\Stragety`

```php
namespace FollowThePath\Strategy;

interface Strategy{
    public function __construct(array $fisrtMove);
    public function move($try=0);
    public function receiveFeedback($feedback);
}
```

and respect the syntax of the move: **`['x'=>0,'y'=>0]`**

the construct receive the edge of the track, so you can start right in your algorithm.

its a pet, created in a moment of insomnia. Do not expect nothing besides follow the track.
