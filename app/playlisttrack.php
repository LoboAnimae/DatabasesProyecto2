<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class playlisttrack extends Model
{
    protected $table = 'PlaylistTrack';
    protected $primaryKey = ['PlaylistId', 'TrackId'];
}
