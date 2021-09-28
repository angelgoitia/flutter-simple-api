<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = [
        'id', 'specialty', 'name', 'age', 'size', 'weight', 'total', 'average', 'result', 'created_at'
    ];

    public function evaluates()
    {
        return $this->hasMany('App\Evaluate');
    }
    
}
