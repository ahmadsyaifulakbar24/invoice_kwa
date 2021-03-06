<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryAlker extends Model 
{
    protected $table = 'history_alker';

    protected $fillable = [
        'alker_id',
        'alker_request_id',
        'status'
    ];

    public function alker_request() 
    {
        return $this->hasOne('App\Models\AlkerRequest', 'id', 'alker_request_id');
    }

    public function alker() 
    {
        return $this->belongsTo('App\Models\Alker', 'alker_id');
    }
}
