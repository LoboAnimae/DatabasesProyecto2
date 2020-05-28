<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class album extends Model
{
    protected $table = 'album';
    protected $primaryKey = 'albumid';
    public $timestamps = false;
}
