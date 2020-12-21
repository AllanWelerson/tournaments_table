<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['name','edition','logo'];

    public function teams()
    {
        return $this->belongsToMany('App\Team')->withTimestamps();
    }
}
