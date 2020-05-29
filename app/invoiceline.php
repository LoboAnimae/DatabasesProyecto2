<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoiceline extends Model
{
    protected $table = 'invoiceline';
    protected $primaryKey = 'invoicelineid';
    public $timestamps = false;
}
