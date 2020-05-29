<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class modification extends Model
{
    protected $table = 'modifications';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
}
