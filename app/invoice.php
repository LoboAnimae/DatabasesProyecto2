<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    protected $table = 'Invoice';
    protected $primaryKey = 'InvoiceId';
}
