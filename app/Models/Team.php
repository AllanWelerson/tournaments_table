<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name','shield','id'];

    public function tournaments()
    {
        return $this->belongsToMany('App\Models\Tournament')->withTimestamps();
    }

    public function matches()
    {
        return $this->hasMany('App\Models\Match');
    }
}
