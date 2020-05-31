<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reproductions extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;
    protected $table = 'reproducedtracks';
}
