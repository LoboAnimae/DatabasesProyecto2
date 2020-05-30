<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class shoppingCart extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'shoppingCart';

    protected $fillable = ['artist', 'album', 'track', 'trackid'];
    public $timestamps = false;


}


