<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolRequest extends Model 
{
    protected $table = 'tool_requests';

    protected $fillable = [
        'user_id',
        'item_id',
        'teknisi_id',
        'jenis',
        'keterangan_id',
        'front_picture',
        'back_picture',
        'status'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function teknisi()
    {
        return $this->belongsTo('App\Models\employee', 'teknisi_id');
    }

    public function keterangan()
    {
        return $this->belongsTo('App\Models\employee', 'keterangan_id');
    }
}
