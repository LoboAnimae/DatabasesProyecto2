<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class artist extends Model
{
    protected $table = 'artist';
    protected $primaryKey = 'artistid';
    public $timestamps = false;
}
