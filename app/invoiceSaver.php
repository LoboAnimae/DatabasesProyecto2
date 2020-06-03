<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class invoiceSaver extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'sales';
}
