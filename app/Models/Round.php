<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = ['numero','tournament_id'];

    public function tournaments()
    {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function matches()
    {
        return $this->hasMany('App\Models\Match');
    }
}
