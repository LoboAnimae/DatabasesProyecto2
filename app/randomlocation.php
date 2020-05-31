<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class randomlocation extends Model
{
    public $timestamps = false;
    protected $table = 'randomlocations';
    protected $primaryKey = 'locationid';
}
