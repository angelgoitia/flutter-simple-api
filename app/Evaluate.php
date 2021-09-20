<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    protected $fillable = [
        'id', 'data_id', 'type', 'repTiemp', 'note', 'pts',
    ];

    public function data()
    {
        return $this->belongsTo('App\Data', 'data_id');
    }
}
