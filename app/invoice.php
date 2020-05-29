<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table = 'invoice';
    protected $primaryKey = 'invoiceid';
    public $timestamps = false;
}
