<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class logDeletion extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'logDeletions';



}


