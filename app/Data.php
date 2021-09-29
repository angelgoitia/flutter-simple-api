<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = [
        'id', 'specialty', 'name', 'age', 'size', 'weight', 'total', 'average', 'result', 'created_at', 'user_id',
    ];

    public function evaluates()
    {
        return $this->hasMany('App\Evaluate');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
