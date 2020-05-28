<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tracking extends Model
{
    protected $table = 'track';
    protected $primaryKey = 'trackid';
    public $timestamps = false;
}
